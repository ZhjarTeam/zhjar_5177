<div class="content">
    <h1><?php echo $output['forum_info']['TITLE'];?></h1>
    <p>
      <?php 
if ($output['forum_info']['author']) {
 echo '<a href="'.$output['forum_info']['source_url'].'" target="_blank">'.$output['forum_info']['author'].'</a>';
}
      ?>
      
      <?php echo $output['forum_info']['CREATE_TIME'];?>
      <span><?php echo $output['forum_info']['BROWSE_COUNT'];?></span>
    </p>
    <div class="word">
      <?php echo $output['forum_info']['CONTENT'];?>
    </div>
    <div class="about-search clearfix">
      <h3>相关资讯</h3>
      <?php if(!empty($output['other_news_list']) && is_array($output['other_news_list'])){ ?>
        <?php foreach($output['other_news_list'] as $k => $info){ ?>
        <a href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>"><font color="<?php echo $info['color']; ?>"><?php echo $info['title']?></font></a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>

  <div class="other-right">
    <h3>最新资讯</h3>
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