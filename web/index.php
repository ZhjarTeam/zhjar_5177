<?php
/**
 * 主页板块初始化文件
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
define('APP_ID','web');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

require __DIR__ . '/../zhjar.php';

define('APP_SITE_URL',WEB_SITE_URL);
define('TPL_NAME','default');
define('WEB_TEMPLATES_URL',WEB_SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);

Zhjar\Core::runApplication();
