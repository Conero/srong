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
        print_r([$db->qC('test'), $db->qV('sys_user')]);
        print_r([$db->all('select * from sys_user')]);
    }
}
