<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/11/28 0028 15:45
 * Email: brximl@163.com
 * Name: 数据结构类型(data strut)/字典
 */

namespace sR\ds;


class Dick
{
    // 同数据
    const None = '_sRDataStrutValueNone';

    // 数据集合
    private $data = [];

    /**
     * Dick constructor.
     * @param array $data
     */
    function __construct($data=[])
    {
        $this->data = $data;
    }

    /**
     * 获取数据
     * @param mixed $key
     * @return bool|mixed
     */
    function get($key){
        if(isset($this->data[$key])){
            return $this->data[$key];
        }
        return false;
    }

    /**
     * 数据修改
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    function set($key, $value){
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 删除数据对象
     * @param string $key
     * @return bool
     */
    function delete($key){
        if($this->has($key)){
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    /**
     * 检测数据对象是否存在
     * @param mixed $key
     * @return bool
     */
    function has($key){
        return isset($this->data[$key]);
    }

    /**
     * @param array $data
     * @return $this
     */
    function merge($data){
        $this->data = array_merge($this->data, $data);
        return $this;
    }
    /**
     * 数据处理 mixin
     * @param $key
     * @param string $value
     * @return bool|mixed|Dick
     */
    function data($key=self::None, $value=self::None){
        if($key !== self::None && $value === self::None){
            return $this->get($key);
        }elseif (self::None === $key){
            return $this->data;
        }
        return $this->set($key, $value);
    }

    /**
     * 获取生成器
     * @return \Generator
     */
    function iter(){
        foreach ($this->data as $key => $value){
            yield $key => $value;
        }
    }

    /**
     * 数据数字的模式方法
     * @param $name
     * @return bool|mixed
     */
    function __get($name)
    {
        return $this->get($name);
    }
    /**
     * 数据设置的魔术方法
     * @param $name
     * @param $value
     * @return Dick
     */
    function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * 静态数据示例化
     * @param array $data
     * @return Dick
     */
    static function create($data=[]){
        $dick = new static($data);
        return $dick;
    }
}