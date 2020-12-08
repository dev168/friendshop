
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
			  <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_account">
              	<a href="?m=shop&c=goods_add" style="text-decoration:none; color:#fff;">添加商品</a>
              </button>
		      </span>
              商品管理
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
                <div class="layui-form" lay-filter="lay-search" id="lay-search">
                    <div class="layui-inline">
                        <label class="layui-form-label-col" style="float:left">搜索：</label>
                        <div class="layui-input-inline" style="width:200px;">
                          <input type="text" name="g_title" placeholder="商品标题/商品价格" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-input-inline" style="width: 120px;">
                         <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索</button>
                        </div>
                    </div>			
                </div>
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>			 
			  <script type="text/html" id="barDemo">
				  <a class="layui-btn layui-btn-normal layui-btn-xs" href="?m=shop&c=goods_edit&g_id={{d.g_id}}">编辑</a>
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
	  table.render({
		elem: '#weblist'
		,url:'?m=shop&c=goods_data'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'g_id', title:'ID', width:80, unresize: true}
		  ,{field:'g_title', title:'商品标题'}
		  ,{field:'g_price', title:'商品价格', width:120}
		  ,{field:'g_pic', title:'商品封面', width:120}
          ,{field:'g_tui', title:'是否推荐',align:'center',templet:'#IsAddOrder'}
		  ,{field:'g_shop', title:'商户名称'}
		  ,{field:'g_addtime', title:'发布时间'}
		  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=shop&c=goods_data&g_title=' + encodeURI(field.s_name);
		  var tableIns = table.render({
			elem: '#weblist'
			,url:url
			,cellMinheight: 80
			,height: 'full-110'
			,limit: 20
			,cols: [[
                   {field:'g_id', title:'ID', width:80, unresize: true}
                  ,{field:'g_title', title:'商品标题'}
                  ,{field:'g_price', title:'商品价格', width:120}
                  ,{field:'g_pic', title:'商品封面', width:120}
                  ,{field:'g_tui', title:'是否推荐',align:'center',templet:'#IsAddOrder'}
                  ,{field:'g_shop', title:'商户名称'}
                  ,{field:'g_addtime', title:'发布时间'}
                  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
			]]
			,page: true
		  }); 
	  });
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'del'){
		  layer.confirm('删除后将不能恢复，确定删除？', function(index){
			var g_id=data.g_id;
			layui.$.post('?m=shop&c=goods_del',{'g_id':g_id},function(retmsg){
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
<script type="text/html" id="IsAddOrder">
    {{# if(d.g_tui == '0'){ }}
    <span style="background-color:#ff6b6b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">否</span>
    {{# } else { }}
    <span style="background-color:#46c37b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">是</span>
    {{# } }}
</script>
</html>