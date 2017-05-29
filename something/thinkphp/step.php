<?php
总体来说，应用的流程涉及到几个文件：
Index.php
ThinkPHP.php
Think.class.php
App.class.php
Dispatcher.class.php
ThinkPHP/Mode/common.php
ReadHtmlBehavior.class.php
Route.class.php
Hook.class.php
ContentReplaceBehavior.class.php
WriteHtmlCacheBehavior.class.php

ThinkPHP框架开发的应用的标准执行流程如下：
1.	用户URL请求
2.	调用应用入口文件（通常是网站的index.php）
3.	载入框架入口文件（ThinkPHP.php）
4.	记录初始运行时间和内存开销
(引用自ThinkPHP.php)
// 记录开始运行时间
$GLOBALS['_beginTime'] = microtime(TRUE);
// 记录内存初始使用
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();
复制代码
5.	系统常量判断及定义
(引用自ThinkPHP.php)
// 系统常量定义
defined('THINK_PATH')   or define('THINK_PATH',     __DIR__.'/');
defined('APP_PATH')     or define('APP_PATH',       dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('APP_STATUS')   or define('APP_STATUS',     ''); // 应用状态 加载对应的配置文件
defined('APP_DEBUG')    or define('APP_DEBUG',      false); // 是否调试模式
复制代码
6.	载入框架引导类（Think\Think）并执行Think::start方法进行应用初始化
(引用自ThinkPHP.php)
// 应用初始化
Think\Think::start();
复制代码
7.	设置错误处理机制和自动加载机制
(引用Think.class.php)
// 注册AUTOLOAD方法
      spl_autoload_register('Think\Think::autoload');
      // 设定错误和异常处理
      register_shutdown_function('Think\Think::fatalError');
      set_error_handler('Think\Think::appError');
      set_exception_handler('Think\Think::appException');
复制代码
8.	调用Think\Storage类进行存储初始化（由STORAGE_TYPE常量定义存储类型）
(引用Think.class.php)
// 初始化文件存储方式
   Storage::connect(STORAGE_TYPE);
复制代码
9.	部署模式下如果存在应用编译缓存文件则直接加载（直接跳转到步骤22）
(引用Think.class.php)
if(!APP_DEBUG && Storage::has($runtimefile)){
          Storage::load($runtimefile);
      }
复制代码
10.	读取应用模式（由APP_MODE常量定义）的定义文件（以下以普通模式为例说明）
Thinkphp框架默认的应用模式 为普通模式。
(引用Think.class.php)
// 读取应用模式
          $mode   =   include is_file(CONF_PATH.'core.php')?CONF_PATH.'core.php':MODE_PATH.APP_MODE.'.php';
复制代码
11.	加载当前应用模式定义的核心文件（普通模式是 ThinkPHP/Mode/common.php）
(common.php)
THINK_PATH.'Conf/convention.php',   // 系统惯例配置
CONF_PATH.'config'.CONF_EXT,      // 应用公共配置
复制代码
12.	加载惯例配置文件（普通模式是 ThinkPHP/Conf/convention.php）

13.	加载应用配置文件（普通模式是 Application/Common/Conf/config.php）

14.	加载系统别名定义
(common.php)
// 别名定义
    'alias'     =>  array(
        'Think\Log'               => CORE_PATH . 'Log'.EXT,
        'Think\Log\Driver\File'   => CORE_PATH . 'Log/Driver/File'.EXT,
        'Think\Exception'         => CORE_PATH . 'Exception'.EXT,
        'Think\Model'             => CORE_PATH . 'Model'.EXT,
        'Think\Db'                => CORE_PATH . 'Db'.EXT,
        'Think\Template'          => CORE_PATH . 'Template'.EXT,
        'Think\Cache'             => CORE_PATH . 'Cache'.EXT,
        'Think\Cache\Driver\File' => CORE_PATH . 'Cache/Driver/File'.EXT,
        'Think\Storage'           => CORE_PATH . 'Storage'.EXT,
    ),
复制代码
15.	判断并读取应用别名定义文件（普通模式是 Application/Common/Conf/alias.php）
16.	加载系统行为定义
17.	判断并读取应用行为定义文件（普通模式是 Application/Common/Conf/tags.php）
(tags.php)
'app_init'=>array('Common\Behavior\InitHookBehavior')
复制代码
18.	加载框架底层语言包（普通模式是 ThinkPHP/Lang/zh-cn.php）
19.	如果是部署模式则生成应用编译缓存文件
20.	加载调试模式系统配置文件（ThinkPHP/Conf/debug.php）
21.	判断并读取应用的调试配置文件（默认是 Application/Common/Conf/debug.php）
22.	判断应用状态并读取状态配置文件（如果APP_STATUS常量定义不为空的话）
（think.class.php）
// 读取当前应用状态对应的配置文件
   if(APP_STATUS && is_file(CONF_PATH.APP_STATUS.CONF_EXT))
   C(include CONF_PATH.APP_STATUS.CONF_EXT);
复制代码
23.	检测应用目录结构并自动生成（如果CHECK_APP_DIR配置开启并且RUNTIME_PATH目录不存在的情况下）
think.class.php
// 检查应用目录结构 如果不存在则自动创建
      if(C('CHECK_APP_DIR')) {
          $module     =   defined('BIND_MODULE') ? BIND_MODULE : C('DEFAULT_MODULE');
          if(!is_dir(APP_PATH.$module) || !is_dir(LOG_PATH)){
              // 检测应用目录结构
              Build::checkDir($module);
          }
      }
复制代码
24.	调用Think\App类的run方法启动应用
think.class.php
// 运行应用
      App::run();
复制代码
25.	应用初始化（app_init）标签位侦听并执行绑定行为
26.	判断并加载动态配置和函数文件
27.	调用Think\Dispatcher::dispatch方法进行URL请求调度
App.class.php
Dispatcher::dispatch();
复制代码
28.	自动识别兼容URL模式和命令行模式下面的$_SERVER['PATH_INFO']参数
Dispatcher.class.php
            $_SERVER['PATH_INFO'] = $_GET[$varPath];
复制代码
29.	检测域名部署以及完成模块和控制器的绑定操作（APP_SUB_DOMAIN_DEPLOY参数开启）
Dispatcher.class.php
复制代码
30.	分析URL地址中的PATH_INFO信息
Dispatcher.class.php
复制代码
31.	获取请求的模块信息
32.	检测模块是否存在和允许访问
33.	判断并加载模块配置文件、别名定义、行为定义及函数文件
34.	判断并加载模块的动态配置和函数文件
35.	模块的URL模式判断
36.	模块的路由检测（URL_ROUTER_ON开启）
Dispatcher.class.php
复制代码
37.	PATH_INFO处理（path_info）标签位侦听并执行绑定行为
38.	URL后缀检测（URL_DENY_SUFFIX以及URL_HTML_SUFFIX处理）
39.	获取当前控制器和操作，以及URL其他参数
40.	URL请求调度完成（url_dispatch）标签位侦听并执行绑定行为
41.	应用开始（app_begin）标签位侦听并执行绑定行为
App.class.php
static public function run() {
        // 应用初始化标签
        Hook::listen('app_init');
        App::init();
        // 应用开始标签
        Hook::listen('app_begin');
复制代码
42.	调用SESSION_OPTIONS配置参数进行Session初始化（如果不是命令行模式）
// Session初始化
        if(!IS_CLI){
            session(C('SESSION_OPTIONS'));
        }
复制代码
43.	根据请求执行控制器方法
44.	如果控制器不存在则检测空控制器是否存在
45.	控制器开始（action_begin）标签位侦听并执行绑定行为
Controller.class.php
public function __construct() {
        Hook::listen('action_begin',$this->config);
        //实例化视图类
        $this->view     = Think::instance('Think\View');
        //控制器初始化
        if(method_exists($this,'_initialize'))
            $this->_initialize();
    }
复制代码
46.	默认调用系统的ReadHtmlCache行为读取静态缓存（HTML_CACHE_ON参数开启）
47.	判断并调用控制器的_initialize初始化方法
Controller.class.php
if(method_exists($this,'_initialize'))
            $this->_initialize();
复制代码
48.	判断操作方法是否存在，如果不存在则检测是否定义空操作方法
49.	判断前置操作方法是否定义，有的话执行
50.	Action参数绑定检测，自动匹配操作方法的参数
51.	如果有模版渲染（调用控制器display方法）
52.	视图开始（view_begin）标签位侦听并执行绑定行为
53.	调用Think\View的fetch方法解析并获取模版内容
View.class.php
复制代码
54.	自动识别当前主题以及定位模版文件
55.	视图解析（view_parse）标签位侦听并执行绑定行为
View.class.php

            Hook::listen('view_parse',$params);
common.php
'view_parse'    =>  array(
            'Behavior\ParseTemplateBehavior', // 模板解析 支持PHP、内置模板引擎和第三方模板引擎
        ),
复制代码
56.	默认调用内置ParseTemplate行为解析模版（普通模式下面）
View.class.php
    public function parseTemplate($template='')
复制代码
57.	模版引擎解析模版内容后生成模版缓存

58.	模版过滤替换（template_filter）标签位侦听并执行绑定行为
Template.class.php
        Hook::listen('template_filter',$tmplContent);
复制代码
59.	默认调用系统的ContentReplace行为进行模版替换
'template_filter'=> array(
            'Behavior\ContentReplaceBehavior', // 模板输出替换
        ),
ContentReplaceBehavior.class.php
class ContentReplaceBehavior {
复制代码
60.	输出内容过滤（view_filter）标签位侦听并执行绑定行为
'view_filter'   =>  array(
            'Behavior\WriteHtmlCacheBehavior', // 写入静态缓存
        ),
复制代码
61.	默认调用系统的WriteHtmlCache行为写入静态缓存（HTML_CACHE_ON参数开启）
WriteHtmlCacheBehavior.class.php
class WriteHtmlCacheBehavior {
复制代码
62.	调用Think\View类的render方法输出渲染内容
63.	视图结束（view_end）标签位侦听并执行绑定行为
view.class.php
复制代码
64.	判断后置操作方法是否定义，有的话执行
65.	控制器结束（action_end）标签位侦听并执行绑定行为
Controller.class.php
复制代码
66.	应用结束（app_end）标签位侦听并执行绑定行为
App.class.php
Hook::listen('app_end');
复制代码
67.	执行系统的ShowPageTrace行为（SHOW_PAGE_TRACE参数开启并且不是AJAX请求）
68.	日志信息存储写入
