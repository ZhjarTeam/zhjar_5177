<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $output['seo']['keyword']?>" />
<meta name="description" content="<?php echo $output['seo']['desc']?>" />
<meta http-equiv="X-UA-Compatible" content="IE=8">
<title><?php echo $output['seo']['title']?></title>
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/reset.css?v=20160807" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/base.css?v=20160807" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="spread">
  <div class="spread_img"></div>
  <span id="close_spread">X</span>
  <div class="maskbg"></div>
</div>
<div class="head">
  <a class="logo" href="<?php echo WEB_SITE_URL;?>"><img src="<?php echo $output['list_setting']['site_logo']?>" alt="<?php echo $output['seo']['title']?>"></a>
  <form class="search_bar" method="get" action="http://www.baidu.com/s" target="_blank">
    <input type="text" name="word" value="" placeholder="搜你想要的">
    <input type="submit" value="搜一搜">
  </form>
</div>

<div class="container clearfix">
  <div class="left-side">
    <div id="home-focus">
      <div class="pic">
        <ul>
          <?php if(!empty($output['focus_top_list']) && is_array($output['focus_top_list'])){ ?>
        <?php foreach($output['focus_top_list'] as $k => $info){ ?>
          <li>
            <a href="<?php echo $info['link_url']?>" target="_blank">
              <img src="<?php echo $info['upload_path']?>" alt="">
              <p class="txtover"><?php echo $info['title']?></p>
            </a>
          </li>
           <?php } ?>
        <?php } ?>
        </ul>
      </div>
      <div class="num"><ul></ul></div>
      <a class="prev" style="display: none;"></a>
      <a class="next" style="display: none;"></a>
    </div>
    <div class="news-module">
      <div class="nav">
        <ul>
          <li data-url='<?php echo WEB_SITE_URL;?>?act=news&op=list&t=1&m=2'>热点</li>
          <li data-url='<?php echo WEB_SITE_URL;?>?act=news&op=list&t=2&m=3'>头条</li>
        </ul>
        <a href="<?php echo WEB_SITE_URL;?>?act=news&op=list&t=1&m=2">更多</a>
      </div>
      <div class="list">
        <?php if(!empty($output['hot_news_list']) && is_array($output['hot_news_list'])){ ?>
        <?php foreach($output['hot_news_list'] as $k => $info){ ?>
          <a class="txtover" href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>&m=2" target="_blank"><font color="<?php echo $info['color']; ?>"><?php echo $info['title']?></font></a>
        <?php } ?>
        <?php } ?>
      </div>
      <div class="list">
        <?php if(!empty($output['top_news_list']) && is_array($output['top_news_list'])){ ?>
        <?php foreach($output['top_news_list'] as $k => $info){ ?>
          <a class="txtover" href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>&m=3" target="_blank"><font color="<?php echo $info['color']; ?>"><?php echo $info['title']?></font></a>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="trend">
      <h2>彩票走势
        <ul>
          <li class="cur">福彩</li>
          <li>体彩</li>
          <li>足彩</li>
        </ul>
      </h2>
      <div class="trend-box">
        <div class="trend-list">
          <h3>双色球</h3>
          <a href="<?php echo $output['trend_list_fc_left'][0]['link_url']?>"><img src="<?php echo $output['trend_list_fc_left'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_fc_left']) && is_array($output['trend_list_fc_left'])){ ?>
              <?php foreach($output['trend_list_fc_left'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="trend-list">
          <h3>福彩3D</h3>
          <a href="<?php echo $output['trend_list_fc_right'][0]['link_url']?>"><img src="<?php echo $output['trend_list_fc_right'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_fc_right']) && is_array($output['trend_list_fc_right'])){ ?>
              <?php foreach($output['trend_list_fc_right'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="trend-box" style="display:none">
        <div class="trend-list">
          <h3>体彩</h3>
          <a><img src="<?php echo $output['trend_list_tc_left'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_tc_left']) && is_array($output['trend_list_tc_left'])){ ?>
              <?php foreach($output['trend_list_tc_left'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="trend-list">
          <h3>体彩</h3>
          <a><img src="<?php echo $output['trend_list_tc_right'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_tc_right']) && is_array($output['trend_list_tc_right'])){ ?>
              <?php foreach($output['trend_list_tc_right'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="trend-box" style="display:none">
        <div class="trend-list">
          <h3>足彩</h3>
          <a><img src="<?php echo $output['trend_list_zc_left'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_zc_left']) && is_array($output['trend_list_zc_left'])){ ?>
              <?php foreach($output['trend_list_zc_left'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="trend-list">
          <h3>足彩</h3>
          <a><img src="<?php echo $output['trend_list_zc_right'][0]['upload_path']?>"></a>
          <div>
            <?php if(!empty($output['trend_list_zc_right']) && is_array($output['trend_list_zc_right'])){ ?>
              <?php foreach($output['trend_list_zc_right'] as $k => $info){ ?>
              <a class="txtover" href="<?php echo $info['link_url']?>" target="_blank">
                <font color=<?php echo $info['color']?>""><?php echo $info['name']?></font>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="site-list">
      <ul class="icon-site clearfix">
        <?php if(!empty($output['use_links_list']) && is_array($output['use_links_list'])){ ?>
        <?php foreach($output['use_links_list'] as $k => $info){ ?>
        <li class="txtover"><a href="<?php echo $info['link_url']?>" target="_blank">
          <?php if (!empty($info['upload_path'])) {
            echo '<img src="'. $info['upload_path'].'" alt="'.$info['title'].'">';
          }?>
          <?php echo $info['title']?>
        </a>
        </li>
        <?php } ?>
        <?php } ?>
        <img src="<?php echo WEB_TEMPLATES_URL;?>/images/lottery.png">
      </ul>
      <!--<ul class="word-site clearfix">
        <?php if(!empty($output['hot_links_list']) && is_array($output['hot_links_list'])){ ?>
        <?php foreach($output['hot_links_list'] as $k => $info){ ?>
        <li><a href="<?php echo $info['link_url']?>" target="_blank"><?php echo $info['title']?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>-->
      <a id="set-site"><img src="<?php echo WEB_TEMPLATES_URL;?>/images/set.png" alt="管理常用网址"></a>
      <div class="set-site">        
        <p class="title">
          管理常用网址
          <span>X</span>
        </p>
        <ul class="select-list clearfix">
          <li style="display:none;"></li>
          <?php if(!empty($output['use_links_list1']) && is_array($output['use_links_list1'])){ ?>
        <?php foreach($output['use_links_list1'] as $k => $info){ ?>
          <li id="select_<?php echo $info['id']?>"><p class="txtover"><?php echo $info['title']?></p><a href="javascript:;" data-id="<?php echo $info['id']?>"></a></li>
          <?php } ?>
        <?php } ?>
        </ul>
        <form class="add-site">
          <label>网站名称</label>
          <input type="text" name="siteName" id="siteName" style="width:140px;" value="" placeholder="例如：百度">
          <label>网址</label>
          <input type="text" name="siteUrl" id="siteUrl" value="" placeholder="例如：www.baidu.com">
          <input type="button" id="add-site" value="添加">
        </form>
        <div class="list clearfix select">
          <h3>最热网站</h3>
          <ul>
            <?php if(!empty($output['hot_links_list']) && is_array($output['hot_links_list'])){ ?>
            <?php foreach($output['hot_links_list'] as $k => $info){
              $cur = '';
              if (!empty($output['select_ids'])) {
                $arr = explode(',', $output['select_ids']);
                if (in_array($info['id'], $arr)) {
                  $cur = ' cur';
                }
              }
              ?>
            <li class="txtover<?php echo $cur?>" data-id="list_<?php echo $info['id']?>"><a data-id="<?php echo $info['id']?>" target="_blank"><?php echo $info['title']?></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
        </div>
        <div class="list clearfix select">
          <h3>最热收藏</h3>
          <ul>
            <?php if(!empty($output['collect_links_list']) && is_array($output['collect_links_list'])){ ?>
            <?php foreach($output['collect_links_list'] as $k => $info){
              $cur = '';
              if (!empty($output['select_ids'])) {
                $arr = explode(',', $output['select_ids']);
                if (in_array($info['id'], $arr)) {
                  $cur = ' cur';
                }
              }
              ?>
            <li class="txtover<?php echo $cur?>" data-id="list_<?php echo $info['id']?>"><a data-id="<?php echo $info['id']?>" target="_blank"><?php echo $info['title']?></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
        </div>
        <div class="list clearfix select">
          <h3>彩票技术</h3>
          <ul>
            <?php if(!empty($output['cp_links_list']) && is_array($output['cp_links_list'])){ ?>
            <?php foreach($output['cp_links_list'] as $k => $info){
              $cur = '';
              if (!empty($output['select_ids'])) {
                $arr = explode(',', $output['select_ids']);
                if (in_array($info['id'], $arr)) {
                  $cur = ' cur';
                }
              }
              ?>
            <li class="txtover<?php echo $cur?>" data-id="list_<?php echo $info['id']?>"><a data-id="<?php echo $info['id']?>" target="_blank"><?php echo $info['title']?></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="mask"></div>
    </div>
    <div class="video">
      <h2>彩票视频
        <ul>
          <li class="cur">福彩</li>
          <li>体彩</li>
          <li>篮球</li>
          <li>足球</li>
        </ul>
      </h2>
      <div class="video-list">
        <?php if(!empty($output['video_list_fc']) && is_array($output['video_list_fc'])){ ?>
          <a href="<?php echo $output['video_list_fc'][0]['link_url']?>">
            <img src="<?php echo $output['video_list_fc'][0]['upload_path']?>">
            <p class="txtover"><?php echo $output['video_list_fc'][0]['name']?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($output['video_list_fc'][0]['input_time'],0,10)?></p>
          </a>
          <ul>
            <?php foreach($output['video_list_fc'] as $k => $info){?>
              <?php if($k == 1){ ?>
                  <a href="<?php echo $info['link_url']?>">
                    <img src="<?php echo $info['upload_path']?>">
                    <p class="txtover"><?php echo $info['name']?></p>
                  </a>
              <?php }else if($k%2 == 1 && $k != 1){ ?>
                  <li><a class="txtover" href="<?php echo $info['link_url']?>"><?php echo $info['name']?></a></li>
              <?php } ?>
            <?php } ?>
          </ul>
          <ul>
            <?php foreach($output['video_list_fc'] as $k => $info){?>
              <?php if($k == 2){ ?>
                  <a href="<?php echo $info['link_url']?>">
                    <img src="<?php echo $info['upload_path']?>">
                    <p class="txtover"><?php echo $info['name']?></p>
                  </a>
              <?php }else if($k%2 == 0 && $k != 1 && $k != 0){ ?>
                  <li><a class="txtover" href="<?php echo $info['link_url']?>"><?php echo $info['name']?></a></li>
              <?php } ?>
            <?php } ?>
          </ul>
        <?php } ?>
      </div>
      <div class="video-list" style="display: none">
        <?php if(!empty($output['video_list_tc']) && is_array($output['video_list_tc'])){ ?>
          <a href="<?php echo $output['video_list_tc'][0]['link_url']?>">
            <img src="<?php echo $output['video_list_tc'][0]['upload_path']?>">
            <p class="txtover"><?php echo $output['video_list_tc'][0]['name']?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($output['video_list_tc'][0]['input_time'],0,10)?></p>
          </a>
          <ul>
            <?php foreach($output['video_list_tc'] as $k => $info){?>
              <?php if($k == 1){ ?>
                  <a href="<?php echo $info['link_url']?>">
                    <img src="<?php echo $info['upload_path']?>">
                    <p class="txtover"><?php echo $info['name']?></p>
                  </a>
              <?php }else if($k%2 == 1 && $k != 1){ ?>
                  <li><a class="txtover" href="<?php echo $info['link_url']?>"><?php echo $info['name']?></a></li>
              <?php } ?>
            <?php } ?>
          </ul>
          <ul>
            <?php foreach($output['video_list_tc'] as $k => $info){?>
              <?php if($k == 2){ ?>
                  <a href="<?php echo $info['link_url']?>">
                    <img src="<?php echo $info['upload_path']?>">
                    <p class="txtover"><?php echo $info['name']?></p>
                  </a>
              <?php }else if($k%2 == 0 && $k != 1 && $k != 0){ ?>
                  <li><a class="txtover" href="<?php echo $info['link_url']?>"><?php echo $info['name']?></a></li>
              <?php } ?>
            <?php } ?>
          </ul>
        <?php } ?>
      </div>
      <div class="video-list-ball" style="display: none">
        <?php if(!empty($output['video_list_lq']) && is_array($output['video_list_lq'])){ ?>
          <?php foreach($output['video_list_lq'] as $k => $info){?>
            <?php if($k == 0){ ?>
              <a href="<?php echo $info['link_url']?>">
                <img src="<?php echo $info['upload_path']?>">
                <div><img src="<?php echo $info['left_img_list']?>"><p><?php echo $info['team_left']?></p></div>
                <span></span>
                <div><img src="<?php echo $info['right_img_list']?>"><p><?php echo $info['team_right']?></p></div>
              </a>
              <ul>
            <?php }else{ ?>
                <li>
                  <a href="<?php echo $info['link_url']?>">
                    <div><img src="<?php echo $info['left_img_list']?>"><p><?php echo $info['team_left']?></p></div>
                    <span><?php echo $info['time']?></span>
                    <div><img src="<?php echo $info['right_img_list']?>"><p><?php echo $info['team_right']?></p></div>
                  </a>
                </li>
            <?php } ?>
          <?php } ?>
             </ul>
        <?php } ?>
      </div>
      <div class="video-list-ball" style="display: none">
        <?php if(!empty($output['video_list_lq']) && is_array($output['video_list_zq'])){ ?>
          <?php foreach($output['video_list_zq'] as $k => $info){?>
            <?php if($k == 0){ ?>
              <a href="<?php echo $info['link_url']?>">
                <img src="<?php echo $info['upload_path']?>">
                <div><img src="<?php echo $info['left_img_list']?>"><p><?php echo $info['team_left']?></p></div>
                <span></span>
                <div><img src="<?php echo $info['right_img_list']?>"><p><?php echo $info['team_right']?></p></div>
              </a>
              <ul>
            <?php }else{ ?>
                <li>
                  <a href="<?php echo $info['link_url']?>">
                    <div><img src="<?php echo $info['left_img_list']?>"><p><?php echo $info['team_left']?></p></div>
                    <span><?php echo $info['time']?></span>
                    <div><img src="<?php echo $info['right_img_list']?>"><p><?php echo $info['team_right']?></p></div>
                  </a>
                </li>
            <?php } ?>
          <?php } ?>
             </ul>
        <?php } ?>
      </div>
    </div>
    <div class="sq clearfix">
    	<h2>社区精华</h2>
    	<div class="clearfix">
    		<h3>经验分享</h3>
        <?php if(!empty($output['forums_801']) && is_array($output['forums_801'])){ ?>
        <?php foreach($output['forums_801'] as $k => $info){
          if ($k==0) {
         ?>
    		<a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=801"><img src="<?php echo $info['RELATIVE_DIR']?>"><span><?php echo $info['TITLE']?></span></a>
        <?php }} ?>
        <?php } ?>
    		<ul>
        <?php if(!empty($output['forums_801']) && is_array($output['forums_801'])){ ?>
        <?php foreach($output['forums_801'] as $k => $info){
          if ($k>0) {
         ?>
    			<li class="txtover"><a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=801"><?php echo $info['TITLE']?></a></li>
          <?php }} ?>
        <?php } ?>
    		</ul>
    	</div>
    	<div class="clearfix">
    		<h3>选号分享</h3>
    		<?php if(!empty($output['forums_802']) && is_array($output['forums_802'])){ ?>
        <?php foreach($output['forums_802'] as $k => $info){
          if ($k==0) {
         ?>
        <a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=802"><img src="<?php echo $info['RELATIVE_DIR']?>"><span><?php echo $info['TITLE']?></span></a>
        <?php }} ?>
        <?php } ?>
        <ul>
        <?php if(!empty($output['forums_802']) && is_array($output['forums_802'])){ ?>
        <?php foreach($output['forums_802'] as $k => $info){
          if ($k>0) {
         ?>
          <li class="txtover"><a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=802"><?php echo $info['TITLE']?></a></li>
          <?php }} ?>
        <?php } ?>
    		</ul>
    	</div>
    	<div class="clearfix">
    		<h3>走势分析</h3>
        <?php if(!empty($output['forums_803']) && is_array($output['forums_803'])){ ?>
        <?php foreach($output['forums_803'] as $k => $info){
          if ($k==0) {
         ?>
        <a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=803"><img src="<?php echo $info['RELATIVE_DIR']?>"><span><?php echo $info['TITLE']?></span></a>
        <?php }} ?>
        <?php } ?>
        <ul>
        <?php if(!empty($output['forums_803']) && is_array($output['forums_803'])){ ?>
        <?php foreach($output['forums_803'] as $k => $info){
          if ($k>0) {
         ?>
          <li class="txtover"><a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=803"><?php echo $info['TITLE']?></a></li>
          <?php }} ?>
        <?php } ?>
    		</ul>
    	</div>
    	<div class="clearfix">
    		<h3>高手研讨</h3>
        <?php if(!empty($output['forums_804']) && is_array($output['forums_804'])){ ?>
        <?php foreach($output['forums_804'] as $k => $info){
          if ($k==0) {
         ?>
        <a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=804"><img src="<?php echo $info['RELATIVE_DIR']?>"><span><?php echo $info['TITLE']?></span></a>
        <?php }} ?>
        <?php } ?>
        <ul>
        <?php if(!empty($output['forums_804']) && is_array($output['forums_804'])){ ?>
        <?php foreach($output['forums_804'] as $k => $info){
          if ($k>0) {
         ?>
          <li class="txtover"><a target="_blank" href="<?php echo WEB_SITE_URL;?>?act=forum&op=show&id=<?php echo $info['ID']?>&topic=804"><?php echo $info['TITLE']?></a></li>
          <?php }} ?>
        <?php } ?>
    		</ul>
    	</div>
    </div>
  </div>
  <div class="right-side">
  	<ul class="tool clearfix">
  		<li>
  			<img src="<?php echo WEB_TEMPLATES_URL;?>/images/water.png">
  			<p>缩水工具</p>
  			<div>
        <?php if(!empty($output['ss_links_list']) && is_array($output['ss_links_list'])){ ?>
        <?php foreach($output['ss_links_list'] as $k => $info){ ?>
          <a href="<?php echo $info['link_url']?>" class="txtover" target="_blank"><?php echo $info['title']?></a>
        <?php } ?>
        <?php } ?>
  			</div>
  		</li>
  		<li>
  			<img src="<?php echo WEB_TEMPLATES_URL;?>/images/count.png">
  			<p>计算器</p>
  			<div>
  				<?php if(!empty($output['js_links_list']) && is_array($output['js_links_list'])){ ?>
        <?php foreach($output['js_links_list'] as $k => $info){ ?>
          <a href="<?php echo $info['link_url']?>" class="txtover" target="_blank"><?php echo $info['title']?></a>
        <?php } ?>
        <?php } ?>
  			</div>
  		</li>
  		<li>
  			<img src="<?php echo WEB_TEMPLATES_URL;?>/images/analyse.png">
  			<p>分析器</p>
  			<div>
  				<?php if(!empty($output['fx_links_list']) && is_array($output['fx_links_list'])){ ?>
        <?php foreach($output['fx_links_list'] as $k => $info){ ?>
          <a href="<?php echo $info['link_url']?>" class="txtover" target="_blank"><?php echo $info['title']?></a>
        <?php } ?>
        <?php } ?>
  			</div>
  		</li>
  		<li>
  			<img src="<?php echo WEB_TEMPLATES_URL;?>/images/more.png">
  			<p>更多工具</p>
  			<div>
  				<?php if(!empty($output['more_links_list']) && is_array($output['more_links_list'])){ ?>
        <?php foreach($output['more_links_list'] as $k => $info){ ?>
          <a href="<?php echo $info['link_url']?>" class="txtover" target="_blank"><?php echo $info['title']?></a>
        <?php } ?>
        <?php } ?>
  			</div>
  		</li>
  	</ul>
  	<div class="lottery">
  		<p class="top">最新开奖<span>足彩</span><span>体彩</span><span class="cur">福彩</span></p>
  		<ul style="display:block;">
        <?php if(!empty($output['dob_color_info']) && is_array($output['dob_color_info'])){ ?>
  			<li>
  				<p class="title"><strong>双色球</strong><?php echo $output['dob_color_info']['ISSUE_NAME']?>期<span><?php echo $output['dob_color_info']['date']?></span></p>
  				<p class="content"><?php echo $output['dob_color_info']['numbers']?></p>
  				<!-- <p class="other"><a href="#">详情</a>|<a href="#">走势</a>|<a href="#">分析</a></p> -->
  			</li>
        <?php } ?>
  			<?php if(!empty($output['3d_info']) && is_array($output['3d_info'])){ ?>
        <li>
          <p class="title"><strong>福彩3D</strong><?php echo $output['3d_info']['ISSUE_NAME']?>期<span><?php echo $output['3d_info']['date']?></span></p>
          <p class="content"><?php echo $output['3d_info']['numbers']?></p>
          <!-- <p class="other"><a href="#">详情</a>|<a href="#">走势</a>|<a href="#">分析</a></p> -->
        </li>
        <?php } ?>
  			<?php if(!empty($output['nice_info']) && is_array($output['nice_info'])){ ?>
        <li>
          <p class="title"><strong>好彩一</strong><?php echo $output['nice_info']['ISSUE_NAME']?>期<span><?php echo $output['nice_info']['date']?></span></p>
          <p class="content"><?php echo $output['nice_info']['numbers']?></p>
          <!-- <p class="other"><a href="#">详情</a>|<a href="#">走势</a>|<a href="#">分析</a></p> -->
        </li>
        <?php } ?>
  			<li>
            <div class="rht_nav">
               <?php if(!empty($output['fc_links_list']) && is_array($output['fc_links_list'])){ ?>
                <?php foreach($output['fc_links_list'] as $k => $info){ ?>
                <a href="<?php echo $info['link_url']?>" target="_blank"><font color="<?php echo $info['color']?>"><?php echo $info['title']?></font></a>
                <?php } ?>
               <?php } ?>
            </div>
  			</li>
        <li class="more">
            <a href="">更多福彩</a>
        </li>
  		</ul>
  		<ul>
  			<li>
            <div class="rht_nav">
              <?php if(!empty($output['tc_links_list']) && is_array($output['tc_links_list'])){ ?>
                <?php foreach($output['tc_links_list'] as $k => $info){ ?>
                <a href="<?php echo $info['link_url']?>" target="_blank"><font color="<?php echo $info['color']?>"><?php echo $info['title']?></font></a>
                <?php } ?>
               <?php } ?>
            </div>
        </li>
        <li class="more">
            <a href="">更多体彩</a>
        </li>
  		</ul>
  		<ul>
  			<li>
            <div class="rht_nav">
              <?php if(!empty($output['zc_links_list']) && is_array($output['zc_links_list'])){ ?>
                <?php foreach($output['zc_links_list'] as $k => $info){ ?>
                <a href="<?php echo $info['link_url']?>" target="_blank"><font color="<?php echo $info['color']?>"><?php echo $info['title']?></font></a>
                <?php } ?>
               <?php } ?>
            </div>
        </li>
        <li class="more">
            <a href="">更多足彩</a>
        </li>
  		</ul>
  		<!-- <p class="bottom">
  			<span>福彩3D试机号：857</span>
  			<span>体彩P3试机号：405</span>
  		</p> -->
  	</div>
  	<h3>彩票APP</h3>
  	<div id="side-focus">
      <div class="pic">
        <ul>
          <?php if(!empty($output['focus_right_list']) && is_array($output['focus_right_list'])){ ?>
        <?php foreach($output['focus_right_list'] as $k => $info){ ?>
          <li>
            <a href="<?php echo $info['link_url']?>" target="_blank">
              <img src="<?php echo $info['upload_path']?>" alt="">
              <p class="txtover"><?php echo $info['title']?></p>
            </a>
          </li>
           <?php } ?>
        <?php } ?>
        </ul>
      </div>
      <div class="num"><ul></ul></div>
    </div>
    <ul class="appicon clearfix">
      <?php if(!empty($output['app_links_list']) && is_array($output['app_links_list'])){ ?>
      <?php foreach($output['app_links_list'] as $k => $info){ ?>
    	   <li><a href="<?php echo $info['link_url']?>" target="_blank"><img src="<?php echo $info['upload_path']?>"><p><?php echo $info['title']?></p></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <h3>公众号</h3>
    <div class="public-wx">
      <ul>
        <?php if(!empty($output['weixin_list']) && is_array($output['weixin_list'])){ ?>
        <?php foreach($output['weixin_list'] as $k => $info){ ?>
        <li>
          <a <?php if($info['hot'] == 1) echo 'class="hot"';?> ><?php echo $info['name']?></a>
          <div>
          <p><?php echo $info['description']?></p>
          <img src="<?php echo $info['upload_path']?>">
        </div>
        </li>
        <?php } ?>
        <?php } ?>

      </ul>
    </div>
  </div>

</div>


<div class="foot">
  <p class="links">
      <?php if(!empty($output['friend_links_list']) && is_array($output['friend_links_list'])){ ?>
      <?php foreach($output['friend_links_list'] as $k => $info){ ?>
      <a href="<?php echo $info['link_url']?>" target="_blank"><font color="<?php echo $info['color']?>"><?php echo $info['title']?></font></a>
      <?php } ?>
     <?php } ?>
  </p>
  <p>
    <?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>
    <?php foreach($output['article_list'] as $k => $info){ ?>
    <a href="<?php echo WEB_SITE_URL;?>?act=article&op=show&id=<?php echo $info['id']?>"><?php echo $info['title']?></a>
    <?php } ?>
    <?php } ?>
  </p>

  <p><?php echo $output['list_setting']['icp_number']?>&nbsp;&nbsp;<?php echo $output['list_setting']['statistics_code']?></p>
</div>


<script src="<?php echo WEB_TEMPLATES_URL;?>/js/jquery.js"></script> 
<script src="<?php echo WEB_TEMPLATES_URL;?>/js/Slideimg.js"></script>
<script src="<?php echo WEB_TEMPLATES_URL;?>/js/setcookie.js"></script>
<script>
  $('#close_spread').click(function(){
    $('.spread').hide();
  });
  //幻灯片
  $("#home-focus").slideimg(5000);//参数是切换时间
  $("#side-focus").slideimg(5000);
  $(".news-module").find(".list").eq(0).addClass("cur");
  $(".news-module").find(".nav li").eq(0).addClass("cur");
  $(".news-module").find(".nav li").click(function(){
    var num = $(this).index();
    $(".news-module").find(".list").removeClass("cur").eq(num).addClass("cur");
    $(".news-module").find(".nav li").removeClass("cur").eq(num).addClass("cur");


    var url = $(this).data('url');
    $('.nav a').attr('href',url);
  });

  $("#set-site").click(function(){
    $(".set-site,.mask").show();
  });

  $(".set-site .title").find("span").click(function(){
    $(".set-site,.mask").hide();
  });

  $(".public-wx").find("li").hover(function(){
  	$(".public-wx").find("li").removeClass("hover");
  	$(this).addClass("hover");
  },function(){
  	$(this).parent().mouseleave(function(){
  		$(this).find("li").removeClass("hover");
  	});
  });

  $(".tool").find("li").hover(function(){
  	$(this).addClass("hover");
  	$(this).find("div").show();
  },function(){
  	$(this).removeClass("hover");
  	$(this).find("div").hide();
  });

  $(".lottery .top").find("span").click(function(){
  	$(".lottery .top").find("span").removeClass("cur");
  	$(this).addClass("cur");
  	var index = 2-$(this).index();
  	$(".lottery ul").hide().eq(index).show();
  });

  $('.trend > h2 > ul > li').click(function(){
    var num = $(this).index();
    $(this).siblings().removeClass('cur');
    $(this).addClass('cur');
    $('.trend-box').hide();
    $('.trend-box').eq(num).show();
  });

  $('.video > h2 > ul > li').click(function(){
    var num = $(this).index();
    $(this).siblings().removeClass('cur');
    $(this).addClass('cur');
    $('.video > div').hide();
    $('.video > div').eq(num).show();
  });

  $('.public-wx').find('li').each(function(idx,item){
    if(idx%3 == 1){
      $(this).addClass('abcenter');
    }else if(idx%3 == 2){
      $(this).addClass('abright');
    }
    if(idx > 11){
      $(this).addClass('turn');
    }
  });

  $('.video-list-ball ul li').eq(4).css('border','none');
  $('.video-list-ball ul li').eq(5).css('border','none');

var select_ids = "<?php echo $output['select_ids'];?>";

/*
添加收藏
 */
  $('.select li').click(function(){
    if ($(this).hasClass('txtover cur')) {
      return false;
    };


    var title = $(this).find('a').text();
    var clkId = $(this).find('a').data('id');


    //重复处理
    $('.list ul li').each(function () {
      var li_id = $(this).data('id');
      if (li_id == 'list_'+clkId) {
        $(this).attr('class','txtover cur')
      };
    });
    
    var status = false;
    if (select_ids!='') {
      var ids = new Array();
      ids = select_ids.split(',');

      for (var i = ids.length - 1; i >= 0; i--) {
        if (clkId == ids[i]) {
          status = true;
        };
      };
    };

    if (!status) {
      select_ids = select_ids+','+clkId;
    }
    setCookie('select_ids',select_ids);

    var li = '<li id="select_'+clkId+'"><p class="txtover">'+title+'</p><a href="javascript:;" data-id="'+clkId+'"></a></li>';
    $('.select-list li:first').before(li);
    $('#select_'+clkId+' a').bind('click',function(){
      delSelectIds($(this).data('id'));
    });


  });

/*
删除收藏
 */
$('.select-list li a').click(function(){
  delSelectIds($(this).data('id'));
});

//reload
$('.set-site .title span').click(function(){
   window.location.reload();
});

/*
自定义添加收藏
 */
var isSumbit = false;
$('#add-site').click(function(){
  var siteName = $('#siteName').val();
  var siteUrl = $('#siteUrl').val();
  var locationUrl = window.location.href;

  if (siteUrl==''||siteName=='') {
    alert('请填写完整信息');
    return false;
  };

  //http://
  siteUrl = siteUrl.substr(0,7).toLowerCase()=="http://"?siteUrl:"http://"+siteUrl;

  //去重复提交
  if (isSumbit) { return false};
  isSumbit = true;

  $.post(locationUrl+"?act=links&op=add",{'siteName':siteName,'siteUrl':siteUrl},function(result){
      var jsonobj=eval('('+result+')');
      if(jsonobj.status=="1"){
        var id = jsonobj.custom;
        var li = '<li id="select_'+id+'"><p class="txtover">'+siteName+'</p><a href="javascript:;" data-id="'+id+'"></a></li>';
        $('.select-list li:first').before(li);
        $('#select_'+id+' a').bind('click',function(){
          updateSelectIds($(this).data('id'));
        });

        //session
        select_ids = select_ids+','+id;
        setCookie('select_ids',select_ids);

        $('#siteName').val('');
        $('#siteUrl').val('');
        alert('添加成功');
      }else{
        alert(jsonobj.msg);
      }
      isSumbit = false;
  });

});


function updateSelectIds(id){
  if (select_ids!='') {
      var ids = new Array();
      ids = select_ids.split(',');

      select_ids = '';
      for (var i = ids.length - 1; i >= 0; i--) {
        if (id != ids[i]) {
          select_ids = select_ids+','+ids[i];
        };
      };
    };
    setCookie('select_ids',select_ids);
}


function delSelectIds(id){
  $('#select_'+id).remove();

  //重复处理
  $('.list ul li').each(function () {
    var li_id = $(this).data('id');
    if (li_id == 'list_'+id) {
      $(this).attr('class','txtover')
    };
  });

  if (select_ids!='') {
      var ids = new Array();
      ids = select_ids.split(',');

      select_ids = '';
      for (var i = ids.length - 1; i >= 0; i--) {
        if (id != ids[i]) {
          select_ids = select_ids+','+ids[i];
        }else{
          continue;
        }
      };
    };
    setCookie('select_ids',select_ids);
}

</script>
</body>
</html>