<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>走势管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=trend&op=add" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="trend" name="act">
    <input type="hidden" value="index" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_name">选择类型</label></th>
          <td>
            <select name="search_type" id="search_type">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="1" <?php if ($output['search_type'] == 1) echo 'selected="selected"';?> >福彩</option>
              <option value="2" <?php if ($output['search_type'] == 2) echo 'selected="selected"';?>>体彩</option>
              <option value="3" <?php if ($output['search_type'] == 3) echo 'selected="selected"';?>>足彩</option>
            </select>
          </td>
          <th><label for="search_name">关键词</label></th>
          <td><input type="text" value="<?php echo $output['search_name'];?>" name="search_name" id="search_name" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_name'] != ''){?>
            <a href="index.php?act=trend&op=index" class="btns " title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['article_index_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="form_article">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48">ID</th>
          <th >图片</th>
          <th >标题</th>
          <th >类型</th>
          <th >颜色</th>
          <th >位置</th>
          <th >排序</th>
          <th >发布时间</th>
          <th class="w60 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['trend_list']) && is_array($output['trend_list'])){ ?>
        <?php foreach($output['trend_list'] as $k => $v){ ?>
        <tr class="hover">
          <td><input type="checkbox" name='del_id[]' value="<?php echo $v['id']; ?>" class="checkitem"></td>
          <td><?php echo $v['id']; ?></td>
          <td><img src="<?php echo $v['upload_path']; ?>" width="50" height="50"></td>
          <td><font color="<?php echo $v['color']; ?>"><?php echo $v['name']; ?></font></td>
          <td><?php 
            switch ($v['type'])
            {
            case 1:
                echo "福彩";
                break;
            case 2:
                echo "体彩";
                break;
            case 3:
                echo "足彩";
                break;
            default:
                echo "福彩";
            }

          ?></td>
          <td><?php echo $v['color']; ?></td>
          <td><?php if($v['child_type'] == 1){echo "左列";}else{echo "右列";} ?></td>
          <td><?php echo $v['ordering']; ?></td>
          <td><?php echo $v['input_time']; ?></td>
          <td class="align-center"><a href="index.php?act=trend&op=edit&trend_id=<?php echo $v['id']; ?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['trend_list']) && is_array($output['trend_list'])){ ?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_article').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
