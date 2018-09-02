<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/2 0002 15:39
 * Email: brximl@163.com
 * Name: 文件系统
 */

namespace sR;


class Fs
{
    private static $_mkdirs_cur;

    /**
     * 文件删除
     * @param string $path
     * @return bool
     */
    static function rmdirs($path){
        // 不是目录，表名无需删除返回成功
        if(!is_dir($path)){
            $isSuccess = true;
        }else{
            foreach (scandir($path) as $v){
                if(in_array($v, ['.', '..'])){
                    continue;
                }
                $nPath = $path.(substr($path, -1) == '/'? '':'/').$v;
                if(is_file($nPath)){
                    unlink($nPath);
                }elseif (is_dir($nPath)){
                    self::rmdirs($nPath);
                }
            }
            $isSuccess = rmdir($path);
        }
        return $isSuccess;
    }

    /**
     * 多级目录生成
     * @param string $path
     * @param bool $isfle
     * @return bool
     */
    static function mkdirs($path,$isfle=false){
        $path = empty(self::$_mkdirs_cur)? str_replace('\\','/',$path) : $path;
        if($isfle){
            if(is_file($path)) return false;
            $path = pathinfo($path)['dirname'];
        }
        if(!is_dir($path)){
            if(empty(self::$_mkdirs_cur)){
                // 尝试直接使用 mkdir 函数
                // try{if(mkdir($path)) return true;}catch(Exception $e){}
                // 兼容 mkdir 函数
                if(is_dir(dirname($path))){
                    return mkdir($path);
                }
                self::$_mkdirs_cur = $path;
            }
            self::mkdirs(dirname($path));
        }
        else{
            if(self::$_mkdirs_cur){
                $firstDir = self::$_mkdirs_cur;
                self::$_mkdirs_cur = null;
                $_basedir = $path;
                $firstDir = str_replace($_basedir,'',$firstDir);
                if(strpos($firstDir,'/') === 0) $firstDir = substr($firstDir,1);
                foreach(explode('/',$firstDir) as $v){
                    if(!is_dir($_basedir.'/'.$v)){
                        mkdir($_basedir.'/'.$v);
                        $_basedir = $_basedir.'/'.$v;
                    }
                }
            }
        }
    }
}