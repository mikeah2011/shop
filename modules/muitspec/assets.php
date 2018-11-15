<?php page_start('page_footer');?> 
<style type="text/css">
  #spec-table input{
    width: 80px;
  }
</style>
 
 <script>

  function load_spec(){
   
    var vm = new Vue({
        el:'#spec-app', 
        data:{
          lists:{},
          price:{},
          title:{},
          ori:{},
          is_show:false,
          spec1:'',
          spec2:'',
          goods_id:<?php echo $_REQUEST['id'];?>,
          more:{},
          settings:{},
          spec_template:{},
          spec_template_admin:{},
          spec_template_val:"",
          box1: 0, 
          box2: 0
        },
        created:function(){
           var _this = this;
           this.create();
           this.get_spec();
           this.is_show = true;  
        },
        mounted:function(){   
        },
        watch: {
            ori: function(newValue, oldValue) { 
            }
        },
        methods: {
          /**
           * 返回设置批量价格input的name属性
           */
          spec_price_set:function(item,index){ 
              return "spec_set["+index+"]";
          },
          /**
          * 加载笛卡尔积 table
          */
          create:function(){ 
             var _this = this;
             $.get("<?php echo module_url('muitspec','Hook','table');?>",function(res){ 
                  vm_set(_this,res);
             },'json');
          },
          /**
           * 加载规格 
           */
         get_spec:function(){
          var _this = this;
          /**
            * 加载规格模板 
            */
           $.get("<?php echo murl('muitspec/Hook/defaultSpec');?>",function(res){ 
                _this.spec_template = res.key;
                _this.spec_template_admin = res.key_admin;

           },'json');
         },
         /**
          * 打开规格排序
          * @return {[type]} [description]
          */
         spec_sort_open:function(){ 
              this.box2 = true;
              var el = this.$el;  
              this.box();
                
         },
         /**
          * 弹出窗口排序　
          */
         box:function(){
              this.$nextTick(function(){
                  console.log('get html');
                  var sh = document.querySelector('#muit'); 
                  Sortable.create(sh,{ 
                     handle: ".tile", 
                     handle: '.tile__name'
                  });  
                  [].forEach.call(sh.getElementsByClassName('tile__list'), function (el){
                    Sortable.create(el, {
                      group: 'span' 
                    });
                  });
              });
         },
         /**
          * 设置规格排序名
          */
         spec_sort_name:function(index,v){
              return "spec_name["+index+"]["+v+"]";
         },
         /**
          * 规格排序
          * @return {[type]} [description]
          */
         spec_sort_save:function(){
            var _this = this;   
            this.$nextTick(function(){ 
                var post_data = new Array;
                $("input[name^='spec_name']").each(function(i,el){
                    post_data.push(el.name); 
                });
                $.post("<?php echo murl('muitspec/Hook/sortSpec');?>",{data:post_data,goods_id:_this.goods_id},function(res){
                  if(res.status){
                    _this.ori = {};
                    setTimeout(function(){
                         _this.ori = res.ori; 
                         _this.box();
                    },'500');  
                    _this.box2 = false;
                    alert("<?php echo lang('Spec sort has changed');?>");
                  }

                },'json');
                console.log(post_data);
            });

              
         },
         /**
          * 删除模板
          */
         dele_template:function(item,index){
              var _this = this;
              var _index = index;
              layer.confirm("<?php echo lang('Change spec,cant back');?>", {icon: 3, title:"<?php echo lang('Action cant back');?>"}, function(index){

                  _this.spec_template_admin.remove(item);
                  $.post("<?php echo murl('muitspec/Hook/deleteT');?>",{name,item},function(res){ 
                    _this.spec_template = res.key;
                  },'json');
              }); 


               
               
         },
          
         /**
          * 保存模板 
          */
         spec_save:function(){
              var _this = this;
              this.$prompt('<?php echo lang("Please input template name");?>', '提示', {
                  confirmButtonText: '<?php echo lang('Confirm');?>',
                  cancelButtonText: '<?php echo lang('Cancel');?>', 
                }).then(({ value }) => {
                  $.post("<?php echo module_url('muitspec','Hook','template');?>",{val:value,goods_id:_this.goods_id},function(res){
                        if(res.status){
                          _this.spec_template.push(res.name);
                          _this.spec_template_admin.push(res.name);
                          _this.$message({ 
                            type: 'success',
                            message: '<?php echo lang('Save template success');?>'
                          });
                        }else{
                          _this.$message({ 
                            type: 'error',
                            message: '<?php echo lang('Template name exists');?>'
                          });
                        }
                  },'json');
                  
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    message: '<?php echo lang('Cancel');?>'
                  });       
                });

         },
          /**
           * 规格模板选择 
           */
          tt:function(){
              var _this = this;
              var val = this.spec_template_val; 

              layer.confirm("<?php echo lang('Change spec,cant back');?>", {icon: 3, title:'<?php echo lang('Action cant back');?>'}, function(index){
                  console.log('send change spec');
                  /**
                   * 查寻后台数据
                   */
                  $.post("<?php echo murl('muitspec/Hook/defaultSpec');?>",{val:val,goods_id:_this.goods_id},function(res){ 
                        console.log(res);
                        vm_set(_this,res); 
                  },'json'); 
                
                layer.close(index);
              }); 
          },
          /**
           * 批量设置市场价等 
           */
          spec_setting:function(){

          },
          /**
           * 添加规格  
           */
          spec_action: function(method){
              var _this = this;
              var ds = {
                goods_id:this.goods_id,
                val:this.spec2,
                name:this.spec1,
                type:'save'
              };
              $.post("<?php echo murl('muitspec/Hook/action');?>",ds,function(res){
                  vm_set(_this,res);   
              },'json');
              
          },
          /**
           * 删除规格 
           */
          removeSpec: function (key1,key2) {
            var _this = this;
            var ds = {
              goods_id:this.goods_id,
              val:key2,
              name:key1,
              type:'delete'
            };
            $.post("<?php echo module_url('muitspec','Hook','action');?>",ds,function(res){
                 vm_set(_this,res);  
                  
            },'json');

            
          }
        } 
    }); 
    /**
     * 设置VUE DATA 
     */
    function vm_set(_this,res){
        _this.lists = res.lists;
        _this.title = res.title;
        _this.ori = res.ori;
        _this.more = res.more;
        _this.settings = res.settings;
        
        

    }
  }
  
 
    
 </script> 
<?php page_end();?>