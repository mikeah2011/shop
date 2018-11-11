<?php 
/**
 * 加载VueSelect插件
 *
 *
 * [
 * ':multiple'=>true
 * ]
 * https://vue-treeselect.js.org/
 */
plugin('VueSelect');

$select_id = 'vue-select-'.mt_rand(0,99999);

?>
<?php if($label){?>
<div class="layui-form-item">
	<label class="layui-form-label"><?php echo $label;?>
		<?php if($attrs['require']){?><span style="color:red">*</span><?php }?>
		<?php echo $label_next;?>
	</label>
	<div class="layui-input-block" id="<?php echo $select_id;?>">
	<?php } ?> 
 
	   <treeselect <?php TForm::attrs($attrs);?>  v-model="value"  :options="options"   name="<?php echo $name;?>" >
		       
	<?php if($label){?>
	</div>
</div>
<?php } ?>
<?php  page_start('footer');?>

	Vue.component('treeselect', VueTreeselect.Treeselect)

    new Vue({
      el: '#<?php echo $select_id;?>',
      data: {
        // define default value
        value: null,
        // define options
        options:  <?php echo js_encode($values);?>
      },
    })

<?php page_end();?>
