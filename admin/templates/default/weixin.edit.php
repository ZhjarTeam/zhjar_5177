<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>活动管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=weixin&op=index"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=weixin&op=add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="weixin_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="weixin_id" value="<?php echo $output['weixin_array']['id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="weixin_title">标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['weixin_array']['name'];?>" name="weixin_title" id="weixin_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2"><label>颜色码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['weixin_array']['color'];?>" name="weixin_color" id="weixin_color" class="txt"></td>
          <td class="vatop tips">如#EA0000</td>
        </tr>
        <tr>
          <td colspan="2"><label>排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['weixin_array']['ordering'];?>" name="weixin_ordering" id="weixin_ordering" class="txt"></td>
          <td class="vatop tips">排序越大，越靠前</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="weixin_desc">摘要:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="weixin_desc" rows="6" class="tarea" id="weixin_desc"><?php echo $output['weixin_array']['description'];?></textarea></td>
          <td class="vatop tips"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">活动图片:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图片预览:</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['weixin_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
        </tr>
        <tr>
          <td colspan="2" class="required">推荐:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="radio" name="weixin_hot" value="0" <?php if($output['weixin_array']['hot'] == 0) echo 'checked="checked"';?> >否
            <input type="radio" name="weixin_hot" value="1" <?php if($output['weixin_array']['hot'] == 1) echo 'checked="checked"';?> >是
          </td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){
  $("#submitBtn").click(function(){
    if($("#weixin_form").valid()){
     $("#weixin_form").submit();
	}
	});
});
//
$(document).ready(function(){
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=weixin&op=pic_upload&item_id=<?php echo $output['weixin_array']['id'];?>',
            done: function (e,data) {
                if(data != 'error'){
                	add_uploadedfile(data.result);
                }
            }
        });
    });
});
function add_uploadedfile(file_data)
{
	var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_WEIXIN.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_WEIXIN.'/';?>' + file_data.file_name + '\');"><?php echo $lang['weixin_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('weixin_description', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=weixin&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['weixin_add_del_fail'];?>');
        }
    });
}
</script>