<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php';?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
    <a class="jui_top_left" href="?m=user&c=index">
        <img src="/public/icon/back_111.png">
    </a>
    <div class="jui_top_middle">申請代理</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<?php if($is_agent == 0){ ?>
    <form action="">
        <div class="jui_bg_fff ">
            <div class="jui_public_list jui_flex_justify_between">
                <p class="mima_left">您的姓名</p>
                <input class="jui_flex1" id="l_name" name="l_name" type="text" placeholder="您的姓名">
            </div>
            <div class="jui_public_list jui_flex_justify_between">
                <p class="mima_left">您的電話</p>
                <input class="jui_flex1" id="l_tel" name="l_tel" type="tel" placeholder="您的電話">
            </div>
            <div class="jui_public_list jui_flex_justify_between">
                <p class="mima_left">您的LINE</p>
                <input class="jui_flex1" id="l_weichat" name="l_weichat" type="text" placeholder="您的LINE">
            </div>
            <div class="jui_public_list jui_flex_justify_between">
                <p>申請級別</p>
                <select class="jui_flex1 jui_bg_fff jui_pad_r12" dir="rtl" name="l_level" id="l_level">
                    <?php
                    foreach ($agent as $row) {
                        echo '<option value="' . $row['a_level'] . '">' . $row['a_name'] . '</option>';
                    }
                    ?>
                </select>
                <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
            </div>
        </div>
        <div class="jui_public_btn">
            <input type="button" value="提交申請">
        </div>
    </form>
<?php }else{ ?>
    <!-- 溫馨提示 -->
    <div class="jui_none_bar">
        <img src="/public/icon/tishi_icon.png" alt="溫馨提示">
        <p class="jui_fc_999">您的申請正在審核中</p>
        <div class="jui_h20"></div>
        <a href="#" class="jui_none_btn jui_bg_zhuse">請耐心等待</a>
    </div>
    <!-- 溫馨提示end -->
<?php } ?>
<!-- 主體end -->
</body>

<script>
    $(function () {

        function isPhoneNumber(tel) {
            var reg = /^[1][3-8]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/;
            return reg.test(tel);
        }

        $('.jui_public_btn').click(function () {
            var l_name = $('#l_name').val();
            if (l_name.trim() == '') {
                layer.msg('請輸入您的姓名');
                return;
            }
            var l_tel = $('#l_tel').val();
            if (l_tel.trim() == '') {
                layer.msg('請輸入您的電話');
                return;
            }
            if (!isPhoneNumber(l_tel)) {
                layer.msg('電話號格式有誤');
                return;
            }
            var l_weichat = $('#l_weichat').val();
            if (l_weichat.trim() == '') {
                layer.msg('請輸入您的LINE');
                return;
            }
            var xxx = new FormData(document.querySelector("form"));
            $.ajax('?m=agent&c=apply', {
                method: 'POST', data: xxx, processData: false, contentType: false,
                success: function (data) {
                    if (data.code == 1) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = '?m=user&c=index';
                        });
                    } else {
                        layer.msg(data.msg);
                    }
                }, dataType: 'json'
            });
        });
    });
</script>
</html>
