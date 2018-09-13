<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 13:19
 * Email: brximl@163.com
 * Name: 数据库连接适配器
 */

namespace sR\db;


class ConnectFactory
{
    /**
     * @param array $options
     * @return AbstractQuery|null
     */
    static function connect($options){
        $conn = null;
        $type = $options['type'] ?? null;
        if($type){
            $options['type'] = $type;
            switch (strtolower($type)){
                case 'mysql':
                    $conn = new Mysql($options);
                    break;
                case 'oci':
                    $conn = new Oci($options);
                    break;
            }
        }
        return $conn;
    }
}