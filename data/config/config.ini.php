<?php

// defined('InShopNC') or exit('Access Invalid!');

$config = array();
$config['web_site_url'] 		= '/web';
$config['admin_site_url'] 		= '/admin';
$config['node_site_url'] 		= 'http://192.168.3.50:8090';
$config['upload_site_url']		= '/data/upload';
$config['resource_site_url']	= '/data/resource';

$config['version'] 		= '201405154774';
$config['setup_date'] 	= '2014-11-27 10:50:15';
$config['gip'] 			= 0;
$config['dbdriver'] 	= 'mysqli';
$config['tablepre']		= 'jar_';
$config['db']['master']['dbhost']       = '192.168.3.50';
$config['db']['master']['dbport']       = '3306';
$config['db']['master']['dbuser']       = 'root';
$config['db']['master']['dbpwd']        = 'abc123.db';
$config['db']['master']['dbname']       = 'zhjar';
$config['db']['master']['dbcharset']    = 'UTF-8';
$config['db']['slave']                  = $config['db']['master'];
$config['session_expire'] 	= 3600;
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= 'D7E7_';
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 			= 'file';
//$config['redis']['prefix']      	= 'nc_';
//$config['redis']['master']['port']     	= 6379;
//$config['redis']['master']['host']     	= '127.0.0.1';
//$config['redis']['master']['pconnect'] 	= 0;
//$config['redis']['slave']      	    = array();
//$config['fullindexer']['open']      = false;
//$config['fullindexer']['appname']   = 'shopnc';
$config['debug'] 			= false;
$config['default_store_id'] = '1';
$config['url_model'] = true;
$config['subdomain_suffix'] = '';
$config['node_chat'] = true;
//娴侀噺璁板綍琛ㄦ暟閲忥紝涓�~10涔嬮棿鐨勬暟瀛楋紝榛樿涓�锛屾暟瀛楄缃畬鎴愬悗璇蜂笉瑕佽交鏄撲慨鏀癸紝鍚﹀垯鍙兘閫犳垚娴侀噺缁熻鍔熻兘鏁版嵁閿欒
$config['flowstat_tablenum'] = 3;
$config['sms']['gwUrl'] = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService';
$config['sms']['serialNumber'] = '';
$config['sms']['password'] = '';
$config['sms']['sessionKey'] = '';
$config['queue']['open'] = false;
$config['queue']['host'] = '127.0.0.1';
$config['queue']['port'] = 6379;
return $config;