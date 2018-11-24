<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/11/24 0024 9:03
 * Email: brximl@163.com
 * Name: sR\Config 测试
 */

use sR\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function testHasKey()
    {
        $conf = new Config();
        // 普通字符串
        $author = 'Joshua Conero';
        $key = 'author';
        $conf->author = $author;
        $this->assertEquals($author, $conf->author);
        $this->assertEquals(true, $conf->hasKey($key));
        $this->assertEquals(false, $conf->hasKey(''));

        // 零检测
        $key = 'zero';
        $conf->$key = 0;
        $this->assertEquals(0, $conf->$key);
        $this->assertEquals(true, $conf->hasKey($key));
        $this->assertEquals(true, $conf->delete($key));
        $this->assertEquals(false, $conf->$key);
    }
}
