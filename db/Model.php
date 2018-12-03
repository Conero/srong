<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/12/3 0003 22:25
 * Email: brximl@163.com
 * Name: 数据库模型
 */

namespace sR\db;


class Model
{
    /**
     * Model constructor.
     * @param array $option
     */
    function __construct($option=[])
    {
        // 设置数据表表
        if($table = ($option['table'] ?? false)){
            $this->_getTable($table);
        }
    }

    /**
     * @var string 缓存数据库
     */
    private $_cTableName;

    /**
     * 创建空的数据库表模型
     * @param string $table
     * @return Model
     */
    static function create($table){
        $model = new self([
            'table' => $table
        ]);
        return $model;
    }

    /**
     * 模型命名规则: 一大写字母开头，使用峰驼法命名规则: user -> User/sys_user -> SysUer
     * 获取数据表
     * @return string
     */
    function getTable(){
        $table = $this->_cTableName;
        // 存在数据表时自动还原
        if($table){
            $table = str_replace('_', ' ', $table);
            $table = ucfirst($table);
            $table = str_replace(' ', '', $table);
            return $table;
        }
        $class = get_class($this);
        if(($idx = strrpos($class, '\\')) !== false){
            $class = substr($class, $idx+1);
        }
        return $class;
    }

    /**
     * 获取实际的数据库表；也可自定义数据表
     * @param string $table
     * @return string
     */
    private function _getTable($table=''){
        if(empty($this->_cTableName)){
            $table = ($table ?? $this->getTable());
            $this->_cTableName = $table;
        }
        return $this->_cTableName;
    }

    /**
     * 新增数据
     * @param array $data
     * @return int
     */
    function insert($data){
        $success = 0;
        // @TODO 实现数据新增
        return $success;
    }

    /**
     * 数据删除
     * @param mixed $where
     * @return int
     */
    function delete($where=false){
        $success = 0;
        // @TODO 实现数据删除
        return $success;
    }

    /**
     * 数据更新
     * @param bool|array $data
     * @return int
     */
    function update($data=false){
        $succes = 0;
        // @TODO 实现数据更新
        return $succes;
    }

    /**
     * 数据查询
     */
    function select(){
        // @TODO 数据查询;返回多数据集
    }

    /**
     * 获取但数据记录
     */
    function get(){}

    /**
     * @param $name
     */
    function __get($name)
    {
        // TODO: Implement __get() method. 获取查询到的单个值
    }
}