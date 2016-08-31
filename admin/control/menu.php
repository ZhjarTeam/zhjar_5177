<?php
/**
 * 菜单管理
 *
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
class menuControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('menu');
	}
	/**
	 * 文章管理
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_menu = Model('menu');
		$model_upload = Model('upload');
		
		/**
		 * 删除
		 */
		if (chksubmit()){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				foreach ($_POST['del_id'] as $k => $v){
					$v = intval($v);
					$model_menu->del($v);
				}
				showMessage('删除成功');
			}else {
				showMessage('请选择删除项');
			}
		}
		/**
		 * 检索条件
		 */
		$condition['like_name'] = trim($_GET['search_name']);
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 列表
		 */
		$menu_list = $model_menu->getList($condition,$page);
		Tpl::output('menu_list',$menu_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('menu.index');
	}

	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_menu = Model('menu');
		
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["menu_name"], "require"=>"true", "message"=>'名称必填'),
				array("input"=>$_POST["menu_link_url"], "require"=>"true", "message"=>'链接地址必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['name'] = trim($_POST['menu_name']);
				$insert_array['link_url'] = trim($_POST['menu_link_url']);
				$insert_array['ordering'] = intval($_POST['menu_ordering']);
				$insert_array['status'] = intval($_POST['menu_status']);
				$insert_array['input_time'] = curtime_format();
				$result = $model_menu->add($insert_array);
				if ($result){
					showMessage("添加成功",'index.php?act=menu&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::showpage('menu.add');
	}

	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_menu = Model('menu');
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["menu_name"], "require"=>"true", "message"=>'名称必填'),
				array("input"=>$_POST["menu_link_url"], "require"=>"true", "message"=>'链接地址必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['id'] = intval($_POST['menu_id']);
				$update_array['name'] = trim($_POST['menu_name']);
				$update_array['link_url'] = trim($_POST['menu_link_url']);
				$update_array['ordering'] = intval($_POST['menu_ordering']);
				$update_array['status'] = intval($_POST['menu_status']);

				$result = $model_menu->update($update_array);
				if ($result){
					showMessage('修改成功',$_POST['ref_url']);
				}else {
					showMessage('修改失败');
				}
			}
		}

		$menu_array = $model_menu->getOne(intval($_GET['menu_id']));
		if (empty($menu_array)){
			showMessage($lang['param_error']);
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('menu_array',$menu_array);
		Tpl::showpage('menu.edit');
	}
}
