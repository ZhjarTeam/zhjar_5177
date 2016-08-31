<?php
/**
 * 默认展示页面
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
class indexControl extends BaseHomeControl{
	public function indexOp(){
		Tpl::setLayout('null_layout');
		$model_types = Model('types');
		$model_news = Model('news');
		$order = ' ordering desc,id desc';
		$page	= new Page();
// 		echo url_html('news','show',array('m'=>2,'id'=>26));
		/*
		 * 新闻
		 */
		$page->setEachNum(6);
		$news_list = $model_news->getList(array('type_id'=>1,'order'=>'input_time desc'),$page);
		Tpl::output('hot_news_list',$news_list);
		
		$news_list = $model_news->getList(array('type_id'=>2,'order'=>'input_time desc'),$page);
		Tpl::output('top_news_list',$news_list);
		
		/*
		 * 链接
		 */
		$model_links = Model('links');
		
		//网址收藏
		$select_ids = isset($_COOKIE['select_ids'])?$_COOKIE['select_ids']:'';
		$query_num = 10;
		$select_list = array();
		if (!empty($select_ids)) {
			$ids_arr = explode(',', $select_ids);
			
			$ids = '';
			if (count($ids_arr)>0) {
				foreach ($ids_arr as $key => $row) {
					if (is_numeric($row)) {
						$ids .= ','.$row;
					}
				}
			}
			$select_ids = substr($ids, 1,strlen($ids));
			$ids_arr = explode(',', $select_ids);
			
			$num = count($ids_arr);
			$query_num -= count($ids_arr);
			$page->setEachNum($query_num);
			if (!empty($select_ids)) {
				$select_list = $model_links->getList(array('in_ids'=>$select_ids),count($ids_arr));
				krsort($select_list);//倒序
			}
		}
		Tpl::output('use_links_list1',$select_list);
		
		$condition = '1';
		if (!empty($select_ids)) {
			$condition .= " AND id NOT IN(".$select_ids.") ";
		}
		$links_list = Model('links')->query("SELECT *
										FROM jar_links
										WHERE ".$condition." AND (FIND_IN_SET(4,type_ids) OR FIND_IN_SET(5,type_ids) OR FIND_IN_SET(6,type_ids))
										LIMIT ".$query_num);
		if (!empty($links_list)) {
			foreach ($links_list as $key => $row) {
				$select_list[] = $row;
			}
		}
		Tpl::output('select_ids',$select_ids);
		Tpl::output('use_links_list',$this->getLinks($select_list));
		
		$page->setEachNum(15);
		
		//热门网站
		$links_list = $model_links->getList(array('type_id'=>4,'order'=>$order,'no_type_id'=>15),$page);
		Tpl::output('hot_links_list',$links_list);
		
		//热门收藏
		$links_list = $model_links->getList(array('type_id'=>5,'order'=>$order,'no_type_id'=>15),$page);
		Tpl::output('collect_links_list',$links_list);
		
		//彩票网站
		$links_list = $model_links->getList(array('type_id'=>6,'order'=>$order,'no_type_id'=>15),$page);
		Tpl::output('cp_links_list',$links_list);
		
		//右侧
		//福彩
		$page->setEachNum(6);
		$links_list = $model_links->getList(array('type_id'=>24,'order'=>$order),$page);
		Tpl::output('fc_links_list',$links_list);
		//体彩
		$page->setEachNum(24);
		$links_list = $model_links->getList(array('type_id'=>25,'order'=>$order),$page);
		Tpl::output('tc_links_list',$links_list);
		//足彩
		$links_list = $model_links->getList(array('type_id'=>26,'order'=>$order),$page);
		Tpl::output('zc_links_list',$links_list);
		
		$page->setEachNum(12);
		$links_list = $model_links->getList(array('type_id'=>7,'order'=>$order),$page);
		Tpl::output('app_links_list',$this->getLinks($links_list));
		
		$page->setEachNum(6);
		$links_list = $model_links->getList(array('type_id'=>11,'order'=>$order),$page);
		Tpl::output('ss_links_list',$links_list);
		
		$links_list = $model_links->getList(array('type_id'=>12,'order'=>$order),$page);
		Tpl::output('js_links_list',$links_list);
		
		$links_list = $model_links->getList(array('type_id'=>13,'order'=>$order),$page);
		Tpl::output('fx_links_list',$links_list);
		
		$links_list = $model_links->getList(array('type_id'=>14,'order'=>$order),$page);
		Tpl::output('more_links_list',$links_list);
		
		/*
		 * 公众号
		 */
		$page->setEachNum(20);
		$model_weixin = Model('weixin');
		$weixin_list = $model_weixin->getList(array(),$page);
		Tpl::output('weixin_list',$this->getWeixins($weixin_list));
		
		/*
		 * 幻灯片
		 */
		$page->setEachNum(5);
		$links_list = $model_links->getList(array('type_id'=>8,'order'=>$order),$page);
		Tpl::output('focus_top_list',$this->getLinks($links_list));
		
		$links_list = $model_links->getList(array('type_id'=>9,'order'=>$order),$page);
		Tpl::output('focus_right_list',$this->getLinks($links_list));
		
		
		/*
		 * 中奖信息
		 */
		$this->getOpenPrizes();
		
		/*
		 * 友情链接
		 */
		$page->setEachNum(20);
		$links_list = $model_links->getList(array('type_id'=>27,'order'=>$order),$page);
		Tpl::output('friend_links_list',$links_list);
		
		/*
		 * 社区精华
		 */
		$this->getForumBests();
		
		
		$this->seo();
		Tpl::showpage('index');
	}
	
	
	private function getLinks($links_list){
		$model_upload = Model('upload');
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
		return $links_list;
	}
	
	private function getWeixins($weixin_list) {
		$model_upload = Model('upload');
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
		return $weixin_list;
	}
	
	private function getOpenPrizes() {
		//双色球
		$url = 'http://fc.ws.runbao.asia/api/ExternalAwardsInfo/GetLastDoubleColorAwardsInfo';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		if (!empty($arr['results']['RAFFLE_NUMBER'])) {
			$numbers = "<span>".str_replace(' ', '</span><span>', $arr['results']['RAFFLE_NUMBER']);
			$numbers = str_replace('-', '</span><strong>', $numbers);
			$numbers .= "</strong>";
			$arr['results']['numbers'] = $numbers;
			$arr['results']['date'] = substr( $arr['results']['CREATE_TIME'], 0,10);
		}
		Tpl::output('dob_color_info',$arr['results']);
		
		//福彩3D
		$url = 'http://fc.ws.runbao.asia/api/ExternalAwardsInfo/GetLastThreeDAwardsInfo';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		if (!empty($arr['results']['RAFFLE_NUMBER'])) {
			$numbers = "<span>".str_replace(' ', '</span><span>', $arr['results']['RAFFLE_NUMBER']);
			$arr['results']['numbers'] = $numbers;
			$arr['results']['date'] = substr( $arr['results']['CREATE_TIME'], 0,10);
		}
		Tpl::output('3d_info',$arr['results']);
		
		//福彩好彩
		$url = 'http://fc.ws.runbao.asia/api/ExternalAwardsInfo/GetLastLuckyOneAwardsInfo';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		if (!empty($arr['results']['RAFFLE_NUMBER'])) {
			$numbers = "<span>".str_replace(' ', '</span><span>', $arr['results']['RAFFLE_NUMBER']);
			$arr['results']['numbers'] = $numbers;
			$arr['results']['date'] = substr( $arr['results']['CREATE_TIME'], 0,10);
		}
		Tpl::output('nice_info',$arr['results']);
		

	} 
	
	/**
	 * 社区精华
	 */
	private function getForumBests() {
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityTopic?topic=801&top=5';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		Tpl::output('forums_801',$arr['results']);
		
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityTopic?topic=802&top=5';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		Tpl::output('forums_802',$arr['results']);
		
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityTopic?topic=803&top=5';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		Tpl::output('forums_803',$arr['results']);
		
		$url = 'http://fc.ws.runbao.asia/api/ExternalCommunity/GetCommunityTopic?topic=804&top=5';
		$rs = file_get_contents($url);
		$arr = json_decode($rs,true);
		Tpl::output('forums_804',$arr['results']);
		
// 		var_dump ($arr['results']);
	}
}
