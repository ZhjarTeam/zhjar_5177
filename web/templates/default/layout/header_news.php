<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $output['news_info']['keyword']?>" />
<meta name="description" content="<?php echo $output['news_info']['short_tit']?>" />
<title><?php echo $output['news_info']['title']?></title>
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
    <?php if(!empty($output['menu_list']) && is_array($output['menu_list'])){ ?>
    <?php foreach($output['menu_list'] as $k => $info){
      $cur = '';
      $m = isset($_GET['m'])?intval($_GET['m']):1;
      if ($m==$info['id']) {
        $cur ='class="hover"';
      }
     ?>
    <a <?php echo $cur;?> href="<?php echo $info['link_url'];?>&m=<?php echo $info['id']?>"><?php echo $info['name']?></a>
    <?php } ?>
    <?php } ?>
  </div>