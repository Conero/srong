<?php
/**
 * Auther: Joshua Conero
 * Date: 2019/2/12 0012 11:10
 * Email: brximl@163.com
 * Name:
 */

namespace sR\tests;

use PHPUnit\Framework\TestCase;
use sR\Db;

class UsageMysqlTest extends TestCase
{
    function testSycnData(){
        Db::registerDefault(__DIR__.'/data/private-mysql-conerocn.php');
        print_r([Db::query('select * from log_record limit 50')]);
        print_r([Db::query('select 3*2')]);
        print_r([Db::table('log_record')]);
    }
}
