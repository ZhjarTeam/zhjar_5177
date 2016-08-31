<?php
/**
 * 网址
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
use Zhjar\Tpl;


defined('InShopNC') or exit('Access Invalid!');
class linksControl extends BaseHomeControl{
		
	public function addOp(){
		$title = trim($_POST ['siteName']);
		$link_url = trim($_POST ['siteUrl']);
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
				array("input"=>$title, "require"=>"true", "message"=>'网站名称必填'),
				array("input"=>$link_url, "require"=>"true", "message"=>'网址必填'),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage($error);
		}else {
			$model_links = Model('links');
			$insert_array = array();
			$insert_array['title'] = $title;
			$insert_array['link_url'] = $link_url;
			$insert_array['type_ids'] = 15;
			$insert_array['input_time'] = curtime_format();
			$result = $model_links->add($insert_array);
			if ($result){
				successJson('succ',$result);
			}else {
				errorJson('fail');
			}
		}
		
	}
}
