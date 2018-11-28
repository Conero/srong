<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/11/24 0024 10:01
 * Email: brximl@163.com
 * Name:
 */

use sR\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{

    public function testtpl2Str()
    {
        $tpl = new Template();
        $tpl->name = 'Susanna Rong';

        $this->assertEquals('This is '.$tpl->name,
            $tpl->tpl2Str('This is {name}', ['name' => $tpl->name]));
    }
}
