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
    /**
     * @var \PDO
     */
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

    /**
     * @param $sql
     * @param array $bind
     * @return bool|\PDOStatement
     */
    protected function prepareThenExec($sql, $bind=array()){
        $sth = $this->pdo->prepare($sql);
        $sth->execute($bind);
        return $sth;
    }

    /**
     * @param string $sql
     * @param array $bind
     * @return array|null
     */
    public function all($sql, $bind = array())
    {
        $sth = $this->prepareThenExec($sql, $bind);
        return $sth->fetchAll(\PDO::FETCH_CLASS);
    }

    public function row($sql, $bind = array())
    {
        // TODO: Implement row() method.
    }

    public function one($sql, $bind = array())
    {
        // TODO: Implement one() method.
    }

    /**
     * 开启事务
     * @return bool
     */
    public function beginTransaction()
    {
        if($this->pdo){
            return $this->pdo->beginTransaction();
        }
        return false;
    }

    /**
     * 事务提交
     * @return bool|mixed
     */
    public function commit()
    {
        if($this->pdo){
            return $this->pdo->commit();
        }
        return false;
    }

    /**
     * 事务回滚
     * @return bool|mixed
     */
    public function rollBack()
    {
        if($this->pdo){
            return $this->pdo->rollBack();
        }
        return false;
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