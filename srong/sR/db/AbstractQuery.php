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
    protected $quoteValue = '\'';
    protected $quoteColumn = '';
    /**
     * @var \PDO
     */
    protected $pdo;
    protected $options;
    /**
     * @var \Exception
     */
    protected $errorException;
    protected $driverOptions = [];
    /**
     * @var \PDOStatement
     */
    protected $sth;
    public function __construct($options)
    {
        $this->options = $options;
        $this->connect();
    }

    /**
     * 获取 dsn 插接器
     * @return string
     */
    function getDsn(){
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
            $this->pdo = new \PDO($this->getDsn(), $options['user'], $options['password'], $this->driverOptions);
        }catch (\Exception $e){
            $this->errorException = $e;
        }

    }

    /**
     * @param string $sql
     * @param array $bind
     * @param bool $affect
     * @return bool|\PDOStatement
     */
    protected function prepareThenExec($sql, $bind=array(), $affect=false){
        $sth = $this->pdo->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        $result = $sth->execute($bind);
        if($affect){
            return $result;
        }
        $this->sth = $sth;
        return $sth;
    }

    /**
     * 获取查询结果集所有列
     * @param string $sql
     * @param array $bind
     * @return array|null
     */
    public function all($sql, $bind = array())
    {
        $sth = $this->prepareThenExec($sql, $bind);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获取结果集单列
     * @param string $sql
     * @param array $bind
     * @return array|mixed|null
     */
    public function row($sql, $bind = array())
    {
        $sth = $this->prepareThenExec($sql, $bind);
        $row = $sth->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * 获取结果集单值
     * @param $sql
     * @param array $bind
     * @return mixed
     */
    public function one($sql, $bind = array())
    {
        $sth = $this->prepareThenExec($sql, $bind);
        $column = $sth->fetchColumn();
        return $column;
    }

    /**
     * 数据查询，返回影响的结果
     * @param string $sql
     * @param array $bind
     * @return bool|int
     */
    function query($sql, $bind = array())
    {
        return $this->prepareThenExec($sql, $bind, true);
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
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * 执行sql并返回影响的行
     * @param $sql
     * @return int
     */
    function exec($sql)
    {
        return $this->pdo->exec($sql);
    }

    /**
     * @return \Exception|null
     */
    function error()
    {
        return $this->errorException;
    }

    /**
     * @param null|string $value
     * @return string
     */
    function qV($value=null){
        $quote = $this->quoteValue;
        if($value){
            return $quote. $value. $quote;
        }
        return $quote;
    }

    /**
     * @param null|string $value
     * @return string
     */
    function qC($value=null){
        $quote = $this->quoteColumn;
        if($value){
            return $quote. $value. $quote;
        }
        return $quote;
    }

    /**
     * SQL 生成器
     * @return Builder
     */
    function builder(){
        return new Builder($this);
    }

    /**
     * 表查询
     * @param string $table
     * @param null $alias
     * @return Builder
     */
    function table($table, $alias = null)
    {
        return (new Builder($this))->table($table, $alias);
    }
}