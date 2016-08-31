<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>类型管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=types&op=index"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=types&op=add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="types_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="types_id" value="<?php echo $output['types_array']['id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="types_title">名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['types_array']['name'];?>" name="types_name" id="types_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="hd_type_id">所属模块:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input type="radio" name="types_group_type" value="0" <?php if($output['types_array']['group_type']==0)echo 'checked="checked"';?>/>新闻
              <input type="radio" name="types_group_type" value="1" <?php if($output['types_array']['group_type']==1)echo 'checked="checked"';?>/>链接
              <input type="radio" name="types_group_type" value="2" <?php if($output['types_array']['group_type']==2)echo 'checked="checked"';?>/>公众号
          </td>
          </td>
          <td class="vatop tips">目前二级菜单，只支持新闻模块</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['types_array']['ordering'];?>" name="types_ordering" id="types_ordering" class="txt"></td>
          <td class="vatop tips">排序越大，越靠前</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){
  $("#submitBtn").click(function(){
    if($("#types_form").valid()){
     $("#types_form").submit();
	}
	});
});
</script>