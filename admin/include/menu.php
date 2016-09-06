<?php
/**
 * 菜单
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
/**
 * top 数组是顶部菜单 ，left数组是左侧菜单
 * left数组中'args'=>'welcome,dashboard,dashboard',三个分别为op,act,nav，权限依据act来判断
 */
$arr = array(
		'top' => array(
			0 => array(
				'args' 	=> 'dashboard',
				'text' 	=> $lang['nc_console']),
			1 => array(
					'args' 	=> 'zhjar',
					'text' 	=> '内容'),
		),
		'left' =>array(
			0 => array(
				'nav' => 'dashboard',
				'text' => $lang['nc_normal_handle'],
				'list' => array(
					array('args'=>'base,setting,dashboard',	'text'=>$lang['nc_web_set']),
					array('args'=>'index,menu,dashboard',	'text'=>"导航设置"),
					array('args'=>'index,types,dashboard',	'text'=>"类型设置"),
				)
			),
			1 => array(
					'nav' => 'zhjar',
					'text' => '内容管理',
					'list' => array(
							array('args'=>'index,article,zhjar',			'text'=>'图文管理'),
							array('args'=>'index,news,zhjar',			'text'=>'新闻管理'),
							array('args'=>'index,links,zhjar',			'text'=>'链接管理'),
							array('args'=>'index,weixin,zhjar',			'text'=>'公众号管理'),
							array('args'=>'index,video,zhjar',			'text'=>'视频管理'),
							array('args'=>'index,trend,zhjar',			'text'=>'走势管理'),
					)
			),
		),

);

return $arr;
?>
