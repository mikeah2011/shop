<?php 
/**
 * 上传文件后或加载数据后显示图片效果。
 * 
 */

 
$name = 'node-'.$name;
$str = '<div class="img click_delete">';
$str .="<input type='hidden' name='".$name."[]' value='".$data['id']."'>";
$str .='<img src="'.$data['thumb'].'" alt="'.$data['thumb'].'" ><span class="hide"  title="'.lang('Support drag and drop').'" ><a class="layui-btn layui-btn-danger delete layui-btn-xs" lay-event="del" ><i class="layui-icon layui-icon-delete"></i>'.lang('Delete').'</a></span></div>';
 
return $str;

?>