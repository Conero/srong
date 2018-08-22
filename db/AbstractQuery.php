<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 13:10
 * Email: brximl@163.com
 * Name: 抽象查询类
 */

namespace sR\db;


abstract class AbstractQuery implements Query
{
    protected $pdo;
    protected $options;
    /**
     * @var \Exception
     */
    protected $errorException;
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * 获取 dsn 插接器
     * @return string
     */
    protected function getDsn(){
        $dsn = '';
        return $dsn;
    }

    /**
     * 字典转变为dsn连接字符串
     * @param $map
     * @return string
     */
    protected function mapToDsnStr($map){
        $queue = [];
        foreach ($map as $k=>$v){
            $queue[] = $k.'='.$v;
        }
        return implode(';', $queue);
    }
    /**
     * 数据库连接
     */
    protected function connect(){
        $options = $this->options;
        try{
            $this->pdo = new \PDO($this->getDsn(), $options['user'], $options['password']);
        }catch (\Exception $e){
            $this->errorException = $e;
        }

    }

    public function all($sql, $bind = array())
    {
        // TODO: Implement all() method.
    }

    public function row($sql, $bind = array())
    {
        // TODO: Implement row() method.
    }

    public function one($sql, $bind = array())
    {
        // TODO: Implement one() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return \Exception|null
     */
    function error()
    {
        return $this->errorException;
    }
}