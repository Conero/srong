<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/14 0014 16:33
 * Email: brximl@163.com
 * Name:  PostgreSQL
 */

namespace sR\db;


use sR\Db;

class Pgsql extends AbstractQuery
{
    protected $quoteValue = '\'';
    protected $quoteColumn = '';
    protected $dbType = Db::DbTypePostgreSql;          // 数据库类型

    /**
     * pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
     * @return string
     */
    function getDsn()
    {
        $dsn = 'pgsql:';
        $map = array_filter($this->options, function ($v){
            return in_array($v, ['host', 'port', 'dbname']);
        }, ARRAY_FILTER_USE_KEY);
        $mapStr = $this->mapToDsnStr($map);
        $dsn .= ($mapStr? ';'. $mapStr: '');
        return $dsn;
    }
}