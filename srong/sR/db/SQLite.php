<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/14 0014 16:47
 * Email: brximl@163.com
 * Name:
 */

namespace sR\db;


class SQLite extends AbstractQuery
{
    protected $quoteValue = '\'';
    protected $quoteColumn = '';

    /**
     * @return string
     */
    function getDsn()
    {
        return $this->options['dsn'] ?? '';
    }
}