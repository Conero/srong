<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/13 0013 14:39
 * Email: brximl@163.com
 * Name:
 */

namespace sR\db;


class Oci extends AbstractQuery
{
    protected $quoteValue = '\'';
    protected $quoteColumn = '"';

    /**
     * oci:dbname=//localhost:1521/mydb
     * @return string
     */
    function getDsn()
    {
        $options = $this->options;
        $port = $options['port'] ?? false;
        $dsn = 'oci:dbname='. ($options['host'] ?? 'localhost'). ($port? ':'.$port:''). '/'.$options['dbname'];
        $map = array_filter($this->options, function ($v){
            return in_array($v, ['charset']);
        }, ARRAY_FILTER_USE_KEY);
        $mapStr = $this->mapToDsnStr($map);
        $dsn .= ($mapStr? ';'. $mapStr: '');
        return $dsn;
    }
}