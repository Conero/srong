<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:41
 * Email: brximl@163.com
 * Name: 路由器
 */

namespace sR;


class Router
{
    protected static $routerRuleDick = [];  // 路由规则
    protected static $queryString = ''; // 请求地址
    protected static $queryParam = [];  // 请求参数
    /**
     * 路由监听器
     */
    static function listen(){
        if(!Adapter::isCli()){
            self::webListener();
        }else{
            println('系统载入成功！');
        }
    }


    /**
     * web 路由规则检测
     * @param $rule
     * @return bool
     */
    protected static function matchTheWebRule($rule){
        $matched = false;
        // 快速匹配
        if($rule == self::$queryString){
            $matched = true;
        } else{
          static $qStrQue = null;
          if(!$qStrQue){
              $qStrQue = explode('/', self::$queryString);
          }
          $rStrQue = explode('/', $rule);
          if(count($qStrQue) == count($rStrQue)){
                $param = [];
                $allMatched = true;
                foreach ($rStrQue as $i => $v){
                    $qv = $qStrQue[$i];
                    if(substr($v, 0, 1) == '{' && substr($v, -1) == '}'){
                        $key = substr($v, 1, -1);
                        $param[$key] = $qv;
                    }else if($v != $qv){
                        $allMatched = false;
                        break;
                    }
                }
                if($allMatched){
                    $matched = $allMatched;
                    self::$queryParam = $param;
                }
          }
        }
        return $matched;
    }

    /**
     * 获取标准的规则字符串
     * @param string $rule
     * @return bool|string
     */
    protected static function getStdRuleStr($rule){
        // 获取 /path/test/ => path/test
        $rule = preg_replace('/\s/', '', $rule);
        if($rule && '/' == substr($rule, 0, 1)){
            $rule = substr($rule, 1);
        }
        if($rule && '/' == substr($rule, -1)){
            $rule = substr($rule, 0, -1);
        }
        return $rule;
    }
    /**
     * web 监听处理
     */
    protected static function webListener(){
        $app = Adapter::getAppConfig();
        $queryString = $app->value('web.rewrite_key');
        $queryString = ($_GET[$queryString] ?? null);
        $queryString = ($queryString? self::getStdRuleStr($queryString) : null);

        self::$queryString = $queryString;

        // 路由匹配
        $method = Request::method();
        $ruleDick = self::$routerRuleDick[$method] ?? [];
        $findPathMk = false;
        foreach ($ruleDick as $rules){
            $rtdata = self::matchTheWebRule($rules['path']);
            if($rtdata){
                if($rules['callback'] ?? false){
                    $param = self::$queryParam;
                    $param = empty($param)? false: array_values($param);
                    if(is_array($param)){
                        call_user_func($rules['callback'], ...$param);
                    }else{
                        call_user_func($rules['callback']);
                    }
                    $findPathMk = true;
                }
                break;
            }
        }
        // 路由失败处理
        if(false === $findPathMk){
            $unfindRouter = (self::$routerRuleDick['unfind'] ?? false);
            if(is_callable($unfindRouter)){
                call_user_func($unfindRouter);
            }
        }
    }

    /**
     * @param $path
     * @param $callback
     */
    static function get($path, $callback){
        if(!isset(self::$routerRuleDick['get'])){
            self::$routerRuleDick['get'] = [];
        }
        $path = self::getStdRuleStr($path);
        self::$routerRuleDick['get'][] = ['path'=>$path, 'callback'=>$callback];
    }

    /**
     * @param $path
     * @param $callback
     */
    static function post($path, $callback){
        if(!isset(self::$routerRuleDick['post'])){
            self::$routerRuleDick['post'] = [];
        }
        $path = self::getStdRuleStr($path);
        self::$routerRuleDick['post'][] = ['path'=>$path, 'callback'=>$callback];
    }

    /**
     * 未发现路由的处理
     * @param callable $callback
     */
    static function unfind($callback){
        self::$routerRuleDick['unfind'] = $callback;
    }
}