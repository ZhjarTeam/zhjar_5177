<?php
/**
 * 任务计划 - 通用任务、促销处理
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

class goodsControl {

    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }

    /**
     * 更新商品促销到期状态
     */
    public function promotionOp() {
        //满即送过期
        Model('p_mansong')->editExpireMansong();
    }

    /**
     * 更新首页的商品价格信息
     */
    public function web_updateOp(){
         Model('web_config')->updateWebGoods();
    }

    /**
     * 执行通用任务
     */
    public function commonOp(){

        //查找待执行任务
        $model_cron = Model('cron');
        $cron = $model_cron->getCronList(array('exetime'=>array('elt',TIMESTAMP)));
        if (!is_array($cron)) return ;
        $cron_array = array(); $cronid = array();
        foreach ($cron as $v) {
            $cron_array[$v['type']][$v['exeid']] = $v;
        }
        foreach ($cron_array as $k=>$v) {
            // 如果方法不存是，直接删除id
            if (!method_exists($this,'_cron_'.$k)) {
                $tmp = current($v);
                $cronid[] = $tmp['id'];continue;
            }
            $result = call_user_func_array(array($this,'_cron_'.$k),array($v));
            if (is_array($result)){
                $cronid = array_merge($cronid,$result);
            }
        }

        //删除执行完成的cron信息
        if (!empty($cronid) && is_array($cronid)){
            $model_cron->delCron(array('id'=>array('in',$cronid)));
        }
    }

    /**
     * 上架
     *
     * @param array $cron
     */
    private function _cron_1($cron = array()){
        $condition = array('goods_commonid' => array('in',array_keys($cron)));
        $update = Model('goods')->editProducesOnline($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 根据商品id更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_2($cron = array()){
        $condition = array('goods_id' => array('in',array_keys($cron)));
        $update = Model('goods')->editGoodsPromotionPrice($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 优惠套装过期
     *
     * @param array $cron
     */
    private function _cron_3($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = Model('p_bundling')->editBundlingQuotaClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 推荐展位过期
     *
     * @param array $cron
     */
    private function _cron_4($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = Model('p_booth')->editBoothClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 团购开始更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_5($cron = array()) {
        $condition = array();
        $condition['goods_commonid'] = array('in', array_keys($cron));
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $groupbuy = Model('groupbuy')->getGroupbuyList($condition);
        foreach ($groupbuy as $val) {
            Model('goods')->editGoods(array('goods_promotion_price' => $val['groupbuy_price'], 'goods_promotion_type' => 1), array('goods_commonid' => $val['goods_commonid']));
        }
        //返回执行成功的cronid
        $cronid = array();
        foreach ($cron as $v) {
            $cronid[] = $v['id'];
        }
        return $cronid;
    }

    /**
     * 团购过期
     *
     * @param array $cron
     */
    private function _cron_6($cron = array()) {
        $condition = array('goods_commonid' => array('in', array_keys($cron)));
        //团购活动过期
        Model('groupbuy')->editExpireGroupbuy($condition);
        return array_keys($cron);
    }

    /**
     * 限时折扣过期
     *
     * @param array $cron
     */
    private function _cron_7($cron = array()) {
        $condition = array('xianshi_id' => array('in', array_keys($cron)));
        //限时折扣过期
        Model('p_xianshi')->editExpireXianshi($condition);
        return array_keys($cron);
    }

    /**
     * 将缓存中的浏览记录存入数据库中，并删除30天前的浏览历史
     */
    public function browseOp(){
        $model = Model('goods_browse');
        //将memcache中的记录存入数据库
        if (!C('cache.type') == 'file'){//如果浏览记录已经存入了缓存中，则将其整理到数据库中
            //上次更新缓存的时间
            $latest_record = $model->getGoodsbrowseOne(array(),'','browsetime desc');

            $starttime = ($t = intval($latest_record['browsetime']))?$t:0;
            //查询会员信息总条数
            $countnum = Model('member')->count();
            $eachnum = 100;
            for ($i=0; $i<$countnum; $i+=$eachnum){//每次查询100条
                $member_list = $model->table('member')->limit($i.",$eachnum")->select();
                foreach ((array)$member_list as $k=>$v){
                    $insert_arr = array();
                    $goodsid_arr = array();
                    //生成缓存的键值
                    $hash_key = $v['member_id'];
                    if ($_cache = rcache($hash_key, 'goodsbrowse')) {
                        foreach ((array)$_cache as $c_k=>$c_v){
                            if ($c_v['browsetime'] >= $starttime){//如果 缓存中的数据未更新到数据库中（即添加时间大于上次更新到数据库中的数据时间）则将数据更新到数据库中
                                $insert_arr[] = $c_v;//如果缓存项和数据库列不一致，此处需要重新赋值
                            }
                            $goodsid_arr[] = $c_v['goods_id'];
                        }
                        //删除已经存在的该商品浏览记录
                        if ($goodsid_arr){
                            $model->delGoodsbrowse(array('member_id'=>$v['member_id'],'goods_id'=>array('in',$goodsid_arr)));
                        }
                        if ($insert_arr){
                            $model->addGoodsbrowseAll($insert_arr);
                        }
                    }
                }
            }
        }
        //删除30天前的浏览历史
        $monthago = strtotime(date('Y-m-d',time())) - 86400*30;
        $model->delGoodsbrowse(array('browsetime'=>array('lt',$monthago)));
    }

    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}