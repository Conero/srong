<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/14 0014 11:03
 * Email: brximl@163.com
 * Name:
 */

namespace sR\tests;

use sR\db\Mysql;
use PHPUnit\Framework\TestCase;

final class MysqlTest extends TestCase
{
    function testBaseNew(){
        $db = new Mysql([
            'dbname'    => 'aurora',
            'user'      => 'root',
            'password'  => '151001',
            'host'      => 'localhost',
            'charset'   => 'utf8'
        ]);
        //print_r([$db->qC('test'), $db->qV('sys_user')]);
        //print_r([$db->all('select * from sys_user')]);

        // SQL builder
        $sql = $db->table('sys_user', 'a')
            ->join('fnc1000c', 'b', 'a.uid=b.uid')
            //->field('b.*', 'a.name')
            ->field('b.no, b.uid', 'a.name', ['ifnull(b.uid, -1)', 't1'])
        ;
        $sql->where(['a.uid', '>', 2]);
        print_r([$sql->sql()]);
        print_r([$sql->row()]);
    }
}
