<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 12:59
 * Email: brximl@163.com
 * Name: 数据库处理
 */

namespace sR;


use mysql_xdevapi\Exception;
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

    const DbDefaultRegisterKey = 'default';

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
     * @return db\Mysql|db\Oci|db\Pgsql|db\SQLite|null
     * @throws \Exception
     */
    static function register($name, $options){
        $query = ConnectFactory::connect($options);
        self::$currentDbRs = $query;
        self::$resourceDick[$name] = $query;
        self::$currentDbRsKey = $name;
        return $query;
    }

    /**
     * @param string|array $option
     * @param string $type
     * @param string $key
     * @return AbstractQuery|null
     * @throws \Exception
     */
    static function registerDefault($option, $type='php', $key=''){
        if(is_array($option)){
            return self::register(self::DbDefaultRegisterKey, $option);
        }else if(is_string($option)){
            return self::registerByFile($option, $key, $type);
        }
        throw new \Exception('参数无效，无法解析');
    }

    /**
     * 通过文件注册数据库查询实例
     * @param string $name
     * @param string $file
     * @param null|string $type
     * @return bool|AbstractQuery|null
     * @throws \Exception
     */
    /**
     * @param string $file 文件名称
     * @param null $key 配置键名
     * @param null $type 类型
     * @return AbstractQuery|null
     * @throws \Exception
     */
    static function registerByFile($file, $key=null, $type=null){
        $query = null;
        // 类型不存在时,根据文件名称自动生成
        if(empty($type)){
            $path_parts = pathinfo($file);
            $path_parts = is_array($path_parts)? $path_parts: [];
            $type = strtolower($path_parts['extension']) ?? '';
        }
        if(empty($type)){
            throw new \Exception('文件类型为空！');
        }
        switch ($type){
            case 'ini':
                $query = ConnectFactory::configUseIni($file, $key);
                break;
            case 'json':
                $query = ConnectFactory::configUseJson($file, $key);
                break;
            case 'php':
                $query = ConnectFactory::configUsePhp($file, $key);
                break;
        }
        if(!empty($query)){
            self::$currentDbRs = $query;
            self::$resourceDick[$key] = $query;
            self::$currentDbRsKey = $key;
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