<?php
/**
 * 网站设置
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
class settingControl extends SystemControl{
	private $links = array(
		array('url'=>'act=setting&op=base','lang'=>'web_set'),
		array('url'=>'act=setting&op=dump','lang'=>'dis_dump'),
	);
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 基本信息
	 */
	public function baseOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			//上传网站Logo
			if (!empty($_FILES['site_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$result = $upload->upfile('site_logo');
				if ($result){
					$_POST['site_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			$list_setting = $model_setting->getListSetting();
			$update_array = array();
			$update_array['site_name'] = $_POST['site_name'];
			$update_array['site_phone'] = $_POST['site_phone'];
			$update_array['site_bank_account'] = $_POST['site_bank_account'];
			$update_array['site_email'] = $_POST['site_email'];
			$update_array['statistics_code'] = $_POST['statistics_code'];
			if (!empty($_POST['site_logo'])){
				$update_array['site_logo'] = $_POST['site_logo'];
			}
			$update_array['site_desc'] = $_POST['site_desc'];
			$update_array['site_keyword'] = $_POST['site_keyword'];
			$update_array['icp_number'] = $_POST['icp_number'];
			$update_array['site_status'] = $_POST['site_status'];
			$update_array['closed_reason'] = $_POST['closed_reason'];
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				//判断有没有之前的图片，如果有则删除
				if (!empty($list_setting['site_logo']) && !empty($_POST['site_logo'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS.$list_setting['site_logo']);
				}
				$this->log(L('nc_edit,web_set'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,web_set'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);

		//输出子菜单
		Tpl::output('top_link',$this->sublink($this->links,'base'));

		Tpl::showpage('setting.base');
	}
}
