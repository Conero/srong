<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 15:41
 * Email: brximl@163.com
 * Name: 配置获取
 */

namespace sR;


class Config
{
    protected $data = [];

    /**
     * Config constructor.
     * @param array|string $opts
     */
    function __construct($opts=[])
    {
        $this->parseOptions($opts);
    }

    /**
     * @param array|string $opts
     */
    protected function parseOptions($opts){
        if(is_string($opts)){
            $this->readPhp($opts);
        }else{
            $type = strtolower($opts['type'] ?? false);
            if($type){
                $filename = $opts['filename'];
                switch ($type){
                    case 'php':
                        $this->readPhp($filename);
                        break;
                    case 'ini':
                        $this->readIni($filename);
                        break;
                    case 'json':
                        $this->readJson($filename);
                        break;
                }
            }else if(is_array($opts)){
                $this->data = $opts;
            }
        }
    }
    /**
     * 读取php原生配置文件
     * @param $name
     */
    function readPhp($name){
        $name .= ((strtolower(substr($name,-4)) == '.php')? '':'.php');
        $this->data = $this->readFile($name);
    }

    /**
     * @param $filename
     */
    function readIni($filename){
        if(is_file($filename)){
            $this->data = parse_ini_file($filename);
        }
    }

    /**
     * @param $filename
     */
    function readJson($filename){
        if(is_file($filename)){
            $content = file_get_contents($filename);
            $this->data = json_decode($content, true);
        }
    }

    /**
     * 文件读取
     * @param string $name
     * @return array
     */
    protected function readFile($name){
        if(is_file($name)){
            return include_once($name);
        }
        return [];
    }

    /**
     * 简单值获取
     * @param $name
     * @return mixed|null
     */
    function __get($name)
    {
        return ($this->data[$name] ?? null);
    }

    /**
     * @param $name
     * @param $value
     */
    function __set($name, $value)
    {
        $this->value($name, $value);
    }

    /**
     * 配置文件值获取或者设置；支持多级
     * @param string|array $key
     * @param null $value
     * @return $this|mixed|null
     */
    function value($key, $value=null){
        if(null === $value){
            if(is_array($key)){
                $this->data = array_merge($this->data, $key);
                return $this;
            }
            // 多级 “.” 参数获取
            else if(strpos($key, '.') !== false){
                $key = preg_replace('/\s/', '', $key);
                $tmpValue = $this->data;
                foreach (explode('.', $key) as $k){
                    if(is_array($tmpValue)){
                        $tmpValue = ($tmpValue[$k] ?? null);
                    }
                }
                return $tmpValue;
            }
            return ($this->data[$key] ?? null);
        }

        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 键值存在检测
     * @param string $key
     * @return bool
     */
    function hasKey($key){
        // 多级 “.” 参数获取
        if(strpos($key, '.') !== false){
            $key = preg_replace('/\s/', '', $key);
            $tmpValue = $this->data;
            foreach (explode('.', $key) as $k){
                if(is_array($tmpValue)){
                    $checkValue = isset($tmpValue[$k]);
                    if($checkValue){
                        $tmpValue = $tmpValue[$k];
                    }else{
                        $tmpValue = false;
                        break;
                    }
                }else{
                    $tmpValue = false;
                    break;
                }
            }
            $hasKey = false !== $tmpValue;
        }else{
            $hasKey = isset($this->data[$key]);
        }
        return $hasKey;
    }
    /**
     * 删除键值
     * @param string $key
     * @return bool
     */
    function delete($key){
        if($this->hasKey($key)){
            unset($this->data[$key]);
            return true;
        }
        return false;
    }
    /**
     * 获取配置文件参数
     * @return array
     */
    function getData(){
        return $this->data;
    }
}