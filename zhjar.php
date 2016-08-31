<?php
/**
 * 入口文件
 *
 * 统一入口，进行初始化信息
 *
 *
 */

error_reporting(E_ALL & ~E_NOTICE);
define('BASE_ROOT_PATH',str_replace('\\','/',dirname(__FILE__)));
define('BASE_CORE_PATH',BASE_ROOT_PATH.'/core');
define('BASE_DATA_PATH',BASE_ROOT_PATH.'/data');
define("BASE_UPLOAD_PATH", BASE_ROOT_PATH . "/data/upload");
define("BASE_RESOURCE_PATH", BASE_ROOT_PATH . "/data/resource");

if (!extension_loaded('shopnc'))
{
    require __DIR__ . '/core/zhjar/core.php';
    require __DIR__ . '/core/zhjar/log.php';
    require __DIR__ . '/core/zhjar/tpl.php';
}

/**
 * 初始化
 */
Zhjar\Core::initializeApplication(require BASE_DATA_PATH . '/config/config.ini.php');

define('DIR_MOBILE','mobile');
define('DIR_WAP','wap');

define('DIR_RESOURCE','data/resource');
define('DIR_UPLOAD','data/upload');

define('ATTACH_COMMON','common');
define('ATTACH_WEIXIN','weixin');
define('ATTACH_NEWS','news');
define('ATTACH_LINKS','links');
define('TPL_ADMIN_NAME', 'default');


$_GET['act'] = $_GET['act'] ? strtolower($_GET['act']) : ($_POST['act'] ? strtolower($_POST['act']) : null);
$_GET['op'] = $_GET['op'] ? strtolower($_GET['op']) : ($_POST['op'] ? strtolower($_POST['op']) : null);

if (empty($_GET['act'])){
    require_once(BASE_CORE_PATH.'/framework/core/route.php');
    new Route($config);
}
//统一ACTION
$_GET['act'] = preg_match('/^[\w]+$/i',$_GET['act']) ? $_GET['act'] : 'index';
$_GET['op'] = preg_match('/^[\w]+$/i',$_GET['op']) ? $_GET['op'] : 'index';

//对GET POST接收内容进行过滤,$ignore内的下标不被过滤
$ignore = array('content');
if (!class_exists('Security')) require(BASE_CORE_PATH.'/framework/libraries/security.php');
$_GET = !empty($_GET) ? Security::getAddslashesForInput($_GET,$ignore) : array();
$_POST = !empty($_POST) ? Security::getAddslashesForInput($_POST,$ignore) : array();
$_REQUEST = !empty($_REQUEST) ? Security::getAddslashesForInput($_REQUEST,$ignore) : array();
$_SERVER = !empty($_SERVER) ? Security::getAddSlashes($_SERVER) : array();

//启用ZIP压缩
if ($config['gzip'] == 1 && function_exists('ob_gzhandler') && $_GET['inajax'] != 1){
	ob_start('ob_gzhandler');
}else {
	ob_start();
}

require_once(BASE_CORE_PATH.'/framework/libraries/queue.php');
