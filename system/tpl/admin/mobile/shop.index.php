
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
    <link rel="stylesheet" href="/static/css/login.css">
    <style>
    .layui-table-cell {
        height: auto; font-size:12px;
    }
    </style>
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
			  <span style="float: right;">
			  <button class="layui-btn layui-btn-sm layui-btn-normal">
              	<a href="?m=shop&c=shop_add" style="text-decoration:none; color:#fff;">添加商户</a>
              </button>
		      </span>
         	  商户管理
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
                <div class="layui-form" lay-filter="lay-search" id="lay-search">
                    <div class="layui-inline">
                        <label class="layui-form-label-col" style="float:left">搜索：</label>
                        <div class="layui-input-inline" style="width:200px;">
                          <input type="text" name="s_name" placeholder="商户名称" autocomplete="off" class="layui-input">
                        </div>
                        <?php if($type==0){?>
                        <div class="layui-input-inline" style="width: 200px;">
                          <input type="text" name="s_regt" class="layui-input" id="test10" placeholder="申请时间">
                        </div>
                        <?php }else{?>
                        <div class="layui-input-inline" style="width: 200px;">
                          <input type="text" name="s_regt" class="layui-input" id="test10" placeholder="到期时间">
                        </div>
                        <?php }?>
                        <div class="layui-input-inline" style="width: 120px;">
                           <select name="s_type">
                           <option value=""></option>
                            <?php
                                foreach($cates as $c){
                                    echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                        <div class="layui-input-inline" style="width: 120px;">
                         <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索</button>
                        </div>
                    </div>			
                </div>
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>			 
			  <script type="text/html" id="barDemo">
				  <a class="layui-btn layui-btn-normal layui-btn-xs" href="?m=shop&c=shop_edit&id={{d.id}}">编辑</a>
                  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
              </script>
          </div>
        </div>
    </div>
  </div>
</div>
<script src="/static/layui.js"></script>
<script>
	layui.use(['element','layer','form','table','laydate'], function(){
	  var element 	= layui.element;	
	  var layer 	= layui.layer;
	  var form 		= layui.form;
	  var table 	= layui.table; 
	  var laydate 	= layui.laydate; 
	  laydate.render({
		elem: '#test10'
		,type: 'datetime'
		,range: true
	  });	    
	  table.render({
		elem: '#weblist'
		,url:'?m=shop&c=shop_list&type=<?php echo $type;?>'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'id', title:'ID', width:80, unresize: true}
		  ,{field:'user_info', title:'申请会员', width:120}
		  ,{field:'shop_name', title:'商户名称', width:120}
		  ,{field:'shop_cate', title:'商户分类', width:120}
		  ,{field:'shop_img', title:'缩略图'}
		  ,{field:'shop_add', title:'商户地址'}
		  ,{field:'shop_info', title:'商户简介'}
		  ,{field:'shop_photo', title:'证件信息', width:120}
		  ,{field:'shop_read', title:'访问量', width:100}
		  <?php
		  	if($type){
				echo ",{field:'shop_time', title:'到期时间', width:150}";
				echo ",{field:'shop_tui', title:'是否推荐', width:100}";
			}else{
				echo ",{field:'shop_time', title:'申请时间', width:150}";
			}
		  ?>
		  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=shop&c=shop_list&type=<?php echo $type;?>&s_name=' + encodeURI(field.s_name) + '&s_regt=' + encodeURI(field.s_regt) + '&s_type=' + field.s_type;
		  var tableIns = table.render({
			elem: '#weblist'
			,url:url
			,cellMinheight: 80
			,height: 'full-110'
			,limit: 20
			,cols: [[
			   {field:'id', title:'ID', width:80, unresize: true}
			  ,{field:'user_info', title:'申请会员', width:120}
			  ,{field:'shop_name', title:'商户名称', width:120}
			  ,{field:'shop_cate', title:'商户分类', width:120}
			  ,{field:'shop_img', title:'缩略图'}
			  ,{field:'shop_add', title:'商户地址'}
			  ,{field:'shop_info', title:'商户简介'}
			  ,{field:'shop_photo', title:'证件信息', width:120}
			  ,{field:'shop_read', title:'访问量', width:100}
			  <?php
				if($type){
					echo ",{field:'shop_time', title:'到期时间', width:150}";
					echo ",{field:'shop_tui', title:'是否推荐', width:100}";
				}else{
					echo ",{field:'shop_time', title:'申请时间', width:150}";
				}
			  ?>
			  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
			]]
			,page: true
		  }); 
	  });
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'del'){
		  layer.confirm('删除后将不能恢复，确定删除？', function(index){
			var webid=data.id;
			layui.$.post('?m=shop&c=del',{'id':webid},function(retmsg){
                if(retmsg.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
				if(parseInt(retmsg.code)==1){
				   layer.msg(retmsg.msg);
				   obj.del();
				}else{
				   layer.msg(retmsg.msg);
				}
			},'json');
			layer.close(index);
		  });
		}		
	  });
	});	
</script>
<style>
.laytable-cell-1-g_img.layui-table-cell{height:auto;} 
</style>
</body>
</html>