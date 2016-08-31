<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $output['seo']['desc']?>" />
<meta name="description" content="<?php echo $output['seo']['desc']?>" />
<title><?php echo $output['seo']['title']?></title>
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_TEMPLATES_URL;?>/css/other.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="head">
  <a class="logo" href="<?php echo WEB_SITE_URL;?>"><img src="<?php echo $output['list_setting']['site_logo']?>" alt="<?php echo $output['seo']['title']?>"></a>
</div>
<div class="container clearfix">
	<div class="about-left">
		<?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>
	    <?php foreach($output['article_list'] as $k => $info){
	    	$cur = '';
	    	if ($_GET['id'] == $info['id']) {
	    		$cur ='hover';
	    	}
	    	?>
	    <a class="<?php echo $cur;?>" href="<?php echo WEB_SITE_URL;?>?act=article&op=show&id=<?php echo $info['id']?>"><?php echo $info['title']?></a>
	    <?php } ?>
	    <?php } ?>
	</div>
	<div class="about-content">
		<h1><?php echo $output['data']['title'];?></h1>
		<div>
			<?php echo htmlspecialchars_decode($output['data']['content']);?>
		</div>
	</div>
</div>
<div class="foot other">
	<p>
		<?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>
	    <?php foreach($output['article_list'] as $k => $info){ ?>
	    <a href="<?php echo WEB_SITE_URL;?>?act=article&op=show&id=<?php echo $info['id']?>"><?php echo $info['title']?></a>
	    <?php } ?>
	    <?php } ?>
	</p>
	<p><?php echo $output['list_setting']['icp_number']?>&nbsp;&nbsp;<?php echo $output['list_setting']['statistics_code']?></p>
</div>
</body>
</html>