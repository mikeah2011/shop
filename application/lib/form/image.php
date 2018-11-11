 <?php 

?>

<?php if($label){?>
 <div class="layui-form-item">
  <label class="layui-form-label"><?php echo $label;?></label>
  <div class="layui-input-block">  
  <?php }?>   
    
      <div class="layui-upload-list upload-preview" id="demo_<?php echo $id;?>">
        
          <?php 
          if($value){
            foreach ($value as  $node) {
               echo \TForm::after_upload([
                    'data'=>$node,
                    'name'=>$name,
                    'return'=>true
                  ]);
            } 
          } 
          ?>


      </div>
     
      <button type="button" <?php TForm::attrs($attrs,['class'=>'layui-btn upload_'.$name]);?>  name="<?php echo $name;?>"></button> 

     <?php page_start('footer');?>
    glay.use('upload', function(){
      var $ = layui.jquery
      ,upload = layui.upload;
     //多图片上传
      upload.render({
        elem: '#<?php echo $name;?>'
        ,url: '<?php echo url('open/upload/index');?>'
        ,data:{
            'id':'<?php echo $name;?>'
        }
        ,multiple: true
        ,before: function(obj){
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result){
            
          });
        }
        ,done: function(res){
          if(res.status==1){
              console.log(res);
              $('#demo_<?php echo $id;?>').append(res.html);
              image_delete();
          }
        }
      }); 

    });
    <?php page_end();?>
    
<?php if($label){?>    
  
  </div>
</div>
<?php } ?>




