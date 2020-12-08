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
        var editor1 = K.create('textarea[name="p_desc"]', {
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
                    if(intval($p_id)==0){
                ?>
                <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">产品名称</label>
                    <div class="layui-input-inline">
                      <input type="text" name="p_title" placeholder="" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                        <label class="layui-form-label">产品分类</label>
                        <div class="layui-input-inline">
                            <select name="p_type">
                                <?php
                                foreach($cate as $c){
                                    echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                   </div>

                  <div class="layui-form-item">
                    <label class="layui-form-label">商品主图</label>
                      <div class="layui-input-inline">
                          <button type="button" class="layui-btn" id="pro_img">
                              <i class="layui-icon">&#xe67c;</i>上传图片
                          </button>

                          <div class="layui-upload-list">
                              <a id="img_src_two" target="_blank" href="">
                                  <img class="layui-upload-img" id="img_src_one" width="150px">
                              </a>
                              <input type="hidden" name="p_cover" id="p_cover" value="">
                          </div>
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">产品原价</label>
                        <div class="layui-input-inline">
                            <input type="text" name="p_price" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">择价类型</label>
                        <div class="layui-inline">
                            <input  lay-filter="ck_radio" type="radio" name="p_price_type" value="1" title="代理折扣" checked>
                            <input  lay-filter="ck_radio"  type="radio" name="p_price_type" value="2" title="单独定价">
                        </div>
                    </div>

                    <div class="layui-form-item" id="agent_zk" style="display: none">
                        <?php foreach ($agent as $row){ ?>
                            <label class="layui-form-label"><?php echo $row['a_name'];?></label>
                            <div class="layui-input-inline" style="width:100px;">
                                <input type="number" name="<?php echo $row['a_level']; ?>" placeholder="" autocomplete="off" class="layui-input" style="width: 100px;">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否推荐</label>
                        <div class="layui-inline">
                            <input type="radio" name="p_tui" value="0" title="否" checked>
                            <input type="radio" name="p_tui" value="1" title="是">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">产品排序</label>
                        <div class="layui-input-inline">
                            <input type="text" name="p_sort" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">已售数量</label>
                        <div class="layui-input-inline">
                            <input type="number" name="p_yishou" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">商品详情</label>
                    <div class="layui-input-inline">
                      <textarea name="p_desc" style='width:720px;height:600px;visibility:hidden;'></textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <div class="layui-input-block">
                      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
                    </div>
                  </div>

                </div>
                <script src="/static/js/jquery-3.3.1.min.js"></script>
                <script src="/static/layui.js"></script> 
                <script>
					layui.use(['form','upload','laydate'],function(){
						var $ = layui.$, form = layui.form, upload = layui.upload;
                        upload.render({
                            elem: '#pro_img',
                            url: '?m=config&c=upload',
                            done: function(res){
                                if(res.code > 0){
                                    return layer.msg('上传失败');
                                }else{
                                    $('#img_src_one').attr('src',res.msg);
                                    $('#img_src_two').attr('href',res.msg);
                                    $('#p_cover').val(res.msg);
                                    return layer.msg('上传成功');
                                }
                            }
                        });
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
                            var field = obj.field;
							layui.$.post('?m=agent&c=product_add',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
								if(data.status==1){
									layer.msg('添加成功', {offset: '15px',icon: 1,time: 1000}, function(){
									    window.location.href='?m=agent&c=product_list';
									});
								}else{
									layer.msg('操作失败:'+data.msg);
								}
							},'json');
						});
                        form.on('radio(ck_radio)', function(data){
                            var ck_ra =  data.value;
                            if(ck_ra == 1){
                                $("#agent_zk").hide();
                            }else{
                                $("#agent_zk").show();
                            }
                        });
                    })
                  </script>
                 <?php
                    }else{
                 ?>

                        <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">产品名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="p_title" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $product['p_title'];?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">产品分类</label>
                                <div class="layui-input-inline">
                                    <select name="p_type">
                                        <?php
                                            foreach($cate as $c){
                                                if($c['id'] == $product['p_type']){
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
                                <label class="layui-form-label">商品主图</label>
                                <div class="layui-input-inline">
                                    <button type="button" class="layui-btn" id="pro_img">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>

                                    <div class="layui-upload-list">
                                        <a id="img_src_two" target="_blank" href="<?php echo $product['p_cover'];?>">
                                            <img class="layui-upload-img" id="img_src_one" width="150px" src="<?php echo $product['p_cover'];?>">
                                        </a>
                                        <input type="hidden" name="p_cover" id="p_cover" value="<?php echo $product['p_cover'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">产品原价</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="p_price" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $product['p_price'];?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">择价类型</label>
                                <div class="layui-inline">
                                    <input  lay-filter="ck_radio" type="radio" name="p_price_type" value="1" title="代理折扣" <?php echo $product['p_price_type']==1?'checked':''?>>
                                    <input  lay-filter="ck_radio" type="radio" name="p_price_type" value="2" title="单独定价" <?php echo $product['p_price_type']==2?'checked':''?>>
                                </div>
                            </div>

                            <div class="layui-form-item" id="agent_zk" style="<?php echo $product['p_price_type']==1?'display: none':''?>">
                                <?php if(count($p_a_price) != count($agent)){ ?>
                                    <div style="padding-left: 3rem;color: red;">代理商位置发生变化,请重新定价</div>
                                    <?php foreach ($agent as $row){ ?>
                                        <label class="layui-form-label"><?php echo $row['a_name'];?></label>
                                        <div class="layui-input-inline" style="width:100px;">
                                            <input type="number" name="<?php echo $row['a_level']; ?>" placeholder="" autocomplete="off" class="layui-input" style="width: 100px;">
                                        </div>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <?php foreach ($p_a_price as $k=>$v){ ?>
                                        <?php foreach ($agent as $row){ ?>
                                            <?php if ($row['a_level'] == $k){ ?>
                                                <label class="layui-form-label"><?php echo $row['a_name'];?></label>
                                                <div class="layui-input-inline" style="width:100px;">
                                                    <input type="number" name="<?php echo $k;?>" placeholder="" autocomplete="off" class="layui-input" style="width: 100px;" value="<?php echo $v; ?>">
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">是否推荐</label>
                                <div class="layui-inline">
                                    <input type="radio" name="p_tui" value="0" title="否" <?php echo $product['p_tui']==0?'checked':''?>>
                                    <input type="radio" name="p_tui" value="1" title="是" <?php echo $product['p_tui']==1?'checked':''?>>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">产品排序</label>
                                <div class="layui-input-inline">
                                    <input type="number" name="p_sort" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $product['p_sort']; ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">已售数量</label>
                                <div class="layui-input-inline">
                                    <input type="number" name="p_yishou" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $product['p_yishou']; ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">商品详情</label>
                                <div class="layui-input-inline">
                                    <textarea name="p_desc" style='width:720px;height:600px;visibility:hidden;'><?php echo $product['p_desc']; ?></textarea>
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
                                elem: '#pro_img',
                                url: '?m=config&c=upload',
                                done: function(res){
                                  if(res.code > 0){
                                      return layer.msg('上传失败');
                                  }else{
                                      $('#img_src_one').attr('src',res.msg);
                                      $('#img_src_two').attr('href',res.msg);
                                      $('#p_cover').val(res.msg);
                                      return layer.msg('上传成功');
                                  }
                                }
						});
						form.render();
						form.on('submit(LAY-user-front-submit)', function(obj){
							var field = obj.field;
							layui.$.post('?m=agent&c=product_edit&p_id=<?php echo $p_id; ?>',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
								if(data.status==1){
									layer.msg('编辑成功', {offset: '15px',icon: 1,time: 1000}, function(){
									    window.location.href='?m=agent&c=product_list';
									});
								}else{
									layer.msg('操作失败:'+data.msg);
								}
							},'json');
						});
                        form.on('radio(ck_radio)', function(data){
                            var ck_ra =  data.value;
                            if(ck_ra == 1){
                                $("#agent_zk").hide();
                            }else{
                                $("#agent_zk").show();
                            }
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