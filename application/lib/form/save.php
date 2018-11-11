
<div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="form"><?php echo lang('Save');?></button>
     
      <?php 
      //返回按钮
      if($backLink){?>
	  <a class="layui-btn layui-btn-primary " style="margin-left: 10px;"  href="	<?php echo $backLink;?>"><?php echo lang('Back');?></a> 
	  <?php }?>
    </div>
  </div>