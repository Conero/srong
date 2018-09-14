<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/13 0013 16:23
 * Email: brximl@163.com
 * Name:
 */

namespace sR\tests;

use sR\Db;
use sR\db\AbstractQuery;
use PHPUnit\Framework\TestCase;

class AbstractQueryTest extends TestCase
{
    function testOciGetDsn(){
        $options = [
            'type'  => 'oci',
            'dbname'=> 'mci600a',
            'user'  => 'SA',
            'password' => 'zotion123'
        ];
        $db = Db::register('default', $options);
        echo  $db->getDsn() ."\n";
        //print_r([Db::getQuery()->all('select * from "sys_user" where uid = :_uid', ['_uid' => 1397])]);
        //print_r([Db::getQuery()->all('select * from "sys_user" where uid = ?', [1397])]);
        //print_r([Db::getQuery()->all('select * from "sys_user"'), Db::getQuery()->getPdo()->errorInfo(), Db::getQuery()]);
        print_r([Db::getQuery()->all('select * from "emp200000"'), Db::getQuery()->getPdo()->errorInfo(), Db::getQuery()]);
    }
}
