<?php
/**
 * 类型管理
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
class typesControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('types');
	}
	/**
	 * 文章管理
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_types = Model('types');
		$model_upload = Model('upload');
		
		/**
		 * 删除
		 */
		if (chksubmit()){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				foreach ($_POST['del_id'] as $k => $v){
					$v = intval($v);
					$model_types->del($v);
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
		$types_list = $model_types->getList($condition,$page);
		Tpl::output('types_list',$types_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('types.index');
	}

	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_types = Model('types');
		
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["types_name"], "require"=>"true", "message"=>'名称必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['name'] = trim($_POST['types_name']);
				$insert_array['group_type'] = intval($_POST['types_group_type']);
				$insert_array['ordering'] = intval($_POST['types_ordering']);
				$result = $model_types->add($insert_array);
				if ($result){
					showMessage("添加成功",'index.php?act=types&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::showpage('types.add');
	}

	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_types = Model('types');
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["types_name"], "require"=>"true", "message"=>'名称必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['id'] = intval($_POST['types_id']);
				$update_array['name'] = trim($_POST['types_name']);
				$update_array['group_type'] = intval($_POST['types_group_type']);
				$update_array['ordering'] = intval($_POST['types_ordering']);

				$result = $model_types->update($update_array);
				if ($result){
					showMessage('修改成功',$_POST['ref_url']);
				}else {
					showMessage('修改失败');
				}
			}
		}

		$types_array = $model_types->getOne(intval($_GET['types_id']));
		if (empty($types_array)){
			showMessage($lang['param_error']);
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('types_array',$types_array);
		Tpl::showpage('types.edit');
	}
}
