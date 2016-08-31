<?php
/**
 * 链接管理
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
class linksControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('links');
	}
	/**
	 * 文章管理
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_links = Model('links');
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
					$condition['upload_type'] = '10';
					$condition['item_id'] = $v;
					$upload_list = $model_upload->getUploadList($condition);
					if (is_array($upload_list)){
						foreach ($upload_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LINKS.DS.$v_upload['file_name']);
						}
					}
					$model_links->del($v);
				}
				showMessage('删除成功');
			}else {
				showMessage('请选择删除项');
			}
		}
		
		/**
		 * 检索条件
		 */
		$condition = array();
		if (isset($_GET['search_name'])) {
			$condition['like_name'] = trim($_GET['search_name']);
		}
		if (isset($_GET['search_type_id'])) {
			$condition['type_id'] = intval($_GET['search_type_id']);
		}
		Tpl::output('search_type_id',intval($_GET['search_type_id']));
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 列表
		 */
		$links_list = $model_links->getList($condition,$page);
		if (count($links_list)>0) {
			foreach ($links_list as $key => $links_info) {
				$condition1['upload_type'] = '1';
				$condition1['item_id'] = $links_info['id'];
				$upload_list = $model_upload->getUploadList($condition1);
				if (is_array($upload_list)){
					foreach ($upload_list as $k => $v){
						$upload_list[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_LINKS.'/'.$upload_list[$k]['file_name'];
					}
				}
				$links_list[$key]['upload_path'] = count($upload_list)>0?$upload_list[0]['upload_path']:'';
			}
		}

		//类型列表
		$model_types = Model('types');
		$types_list = $model_types->getList(array('group_type'=>1,'order'=>' ordering desc'));
		Tpl::output('types_list',$types_list);
		
		Tpl::output('links_list',$links_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('links.index');
	}

	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_links = Model('links');
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
				array("input"=>$_POST["links_title"], "require"=>"true", "message"=>'标题必填'),
				array("input"=>$_POST["links_link_url"], "require"=>"true", "message"=>'链接地址必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['title'] = trim($_POST['links_title']);
				$insert_array['link_url'] = trim($_POST['links_link_url']);
				$insert_array['color'] = trim($_POST['links_color']);
				$insert_array['ordering'] = trim($_POST['links_ordering']);
				$insert_array['description'] = trim($_POST['links_desc']);
				$insert_array['input_time'] = curtime_format();
				
				//类型
				$type_ids = '';
				if (!empty($_POST['type_ids'])) {
					foreach ($_POST['type_ids'] as $key => $type_id) {
						$type_ids .= $type_id.',';
					}
					$insert_array['type_ids'] = substr($type_ids, 0,strlen($type_ids)-1);
				}
				
				$result = $model_links->add($insert_array);
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
					
					showMessage("添加成功",'index.php?act=links&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '1';
		$condition['item_id'] = '0';
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_LINKS.'/'.$file_upload[$k]['file_name'];
			}
		}
		
		//类型列表
		$types_list = $model_types->getList(array('group_type'=>1,'order'=>' ordering desc'));
		Tpl::output('types_list',$types_list);

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::showpage('links.add');
	}

	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_links = Model('links');
		$model_types = Model('types');
		
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["links_title"], "require"=>"true", "message"=>'标题必填'),
				array("input"=>$_POST["links_link_url"], "require"=>"true", "message"=>'链接地址必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['id'] = intval($_POST['links_id']);
				$update_array['title'] = trim($_POST['links_title']);
				$update_array['link_url'] = trim($_POST['links_link_url']);
				$update_array['color'] = trim($_POST['links_color']);
				$update_array['ordering'] = trim($_POST['links_ordering']);
				$update_array['description'] = $_POST['links_desc'];

				//类型
				$type_ids = '';
				if (!empty($_POST['type_ids'])) {
					foreach ($_POST['type_ids'] as $key => $type_id) {
						$type_ids .= $type_id.',';
					}
					$update_array['type_ids'] = substr($type_ids, 0,strlen($type_ids)-1);
				}
				
				$result = $model_links->update($update_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$update_array = array();
							$update_array['upload_id'] = intval($v);
							$update_array['item_id'] = intval($_POST['links_id']);
							$model_upload->update($update_array);
							unset($update_array);
						}
					}
					
					//类型
					$type_ids = '';
					if (!empty($_POST['type_ids'])) {
						foreach ($_POST['type_ids'] as $key => $type_id) {
							$type_ids .= $type_id.',';
						}
						$update_array['type_ids'] = substr($type_ids, 0,strlen($type_ids)-1);
					}
					
					showMessage('修改成功',$_POST['ref_url']);
				}else {
					showMessage('修改失败');
				}
			}
		}

		$links_array = $model_links->getOne(intval($_GET['links_id']));
		if (empty($links_array)){
			showMessage($lang['param_error']);
		}

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '1';
		$condition['item_id'] = $links_array['id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_LINKS.'/'.$file_upload[$k]['file_name'];
			}
		}
		
		//类型列表
		$types_list = $model_types->getList(array('group_type'=>1,'order'=>' ordering desc'));
		Tpl::output('types_list',$types_list);

		//所选类型
		$chos_ids =array();
		if (!empty($links_array['type_ids'])) {
			$chos_ids = explode(',', $links_array['type_ids']);
		}
		Tpl::output('chos_ids',$chos_ids);
		
		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('links_array',$links_array);
		Tpl::showpage('links.edit');
	}
	/**
	 * 文章图片上传
	 */
	public function pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_LINKS);
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
		$insert_array['upload_type'] = '1';
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
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LINKS.DS.$file_array['file_name']);
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
