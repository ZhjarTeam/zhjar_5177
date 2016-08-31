<?php defined('InShopNC') or exit('Access Invalid!');?>
	<div class="list">
		<ul>
			<?php if(!empty($output['news_list']) && is_array($output['news_list'])){ ?>
        <?php foreach($output['news_list'] as $k => $info){ ?>
			<li>
				<a href="<?php echo WEB_SITE_URL;?>?act=news&op=show&id=<?php echo $info['id']?>&m=<?php echo $_GET['m']?>">
					<?php 
					if (!empty($info['upload_path'])) {
						echo '<img src="'.$info['upload_path'].'" alt="" align="left">';
					}
					?>
					
					<h3 class="txtover"><font color="<?php echo $info['color']?>"><?php echo $info['title']?></font></h3>
					<p><?php echo $info['short_tit']?></p>
				</a>
			</li>
		<?php } ?>
        <?php } ?>
		</ul>
		
		<?php if($output['total_page']>1){
		$i = 1;
		$num = $output['total_page']>5?5:$output['total_page'];
		$_GET['curpage'] = isset($_GET['curpage'])?$_GET['curpage']:1;
		$last = false;
		if ($_GET['curpage'] >5 ) {
			$num =  $output['total_page'];
			$i = $num-4;
			$last = true;
		}
		$prev_page = $_GET['curpage']-1>0?$_GET['curpage']-1:1;
		$next_page = $_GET['curpage']+1>$output['total_page']?$output['total_page']:$_GET['curpage']+1;
			?>
		<p>
			<a href="<?php echo WEB_SITE_URL;?>index.php?act=news&op=list&t=<?php echo $_GET['t'];?>&m=<?php echo $_GET['m'];?>&curpage=<?php echo $prev_page;?>">上一页</a>
			<?php 
				for ($i; $i <=$num; $i++) {
				$cur = '';
				if ($i==$_GET['curpage']) {
				 	$cur = 'class="hover" ';
				 } 
		 	?>
			<a <?php echo $cur;?> href="<?php echo WEB_SITE_URL;?>index.php?act=news&op=list&t=<?php echo $_GET['t'];?>&m=<?php echo $_GET['m'];?>&curpage=<?php echo $i;?>"><?php echo $i;?></a>
			<?php } ?>

			<?php if($output['total_page']>5 && !$last){?>
			<span>…</span>
			<a href="<?php echo WEB_SITE_URL;?>index.php?act=news&op=list&t=<?php echo $_GET['t'];?>&m=<?php echo $_GET['m'];?>&curpage=<?php echo $output['total_page'];?>"><?php echo $output['total_page'];?></a>
			<?php }?>
			<a href="<?php echo WEB_SITE_URL;?>index.php?act=news&op=list&t=<?php echo $_GET['t'];?>&m=<?php echo $_GET['m'];?>&curpage=<?php echo $next_page;?>">下一页</a>
		</p>
		<?php } ?>
		
	</div>
	<div class="other-right">
		<h3>最新推荐</h3>
		<?php if(!empty($output['rec_news_list']) && is_array($output['rec_news_list'])){ ?>
        <?php foreach($output['rec_news_list'] as $k => $info){
         ?>
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