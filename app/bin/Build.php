<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/10/10 0010 15:05
 * Email: brximl@163.com
 * Name: 编译为 phar 文件
 */

namespace app\bin;


use sR\Fs;
use tool\CliSrAbstract;
use sR\Adapter;

class Build extends CliSrAbstract
{
    private $_src;
    protected $_pharName;
    protected $_conf;

    const ConfFile = '/srong-phar.conf';
    /**
     * [file, dir, all]
     * @var array
     */
    protected $runOpt = [];         // 运行数据

    /**
     * 压缩文件
     */
    function index(){
        $src = $this->argv('src');
        if($src){
            $src = str_replace('\\', '/', $src);
        }
        $this->_src = $src;
        if(is_file($src)){
            $this->_buildFile();
        }elseif (is_dir($src)){
            $this->_buildDir();
        }else{
            echo self::Border .
                self::H1 . '[src=' . $src . '] 不是有效文件/目录' .
                self::T1 . 'phar 压缩失败！！'.
                self::Br.
                self::Br.
                self::H1 .'(:- 压缩请求命名无效，命令格式如下: ' .
                self::T2 . '1> $ php srong.phar <file>/<directory> [option]'.
                self::T2 . '2> $ php srong.phar build src=<file>/<directory> [option]'.
                self::Br.
                self::H1 . '[option] 参考' .
                self::T1 .' r=pharName      重命名 phar 文件'.
                self::T1 .' o=outputPath    输出目录文件'.
                self::Br.
                self::H1. '用时： '.Adapter::getRtime().'s'.
                self::Br.
                self::Br.
                self::Border
            ;
        }
    }

    /**
     * 初始化
     */
    protected function _buildInit(){
        $this->_pharName = $this->argv('r');
        $src = $this->_src;
        if(empty($this->_pharName)){
            $pathInfo = pathinfo($src);
            $this->_pharName = $pathInfo['filename'];
        }
        $conf = $src . self::ConfFile;
        if(is_dir($src) && is_file($conf)){
            $this->conf = parse_ini_file($conf);
            $conf = $this->conf;
            if(is_array($conf)){
                $this->_pharName = $conf['name'] ?? $this->_pharName;
            }
        }
        // 名称更改
        if($this->_pharName){
            $pInfo = pathinfo($src . '/' . $this->_pharName);
            $extension = $pInfo['extension'] ?? false;
            if('phar' != $extension){
                $this->_pharName .= '.phar';
            }
        }
    }
    protected function _buildFile(){
        $this->_buildInit();
    }
    protected function _buildDir(){
        $this->_buildInit();
        $src = $this->_src;

        $conf = $this->conf ?? [];
        $dist = $src. '/'.($conf['dist'] ?? '');
        if(!is_dir($dist)){
            Fs::mkdirs($dist);
        }
        $path = $dist. $this->_pharName;

        //$path = $src. '/'. $this->_pharName;
        $success = true;
        try{
            $this->runOpt = [
                'file' => 0,
                'dir' => 0,
                'all' => 0
            ];
            $phar = new \Phar($path);
            // 更改入口文件
            $defStub = $conf['defStub'] ?? false;
            if($defStub){
                $phar->setStub($phar->createDefaultStub($defStub));
            }
            $this->scanDirAddPath($phar, $src);
        }catch (\Exception $e){
            echo
                self::H1 . 'phar压缩错误!'
                . self::T1 .'基本信息 '
                . self::T2 .'target     '. $path
                . self::T2 . 'meg       '. $e->getMessage()
                . self::Br
                . self::H1. '用时： '.Adapter::getRtime().'s'
                . self::Br
            ;
            $success = false;
        }
        // 压缩成功
        if($success){
            echo
                self::Border,
                self::T1 . 'phar文档已经成功压缩！'
                . self::T2 . 'phar      '. $path
                . self::T2 . '遍历总文件 '. $this->runOpt['all']
                . self::T2 . '压缩文件数 '. $this->runOpt['file']
                . self::T2 . '压缩目录数 '. $this->runOpt['dir']
                . self::Br
                . self::H1. '用时： '.Adapter::getRtime().'s'
                . self::Br
                . self::Br
                . self::Border

            ;
        }

    }
    protected function scanDirAddPath(\Phar $phar, $dir){
        $src = $this->_src;
        $ignore = is_array($this->conf)? ($this->conf['ignore'] ?? false) : false;
        foreach (scandir($dir) as $v){
            if(in_array($v, ['.', '..'])){
                continue;
            }
            $this->runOpt['all'] += 1;
            $path = $dir .'/'. $v;
            $name = str_replace($src, '', $path);
            if($ignore && is_array($ignore) && in_array($name, $ignore)){
                continue;
            }
            if(is_file($path)){
                $phar->addFile($path, $name);
                $this->runOpt['file'] += 1;
            }elseif (is_dir($path)){
                $phar->addEmptyDir($name);
                $this->runOpt['dir'] += 1;
                $this->scanDirAddPath($phar, $path);
            }
        }
    }
}