<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>走势管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=trend&op=trend"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="trend_form" method="post" name="trendForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="trend_title" id="trend_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label>颜色码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="trend_color" id="trend_color" class="txt"></td>
          <td class="vatop tips">如#EA0000</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label>走势分类:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name="trend_type" id="trend_type">
              <option value="1">福彩</option>
              <option value="2">体彩</option>
              <option value="3">足彩</option>
            </select>
          </td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label>左右分列:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name="trend_child_type" id="trend_child_type">
              <option value="1">左列</option>
              <option value="2">右列</option>
            </select>
          </td>
        </tr>
         <tr class="noborder">
          <td colspan="2"><label>排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="trend_ordering" id="trend_ordering" class="txt"></td>
          <td class="vatop tips">排序越大，越靠前</td>
        </tr>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="trend_link">链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="trend_link" id="trend_link" class="txt"></td>
          <td class="vatop tips"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图片: （尺寸：150 X 90）</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">预览:</td>
        <tr>
          <td colspan="2"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
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
    if($("#trend_form").valid()){
     $("#trend_form").submit();
	}
	});
});
//
$(document).ready(function(){
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=trend&op=pic_upload',
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
    var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_TREND.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_TREND.'/';?>' + file_data.file_name + '\');"><?php echo $lang['trend_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('trend_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=trend&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['trend_add_del_fail'];?>');
        }
    });
}


</script>