<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_set'];?></h3>
      <?php //echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="site_name"><?php echo $lang['web_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_name" name="site_name" value="<?php echo $output['list_setting']['site_name'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['web_name_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="site_logo"><?php echo $lang['site_logo'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['list_setting']['site_logo']);?>"></div>
            </span><span class="type-file-box"><input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="site_logo" type="file" class="type-file-file" id="site_logo" size="30" hidefocus="true" nc_type="change_site_logo">
            </span></td>
          <td class="vatop tips"><span class="vatop rowform">默认网站LOGO,通用头部显示，最佳显示尺寸为195*65像素</span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="icp_number"><?php echo $lang['icp_number'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="icp_number" name="icp_number" value="<?php echo $output['list_setting']['icp_number'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['icp_number_notice'];?></span></td>
        </tr>
         <tr>
          <td colspan="2" class="required"><label for="site_keyword">站点关键词:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="site_keyword" rows="6" class="tarea" id="site_keyword"><?php echo $output['list_setting']['site_keyword'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr> 
        <tr>
          <td colspan="2" class="required"><label for="site_desc">站点描述:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="site_desc" rows="6" class="tarea" id="site_desc"><?php echo $output['list_setting']['site_desc'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr> 
       <!--  <tr>
          <td colspan="2" class="required"><label for="site_phone"><?php echo $lang['site_phone'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_phone" name="site_phone" value="<?php echo $output['list_setting']['site_phone'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_phone_notice'];?></span></td>
        </tr> -->
        <!--
        平台付款帐号，前台暂时无调用
        <tr>
          <td colspan="2" class="required"><label for="site_bank_account"><?php echo $lang['site_bank_account'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_bank_account" name="site_bank_account" value="<?php echo $output['list_setting']['site_bank_account'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_bank_account_notice'];?></span></td>
        </tr>
        -->
        <!-- <tr>
          <td colspan="2" class="required"><label for="site_email"><?php echo $lang['site_email'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="site_email" name="site_email" value="<?php echo $output['list_setting']['site_email'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_email_notice'];?></span></td>
        </tr> -->
         <tr>
          <td colspan="2" class="required"><label for="statistics_code"><?php echo $lang['flow_static_code'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="statistics_code" rows="6" class="tarea" id="statistics_code"><?php echo $output['list_setting']['statistics_code'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['flow_static_code_notice'];?></span></td>
        </tr> 
        <tr>
          <td colspan="2" class="required"><?php echo $lang['site_state'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="site_status1" class="cb-enable <?php if($output['list_setting']['site_status'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="site_status0" class="cb-disable <?php if($output['list_setting']['site_status'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="site_status1" name="site_status" <?php if($output['list_setting']['site_status'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="site_status0" name="site_status" <?php if($output['list_setting']['site_status'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['site_state_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="closed_reason"><?php echo $lang['closed_reason'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="closed_reason" rows="6" class="tarea" id="closed_reason" ><?php echo $output['list_setting']['closed_reason'];?></textarea></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['closed_reason_notice'];?></span></td>
        </tr>
      </tbody>
      <tfoot id="submit-holder">
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
// 模拟网站LOGO上传input type='file'样式
$(function(){
	$("#site_logo").change(function(){
		$("#textfield1").val($(this).val());
	});
	$("#member_logo").change(function(){
		$("#textfield2").val($(this).val());
	});
	$("#seller_center_logo").change(function(){
		$("#textfield3").val($(this).val());
	});
// 上传图片类型
$('input[class="type-file-file"]').change(function(){
	var filepatd=$(this).val();
	var extStart=filepatd.lastIndexOf(".");
	var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("<?php echo $lang['default_img_wrong'];?>");
				$(this).attr('value','');
			return false;
		}
	});
$('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');	
});
</script>
