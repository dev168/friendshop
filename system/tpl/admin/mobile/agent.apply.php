
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
         	  代理入驻
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
                <div class="layui-form" lay-filter="lay-search" id="lay-search">
                    <div class="layui-inline">
                        <label class="layui-form-label-col" style="float:left">搜索：</label>
                        <div class="layui-input-inline" style="width:200px;">
                          <input type="text" name="l_name" placeholder="代理名称" autocomplete="off" class="layui-input">
                        </div>
                            <div class="layui-input-inline" style="width: 200px;">
                              <input type="text" name="l_stime" class="layui-input" id="test10" placeholder="申请时间">
                            </div>
                            <div class="layui-input-inline" style="width: 200px;">
                                <input type="text" name="l_etime" class="layui-input" id="test10" placeholder="审核时间">
                            </div>
                        <div class="layui-input-inline" style="width: 120px;">
                         <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索</button>
                        </div>
                    </div>			
                </div>
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>			 
			  <script type="text/html" id="barDemo">
                  {{# if(d.l_status == '0'){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="charge">通过</a>
                  {{# } }}
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
		,url:'?m=agent&c=apply_data'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'l_id', title:'ID', unresize: true}
		  ,{field:'m_name', title:'会员昵称'}
		  ,{field:'l_name', title:'申请姓名'}
		  ,{field:'l_tel', title:'申请电话'}
		  ,{field:'l_level', title:'申请等级'}
		  ,{field:'l_status', title:'审核状态',align:'center',templet:'#IsAddOrder'}
		  ,{field:'l_weichat', title:'申请LINE'}
		  ,{field:'l_atime', title:'申请时间'}
		  ,{field:'l_ctime', title:'审核时间'}
		  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=agent&c=apply_data&l_name=' + encodeURI(field.l_name) + '&l_stime=' + encodeURI(field.l_stime)+ '&l_etime=' + encodeURI(field.l_etime);
		  var tableIns = table.render({
			elem: '#weblist'
			,url:url
			,cellMinheight: 80
			,height: 'full-110'
			,limit: 20
              ,cols: [[
                  {field:'l_id', title:'ID', unresize: true}
                  ,{field:'m_name', title:'会员昵称'}
                  ,{field:'l_name', title:'申请姓名'}
                  ,{field:'l_tel', title:'申请电话'}
                  ,{field:'l_level', title:'申请等级'}
                  ,{field:'l_status', title:'审核状态',align:'center',templet:'#IsAddOrder'}
                  ,{field:'l_weichat', title:'申请LINE'}
                  ,{field:'l_atime', title:'申请时间'}
                  ,{field:'l_ctime', title:'审核时间'}
                  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
              ]]
			,page: true
		  }); 
	  });
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'del'){
		  layer.confirm('删除后将不能恢复，确定删除？', function(index){
			var l_id=data.l_id;
			layui.$.post('?m=agent&c=apply_del',{'l_id':l_id},function(retmsg){
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
        if(obj.event === 'charge'){
              layer.confirm('该操作不能恢复，确定继续？', function(index){
                  var l_id=data.l_id;
                  layui.$.post('?m=agent&c=apply_sta',{'l_id':l_id},function(res){
                      if(res.role == 'error'){
                          alert('您当前没有操作权限');
                          top.location.href='?m=index&c=index';
                      }
                      if(parseInt(res.code)==1){
                          layer.msg(res.msg);
                          setTimeout(function () {
                              window.location.reload();
                          },'1000')
                      }else{
                          layer.msg(res.msg);
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
    {{# if(d.l_status == '0'){ }}
    <span style="background-color:#ff6b6b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">未审核</span>
    {{# } else { }}
    <span style="background-color:#46c37b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">通过</span>
    {{# } }}
</script>
</html>