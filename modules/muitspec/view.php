<!--多规格开始--> 
<div id='spec-app'>
  <div class="layui-form-item">
    <label class="layui-form-label"><?php echo lang('Spec Name');?></label>
    <div class="layui-input-inline">
      <input type="text" id="spec-1" v-model="spec1" required  lay-verify="required" placeholder="<?php echo lang('Spec Name');?>" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label"><?php echo lang('Spec Val');?></label>
    <div class="layui-input-inline">
      <input type="text" id="spec-2" v-model="spec2"  required lay-verify="required" placeholder="<?php echo lang('Spec Val');?>" autocomplete="off" class="layui-input">
    </div> 
    <el-button type="primary" id='add-spec' @click="spec_action"><?php echo lang('Add');?></el-button>  
    
   

    <el-select v-model='spec_template_val'   @change='tt'  placeholder="<?php echo lang('Import spec template');?>">
      <el-option
        v-for="item in spec_template"
        :key="item"
        :label="item"
        :value="item"        
        >
      </el-option>
    </el-select> 
    <!--模板管理-->
    <el-button type="warning"  @click="box1 = true" ><?php echo lang('Manage spec template');?></el-button>

    <el-dialog title="<?php echo lang('Manage spec template');?>" :visible.sync="box1">
       <table class="layui-table">
          <colgroup>
            <col width="200">
            <col width="150">
            <col>
          </colgroup>
          <thead>
            <tr>
              <th><?php echo lang('Name');?></th>
              <th><?php echo lang('Options');?></th> 
            </tr> 
          </thead>
          <tbody>
            <tr v-for="(item,index) in spec_template_admin">
              <td>{{ item }}</td>
              <td>

                  <el-button @click="dele_template(item,index)" size="mini" type="danger" icon="el-icon-delete" circle>
                    
                  </el-button>

              </td>
               
            </tr>
             
          </tbody>
        </table>
    </el-dialog>
    <!--模板管理 end-->

  </div>
  <!--已选的规格-->
  <div class="layui-form-item">
      <label class="layui-form-label"><?php echo lang('Spec Exists');?></label>
       <div class="layui-input-block" style="padding-top: 6px;"> 
        <div class=" tile" v-for="(item,index) in ori" > 
             <div class="tile__name"> {{ index }} </div>
             <div class="tile__list">
              <el-tag v-for="(v ,index2) in item" class="left"  >
                {{ v }}  
              </el-tag>  
            </div>
       </div>
       <!--规格保存-->
       <el-button type="success"  @click="spec_save"><?php echo lang('Save spec as template');?></el-button>  
       <!--规格排序-->
       <el-button type="warning"  @click="spec_sort_open" ><?php echo lang('Sort spec');?></el-button>
       <!--在弹出窗口排序-->
        <el-dialog  title="<?php echo lang('Sort spec');?>"  :visible.sync="box2">
                <el-alert
                  title="<?php echo lang('Page refresh half');?>"
                  type="warning"
                  show-icon>
                </el-alert>
                <div id='muit' >
                  <div class="tile" v-for="(item,index) in ori"  > 
                       <div class="tile__name drag"> {{ index }} </div>
                       <div class="tile__list">
                        <el-tag v-for="(v ,index2) in item" class="drag left"   closable @close="removeSpec(index,v)" >
                          {{ v }}  
                          <input type='hidden' :name="spec_sort_name(index,v)">
                          
                        </el-tag>  
                      </div>
                  </div>
                </div>
               <el-button @click="spec_sort_save()"  type="success" >
                      <?php echo lang('Save sort');?>
               </el-button>

        </el-dialog>
        <!--规格排序 end-->

     </div>
     

  </div>

  <!--快速设置规格值，为所有的规格-->
  <div class="layui-form-item">
      <label class="layui-form-label"><?php echo lang('Spec Setting All');?></label> 
      <div class="layui-inline" v-for="(item,index) in settings">
        <label class="layui-form-label">{{ item }}</label>
        <div class="layui-input-inline" style="width: 100px;">
          <input type="input"   class="layui-input" :name='spec_price_set(item,index)'>
        </div>
      </div>
 
  </div>

   <!--笛卡尔积-->
  <div class="layui-form-item">
      <label class="layui-form-label"><?php echo lang('Spec Val');?></label>
      <div class="layui-input-block">
        <table class="layui-table" id='spec-table' v-if="is_show">
          <colgroup>
            <col v-for="t1 in title">
            </col> 
          </colgroup>
          <thead>
            <tr>
              <th v-for="item in title" >{{ item }}
               
              </th> 
            </tr> 
          </thead>
          <tbody>
            <tr v-for="(item,index) in lists">
              <td v-for="v in item">   
               <span v-if="more.indexOf(v) == -1" >{{ v }}  </span> 
               <input  v-if="more.indexOf(v) != -1" type='text' :name='spec_price_set(v,index)'  
               > 
              </td>
            </tr> 
          </tbody>
        </table>
      </div>
  </div>
</div> 
<!--多规格结束--> 




