<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 12:59
 * Email: brximl@163.com
 * Name: 数据库处理
 */

namespace sR;


use sR\db\AbstractQuery;
use sR\db\ConnectFactory;
use sR\db\Query;

/**
 * Class Db
 * @method array all(string $sql, array $bind=array())
 * @method array row(string $sql, array $bind=array())
 * @method mixed one(string $sql, array $bind=array())
 * @method int query($sql, $bind = array())
 * @method boolean beginTransaction()
 * @method boolean|mixed commit()
 * @method boolean|mixed rollBack()
 * @method integer exec()
 * @method \Exception|null error()
 * @method string qV(null|string  $value = null)
 * @method string qC(null|string  $value = null)
 * @method string getDsn()
 * @package sR
 */
class Db
{
    const Version = '1.1.1';
    const Release = '20180916';
    protected static $resourceDick = [];    // 资源连接字典
    /**
     * @var Query
     */
    protected static $currentDbRs;

    /**
     * @param string $name
     * @param array $options
     * @return null|AbstractQuery
     */
    static function register($name, $options){
        $query = ConnectFactory::connect($options);
        self::$currentDbRs = $query;
        self::$resourceDick[$name] = $query;
        return $query;
    }

    /**
     * @param string $name
     * @return mixed|null|AbstractQuery
     */
    static function getQuery($name=null){
        if($name){
            return (self::$resourceDick[$name] ?? null);
        }
        return self::$currentDbRs;
    }

    /**
     * 访问指定数据库对象
     * @param string $name
     * @param $arguments
     */
    static function __callStatic($name, $arguments)
    {
        if(self::$currentDbRs){
            if(method_exists(self::$currentDbRs, $name)){
                call_user_func([self::$currentDbRs, $name], ...$arguments);
            }
        }
    }

    /**
     * 当前注册数据库
     * @param string $name
     * @return bool
     */
    static function changeName($name){
        if(self::$resourceDick[$name] ?? false){
            self::$currentDbRs = self::$resourceDick[$name];
            return true;
        }
        return false;
    }
}