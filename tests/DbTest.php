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
    function testBaseRegisterDatabase(){
        $options = [
            'type' => 'mysql'
        ];

        // 测试
        $this->assertInstanceOf(
            Db::class,
            Db::register('defualt', $options)
        );
    }
}