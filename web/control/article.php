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
class articleControl extends BaseHomeControl{
		
	public function showOp(){
		Tpl::setLayout('null_layout');
		$id = intval($_GET ['id']);
		if ($id==0) {
			error();
		}
		$model_article = Model('article');
		$article_info = $model_article->getOne($id);
		Tpl::output('data',$article_info);
		
		$this->seo($article_info['title']);
		
		Tpl::showpage('article_show');
	}
}
