
<?php if($label){?>
<div class="layui-form-item">
	<label class="layui-form-label"><?php echo $label;?>
		<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
		<?php echo $label_next;?>
	</label>
	<div class="layui-input-block">
	<?php } ?>
	   <select <?php TForm::attrs($attrs);?>    name="<?php echo $name;?>" lay-verify="required" lay-search>
		    <?php foreach($values as $k=>$v){?>
		    <option 

		    <?php if(
		    	($value && $k==$value) || 
		    	(is_array($value) && in_array($k,$value))

		    ){echo "selected=true";}?> 


		     value="<?php echo $k;?>"><?php echo $v;?></option>
		    <?php } ?>
		</select>
	<?php if($label){?>
	</div>
</div>
<?php } ?>

