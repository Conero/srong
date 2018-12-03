<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/12/3 0003 22:56
 * Email: brximl@163.com
 * Name:
 */

namespace sR\tests;

use sR\db\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    // 静态数据查询
    public function testcreate()
    {
        $model = Model::create('SysUser');
        $this->assertEquals('SysUser', $model->getTable());
    }
    // 实例数据
    public function test__construct(){
        $model = new SysTestUser();
        $this->assertEquals('SysTestUser', $model->getTable());
    }
}

// 测试模型
class SysTestUser extends Model{}
