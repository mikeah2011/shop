<?php 
  
$nameId = $name;
/**
 * 数组类的字段要替换 
 */
if(strpos($nameId,'[')!==false){
	$nameId = replace(['[',']'],'',$nameId);
}  
?>
<?php if($lang && $langs && count($langs)>1){?> 
<?php 
$i=0;
foreach($langs as $k1=>$v1){
$val =  $value[$k1];
$nameIds[] = $nid = 'editor_'.$k1;
//加载编辑器，统计编辑器出现的次数以便获取内容值 
$ck =  $nid;
?>
<div class="layui-form-item">
	<label class="layui-form-label">
		<?php if($i==0){echo $label;}?><?php echo guoqi($langKey[$i]);?>
			<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
			<?php echo $label_next;?>
		</label>
	</label>
	<div class="layui-input-block"> 
		<textarea type="text" name="<?php echo $name;?>[<?php echo $k1;?>]"   id="<?php echo $nid;?>"
			<?php TForm::attrs($attrs,['class'=>'layui-textarea']);?> ><?php echo trim($val);?></textarea>
	 </div>
</div>
<?php $i++;}?>


<?php }else{?>

<div class="layui-form-item">
	<label class="layui-form-label"><?php echo $label;?>
		<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
		<?php echo $label_next;?>
	</label>
	<div class="layui-input-block"> 
		<textarea type="text" name="<?php echo $name;?>"   id="<?php echo $nameId;?>"
			<?php TForm::attrs($attrs,['class'=>'layui-textarea']);?>><?php echo trim($value);?></textarea>
	 </div>
</div>

<?php } ?>
 