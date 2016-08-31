<?php
/**
 * 图文设置
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
class articleControl extends SystemControl{
	public function __construct(){
		parent::__construct();
	}

	/**
	 * 基本信息
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_article = Model('article');
		
		/**
		 * 删除
		*/
		if (chksubmit()){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				foreach ($_POST['del_id'] as $k => $v){
					$v = intval($v);
					$model_article->del($v);
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
		$article_list = $model_article->getList($condition,$page);
		Tpl::output('article_list',$article_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_name',trim($_GET['search_name']));
		Tpl::showpage('article.index');
	}
	
	/**
	 * 文章添加
	 */
	public function addOp(){
		$lang	= Language::getLangContent();
		$model_article = Model('article');
		/**
		 * 保存
		*/
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["article_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["article_content"], "require"=>"true", "message"=>'内容必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$insert_array = array();
				$insert_array['title'] = trim($_POST['article_title']);
				$insert_array['content'] = trim($_POST['article_content']);
				$insert_array['ordering'] = intval($_POST['article_ordering']);
				$insert_array['input_time'] = curtime_format();
				$result = $model_article->add($insert_array);
				if ($result){
					showMessage("添加成功",'index.php?act=article&op=index');
				}else {
					showMessage("添加失败");
				}
			}
		}
		Tpl::output('PHPSESSID',session_id());
		Tpl::showpage('article.add');
	}
	
	/**
	 * 文章编辑
	 */
	public function editOp(){
		$lang	 = Language::getLangContent();
		$model_article = Model('article');
	
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["article_title"], "require"=>"true", "message"=>'标题必填'),
					array("input"=>$_POST["article_content"], "require"=>"true", "message"=>'内容必填'),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
	
				$update_array = array();
				$update_array['id'] = intval($_POST['article_id']);
				$update_array['title'] = trim($_POST['article_title']);
				$update_array['content'] = trim($_POST['article_content']);
				$update_array['ordering'] = intval($_POST['article_ordering']);
	
				$result = $model_article->update($update_array);
				if ($result){
					showMessage('修改成功',$_POST['ref_url']);
				}else {
					showMessage('修改失败');
				}
			}
		}
	
		$article_array = $model_article->getOne(intval($_GET['article_id']));
		if (empty($article_array)){
			showMessage($lang['param_error']);
		}
	
		Tpl::output('PHPSESSID',session_id());
		Tpl::output('article_array',$article_array);
		Tpl::showpage('article.edit');
	}
}
