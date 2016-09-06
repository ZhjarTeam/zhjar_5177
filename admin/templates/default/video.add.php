<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>视频管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=video&op=video"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="video_form" method="post" name="videoForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="video_title" id="video_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label>展示模版:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name="video_type" id="video_type">
              <option value="1">福彩</option>
              <option value="2">体彩</option>
              <option value="3">篮球</option>
              <option value="4">足球</option>
            </select>
          </td>
        </tr>
         <tr class="noborder">
          <td colspan="2"><label>排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="video_ordering" id="video_ordering" class="txt"></td>
          <td class="vatop tips">排序越大，越靠前</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><label class="validation">链接:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="video_link" id="video_link" class="txt"></td>
        </tr>
        </tr>
        <tr>
          <td colspan="2" class="required">图片: （大图：290*240，小图：180*120）</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" uptype="3" class="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图片预览:</td>
        <tr>
          <td colspan="2"><ul class="thumblists thumbnails">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul>
          </td>
        </tr>
        </tbody>
        <tbody class="ball_template">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="video_time">比赛时间:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['video_array']['time'];?>" name="video_time" id="video_time" class="txt"></td>
          <td class="vatop tips"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="video_desc">左球队名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['video_array']['team_left'];?>" name="video_team_left" id="video_team_left" class="txt"></td>
          <td class="vatop tips"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">左球队图标:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" ><input type="file" multiple="multiple" uptype="4" class="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图标预览:</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><ul class="thumbnails" class="thumblists">
              <?php if(is_array($output['left_upload'])){?>
              <?php foreach($output['left_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['video_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="video_desc">右球队名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['video_array']['team_right'];?>" name="video_team_right" id="video_team_right" class="txt"></td>
          <td class="vatop tips"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">右球队图标:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3"><input type="file" multiple="multiple" uptype="5" class="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图标预览:</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><ul class="thumbnails" class="thumblists">
              <?php if(is_array($output['right_upload'])){?>
              <?php foreach($output['right_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['video_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
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
    if($("#video_form").valid()){
     $("#video_form").submit();
	}
	});
});
//
$(document).ready(function(){
    var de_type = $('#video_type').val();
    if(de_type == '1' || de_type == '2'){
      $('.ball_template').hide();
    }else{
      $('.ball_template').show();
    }
    $('#video_type').change(function(){
      if($(this).val() == '1' || $(this).val() == '2'){
        $('.ball_template').hide();
      }else{
        $('.ball_template').show();
      }
    });

    var uptype = 3;
    $('.fileupload').click(function(){
      uptype = $(this).attr('uptype');
      setTimeout(function(){
        $('.fileupload').fileupload({
            dataType: 'json',
            url: 'index.php?act=video&op=pic_upload&up_type='+uptype+'&item_id=<?php echo $output['video_array']['id'];?>',
            done: function (e,data) {
                console.log(data);
                if(data != 'error'){
                  add_uploadedfile(data.result,$(this).attr("uptype"));
                }
            }
        });
      },100);
    });
});


function add_uploadedfile(file_data,uptype)
{
    var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_VIDEO.'/';?>' + file_data.file_name + '\');"><?php echo $lang['video_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('.thumbnails').eq(uptype-3).prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('video_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=video&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['video_add_del_fail'];?>');
        }
    });
}


</script>