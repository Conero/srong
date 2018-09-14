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
            'password' => 'zotion123',
            'charset'   => 'utf8'
        ];
        $db = Db::register('default', $options);
        echo  $db->getDsn() ."\n";
        //print_r([Db::getQuery()->row('select * from "sys_user" where "uid" = :uid2', ['uid2' => 1397])]);
        //print_r(Db::getQuery()->row('select * from "sys_user"'));
        //print_r([Db::getQuery()->all('select * from "sys_user" where "uid" = ?', [1397])]);
        //print_r([Db::getQuery()->all('select * from "sys_user"'), Db::getQuery()->getPdo()->errorInfo(), Db::getQuery()]);
        //print_r([Db::getQuery()->all('select * from "emp2000c"'), Db::getQuery()->getPdo()->errorInfo(), Db::getQuery()]);
       // print_r([$db->all('select * from "emp2000c"'), Db::getQuery()->getPdo()->errorInfo(), Db::getQuery()]);

        print_r([$db->qC('test'), $db->qV('test')]);
        //
        print_r(Db::all('select * from "sys_user"'));
    }
}
