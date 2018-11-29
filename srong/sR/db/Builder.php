<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/14 0014 14:15
 * Email: brximl@163.com
 * Name: SQL 生成器
 */

namespace sR\db;

use sR\Db;

class Builder
{
    const setFieldExpStr = 10;      // 设置field解析是分割字符串
    protected $table;
    protected $join = [];            // [{table,alias,condition,type}]
    protected $field = [];
    protected $where = [];          // [{condition, relation, isRaw}]
    protected $data = [];           // update/insert 的数据

    protected $parsedTable;         // 解析以后的表格，用于数据缓存
    protected $parsedWhere;         // 解析以后的条件，用于数据缓存
    protected $parsedField;         // 解析以后的字段，用于数据缓存
    protected $bindData = [];       // 绑定参数

    protected $cSql;                    // 当前的sql
    protected $cBind;                   // 当前的数据绑定

    const bindRefStr = 's_';
    /**
     * @var AbstractQuery
     */
    protected $db;
    protected $setting = [];

    function __construct($absQuery=null, $setting=array())
    {
        $this->db = $absQuery ?? Db::getQuery();
        $this->setting = $setting;
    }

    /**
     * 字段设置
     * @param mixed ...$fields
     * @return $this
     */
    function field(...$fields){
        if(($this->setting['expStr'] ?? false) !== self::setFieldExpStr){
            $this->field = array_merge($this->field, $fields);
            return $this;
        }
        foreach ($fields as $fd){
            if(is_array($fd)){
                $this->field[] = $fd;
            }
            elseif (strpos($fd, ',') !== false){
                foreach (explode(',', $fd) as $v){
                    $v = trim($v);
                    $idx = strpos($v, ' ');
                    if($idx !== false){
                        $nKey = trim(substr($v, 0, $idx));
                        $nV = trim(substr($v, $idx+1));
                        $this->field[] = [$nKey, $nV];
                    }
                    else{
                        $this->field[] = $v;
                    }
                }
            }
            else{
                $this->field[] = $fd;
            }
        }
        $this->parsedField = null;
        return $this;
    }

    /**
     * 数据表设置
     * @param string $table
     * @param null|string $alias
     * @return $this
     */
    function table($table, $alias=null){
        if($alias){
            $this->table = ['name' => $table, 'alias' => $alias];
        }else{
            $this->table = $table;
        }
        $this->parsedTable = null;
        return $this;
    }

    /**
     * 链表信息
     * @param string $table
     * @param string $alias
     * @param string $condition
     * @param string $type
     * @return $this
     */
    function join($table, $alias, $condition, $type='INNER'){
        $this->join[] = [
            'table'     => $table,
            'alias'     => $alias,
            'condition' => $condition,
            'type'      => $type
        ];
        return $this;
    }

    /**
     * 表左链接
     * @param string $table
     * @param string $alias
     * @param string $condition
     * @return Builder
     */
    function leftJoin($table, $alias, $condition){
        return $this->join($table, $alias, $condition, 'LEFT');
    }

    /**
     * 表右链接
     * @param string $table
     * @param string $alias
     * @param string $condition
     * @return Builder
     */
    function rightJoin($table, $alias, $condition){
        return $this->join($table, $alias, $condition, 'RIGHT');
    }

    /**
     * 数据绑定
     * @param $key
     * @param null $value
     * @return $this
     */
    function bind($key, $value=null){
        if(is_array($key)){
            $this->bindData = array_merge($this->bindData, $key);
        }elseif ($key && $value){
            $this->bindData[$key] = $value;
        }
        return $this;
    }

    /**
     * 设置 insert/update 的数据
     * @param string $key
     * @param null $value
     * @return $this
     */
    function data($key, $value=null){
        if($key && $value){
            $this->data[$key] = $value;
        }else{
            $this->data = $key;
        }
        return $this;
    }

    /**
     * @return array|null
     */
    function all(){
        $sql = 'SELECT '. $this->getField().' FROM '.$this->getTable(). $this->getWhere();
        $this->cSql = $sql;
        $this->cBind = $this->bindData;
        return $this->db->all($this->cSql, $this->cBind);
    }

    /**
     * @return array|mixed|null
     */
    function row(){
        $sql = 'SELECT '. $this->getField().' FROM '.$this->getTable(). $this->getWhere();
        $this->cSql = $sql;
        $this->cBind = $this->bindData;
        return $this->db->row($this->cSql, $this->cBind);
    }

