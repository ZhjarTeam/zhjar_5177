<?php
/**
 * 公众号管理
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
class weixinControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('weixin');
	}
	/**
	 * 文章管理
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_weixin = Model('weixin');
		$model_upload = Model('upload');
		
		/**
		 * 删除
		 */
		if (chksubmit()){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				foreach ($_POST['del_id'] as $k => $v){
					$v = intval($v);
					/**
					 * 删除图片
					 */
					$condition['upload_type'] = '2';
					$condition['item_id'] = $v;
					$upload_list = $model_upload->getUploadList($condition);
					if (is_array($upload_list)){
						foreach ($upload_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WEIXIN.DS.$v_upload['file_name']);
						}
					}
					$model_weixin->del($v);
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
		$weixin_list = $model_weixin->getList($condition,$page);
		if (count($weixin_list)>0) {
			foreach ($weixin_list as $key => $weixin_info) {
				$condition1['upload_type'] = '2';
				$condition1['item_id'] = $weixin_info['id'];
				$upload_list = $model_upload->getUploadList($condition1);
				if (is_array($upload_list)){
					foreach ($upload_list as $k => $v){
						$upload_list[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_WEIXIN.'/'.$upload_list[$k]['file_name'];
					}
				}
				$weixin_list[$key]['upload_path'] = count($upload_list)>0?$upload_list[0]['upload_path']:'';
			}
		}

		Tpl::output('weixin_list',$weixin_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('weixin.index');
	}

	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_weixin = Model('weixin');
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["weixin_title"], "require"=>"true", "message"=>'标题必填'),
				array("input"=>$_POST["file_id"][0], "require"=>"true", "message"=>'二维码必上传'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['name'] = trim($_POST['weixin_title']);
				$insert_array['color'] = trim($_POST['weixin_color']);
				$insert_array['description'] = trim($_POST['weixin_desc']);
				$insert_array['ordering'] = trim($_POST['weixin_ordering']);
				$insert_array['input_time'] = curtime_format();
				$insert_array['hot'] = trim($_POST['weixin_hot']);
				$result = $model_weixin->add($insert_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$v = intval($v);
							$update_array = array();
							$update_array['upload_id'] = $v;
							$update_array['item_id'] = $result;
							$model_upload->update($update_array);
							unset($update_array);
						}
					}

					showMessage("添加成功",'index.php?act=weixin&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '2';
		$condition['item_id'] = '0';
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_WEIXIN.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::showpage('weixin.add');
	}

	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_weixin = Model('weixin');

		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["weixin_title"], "require"=>"true", "message"=>'标题必填'),
				array("input"=>$_POST["file_id"][0], "require"=>"true", "message"=>'二维码必上传'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['id'] = intval($_POST['weixin_id']);
				$update_array['name'] = trim($_POST['weixin_title']);
				$update_array['color'] = trim($_POST['weixin_color']);
				$update_array['description'] = trim($_POST['weixin_desc']);
				$update_array['ordering'] = trim($_POST['weixin_ordering']);
				$update_array['hot'] = trim($_POST['weixin_hot']);
				$result = $model_weixin->update($update_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$update_array = array();
							$update_array['upload_id'] = intval($v);
							$update_array['item_id'] = intval($_POST['weixin_id']);
							$model_upload->update($update_array);
							unset($update_array);
						}
					}
					showMessage('修改成功',$_POST['ref_url']);
				}else {
					showMessage('修改失败');
				}
			}
		}

		$weixin_array = $model_weixin->getOne(intval($_GET['weixin_id']));
		if (empty($weixin_array)){
			showMessage($lang['param_error']);
		}

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '2';
		$condition['item_id'] = $weixin_array['id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_WEIXIN.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('weixin_array',$weixin_array);
		Tpl::showpage('weixin.edit');
	}
	/**
	 * 文章图片上传
	 */
	public function pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_WEIXIN);
		$result = $upload->upfile('fileupload');
		if ($result){
			$_POST['pic'] = $upload->file_name;
		}else {
			echo 'error';exit;
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		/**
		 * 图片数据入库
		 */
		$insert_array = array();
		$insert_array['file_name'] = $_POST['pic'];
		$insert_array['upload_type'] = '2';
		$insert_array['file_size'] = $_FILES['fileupload']['size'];
		$insert_array['upload_time'] = time();
		$insert_array['item_id'] = intval($_POST['item_id']);
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['file_id'] = $result;
			$data['file_name'] = $_POST['pic'];
			$data['file_path'] = $_POST['pic'];
			/**
			 * 整理为json格式
			 */
			$output = json_encode($data);
			echo $output;
		}

	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 删除文章图片
			 */
			case 'del_file_upload':
				if (intval($_GET['file_id']) > 0){
					$model_upload = Model('upload');
					/**
					 * 删除图片
					 */
					$file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WEIXIN.DS.$file_array['file_name']);
					/**
					 * 删除信息
					 */
					$model_upload->del(intval($_GET['file_id']));
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
}
