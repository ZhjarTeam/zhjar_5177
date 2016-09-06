<?php
/**
 * 视频管理
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
class videoControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('video');
	}
	/**
	 * 文章管理
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_video = Model('video');
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
					$condition['upload_type'] = '3';
					$condition['item_id'] = $v;
					$upload_list = $model_upload->getUploadList($condition);
					if (is_array($upload_list)){
						foreach ($upload_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VIDEO.DS.$v_upload['file_name']);
						}
					}
					$team_left['upload_type'] = '4';
					$team_left['item_id'] = $v;
					$team_left_list = $model_upload->getUploadList($team_left);
					if (is_array($team_left_list)){
						foreach ($team_left_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VIDEO.DS.$v_upload['file_name']);
						}
					}
					$team_right['upload_type'] = '5';
					$team_right['item_id'] = $v;
					$team_right_list = $model_upload->getUploadList($team_right);
					if (is_array($team_right_list)){
						foreach ($team_right_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VIDEO.DS.$v_upload['file_name']);
						}
					}
					$model_video->del($v);
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
		if (trim($_GET['search_type'])) {
			$condition['type'] = trim($_GET['search_type']);
		}
		Tpl::output('search_type',$_GET['search_type']);
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 列表
		 */
		$video_list = $model_video->getList($condition,$page);

		Tpl::output('video_list',$video_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('video.index');
	}

	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_video = Model('video');
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			if ($_POST['video_type'] == '3' || $_POST['video_type'] == '4'){

				$obj_validate->validateparam = array(
					array("input"=>$_POST["video_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["video_link"], "require"=>"true", "message"=>'链接必填'),
					array("input"=>$_POST["video_time"], "require"=>"true", "message"=>'比赛时间必填'),
					array("input"=>$_POST["video_team_left"], "require"=>"true", "message"=>'左球队必填'),
					array("input"=>$_POST["video_team_right"], "require"=>"true", "message"=>'右球队必填'),
				);
			}else{

				$obj_validate->validateparam = array(
					array("input"=>$_POST["video_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["video_link"], "require"=>"true", "message"=>'链接必填'),
				);
			}
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['name'] = trim($_POST['video_title']);
				$insert_array['type'] = trim($_POST['video_type']);
				$insert_array['ordering'] = trim($_POST['video_ordering']);
				$insert_array['input_time'] = curtime_format();
				$insert_array['link_url'] = trim($_POST['video_link']);

				if ($_POST['video_type'] == '3' || $_POST['video_type'] == '4'){
					$insert_array['time'] = trim($_POST['video_time']);
					$insert_array['team_left'] = trim($_POST['video_team_left']);
					$insert_array['team_right'] = trim($_POST['video_team_right']);
				}

				$result = $model_video->add($insert_array);

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

					showMessage("添加成功",'index.php?act=video&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '3';
		$condition['item_id'] = '0';
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$file_upload[$k]['file_name'];
			}
		}

		$team_left['upload_type'] = '4';
		$team_left['item_id'] = '0';
		$left_upload = $model_upload->getUploadList($team_left);
		if (is_array($left_upload)){
			foreach ($left_upload as $k => $v){
				$left_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$left_upload[$k]['file_name'];
			}
		}

		$team_right['upload_type'] = '5';
		$team_right['item_id'] = '0';
		$right_upload = $model_upload->getUploadList($team_right);
		if (is_array($right_upload)){
			foreach ($right_upload as $k => $v){
				$right_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$right_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('left_upload',$left_upload);
		Tpl::output('right_upload',$right_upload);
		Tpl::showpage('video.add');
	}

	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_video = Model('video');

		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();

			if ($_POST['video_type'] == '3' || $_POST['video_type'] == '4'){

				$obj_validate->validateparam = array(
					array("input"=>$_POST["video_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["video_link"], "require"=>"true", "message"=>'链接必填'),
					array("input"=>$_POST["video_time"], "require"=>"true", "message"=>'比赛时间必填'),
					array("input"=>$_POST["video_team_left"], "require"=>"true", "message"=>'左球队必填'),
					array("input"=>$_POST["video_team_right"], "require"=>"true", "message"=>'右球队必填'),
				);
			}else{

				$obj_validate->validateparam = array(
					array("input"=>$_POST["video_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["video_link"], "require"=>"true", "message"=>'链接必填'),
				);
			}
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['id'] = intval($_POST['video_id']);
				$update_array['name'] = trim($_POST['video_title']);
				$update_array['type'] = trim($_POST['video_type']);
				$update_array['ordering'] = trim($_POST['video_ordering']);
				$update_array['link_url'] = trim($_POST['video_link']);

				if ($_POST['video_type'] == '3' || $_POST['video_type'] == '4'){
					$update_array['time'] = trim($_POST['video_time']);
					$update_array['team_left'] = trim($_POST['video_team_left']);
					$update_array['team_right'] = trim($_POST['video_team_right']);
				}

				$result = $model_video->update($update_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$update_array = array();
							$update_array['upload_id'] = intval($v);
							$update_array['item_id'] = intval($_POST['video_id']);
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

		$video_array = $model_video->getOne(intval($_GET['video_id']));
		if (empty($video_array)){
			showMessage($lang['param_error']);
		}

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '3';
		$condition['item_id'] = $video_array['id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$file_upload[$k]['file_name'];
			}
		}

		$team_left['upload_type'] = '4';
		$team_left['item_id'] = $video_array['id'];
		$left_upload = $model_upload->getUploadList($team_left);
		if (is_array($left_upload)){
			foreach ($left_upload as $k => $v){
				$left_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$left_upload[$k]['file_name'];
			}
		}

		$team_right['upload_type'] = '5';
		$team_right['item_id'] = $video_array['id'];
		$right_upload = $model_upload->getUploadList($team_right);
		if (is_array($right_upload)){
			foreach ($right_upload as $k => $v){
				$right_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/'.$right_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('left_upload',$left_upload);
		Tpl::output('right_upload',$right_upload);
		Tpl::output('video_array',$video_array);
		Tpl::showpage('video.edit');
	}
	/**
	 * 文章图片上传
	 */
	public function pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_VIDEO);
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
		if ($_GET['up_type']){
			$insert_array['upload_type'] = $_GET['up_type'];
		}else{
			$insert_array['upload_type'] = '3';
		}
		$insert_array['file_size'] = $_FILES['fileupload']['size'];
		$insert_array['upload_time'] = time();
		$insert_array['item_id'] = intval($_POST['item_id']);
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['upload_type'] = $_GET['up_type'];
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
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VIDEO.DS.$file_array['file_name']);
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
