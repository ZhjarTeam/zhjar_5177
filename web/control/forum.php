<?php
/**
 * 新闻
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
class forumControl extends BaseHomeControl{

	public function listOp(){
		Tpl::setLayout('forum_layout');
		
		$curpage = isset($_GET['curpage'])?intval($_GET['curpage']):1;
		
		$topic = intval($_GET ['topic']);
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityArticleList?topic='.$topic.'&pageIndex='.$curpage;
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		$total = intval($arr['iTotalRecords']);
		$total_page = $total%10==0?$total/10:intval($total/10)+1;
		Tpl::output('total_page',$total_page);
		Tpl::output('forum_list',$arr['results']);
		
		//最新推荐
		$model_news = Model('news');
		$page	= new Page();
		$page->setEachNum(7);
		$news_list = $model_news->getList(array('type_id'=>3),$page);
		Tpl::output('rec_news_list',$news_list);
		
		//adv
		$this->getAdvInfo();
		
		//menu
		$this->getForumMenu();
		
		Tpl::showpage('forum_list');
	}
	
	public function showOp(){
		Tpl::setLayout('forum_layout');
		
		$id = ($_GET ['id']);
		if (empty($id)) {
			error();
		}

		$topic = intval($_GET ['topic']);
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityArticleContentById?id='.$id;
		$rs = file_get_contents($url);
		$info = json_decode($rs,true);
		$forum_info = $info['results']['communityArticleView'];
		Tpl::output('forum_info',$forum_info);
		
		//最新推荐
		$model_news = Model('news');
		$page	= new Page();
		$page->setEachNum(7);
		$news_list = $model_news->getList(array('type_id'=>3),$page);
		Tpl::output('rec_news_list',$news_list);
		
		//相关推荐
		$page->setEachNum(12);
		$news_list = $model_news->getList(array('order'=>' ordering desc'),$page);
		Tpl::output('other_news_list',$news_list);
		
		
		//adv
		$this->getAdvInfo();
		
		//menu
		$this->getForumMenu();
		
		//seo
		$this->seo($forum_info['TITLE']);
		
		Tpl::showpage('forum_show');
	}
	
	private function  getAdvInfo(){
		$page	= new Page();
		$model_links = Model('links');
		$model_upload = Model('upload');
	
		$page->setEachNum(1);
		$links_list = $model_links->getList(array('type_id'=>10,'order'=>' ordering desc'),$page);
		$adv_info = array();
		if (!empty($links_list)) {
			$adv_info = $links_list[0];
			$condition1['upload_type'] = '1';
			$condition1['item_id'] = $adv_info['id'];
			$upload_list = $model_upload->getUploadList($condition1);
			if (is_array($upload_list)){
				foreach ($upload_list as $k => $v){
					$upload_list[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_LINKS.'/'.$upload_list[$k]['file_name'];
				}
			}
	
			$adv_info['upload_path'] = count($upload_list)>0?$upload_list[0]['upload_path']:'';
		}
		Tpl::output('adv_info',$adv_info);
	}
	
	/**
	 * 社区菜单
	 */
	private function  getForumMenu(){
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityTopicType';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		foreach ($arr['results'] as $key => $row) {
			if ($row['Id'] == $_GET['topic']) {
				$this->seo($row['Value']);
			};
		}
		
		Tpl::output('forum_menus',$arr['results']);
	}
}
