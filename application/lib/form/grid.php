<?php 

$table_id = 'grid-demo-'.mt_rand(0,999999);
/**
 * module => treetable
 * https://whvse.gitee.io/treetable-lay
 */
 
$module = $data['module']?:'table';

?>
<?php if($module == 'treetable'){?>

<div class="layui-btn-group">
          <button class="layui-btn" id="btn-expand-<?php echo $table_id;?>"><?php echo lang('All unfolding');?></button>
          <button class="layui-btn" id="btn-fold-<?php echo $table_id;?>"><?php echo lang('All collapse');?></button>
          
 </div>

<input id="edt-search-<?php echo $table_id;?>" class="layui-input grid_search" type="text" 
 placeholder="<?php echo lang('Input search keyword');?>" style="">
<button class="layui-btn" id="btn-search-<?php echo $table_id;?>"><?php echo lang('Search');?></button>


<?php } ?>

<table id="<?php echo $table_id;?>" ></table>

<?php 

page_start('footer');
 

$opts['elem'] = "#".$table_id;
$opts['cellMinWidth'] = '80';
$opts['url'] = $url;
$opts['page'] = true;
$opts['cols'] = [$cols]; 
if($module == 'treetable'){
  $opts['treeColIndex'] = 1;
  $opts['treeSpid']     = 0;
  $opts['treeIdName']   = 'id';
  $opts['treePidName'] = 'pid';
  $opts['treeDefaultClose'] = true;
  $opts['treeLinkage'] = true;  
  $opts['page'] = false;
}

?> 
glay.use('<?php echo $module;?>', function(){
  var <?php echo $module;?> = layui.<?php echo $module;?>; 
   
  <?php echo $module;?>.render(<?php echo js_encode($opts)?>);
  <?php if($module == 'treetable'){?>
  $('#btn-expand-<?php echo $table_id;?>').click(function () {
      <?php echo $module;?>.expandAll('#<?php echo $table_id;?>');
  });

  $('#btn-fold-<?php echo $table_id;?>').click(function () {
      <?php echo $module;?>.foldAll('#<?php echo $table_id;?>');
  });
    $('#btn-search-<?php echo $table_id;?>').click(function () {
        var keyword = $('#edt-search-<?php echo $table_id;?>').val();
        var searchCount = 0;
        $('#<?php echo $table_id;?>').next('.treeTable').find('.layui-table-body tbody tr td').each(function () {
            $(this).css('background-color', 'transparent');
            var text = $(this).text();
            if (keyword != '' && text.indexOf(keyword) >= 0) {
                $(this).css('background-color', 'rgba(250,230,160,0.5)');
                if (searchCount == 0) {
                    treetable.expandAll('#<?php echo $table_id;?>');
                    $('html,body').stop(true);
                    $('html,body').animate({scrollTop: $(this).offset().top - 150}, 500);
                }
                searchCount++;
            }
        });
        if (keyword == '') {
            layer.msg("<?php echo lang('Please input search keyword');?>", {icon: 5});
        } else if (searchCount == 0) {
            layer.msg("<?php echo lang('No result');?>", {icon: 5});
        }
    });
  <?php }?>

  <?php echo $js;?>
  
});



<?php  
page_end();
?>