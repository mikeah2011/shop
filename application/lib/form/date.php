
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

<?php page_start('footer');?>

glay.use('laydate',function(){
	var laydate =  layui.laydate;
	laydate.render({
	  elem: '#<?php echo $id;?>'
	  ,type: 'datetime'
	});
});


<?php page_end();?>