    /**
     * @return mixed
     */
    function one(){
        $sql = 'SELECT '. $this->getField().' FROM '.$this->getTable(). $this->getWhere();
        $this->cSql = $sql;
        $this->cBind = $this->bindData;
        return $this->db->one($this->cSql, $this->cBind);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function _dataToBind($data){
        $fields = [];
        $values = [];
        $bind = [];
        $update = [];
        $db = $this->db;
        foreach ($data as $k=>$v){
            $field = $db->qC($k);
            $fields[] = $field;
            $newKey = $this->_getNewBindKey($k);
            $values[] = ':'.$newKey;
            $bind[$newKey] = $v;
            $update[] = $field.'=:'. $newKey;
        }
        return [
            'field' => implode(',', $fields),
            'value' => implode(',', $values),
            'update'=> implode(',', $update),
            'bind'  => $bind
        ];
    }
    /**
     * 插入数据
     * @return bool|int|
     */
    function insert(){
        $rs = $this->_dataToBind($this->data);
        $sql = 'INSERT INTO '. $this->getTable(). '('.$rs['field'].') VALUES ('.$rs['value'].')';

        $this->cSql = $sql;
        $this->cBind = $this->$rs['bind'];
        return $this->db->query($this->cSql, $this->cBind);
    }

    /**
     * 更新数据
     * @return bool|int
     */
    function update(){
        $rs = $this->_dataToBind($this->data);
        $sql = 'UPDATE '. $this->getTable(). ' SET '.$rs['update'].$this->getWhere();
        $this->cSql = $sql;
        $this->cBind = $this->$rs['bind'];
        return $this->db->query($this->cSql, $this->cBind);
    }

    /**
     * 删除数据
     * @return bool|int
     */
    function delete(){
        $sql = 'DELETE FROM '. $this->getTable(). $this->getWhere();
        $this->cSql = $sql;
        $this->cBind = [];
        return $this->db->query($sql);
    }
    /**
     * count 统计
     * @param null|string $name
     * @return mixed
     */
    function count($name=null){
        $name = $name? $this->db->qC($name) : '1';
        $sql = 'SELECT COUNT('.$name.') FROM '. $this->getTable().
            $this->getWhere()
        ;
        $this->cSql = $sql;
        $this->cBind =  $this->bindData;
        return $this->db->one($this->cSql , $this->cBind);
    }

    /**
     * 获取SQL信息
     * @return array
     */
    function sql(){
        if(empty($this->cSql)){
            $sql = 'SELECT '. $this->getField().' FROM '.$this->getTable(). $this->getWhere();
            $data = [
                'sql' => $sql,
                'bind'=> $this->bindData
            ];
        }else{
            $data = [
                'sql' => $this->cSql,
                'bind'=> $this->cBind
            ];
        }
       return $data;
    }
    /**
     * 子查询
     * @return string
     */
    function subSql(){
        $sql = 'SELECT '. $this->getField().' FROM '.$this->getTable(). $this->getNoBindWhr();;
        return $sql;
    }
    /**
     * @param string|array $wh
     * @param string $relation
     * @param bool $isRaw
     * @return $this
     */
    function where($wh, $relation='AND', $isRaw=false){
        if($wh){
            $this->where[] = [
                'condition' => $wh,
                'relation'  => $relation,
                'isRaw'     => $isRaw
            ];
            $this->parsedWhere = null;
        }
        return $this;
    }

    /**
     * @param string|array $wh
     * @param bool $isRaw
     * @return Builder
     */
    function orWhere($wh, $isRaw=false){
        return $this->where($wh, 'OR', $isRaw);
    }
    /**
     * table 表名解析
     * @return string
     */
    function getTable(){
        if(empty($this->parsedTable)){
            $db = $this->db;
            $alias = '';
            if(is_array($this->table)){
                $table = $this->table['name'];
                $alias = ' '.$this->table['alias'];
            }else{
                $table = $this->table;
            }
            $pTable = $db->qC($table). $alias;
            // 表连接处理
            $queue = [];
            // [{table,alias,condition,type}]
            foreach ($this->join as $row){
                $table = $row['type']. ' JOIN '. $db->qC($row['table']).' '.$row['alias'];
                $table .= ' ON '. $db->qC($row['condition']);
                $queue[] = $table;
            }
            $pTable = empty($queue)? $pTable: $pTable.' '.implode(' ', $queue);

            $this->parsedTable = $pTable;
        }
        return $this->parsedTable;
    }

    /**
     * 获取where 条件，绑定以后的
     * @return string
     */
    function getWhere(){
        if(empty($this->parsedWhere)){
            $queue = [];
            $db = $this->db;
            //[{condition, relation, isRaw}]
            foreach ($this->where as $row){
                $value = '';
                // 关系判断
                $relation = $row['relation'];
                $isRaw = $row['isRaw'];
                $condition = $row['condition'];
                if($isRaw){     // 不解析条件
                    $value .= $condition;
                }else{
                    if(is_array($condition)){
                        // 三重条件判断
                        $isTriple = false;
                        if(count($condition) == 3){
                            $isTriple = true;
                            $i = 0;
                            $condKeys = array_keys($condition);
                            while ($i<3){
                                $ck = $condKeys[$i];
                                if(!is_int($ck) || is_array($condition[$ck])){
                                    $isTriple = false;
                                    break;
                                }
                                $i++;
                            }
                        }
                        if($isTriple){
                            list($newCol, $nRelation, $nValue) = $condition;
                            $bindKey = $this->_getNewBindKey($newCol);
                            $this->bindData[$bindKey] = $nValue;
                            $newCol = $db->qC($newCol);
                            $value .= $newCol.' '.$nRelation.' :'.$bindKey;
                        }
                        foreach ($condition as $column=>$val){
                            if($isTriple){
                                break;
                            }
                            // 绑定参数： k/v
                            if(is_string($column) && !is_array($val)){
                                $bindKey = $this->_getNewBindKey($column);
                                $this->bindData[$bindKey] = $val;
                                $column = $db->qC($column);
                                $value .= ($value? ' '. $relation.' ':'').$column.' = :'.$bindKey;
                            }elseif (is_int($column) && is_array($val) && count($val) == 3){
                                list($newCol, $nRelation, $nValue) = $val;
                                $bindKey = $this->_getNewBindKey($newCol);
                                $this->bindData[$bindKey] = $nValue;
                                $newCol = $db->qC($newCol);
                                $value .= ($value? ' '. $relation.' ':'').$newCol.' '.$nRelation.' :'.$bindKey;
                            }
                        }
                    }else{
                        $value .= $condition;
                    }
                }
                if(count($queue) > 0){
                    $value = $relation.' '. $value;
                }
                $queue[] = $value;
            }
            $this->parsedWhere = implode(' ', $queue);
            // 条件生成
            if($this->parsedWhere){
                $this->parsedWhere = ' WHERE '.$this->parsedWhere;
            }
        }
        return $this->parsedWhere;
    }

    /**
     * 获取非绑定的 where 条件，生成紧凑型 SQL 语句
     * @return string
     */
    function getNoBindWhr(){
        $wh = '';
        if(empty($this->parsedWhere)){
            $queue = [];
            $db = $this->db;
            //[{condition, relation, isRaw}]
            foreach ($this->where as $row){
                $value = '';
                // 关系判断
                $relation = $row['relation'];
                $isRaw = $row['isRaw'];
                $condition = $row['condition'];
                if($isRaw){     // 不解析条件
                    $value .= $condition;
                }else{
                    if(is_array($condition)){
                        // 三重条件判断
                        $isTriple = false;
                        if(count($condition) == 3){
                            $isTriple = true;
                            $i = 0;
                            $condKeys = array_keys($condition);
                            while ($i<3){
                                $ck = $condKeys[$i];
                                if(!is_int($ck) || is_array($condition[$ck])){
                                    $isTriple = false;
                                    break;
                                }
                                $i++;
                            }
                        }
                        if($isTriple){
                            list($newCol, $nRelation, $nValue) = $condition;
                            $newCol = $db->qC($newCol);
                            $value .= $newCol.' '.$this->_getRelation($nRelation).' '.$db->qV($nValue);
                        }
                        // 条件循环
                        foreach ($condition as $column=>$val){
                            if($isTriple){
                                break;
                            }
                            // 绑定参数： k/v
                            if(is_string($column) && !is_array($val)){
                                $column = $db->qC($column);
                                $value .= ($value? ' '. $relation.' ':'').$column.' = '.$db->qV($val);
                            }elseif (is_int($column) && is_array($val) && count($val) == 3){
                                list($newCol, $nRelation, $nValue) = $val;
                                $newCol = $db->qC($newCol);
                                $value .= ($value? ' '. $relation.' ':'').$newCol.' '.$this->_getRelation($nRelation).' '.$db->qV($nValue);
                            }
                        }
                    }else{
                        $value .= $condition;
                    }
                }
                if(count($queue) > 0){
                    $value = $relation.' '. $value;
                }
                $queue[] = $value;
            }
            $wh = implode(' ', $queue);
            // 条件生成
            if($wh){
                $wh = ' WHERE '.$wh;
            }
        }
        return $wh;
    }

    /**
     * 特殊字符串
     * @param string $relation
     * @return string
     */
    protected function _getRelation($relation){
        if('like' == $relation){
            $relation = 'LIKE';
        }
        return $relation;
    }
    /**
     * 获取字段值
     * @return string
     */
    function getField(){
        if(empty($this->parsedField)){
            $queue = [];
            $db = $this->db;
            foreach ($this->field as $k=>$v){
                if(is_int($k) && !is_array($v)){
                    $queue[] = $db->qC($v);
                }
                elseif (is_array($v)){
                    list($key, $alias) = $v;
                    $queue[] = $db->qC($key).' AS '.$db->qC($alias);
                }
                else{
                    $queue[] = $db->qC($k).' AS '.$db->qC($v);
                }
            }
            $this->parsedField = empty($queue)? '*': implode(',', $queue);
        }
        return $this->parsedField;
    }

    /**
     *
     * 生成新的绑定值
     * @param $key
     * @return string
     */
    private function _getNewBindKey($key){
        if(strpos($key, '.') !== false){
            $key = preg_replace('/[a-z0-9]+\./', '', $key);
        }
        $column = self::bindRefStr. $key;
        return $column;
    }
}