<?php
/**
 * 队列处理
 *
 *
 * @package    library
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @author	   ShopNC Team
 * @since      File available since Release v1.1
 */

class QueueClient {

    private static $queuedb;

    /**
     * 入列
     * @param string $key
     * @param array $value
     */
    public static function push($key, $value) {
        if (!C('queue.open')) {
            Model('queue',BASE_ROOT_PATH.'/queue')->$key($value);return;
        }
        if (!is_object(self::$queuedb)) {
            self::$queuedb = new QueueDB();
        }
        return self::$queuedb->push(serialize(array($key=>$value)));
    }
}

class QueueServer {

    private $_queuedb;
    
    public function __construct() {
        $this->_queuedb = new QueueDB();
    }

    /**
     * 取出队列
     * @param unknown $key
     */
    public function pop($key) {
        return unserialize($this->_queuedb->pop($key));
    }

    public function scan() {
        return $this->_queuedb->scan();
    }
}

class QueueDB {

    //定义对象
    private $_redis;

    //存储前缀
    private $_tb_prefix = 'QUEUE_TABLE_';

    //存定义存储表的数量,系统会随机分配存储
    private $_tb_num = 2;

    //临时存储表
    private $_tb_tmp = 'TMP_TABLE';

    /**
     * 初始化
     */
    public function __construct() {
        if ( !extension_loaded('redis') ) {
            throw_exception('redis failed to load');
        }
        $this->_redis = new Redis();
        $this->_redis->pconnect(C('queue.host'),C('queue.port'),1);
    }

    /**
     * 入列
     * @param unknown $value
     */
    public function push($value) {
        try {
            return $this->_redis->lPush($this->_tb_prefix.rand(1,$this->_tb_num),$value);
        }catch(Exception $e) {
             throw_exception($e->getMessage());
        }
    }

    /**
     * 取得所有的list key(表)
     */
    public function scan() {
        $list_key = array();
        for($i=1;$i<=$this->_tb_num;$i++) {
            $list_key[] = $this->_tb_prefix.$i;
        }
        return $list_key;
//         $it = NULL;
//         $this->_redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
//         $match = $this->_tb_prefix.'*';
//         $count = $this->_tb_num;
//         $this->_redis->scan($it,$match, $count);
//         while($arr_keys = $this->_redis->scan($it,$match, $count)) {
//             foreach($arr_keys as $str_key) {
//                 echo $this->pop($str_key)."\n";
//             }
//         }
    }

    /**
     * 出列
     * @param unknown $key
     */
    public function pop($key) {
        try {
//             return $this->_redis->rpoplpush($key,$this->_tb_tmp);
            return $this->_redis->rPop($key);
        } catch (Exception $e) {
             throw_exception($e->getMessage());
        }
        //取出特定项
//         return $this->_redis->brPop('member_1','member_2','member_3',0);
        //取出全部
//         return $this->_redis->lrange($key,0,-1);
        //取出全部key
//         return $this->_redis->keys('*');
    }

    /**
     * 清空,暂时无用
     */
    public function clear() {
        $this->_redis->flushAll();
    }
}