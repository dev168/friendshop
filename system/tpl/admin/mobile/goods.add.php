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
        var editor1 = K.create('textarea[name="g_content"]', {
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
         	  商品管理
          </div>
                <div class="layui-card-body">
                <?php
                    if(intval($g_id)==0){
                ?>
                <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">商品名称</label>
                    <div class="layui-input-inline">
                      <input type="text" name="g_title" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>

                  <div class="layui-form-item">
                    <label class="layui-form-label">所属商户ID</label>
                    <div class="layui-input-inline">
                      <input type="text" name="g_shop" placeholder="会员ID" autocomplete="off" class="layui-input">
                    </div>
                  </div>

                  <div class="layui-form-item">
                    <label class="layui-form-label">商品价格</label>
                    <div class="layui-input-inline">
                      <input type="text" name="g_price" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>

                  <div class="layui-form-item">
                    <label class="layui-form-label">商品主图</label>
                      <div class="layui-input-inline">
                          <button type="button" class="layui-btn" id="gs_img">
                              <i class="layui-icon">&#xe67c;</i>上传图片
                          </button>

                          <div class="layui-upload-list">
                              <a id="img_src_two" target="_blank" href="">
                                  <img class="layui-upload-img" id="img_src_one" width="150px">
                              </a>
                              <input type="hidden" name="g_pic" id="g_pic" value="">
                          </div>
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否推荐</label>
                        <div class="layui-inline">
                            <input type="radio" name="g_tui" value="0" title="否" checked>
                            <input type="radio" name="g_tui" value="1" title="是">
                        </div>
                    </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商品详情</label>
                    <div class="layui-input-inline">
                      <textarea name="g_content" style='width:720px;height:600px;visibility:hidden;'></textarea>
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
						var $ = layui.$, form = layui.form, upload = layui.upload;
                        upload.render({
                            elem: '#gs_img',
                            url: '?m=config&c=upload',
                            done: function(res){
                                if(res.code > 0){
                                    return layer.msg('上传失败');
                                }else{
                                    $('#img_src_one').attr('src',res.msg);
                                    $('#img_src_two').attr('href',res.msg);
                                    $('#g_pic').val(res.msg);
                                    return layer.msg('上传成功');
                                }
                            }
                        });
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
                            var field = obj.field;
							layui.$.post('?m=shop&c=goods_add',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
								if(data.status==1){
									layer.msg('添加成功', {offset: '15px',icon: 1,time: 1000}, function(){
									    window.location.href='?m=shop&c=goods_index';
									});
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
                                <label class="layui-form-label">商品名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="g_title" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $goods['g_title'];?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">所属商户ID</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="g_shop" placeholder="会员ID" autocomplete="off" class="layui-input" value="<?php echo $goods['g_shop'];?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">商品价格</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="g_price" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $goods['g_price'];?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">商品主图</label>
                                <div class="layui-input-inline">
                                    <button type="button" class="layui-btn" id="gs_img">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>

                                    <div class="layui-upload-list">
                                        <a id="img_src_two" target="_blank" href="<?php echo $goods['g_pic'];?>">
                                            <img class="layui-upload-img" id="img_src_one" width="150px" src="<?php echo $goods['g_pic'];?>">
                                        </a>
                                        <input type="hidden" name="g_pic" id="g_pic" value="<?php echo $goods['g_pic'];?>">
                                    </div>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">是否推荐</label>
                                <div class="layui-inline">
                                    <input type="radio" name="g_tui" value="0" title="否" <?php echo $goods['g_tui']==0?'checked':''?>>
                                    <input type="radio" name="g_tui" value="1" title="是" <?php echo $goods['g_tui']==1?'checked':''?>>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">商品详情</label>
                                <div class="layui-input-inline">
                                    <textarea name="g_content" style='width:720px;height:600px;visibility:hidden;'><?php echo $goods['g_content'];?></textarea>
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
						var $ = layui.$, form = layui.form, upload = layui.upload;
                            upload.render({
                                elem: '#gs_img',
                                url: '?m=config&c=upload',
                                done: function(res){
                                  if(res.code > 0){
                                      return layer.msg('上传失败');
                                  }else{
                                      $('#img_src_one').attr('src',res.msg);
                                      $('#img_src_two').attr('href',res.msg);
                                      $('#g_pic').val(res.msg);
                                      return layer.msg('上传成功');
                                  }
                                }
						});
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
							var field = obj.field;
							layui.$.post('?m=shop&c=goods_edit&g_id=<?php echo $g_id; ?>',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
							    if(data.status==1){
									layer.msg('编辑成功', {offset: '15px',icon: 1,time: 1000}, function(){
									    window.location.href='?m=shop&c=goods_index';
									});
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