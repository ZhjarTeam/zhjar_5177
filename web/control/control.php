<?php
/**
 * 前台control父类
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
use Zhjar\Tpl;


defined('InShopNC') or exit('Access Invalid!');

class Control{

    /**
     * 添加到任务队列
     *
     * @param array $goods_array
     * @param boolean $ifdel 是否删除以原记录
     */
    protected function addcron($data = array(), $ifdel = false) {
        $model_cron = Model('cron');
        if (isset($data[0])) { // 批量插入
            $where = array();
            foreach ($data as $k => $v) {
                if (isset($v['content'])) {
                    $data[$k]['content'] = serialize($v['content']);
                }
                // 删除原纪录条件
                if ($ifdel) {
                    $where[] = '(type = ' . $data['type'] . ' and exeid = ' . $data['exeid'] . ')';
                }
            }
            // 删除原纪录
            if ($ifdel) {
                $model_cron->delCron(implode(',', $where));
            }
            $model_cron->addCronAll($data);
        } else { // 单条插入
            if (isset($data['content'])) {
                $data['content'] = serialize($data['content']);
            }
            // 删除原纪录
            if ($ifdel) {
                $model_cron->delCron(array('type' => $data['type'], 'exeid' => $data['exeid']));
            }
            $model_cron->addCron($data);
        }
    }

}

/********************************** 前台control父类 **********************************************/

class BaseHomeControl extends Control {

	private $list_setting = array();
	
	public function __construct(){

		Language::read('common,web_layout');

		Tpl::setDir('web');

		Tpl::setLayout('web_layout');

		$this->getMenu();
		$this->getArticle();
		$this->getSiteSetting();
		
		if ($_GET['column'] && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
		if(!C('site_status')) halt(C('closed_reason'));
		
	}
	
	
	private  function getMenu(){
		$model_menu = Model('menu');
		$menu_list = $model_menu->getList(array('status'=>1,'order'=>' ordering desc'));
		Tpl::output('menu_list',$menu_list);
	}
	
	private function getArticle(){
		$model_article = Model('article');
		$article_list = $model_article->getList(array());
		Tpl::output('article_list',$article_list);
	}
	
	private function getSiteSetting(){
		$model_setting = Model('setting');
		$list_setting = $model_setting->getListSetting();
		if (!empty($list_setting['site_logo'])) {
			$list_setting['site_logo'] = UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/'.$list_setting['site_logo'];
		}
		
		if ($list_setting['site_status'] == 0) {
			error($list_setting['closed_reason']);
		}
		
		$this->list_setting = $list_setting;
		Tpl::output('list_setting',$list_setting);
	}

	public function seo($title=''){
		$seo = array();
		$seo['title'] = !empty($title)?$title.'_'.$this->list_setting['site_name']:$this->list_setting['site_name'];
		$seo['desc'] = $this->list_setting['site_desc'];
		$seo['keyword'] = $this->list_setting['site_keyword'];
		Tpl::output('seo',$seo);
	}
	
}
