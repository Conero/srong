<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 12:59
 * Email: brximl@163.com
 * Name: 数据库处理
 */

namespace sR;


use sR\db\AbstractQuery;
use sR\db\Builder;
use sR\db\ConnectFactory;
use sR\db\Query;

/**
 * Class Db
 * @method static array all(string $sql, array $bind=array())
 * @method static array row(string $sql, array $bind=array())
 * @method static mixed one(string $sql, array $bind=array())
 * @method static int query($sql, $bind = array())
 * @method static \PDO getPdo()
 * @method static integer exec()
 * @method static boolean beginTransaction()
 * @method static boolean|mixed commit()
 * @method static boolean|mixed rollBack()
 * @method static \Exception|null error()
 * @method static Builder builder()
 * @method static Builder table($table, $alias=null)
 * @method static string type()
 * @method static string qV(null|string  $value = null)
 * @method static string qC(null|string  $value = null)
 * @method static string getDsn()
 * @package sR
 */
class Db
{
    const Version = '2.0.0-alpha';
    const Release = '20181203';

    // 数据库类型列表
    const DbTypeMysql = 'mysql';
    const DbTypeOracle = 'oci';
    const DbTypePostgreSql = 'pgsql';
    const DbTypeSQLite = 'sqlite';

    protected static $resourceDick = [];    // 资源连接字典
    /**
     * 当前 Db 对象
     * @var Query
     */
    protected static $currentDbRs;
    /**
     * 当前项目注册id
     * @var string
     */
    protected static $currentDbRsKey;

    /**
     * 数据库注册
     * @param string $name
     * @param array $options
     * @return null|AbstractQuery
     */
    static function register($name, $options){
        $query = ConnectFactory::connect($options);
        self::$currentDbRs = $query;
        self::$resourceDick[$name] = $query;
        self::$currentDbRsKey = $name;
        return $query;
    }

    /**
     * 通过文件注册数据库查询实例
     * @param string $name
     * @param string $file
     * @param string $type
     * @return AbstractQuery|null
     */
    static function registerByFile($name, $file, $type){
        $query = null;
        switch ($type){
            case 'ini':
                $query = ConnectFactory::configUseIni($file, $name);
                break;
            case 'json':
                $query = ConnectFactory::configUseJson($file, $name);
                break;
            case 'php':
                $query = ConnectFactory::configUsePhp($file, $name);
                break;
        }
        if(!empty($query)){
            self::$currentDbRs = $query;
            self::$resourceDick[$name] = $query;
            self::$currentDbRsKey = $name;
        }
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
     * @param $name
     * @param $arguments
     * @return mixed
     */
    static function __callStatic($name, $arguments)
    {
        if(self::$currentDbRs){
            if(method_exists(self::$currentDbRs, $name)){
                return call_user_func([self::$currentDbRs, $name], ...$arguments);
            }
        }
        return null;
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

    /**
     * 后去数据库注册ID码
     * @return string
     */
    static function getKey(){
        return self::$currentDbRsKey;
    }
}