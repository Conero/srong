<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/11/28 0028 16:03
 * Email: brximl@163.com
 * Name:
 */

use sR\ds\Dick;
use PHPUnit\Framework\TestCase;

class sRdsDickTest extends TestCase
{

    // 数据测试
    public function testCreate()
    {
        $dick = Dick::create();
        $author = 'Joshua Conero';
        // 测试-设置/获取
        $dick->author = $author;
        $this->assertEquals($author, $dick->author);

        // 删除键值
        $dick->delete('author');
        $this->assertEquals(false, $dick->has('author'));

        // 测试 data
        $dick->data();
    }
}
