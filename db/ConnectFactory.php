<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 13:19
 * Email: brximl@163.com
 * Name: 数据库连接适配器
 */

namespace sR\db;


use sR\Db;

class ConnectFactory
{
    /**
     * 数据库连接器
     * @param array $options
     * @return AbstractQuery|null
     */
    static function connect($options){
        $conn = null;
        $type = $options['type'] ?? null;
        if($type){
            $options['type'] = $type;
            switch (strtolower($type)){
                case Db::DbTypeMysql:
                    $conn = new Mysql($options);
                    break;
                case Db::DbTypeOracle:
                    $conn = new Oci($options);
                    break;
                case Db::DbTypePostgreSql:
                    $conn = new Pgsql($options);
                    break;
                case Db::DbTypeSQLite:
                    $conn = new SQLite($options);
                    break;
            }
        }
        return $conn;
    }

    /**
     * 通过加载ini文件实例化内容
     * @param string $ini
     * @param string $name
     * @return bool|AbstractQuery
     */
    static function configUseIni($file, $name=''){
        if(is_file($file)){
            $option = parse_ini_file($file);
            if($name){
                $option = $option[$name] ?? [];
            }
            return self::connect($option);
        }
        return null;
    }

    /**
     * 通过加载json文件实例化对象
     * @param string $file
     * @param string $name
     * @return bool|AbstractQuery
     */
    static function configUseJson($file, $name=''){
        if(is_file($file)){
            $option = json_decode(file_get_contents($file), true);
            if($name){
                $option = $option[$name] ?? [];
            }
            return self::connect($option);
        }
        return null;
    }
    /**
     * @param $file
     * @return mixed|null
     */
    private static function getPhpFileData($file){
        if(is_file($file)){
            return require_once ($file);
        }
        return null;
    }

    /**
     * @param string $file
     * @param string $name
     * @return AbstractQuery|null
     */
    static function configUsePhp($file, $name=''){
        if(is_file($file)){
            $option = self::getPhpFileData($file) ?? [];
            if($name){
                $option = $option[$name] ?? [];
            }
            return self::connect($option);
        }
        return null;
    }
}