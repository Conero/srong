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

    // 测试数据获取
    function testget(){
        $dick = new Dick([
            'success' => true
        ]);
        $this->assertEquals(true, $dick->success);

        $dick->joshua = 'Conero';
        $this->assertEquals('Conero', $dick->joshua);

        // 获取空值
        $this->assertEquals(null, $dick->conero);
    }
    // 键值存在测试
    function testhas(){
        $dick = new Dick();
        $this->assertEquals(false, $dick->has('conero'));
        $dick->conero = 'Joshua';
        $this->assertEquals(true, $dick->has('conero'));
    }
    function testdata(){
        $dick = new Dick();
        // 获取值
        $this->assertEquals(null, $dick->data('joshua'));

        // 设置值
        $dick->data('joshua', 'conero');
        $this->assertEquals('conero', $dick->data('joshua'));

        $dick->data('rong', 'susanna');
        $dick->data('joshua', 'JC');
        $this->assertEquals(['joshua' => 'JC', 'rong' => 'susanna'], $dick->data());
    }
}
