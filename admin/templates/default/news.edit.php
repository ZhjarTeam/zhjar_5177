<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>活动管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=news&op=index"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=news&op=add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="news_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="news_id" value="<?php echo $output['news_array']['id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="news_title">标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['title'];?>" name="news_title" id="news_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2"><label>标题颜色:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['color'];?>" name="news_color" id="news_color" class="txt"></td>
          <td class="vatop tips">如#EA0000</td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="news_title">SEO关键词:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="keyword" rows="6" class="tarea" id="keyword"><?php echo $output['news_array']['keyword'];?></textarea></td>
          <td class="vatop tips">默认为摘要内容</td>
        </tr>
        
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="news_title">SEO摘要:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="news_short_tit" rows="6" class="tarea" id="news_short_tit"><?php echo $output['news_array']['short_tit'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        
        <tr>
          <td colspan="2" class="required"><label class="validation">内容:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('news_content',$output['news_array']['content']);?></td>
        </tr>
        <tr>
          <td colspan="2"><label>排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['ordering'];?>" name="news_ordering" id="news_ordering" class="txt"></td>
          <td class="vatop tips">排序越大，越靠前</td>
        </tr>
        <tr>
          <td colspan="2"><label>查看数:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['views'];?>" name="news_views" id="news_views" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2"><label>作者:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['author'];?>" name="news_author" id="news_author" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2"><label>来源网址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['news_array']['source_url'];?>" name="news_source_url" id="news_source_url" class="txt"></td>
          <td class="vatop tips">默认本站，其他带http://</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label>类型:</label>&nbsp;&nbsp;<a href="javascript:;" id="selectAll">全选</a> | <a href="javascript:;" id="selectNoAll">全不选</a></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <div class="types_id">
              <?php if(!empty($output['types_list']) && is_array($output['types_list'])){ ?>
              <?php foreach($output['types_list'] as $k => $type_info){ ?>
                <p><input type="checkbox" name="type_ids[]" value="<?php echo $type_info['id']?>"  <?php if(in_array($type_info['id'], $output['chos_ids']))echo 'checked="checked"';?>><?php echo $type_info['name']?></p>
              <?php } ?>
              <?php } ?>
              </div>
          </td>
          <td class="vatop tips">设置显示的类型</td>
        </tr>
        <tr>
          <td colspan="2" class="required">新闻图片:</td>
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
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['news_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
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
    if($("#news_form").valid()){
     $("#news_form").submit();
	}
	});


$('#selectAll').click(function () {
    $('.types_id input').each(function(){
      $(this).attr('checked','checked');
    });
  });

  $('#selectNoAll').click(function () {
    $('.types_id input').each(function(){
      $(this).removeAttr('checked');
    });
  });
});
//
$(document).ready(function(){
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=news&op=pic_upload&item_id=<?php echo $output['news_array']['id'];?>',
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
	var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_NEWS.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_NEWS.'/';?>' + file_data.file_name + '\');"><?php echo $lang['news_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('news_description', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=news&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['news_add_del_fail'];?>');
        }
    });
}
</script>