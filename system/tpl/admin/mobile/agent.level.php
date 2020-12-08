
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
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    <span style="float: right;">
                        <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_level">添加代理级别</button>
                    </span>
                    代理级别
                </div>
                <div class="layui-card-body">
                    <div style="width:100%; margin-top:10px;">
                        <table class="layui-hide" id="weblist" lay-filter="weblist"></table>
                    </div>
                    <script type="text/html" id="barDemo">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/layui.js"></script>
<script>
    layui.use(['element','layer','form','table'], function(){
        var element 	= layui.element;
        var layer 	= layui.layer;
        var form 		= layui.form;
        var table 	= layui.table;
        layui.$("#add_level").click(function(){
            layer.open({
                type: 2,
                title: '添加代理级别',
                closeBtn: 1,
                scrollbar: false,
                skin: 'layui-anim',
                area:  ['420px', '600px'],
                shadeClose: 0,
                content:'?m=agent&c=agent_add_level'
            });
        });

        table.render({
            elem: '#weblist'
            ,url:'?m=agent&c=agent_level_data'
            ,cellMinheight: 80
            ,height: 'full-110'
            ,limit: 20
            ,cols: [[
                 {field:'a_id', title:'ID', width:80,align:'center',unresize: true}
                ,{field:'a_name', title:'代理名称',align:'center'}
                ,{field:'a_level', title:'代理级别(请保证代理级别不要断层)',align:'center'}
                ,{field:'a_benefit', title:'优惠比率(百分比)',align:'center'}
                ,{fixed:'right',align:'center', toolbar: '#barDemo',title:'操作'}
            ]]
            ,page: false
        });

        table.on('tool(weblist)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('删除后将不能恢复，确定删除？', function(index){
                    var webid=data.id;
                    layui.$.post('?m=goods&c=delcate',{'id':webid},function(retmsg){
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
            if(obj.event === 'edit'){
                var a_id=data.a_id;
                layer.open({
                    type: 2,
                    title: '修改代理级别',
                    closeBtn: 1,
                    scrollbar: false,
                    skin: 'layui-anim',
                    area:  ['420px', '600px'],
                    shadeClose: 0,
                    content:'?m=agent&c=agent_edit_level&a_id='+a_id
                });
            }
        });
    });
</script>
<style>
    .laytable-cell-1-c_img.layui-table-cell{height:auto;}
</style>
</body>
</html>