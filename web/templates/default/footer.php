<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="foot">
  <p>
    <?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>
    <?php foreach($output['article_list'] as $k => $info){ ?>
    <a href="<?php echo WEB_SITE_URL;?>?act=article&op=show&id=<?php echo $info['id']?>"><?php echo $info['title']?></a>
    <?php } ?>
    <?php } ?>
  </p>
  <p><?php echo $output['list_setting']['icp_number']?>&nbsp;&nbsp;<?php echo $output['list_setting']['statistics_code']?></p>
</div>
