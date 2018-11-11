<?php 
 
if($muit_lang || ( $lang && $langs && $_num = count($langs)>1)){?> 
<?php  
$i=0;  
foreach($langs as $k1=>$v1){
$val =  $value[$k1];
 
?>

	<div class="layui-form-item">
		<label class="layui-form-label">
			<?php if($i==0){echo $label;}?><?php if($_num>1){echo guoqi($langKey[$i]);}?> 
				<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
				<?php echo $label_next;?>
			</label>
		<div class="layui-input-block"> 
			<input type="text" name="<?php echo $name;?>[<?php echo $k1;?>]"  
				<?php TForm::attrs($attrs);?> value="<?php echo $val;?>" class="layui-input">
		 </div>
	</div>
	
<?php $i++;}?>


<?php }else{ ?>
<div class="layui-form-item">
	<label class="layui-form-label"><?php echo $label;?>
		<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
		<?php echo $label_next;?>
	</label>
	<div class="layui-input-block"> 
		<input type="text" name="<?php echo $name;?>"  
			<?php TForm::attrs($attrs);?> value="<?php echo $value;?>" class="layui-input">
	 </div>
</div>

<?php } ?>
