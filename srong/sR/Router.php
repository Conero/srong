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
    const MethodCli = 'cli';                    // cli  方法
    const CliUnfind = ':unfind';               // 未发现路由配置
    protected static $routerRuleDick = [];      // 路由规则
    protected static $queryString = '';         // 请求地址
    protected static $queryRawString = '';
    protected static $queryParam = [];          // 请求参数
    /**
     * 路由监听器
     */
    static function listen(){
        if(!Adapter::isCli()){
            self::webListener();
        }else{
            self::cliListener();
        }
        $setTrack = Adapter::getAppConfig()->value('track');
        if($setTrack){
            Log::info('用时: '.Adapter::getRtime().'s');
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
        self::$queryRawString = $queryString;

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
     * @return bool
     */
    protected static function cliAutoRouter(){
        $findMk = false;
        $app = Adapter::getAppConfig();
        if($app->value('auto_router')){
            $command = Cli::getCommand();
            if($command){
                $nsPref = $app->value('cli.ns_pref');
                foreach ($nsPref as $v){
                    $cls = $v. ucfirst($command);
                    if(class_exists($cls)){
                        $instance = new $cls();
                        $action = Cli::getAction();
                        if(method_exists($instance, $action)){
                            call_user_func([$instance, $action]);
                        }
                    }
                }
            }
        }
        return $findMk;
    }
    /**
     * cli 程序路由
     */
    protected static function cliListener(){
        $ruleDick = self::$routerRuleDick[self::MethodCli] ?? [];
        $unfindHld = false;
        $metchedRouterMk = false;
        foreach ($ruleDick as $data){
            $name = $data['name'] ?? false;
            if($name == self::CliUnfind){
                $unfindHld = ($data['callback'] ?? false);
                continue;
            }
            $name = self::getStdRuleStr($name);
            $matched = self::matchTheCliRule($name);
            if($matched){
                $args = ($matched['args'] ?? false);
                if(!empty($args) && is_array($args)){
                    $args = array_values($args);
                    call_user_func($data['callback'], ...$args);
                }else{
                    call_user_func($data['callback']);
                }
                $metchedRouterMk = true;
                break;
            }
        }

        // 自动路由
        if($metchedRouterMk == false){
            $metchedRouterMk = self::cliAutoRouter();
        }

        // 路由失败
        if($metchedRouterMk == false && $unfindHld && is_callable($unfindHld)){
            $args = Cli::getCmdQueue();
            call_user_func($unfindHld, (!empty($args)? implode('/', $args): null));
        }
    }

    /**
     * cli rule 解析
     * @param $name
     * @return array|null
     */
    protected static function matchTheCliRule($name){
        $matched = null;
        $args = [];
        $ruleQue = explode('/', $name);
        $cmdQueue = Cli::getCmdQueue();

        if(!empty($cmdQueue) && count($ruleQue) == count($cmdQueue)){
            $ruleMatched = true;
            foreach ($ruleQue as $i => $v){
                if(substr($v, 0, 1) == '{' && substr($v, -1) == '}'){
                    $key = substr($v, 1, -1);
                    $args[$key] = $cmdQueue[$i];
                }elseif ($v !== $cmdQueue[$i]){
                    $ruleMatched = false;
                    break;
                }
            }
            // 配置成功是放回标识
            if($ruleMatched){
                return [
                    'args' => $args
                ];
            }
        }
        return $matched;
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

    /**
     * @return string
     */
    static function getPath(){
        return self::$queryRawString;
    }

    /**
     * cli 模式下路由
     * @param string $name
     * @param mixed $callback
     */
    static function cli($name, $callback){
        $cli = self::MethodCli;
        if(!isset(self::$routerRuleDick[$cli])){
            self::$routerRuleDick[$cli] = [];
        }
        self::$routerRuleDick[$cli][] = ['name'=>$name, 'callback'=>$callback];
    }

    /**
     * @param string $method
     * @param string $rule
     * @param $callback
     */
    static function match($method, $rule, $callback){
        $method = preg_replace('/\s/', '', $method);
        foreach (explode('|', $method) as $mth){
            if(empty($mth)){
                continue;
            }
            if(!isset(self::$routerRuleDick[$mth])){
                self::$routerRuleDick[$mth] = [];
            }
            $data = ['callback'=>$callback];
            if($mth == self::MethodCli){
                $data['name'] = $rule;
            }else{
                $data['path'] = $rule;
            }
            self::$routerRuleDick[$mth][] = $data;
        }
    }
}