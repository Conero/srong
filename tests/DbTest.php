<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 14:39
 * Email: brximl@163.com
 * Name: Db 类测试
 */
use PHPUnit\Framework\TestCase;
use sR\Db;

final class DbTest extends TestCase
{
    // 基本数据库注册
    function testBaseRegisterDatabase(){
        $options = [
            'type' => Db::DbTypeMysql
        ];

        $key = 'default';
        Db::register($key, $options);

        // 数据库类型的基本测试
        $this->assertEquals($key, Db::getKey());

        $this->assertEquals(Db::DbTypeMysql, Db::type());
        // $this->assertEquals(Db::DbTypeMysql, Db::getQuery()->type());

        // SQL 生成器
        $sql = 'SELECT * FROM `user`';
        $this->assertEquals($sql, (Db::table('user')->sql())['sql']);

        // =/like 等运算符号采取割空格的格式
        $sql = 'SELECT `name` FROM `user` WHERE `uid` = 2 AND `age` > 12 AND `name` = \'Jc\' AND `birth` LIKE \'1994-%\'';

        $builder = Db::table('user')->field('name')
            ->where(['uid'=>2])
            ->where([
                ['age', '>', 12],
                'name'=>'Jc',
                ['birth', 'like', '1994-%']
            ]);
        $this->assertEquals($sql,
            $builder->subSql());
        // print_r($builder->sql());
    }
}