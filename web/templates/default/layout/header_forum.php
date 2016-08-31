<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $output['seo']['keyword']?>" />
<meta name="description" content="<?php echo $output['seo']['desc']?>" />
<title><?php echo $output['seo']['title']?></title>
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/other.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="head">
  <a class="logo" href="<?php echo WEB_SITE_URL;?>"><img src="<?php echo $output['list_setting']['site_logo']?>" alt="<?php echo $output['seo']['title']?>"></a>
  <form class="search_bar" method="get" action="http://www.baidu.com/s" target="_blank">
    <input type="text" name="word" value="" placeholder="搜你想要的">
    <input type="submit" value="搜一搜">
  </form>
</div>
<div class="container clearfix">
  <div class="nav clearfix">
        <a href="/?act=index&amp;op=index&amp;m=1">首页</a>
        <?php if(!empty($output['forum_menus']) && is_array($output['forum_menus'])){ ?>
        <?php foreach($output['forum_menus'] as $k => $info){
          $cur = '';
          $m = isset($_GET['topic'])?intval($_GET['topic']):1;
          if ($m==$info['Id']) {
            $cur ='class="hover"';
          }
         ?>
        <a <?php echo $cur;?> href="<?php echo WEB_SITE_URL;?>?act=forum&op=list&topic=<?php echo $info['Id']?>"><?php echo $info['Value']?></a>
        <?php } ?>
        <?php } ?>
  </div>