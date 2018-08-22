<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 13:11
 * Email: brximl@163.com
 * Name: MySQL 数据查询
 */

namespace sR\db;


class Mysql extends AbstractQuery
{
    protected function getDsn()
    {
        $dsn = 'mysql:';
        $map = array_filter($this->options, function ($v){
            return in_array($v, ['host', 'dbname', 'port', 'unix_socket']);
        }, ARRAY_FILTER_USE_KEY);
        $dsn .= $this->mapToDsnStr($map);
        return $dsn;
    }
}