<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME; ?> - <?php echo WEBDESC; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/layui.css">
    <link rel="stylesheet" href="/static/css/main.css">
    <link rel="stylesheet" href="/static/css/login.css">
    <style>
        .layui-table-cell {
            height: auto;
            font-size: 12px;
        }
    </style>
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    订单管理
                </div>
                <div class="layui-card-body">
                    <div style="width:100%; margin-top:10px;">
                        <div class="layui-form" lay-filter="lay-search" id="lay-search">
                            <div class="layui-inline">
                                <label class="layui-form-label-col" style="float:left">搜索：</label>
                                <div class="layui-input-inline" style="width:200px;">
                                    <input type="text" name="o_data" placeholder="订单ID/产品ID/用户ID" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-input-inline" style="width:200px;">
                                    <input type="text" name="o_name" placeholder="收货人/手机号" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="text" name="o_regt" class="layui-input" id="test10" placeholder="时间筛选">
                                </div>
                                <div class="layui-input-inline" style="width: 120px;">
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索</button>
                                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="do_export" lay-submit lay-filter="do_export">导出</button>
                                </div>
                            </div>

                        </div>
                        <table class="layui-hide" id="weblist" lay-filter="weblist"></table>
                    </div>
                    <script type="text/html" id="barDemo">
                        {{# if(d.o_status == '0'){ }}
                            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="edit">发货</a>
                        {{# } else if(d.o_status == '1') { }}

                        {{# } else if(d.o_status == '2') { }}
                            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                        {{# } else if(d.o_status == '3') { }}

                        {{# } }}

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/layui.js"></script>
<script>
    layui.use(['element', 'layer', 'form', 'table', 'laydate'], function () {
        var element = layui.element;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var laydate = layui.laydate;
        laydate.render({
            elem: '#test10'
            ,type: 'datetime'
            ,range: true
        });
        table.render({
            elem: '#weblist'
            , url: '?m=agent&c=order_data'
            , cellMinheight: 80
            , height: 'full-110'
            , limit: 20
            , cols: [[
                  {field: 'o_id', title: 'ID',align:'center', unresize: true}
                , {field: 'o_num', title: '订单号',align:'center'}
                , {field: 'm_name', title: '代理昵称',align:'center'}
                , {field: 'p_title', title: '产品标题',align:'center'}
                , {field: 'p_cover', title: '产品封面',align:'center'}
                , {field: 'p_num', title: '购买数量',align:'center'}
                , {field: 'p_price', title: '产品单价',align:'center'}
                , {field: 'order_sum_price', title: '订单总价',align:'center'}
                , {field: 'o_name', title: '收货人',align:'center'}
                , {field: 'o_tel', title: '手机号',align:'center'}
                , {field: 'o_city', title: '地址',align:'center'}
                , {field: 'o_status',title: '订单状态', align: 'center', templet: '#IsAddOrder'}
                , {field: 'o_express_name',title: '快递公司', align: 'center'}
                , {field: 'o_express_num',title: '快递号', align: 'center'}
                , {field: 'order_addtime', title: '创建时间',align:'center'}
                , {field: 'o_express_time', title: '发货时间',align:'center'}
                , {width: 200, align: 'center', toolbar: '#barDemo', title: '操作'}
            ]]
            , page: true
        });
        form.on('submit(do_searh)', function (obj) {
            var field = obj.field;
            var url = '?m=agent&c=order_data&o_data=' + encodeURI(field.o_data)+ '&o_regt=' + encodeURI(field.o_regt)+ '&o_name=' + encodeURI(field.o_name);
            var tableIns = table.render({
                elem: '#weblist'
                , url: url
                , cellMinheight: 80
                , height: 'full-110'
                , limit: 20
                , cols: [[
                    {field: 'o_id', title: 'ID',align:'center', unresize: true}
                    , {field: 'o_num', title: '订单号',align:'center'}
                    , {field: 'm_name', title: '代理昵称',align:'center'}
                    , {field: 'p_title', title: '产品标题',align:'center'}
                    , {field: 'p_cover', title: '产品封面',align:'center'}
                    , {field: 'p_num', title: '购买数量',align:'center'}
                    , {field: 'p_price', title: '产品单价',align:'center'}
                    , {field: 'order_sum_price', title: '订单总价',align:'center'}
                    , {field: 'o_name', title: '收货人',align:'center'}
                    , {field: 'o_tel', title: '手机号',align:'center'}
                    , {field: 'o_city', title: '地址',align:'center'}
                    , {field: 'o_status',title: '订单状态', align: 'center', templet: '#IsAddOrder'}
                    , {field: 'o_express_name',title: '快递公司', align: 'center'}
                    , {field: 'o_express_num',title: '快递号', align: 'center'}
                    , {field: 'order_addtime', title: '创建时间',align:'center'}
                    , {field: 'o_express_time', title: '发货时间',align:'center'}
                    , {width: 200, align: 'center', toolbar: '#barDemo', title: '操作'}
                ]]
                , page: true
            });
        });
        table.on('tool(weblist)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('删除后将不能恢复，确定删除？', function (index) {
                    var p_id = data.p_id;
                    layui.$.post('?m=agent&c=product_del', {'p_id': p_id}, function (retmsg) {
                        if(retmsg.role == 'error'){
                            alert('您当前没有操作权限');
                            top.location.href='?m=index&c=index';
                        }
                        if (parseInt(retmsg.code) == 1) {
                            layer.msg(retmsg.msg);
                            obj.del();
                        } else {
                            layer.msg(retmsg.msg);
                        }
                    }, 'json');
                    layer.close(index);
                });
            }else if(obj.event === 'edit'){
                var o_id=data.o_id;
                layer.open({
                    type: 2,
                    title: '发货',
                    closeBtn: 1,
                    scrollbar: false,
                    skin: 'layui-anim',
                    area:  ['410px', '300px'],
                    shadeClose: 0,
                    content:'?m=agent&c=order_delivery&o_id=' + o_id
                });
            }
        });
        function creatFrame(url){
            var frameid = "wexframe" + Math.random();
            var _iframe = document.createElement("iframe");
            _iframe.src = url
            _iframe.id  = frameid;
            _iframe.setAttribute("frameborder", "0", 0);
            _iframe.scrolling 	= "no";
            _iframe.style.width = "0px";
            _iframe.style.height= "0px";
            document.body.appendChild(_iframe);
        }
        form.on('submit(do_export)', function(obj){
            var field = obj.field;
            var url	='/admin.php?m=agent&c=export_list&o_data=' + encodeURI(field.o_data)+ '&o_regt=' + encodeURI(field.o_regt)+ '&o_name=' + encodeURI(field.o_name);
            creatFrame(url);
        });
    });
</script>
<style>
    .laytable-cell-1-g_img.layui-table-cell {
        height: auto;
    }
</style>
</body>
<script type="text/html" id="IsAddOrder">
    {{# if(d.o_status == '0'){ }}
        <span style="background-color:#ff6b6b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">待发货</span>
    {{# } else if(d.o_status == '1') { }}
        <span style="background-color:#46c37b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">待收货</span>
    {{# } else if(d.o_status == '2') { }}
        <span style="background-color:#1cd7ed; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">已完成</span>
    {{# } else if(d.o_status == '3') { }}
        <span style="background-color:#fa9400; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">售后</span>
    {{# } }}
</script>
</html>