<?php
/**
 * 缓存操作
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class cacheModel extends Model {
	
	public function __construct(){
		parent::__construct();
	}

	public function call($method){
		$method = '_'.strtolower($method);
		if (method_exists($this,$method)){
			return $this->$method();
		}else{
			return false;
		}
	}

	/**
	 * 基本设置
	 *
	 * @return array
	 */
	private function _setting(){
		$list =$this->table('setting')->limit(false)->select();
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['name']] = $v['value'];
		}
		unset($list);
		return $array;
	}

	/**
	 * 商品分类
	 *
	 * @return array
	 */
	private function _goods_class(){
		$fields = 'gc_id,gc_name,type_id,gc_parent_id,gc_sort';
	    $result = $this->table('goods_class')->field($fields)->order('gc_parent_id asc, gc_sort asc')->limit(false)->select();
	    if (!is_array($result)) return null;

	    $class_level = array();
		$result_copy = $result;
		$result_child = array();
		$result_childchild = array();
		$return_array = array();
		foreach ($result_copy as $k=>$v) {
			$return_array[$v['gc_id']] = $v;
			if (!$v['gc_parent_id']) {
				$class_level[1][$v['gc_id']] = $v;
				unset($result_copy[$k]);
			}
		}
		foreach ($result_copy as $k=>$v) {
			if (array_key_exists($v['gc_parent_id'],$class_level[1])){
				$result_child[$v['gc_parent_id']][] = $v['gc_id'];
				$class_level[2][$v['gc_id']] = $v;
				unset($result_copy[$k]);
			}
		}

		foreach ($result_copy as $k=>$v) {
			if (array_key_exists($v['gc_parent_id'],$class_level[2])){
				$result_child[$v['gc_parent_id']][] = $v['gc_id'];
				$parent_parent_gc_id = $class_level[2][$v['gc_parent_id']]['gc_parent_id'];
				$result_childchild[$parent_parent_gc_id][] = $v['gc_id'];
				$class_level[3][$v['gc_id']] = $v;
				unset($result_copy[$k]);
			}
		}

		foreach ($return_array as $k=>$v){
		    if (array_key_exists($v['gc_id'],$class_level[1])) {
		        $return_array[$k]['depth'] = 1;
		    } elseif (array_key_exists($v['gc_id'],$class_level[2])) {
		        $return_array[$k]['depth'] = 2;
		    } elseif (array_key_exists($v['gc_id'],$class_level[3])) {
		        $return_array[$k]['depth'] = 3;
		    }
			if (array_key_exists($k, $result_child)){
				$return_array[$k]['child'] = implode(',', $result_child[$k]);
			}
			if (array_key_exists($k, $result_childchild)){
				$return_array[$k]['childchild'] = implode(',',$result_childchild[$k]);
			}
		}
		return $return_array;
	}

	/**
	 * 商品分类SEO
	 *
	 * @return array
	 */
	private function _goods_class_seo(){

		$list = $this->table('goods_class')->field('gc_id,gc_title,gc_keywords,gc_description')->where(array('gc_keywords'=>array('neq','')))->limit(false)->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $k=>$v) {
			if ($v['gc_title'] != '' || $v['gc_keywords'] != '' || $v['gc_description'] != ''){
				if ($v['gc_name'] != ''){
					$array[$v['gc_id']]['name'] = $v['gc_name'];
				}
				if ($v['gc_title'] != ''){
					$array[$v['gc_id']]['title'] = $v['gc_title'];
				}
				if ($v['gc_keywords'] != ''){
					$array[$v['gc_id']]['key'] = $v['gc_keywords'];
				}
				if ($v['gc_description'] != ''){
					$array[$v['gc_id']]['desc'] = $v['gc_description'];
				}
			}
		}
		return $array;
	}
	
	/**
	 * 商城主要频道SEO
	 *
	 * @return array
	 */
	private function _seo(){
		$list =$this->table('seo')->limit(false)->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $key=>$value){
			$array[$value['type']] = $value;
		}
		return $array;
	}
	
	/**
	 * 快递公司
	 *
	 * @return array
	 */
	private function _express(){
	    $fields = 'id,e_name,e_code,e_letter,e_order,e_url';
		$list = $this->table('express')->field($fields)->order('e_order,e_letter')->where(array('e_state'=>1))->limit(false)->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $k=>$v) {
			$array[$v['id']] = $v;
		}
		return $array;
	}

	/**
	 * 自定义导航
	 *
	 * @return array
	 */
	private function _nav(){
		$list = $this->table('navigation')->order('nav_sort')->limit(false)->select();
		if (!is_array($list)) return null;
		return $list;
	}

	/**
	 * 团购分类、价格区间
	 *
	 * @return array
	 */
	private function _groupbuy(){
		$category = $this->table('groupbuy_class')->where('class_parent_id=0')->order('sort')->select();
		if (!is_array($category)) $category = array();

		$price = $this->table('groupbuy_price_range')->order('range_start')->select();
		if (!is_array($price)) $price = array();

		return array('category'=>$category,'price'=>$price);
	}

	/**
	 * 商品TAG
	 *
	 * @return array
	 */
	private function _class_tag(){
		$field = 'gc_tag_id,gc_tag_name,gc_tag_value,gc_id,type_id';
		$list = $this->table('goods_class_tag')->field($field)->limit(false)->select();
		if (!is_array($list)) return null;
		return $list;
	}

	/**
	 * 店铺分类
	 *
	 * @return array
	 */
	private function _store_class(){
		return $this->table('store_class')->limit(false)->order('sc_sort asc,sc_id asc')->select();
	}

	/**
	 * 店铺等级
	 *
	 * @return array
	 */
	private function _store_grade(){
		$list =$this->table('store_grade')->limit(false)->select();
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['sg_id']] = $v;
		}
		unset($list);
		return $array;
	}

	/**
	 * 店铺等级
	 *
	 * @return array
	 */
	private function _store_msg_tpl(){
		$list = Model('store_msg_tpl')->getStoreMsgTplList(array());
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['smt_code']] = $v;
		}
		unset($list);
		return $array;
	}

	/**
	 * 店铺等级
	 *
	 * @return array
	 */
	private function _member_msg_tpl(){
		$list = Model('member_msg_tpl')->getMemberMsgTplList(array());
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['mmt_code']] = $v;
		}
		unset($list);
		return $array;
	}

	/**
	 * 咨询类型
	 *
	 * @return array
	 */
	private function _consult_type(){
		$list = Model('consult_type')->getConsultTypeList(array());
		$array = array();
		foreach ((array)$list as $val) {
		    $val['ct_introduce'] = html_entity_decode($val['ct_introduce']);
			$array[$val['ct_id']] = $val;
		}
		unset($list);
		return $array;
	}
	
	/**
	 * Circle Member Level
	 * 
	 * @return array
	 */
	private function _circle_level(){
		$list = $this->table('circle_mldefault')->limit(false)->select();
		
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $val){
			$array[$val['mld_id']] = $val;
			
		}
		return $array;
	}
}
