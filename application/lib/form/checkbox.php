<?php 
/**
 * 判断传入的value是字符 还是数组，
 * 统一转成数组
 */
if(is_string($value)){
	$value = [$value];
}
 
?>
 
<div class="layui-form-item" pane>
<label class="layui-form-label"><?php echo $label;?></label>
<div class="layui-input-block">
  <?php foreach($values as $k_1 => $v_1){?>
  <input type="checkbox" <?php TForm::attrs($attrs);?>   lay-skin="primary" value="<?php echo $k_1;?>" name="<?php echo $name;?>"
   <?php if($value && in_array($k_1, $value)){?>  checked <?php }?> 

   title="<?php echo $v_1;?>"   
   >
  <?php } ?>  
</div>
</div>
