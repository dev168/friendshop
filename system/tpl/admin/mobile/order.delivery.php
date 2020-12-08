<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME; ?> - <?php echo WEBDESC; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/layui.css">
    <link rel="stylesheet" href="/static/css/main.css">
</head>
<body>
    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">

        <div class="layui-form-item">
            <label class="layui-form-label">快递公司</label>
            <div class="layui-input-inline">
                <input type="text" name="o_express_name"  placeholder="请输入快递公司" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">运单号</label>
            <div class="layui-input-inline">
                <input type="number" name="o_express_num" placeholder="请输入快递号" autocomplete="off" class="layui-input">
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
        layui.use(['form','upload'], function () {
            var $ = layui.$, form = layui.form;
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                layui.$.post('?m=agent&c=order_delivery&o_id=<?php echo $_GET['o_id'];?>', field, function (data) {
                    if(data.role == 'error'){
                        alert('您当前没有操作权限');
                        top.location.href='?m=index&c=index';
                    }
                    if (data.code == 1) {
                        layer.msg('发货成功', {offset: '15px', icon: 1, time: 1000}, function () {
                            parent.location.reload();
                        });
                    } else {
                        layer.msg('操作失败:' + data.msg);
                    }
                }, 'json');
            });
        })
    </script>

</body>
</html>