<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME;?> - <?php echo WEBDESC;?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="/static/css/layui.css">
<link rel="stylesheet" href="/static/css/main.css">
<link rel="stylesheet" href="/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh-CN.js"></script>
<script charset="utf-8" src="/kindeditor/plugins/code/prettify.js"></script>
<script>
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="s_content"]', {
            cssPath : '/kindeditor/plugins/code/prettify.css',
            uploadJson : '/kindeditor/php/upload_json.php',
            fileManagerJson : '/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
			afterBlur: function () { this.sync(); },
            afterCreate : function() {
                var self = this;
                K.ctrl(document, 13, function() {
                    self.sync();
                });
                K.ctrl(self.edit.doc, 13, function() {
                    self.sync();
                });
            }
        });
        prettyPrint();
    });
</script>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
         	  商户管理
          </div>
                <div class="layui-card-body">
                <?php
                    if(intval($shopid)==0){
                ?>
                <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户名称</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_name" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户分类</label>
                    <div class="layui-input-inline">
                       <select name="s_type">
                        <?php
                            foreach($cates as $c){
                                echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">所属会员</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_uid" placeholder="会员ID" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">所在地区</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_region" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">详细地址</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_address" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户简介</label>
                    <div class="layui-inline" style="width:600px;">
                      <textarea name="s_info" placeholder="60字以内" class="layui-textarea"></textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户主图</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_img" autocomplete="off" class="layui-input" id="s_img">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test1">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">营业执照</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_zhizhao" autocomplete="off" class="layui-input" id="s_zhizhao">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test2">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">身份证正面</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_idfront" autocomplete="off" class="layui-input" id="s_idfront">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test3">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">身份证反面</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_idback" autocomplete="off" class="layui-input" id="s_idback">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test4">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户详情</label>
                    <div class="layui-input-inline">
                      <textarea name="s_content" style='width:720px;height:600px;visibility:hidden;'></textarea>
                    </div>
                  </div>
                   <div class="layui-form-item">
                    <label class="layui-form-label">申请时间</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_ctime" id="s_ctime" value="<?php echo date('Y-m-d H:i:s',time());?>" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">到期时间</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_dtime" id="s_dtime" value="<?php echo date('Y-m-d H:i:s',time());?>" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                <div class="layui-form-item cols">
                <label class="layui-form-label">审核</label>
                <div class="layui-inline">
                  <input type="radio" name="s_status" value="0" title="待审核">
                  <input type="radio" name="s_status" value="1" title="已通过" checked>
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">推荐</label>
                <div class="layui-inline">
                  <input type="radio" name="s_hot" value="0" title="否">
                  <input type="radio" name="s_hot" value="1" title="是" checked>
                </div>
              </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">浏览量</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_read" value="0" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <div class="layui-input-block">
                      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
                    </div>
                  </div>
                </div>
                <script src="/static/layui.js"></script> 
                <script>
					layui.use(['form','upload','laydate'],function(){
						var $ = layui.$, form = layui.form, upload = layui.upload, laydate = layui.laydate;
						upload.render({elem: '#test1',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_img').val(res.msg);}
						}
						});
						upload.render({elem: '#test2',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_zhizhao').val(res.msg);}
						}
						});
						upload.render({elem: '#test3',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_idfront').val(res.msg);}
						}
						});
						upload.render({elem: '#test4',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_idback').val(res.msg);}
						}
						});
						laydate.render({elem: '#s_ctime',type: 'datetime'});             
						laydate.render({elem: '#s_dtime',type: 'datetime'});             
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
							var field = obj.field;
							var type  = field.s_status;
							console.log(type);
							layui.$.post('?m=shop&c=shop_add',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
								if(data.status==1){
									layer.msg('添加成功', {offset: '15px',icon: 1,time: 1000}, function(){window.location.href='?m=shop&c=apply&type='+type;});		
								}else{
									layer.msg('操作失败:'+data.msg);
								}
							},'json');
						});
					})
                  </script>
                 <?php
                 }else{
                 ?>
                 
                <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户名称</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_name" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $shop['s_name'];?>">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户分类</label>
                    <div class="layui-input-inline">
                       <select name="s_type">
                        <?php
                            foreach($cates as $c){
								if($c['id']==$shop['s_type']){
                                	echo '<option value="'.$c['id'].'" selected>'.$c['c_name'].'</option>';
								}else{
                                	echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
								}
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">所属会员</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_uid" placeholder="会员ID" autocomplete="off" class="layui-input" value="<?php echo $shop['s_uid'];?>">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">所在地区</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_region" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $shop['s_region'];?>">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">详细地址</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_address" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $shop['s_address'];?>">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户简介</label>
                    <div class="layui-inline" style="width:600px;">
                      <textarea name="s_info" placeholder="60字以内" class="layui-textarea"><?php echo $shop['s_info'];?></textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户主图</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_img" autocomplete="off" class="layui-input" id="s_img" value="<?php echo $shop['s_img'];?>">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test1">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">营业执照</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_zhizhao" autocomplete="off" class="layui-input" id="s_zhizhao" value="<?php echo $shop['s_zhizhao'];?>">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test2">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">身份证正面</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_idfront" autocomplete="off" class="layui-input" id="s_idfront" value="<?php echo $shop['s_idfront'];?>">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test3">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">身份证反面</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_idback" autocomplete="off" class="layui-input" id="s_idback" value="<?php echo $shop['s_idback'];?>">
                      <div class="layui-upload">
                      <button type="button" class="layui-btn" id="test4">上传图片</button>
                      </div>
                   </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商户详情</label>
                    <div class="layui-input-inline">
                      <textarea name="s_content" style='width:720px;height:600px;visibility:hidden;'><?php echo $shop['s_content'];?></textarea>
                    </div>
                  </div>
                   <div class="layui-form-item">
                    <label class="layui-form-label">申请时间</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_ctime" id="s_ctime" value="<?php echo date('Y-m-d H:i:s',$shop['s_ctime']);?>" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">到期时间</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_dtime" id="s_dtime" value="<?php if($shop['s_dtime'] != false ){ echo date('Y-m-d H:i:s',$shop['s_dtime']); }else{ echo date('Y-m-d H:i:s'); } ?>" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                <div class="layui-form-item cols">
                <label class="layui-form-label">审核</label>
                <div class="layui-inline">
                  <input type="radio" name="s_status" value="0" title="待审核" <?php echo $shop['s_status']==0?'checked':''?>>
                  <input type="radio" name="s_status" value="1" title="已通过" <?php echo $shop['s_status']==1?'checked':''?>>
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">推荐</label>
                <div class="layui-inline">
                  <input type="radio" name="s_hot" value="0" title="否" <?php echo $shop['s_hot']==0?'checked':''?>>
                  <input type="radio" name="s_hot" value="1" title="是" <?php echo $shop['s_hot']==1?'checked':''?>>
                </div>
              </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">浏览量</label>
                    <div class="layui-input-inline">
                      <input type="text" name="s_read" value="<?php echo $shop['s_read'];?>" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <div class="layui-input-block">
                      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
                    </div>
                  </div>
                </div>
                <script src="/static/layui.js"></script> 
                <script>
					layui.use(['form','upload','laydate'],function(){
						var $ = layui.$, form = layui.form, upload = layui.upload, laydate = layui.laydate;
						upload.render({elem: '#test1',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_img').val(res.msg);}
						}
						});
						upload.render({elem: '#test2',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_zhizhao').val(res.msg);}
						}
						});
						upload.render({elem: '#test3',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_idfront').val(res.msg);}
						}
						});
						upload.render({elem: '#test4',url: '?m=config&c=upload',done: function(res){
						  if(res.code > 0){return layer.msg('上传失败');}else{$('#s_idback').val(res.msg);}
						}
						});
						laydate.render({elem: '#s_ctime',type: 'datetime'});             
						laydate.render({elem: '#s_dtime',type: 'datetime'});             
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
							var field = obj.field;
							var type  = field.s_status;
							console.log(type);
							layui.$.post('?m=shop&c=shop_edit&id=<?php echo $shopid; ?>',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
							    if(data.status==1){
									layer.msg('添加成功', {offset: '15px',icon: 1,time: 1000}, function(){window.location.href='?m=shop&c=apply&type='+type;});		
								}else{
									layer.msg('操作失败:'+data.msg);
								}
							},'json');
						});
					})
                  </script>
                <?php
                }
                ?>
                </div>
    </div>
  </div>
</div>
</div>
</body>
</html>