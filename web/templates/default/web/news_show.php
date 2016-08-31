<div class="content">
    <h1><?php echo $output['news_info']['title'];?></h1>
    <p>
      <?php 
if ($output['news_info']['author']) {
 echo '<a href="'.$output['news_info']['source_url'].'" target="_blank">'.$output['news_info']['author'].'</a>';
}
      ?>
      
      <?php echo $output['news_info']['input_time'];?>
      <span><?php echo $output['news_info']['views'];?></span>
    </p>
    <div class="word">
      <?php echo htmlspecialchars_decode($output['news_info']['content']);?>
    </div>
    <div class="about-search clearfix">
      <h3>相关搜索</h3>
      <?php if(!empty($output['other_news_list']) && is_array($output['other_news_list'])){ ?>
        <?php foreach($output['other_news_list'] as $k => $info){ ?>
        <a href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>"><font color="<?php echo $info['color']; ?>"><?php echo $info['title']?></font></a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>

  <div class="other-right">
    <h3>最新推荐</h3>
    <?php if(!empty($output['rec_news_list']) && is_array($output['rec_news_list'])){ ?>
        <?php foreach($output['rec_news_list'] as $k => $info){ ?>
        <a class="txtover" href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>">
        <?php 
          if ($k == 0) {
            echo '<font color="#2d64d1">'.$info['title'].'</font>';
          }else{
            echo $info['title'];
          }
        ?>
        </a>
    <?php } ?>
    <?php } ?>
    
    <?php if(isset($output['adv_info']['upload_path'])){?>
    <a href="<?php echo $output['adv_info']['upload_path']?>" target="_blank"><img src="<?php echo $output['adv_info']['upload_path']?>" alt="<?php echo $output['adv_info']['title']?>"></a>
    <?php } ?>
  </div>
</div>