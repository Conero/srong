<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/22 0022 13:03
 * Email: brximl@163.com
 * Name:sql查询接口
 */

namespace sR\db;


interface Query
{
    /**
     * 查询所有列
     * @param string $sql
     * @param array $bind
     * @return array|null
     */
    function all($sql, $bind=array());
    /**
     * 查询单行
     * @param string $sql
     * @param array $bind
     * @return array|null
     */
    function row($sql, $bind=array());

    /**
     * 查询单个值
     * @param $sql
     * @param array $bind
     * @return mixed
     */
    function one($sql, $bind=array());

    /**
     * @return \PDO
     */
    function getPdo();

    /**
     * @return bool
     */
    function beginTransaction();

    /**
     * @return mixed
     */
    function commit();

    /**
     * @return mixed
     */
    function rollBack();

    /**
     * @return \Exception|null
     */
    function error();
}