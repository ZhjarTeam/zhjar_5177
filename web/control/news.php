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
class newsControl extends BaseHomeControl{
	public function listOp(){
		$type_id = intval($_GET['t']);
		if ($type_id == 0) {
			error();
		}
		
		$model_news = Model('news');
		$model_upload = Model('upload');
		
		$page	= new Page();
		$page->setEachNum(12);
		
		//列表
		$news_list = $model_news->getList(array('type_id'=>$type_id,'order'=>'input_time desc'),$page);
		if (count($news_list)>0) {
			foreach ($news_list as $key => $news_info) {
				$condition1['upload_type'] = '0';
				$condition1['item_id'] = $news_info['id'];
				$upload_list = $model_upload->getUploadList($condition1);
				if (is_array($upload_list)){
					foreach ($upload_list as $k => $v){
						$upload_list[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_NEWS.'/'.$upload_list[$k]['file_name'];
					}
				}
				$news_list[$key]['upload_path'] = count($upload_list)>0?$upload_list[0]['upload_path']:'';
			}
		}
		Tpl::output('total_page',$page->getTotalPage());
		Tpl::output('news_list',$news_list);
		
		
		//最新推荐
		$page->setEachNum(7);
		$news_list = $model_news->getList(array('type_id'=>3),$page);
		Tpl::output('rec_news_list',$news_list);
		
		//seo
		$model_types = Model('types');
		$types_info = $model_types->getOne($type_id);
		$this->seo($types_info['name']);
		
		//adv
		$this->getAdvInfo();
		
		
		Tpl::showpage('news_list');
	}
	
	public function showOp(){
		Tpl::setLayout('news_layout');
		
		$id = intval($_GET ['id']);
		if ($id == 0) {
			error();
		}
		$model_news = Model('news');
		$news_info = $model_news->getOne($id);
		if (empty($news_info['keyword'])) {
			$news_info['keyword'] = $news_info['short_tit'];
		}
		
		Tpl::output('news_info',$news_info);
		
		//views
		$model_news->update(array('id'=>$id,'views'=>$news_info['views']+1));
		
		//最新推荐
		$page	= new Page();
		$page->setEachNum(7);
		$news_list = $model_news->getList(array('type_id'=>3),$page);
		Tpl::output('rec_news_list',$news_list);
		
		//相关推荐
		$page->setEachNum(12);
		$news_list = $model_news->getList(array('order'=>' ordering desc'),$page);
		Tpl::output('other_news_list',$news_list);
		
		//seo
// 		$this->seo($news_info['title']);
		
		//adv
		$this->getAdvInfo();
		
		Tpl::showpage('news_show');
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
}
