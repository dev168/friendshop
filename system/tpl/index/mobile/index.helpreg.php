<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
<!--    <style>
        .codeMsg{width: 92%;margin-left: 4%;margin-top: 1rem;padding: 1.2rem;text-align: center;background: #f7f7f7;border-radius: 0.26rem;}
        .codeMsg img{width: 2.8rem;height: 2.8rem;margin-left: 30%;}
        .codeMsg p{line-height: 0.62rem;color: #999;}
    </style>-->
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar">
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">幫助註冊</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<?php if ($user['m_level'] > 0) { ?>
    <div class="jui_h20"></div>
    <div class="jui_public_list">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe613;</span>
        <input class="flex1" type="tel" value="" placeholder="註冊人手機號" id="r_phone">
    </div>
    <div class="jui_h12"></div>
    <div class="jui_public_list">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe60b;</span>
        <input class="flex1" type="text" value="" placeholder="真實姓名" id="r_name">
    </div>
    <div class="jui_h12"></div>
    <div class="jui_public_list">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe821;</span>
        <input class="flex1" type="text" value="" placeholder="LINE號" id="r_weixin">
    </div>
    <div class="jui_h12"></div>
    <div class="jui_public_list">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
        <input class="flex1" type="password" value="" placeholder="登錄密碼" id="r_pass1">
    </div>
    <div class="jui_h12"></div>
    <div class="jui_public_list">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
        <input class="flex1" type="password" value="" placeholder="確認密碼" id="r_pass2">
    </div>
    <div class="jui_h20"></div>
    <div class="jui_pad_l20 jui_pad_r20">
        <div class="jui_public_btn login_btn"><input type="button" value="立即註冊"></div>
    </div>

  <!--  <div class="codeMsg">
        <img src="<?php /*if($t_user['m_qrcode'] == '' or $t_user['m_qrcode'] == false){ echo '/public/image/tx.jpg';}else{ echo "$t_user[m_qrcode]"; } */?>" alt="">
        <p style="margin-top: 0.2rem;">推薦人:<?php /*echo $t_user['m_name']; */?></p>
        <p>手機號:<?php /*echo $t_user['m_phone']; */?></p>
        <p>LINE:<?php /*echo $t_user['m_weixin']; */?></p>
        <p>等級:<?php /*echo $this->user_levels[$t_user['m_level']];*/?></p>
    </div>-->

    <script language="javascript">
        function isNumber(obj) {
            return !isNaN(parseFloat(obj)) && isFinite(obj);
        }

        function isPhoneNumber(tel) {
            var reg = /^[1][3-8]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/;
            return reg.test(tel);
        }

        function settime(num) {
            var yzm_input = document.getElementById("yzm");
            var num;
            if (num == 0) {
                yzm_input.value = "重新發送";
                yzm_input.removeAttribute("disabled");
                yzm_input.setAttribute("class", "reg_yzminput");
                num = 60;
                return false;
            } else {
                yzm_input.setAttribute("disabled", "disabled");
                yzm_input.setAttribute("class", "reg_yzminput reg_disable")
                yzm_input.value = num + "s後重發";
                num--;
            }
            setTimeout("settime(" + num + ")", 1000);
        }

        $(function () {
            $('.hb_btn').click(function () {
                var verify_code = $('#verify_code').val();
                var login_phone = $('#r_phone').val();
                if (verify_code == '' || !isNumber(verify_code) || verify_code.length < 6) {
                    layer.msg('請輸入正確驗證碼');
                    return;
                }
                $.post("?m=index&c=checkreg", {code: verify_code, phone: login_phone}, function (ret) {
                    if (ret.code == 1) {
                        layer.msg(ret.msg);
                        settime(60);
                        $('.hb_bar').hide();
                    } else {
                        layer.msg(ret.msg);
                    }
                }, 'json');
            });
            $('#yzm').click(function () {
                var login_phone = $('#r_phone').val();
                if (login_phone == '') {
                    layer.msg('手機號不能為空');
                    return;
                }
                if (!isPhoneNumber(login_phone)) {
                    layer.msg('手機號格式不正確');
                    return;
                }
                $('#verify_code').val('');
                $('.login_yzm img').attr('src', '?m=index&c=captcha&_=' + Math.random())
                $('.hb_bar').show();
            })
            $('.hb_close').click(function () {
                $('.hb_bar').hide();
            });
            $('.login_btn').click(function () {
                var val_2 = $('#r_phone').val();
                var val_4 = $('#r_name').val();
                var val_5 = $('#r_weixin').val();
                var val_6 = $('#r_pass1').val();
                var val_7 = $('#r_pass2').val();
                if (val_2 == '') {
                    layer.msg('註冊手機號不能為空');
                    return;
                }
                if (!isPhoneNumber(val_2)) {
                    layer.msg('註冊手機號格式不正確');
                    return;
                }
                if (val_4 == '') {
                    layer.msg('真實姓名不能為空');
                    return;
                }
                if (val_5 == '') {
                    layer.msg('LINE號不能為空');
                    return;
                }
                if (val_6 == '') {
                    layer.msg('登錄密碼不能為空');
                    return;
                }
                if (val_7 == '') {
                    layer.msg('確認密碼不能為空');
                    return;
                }
                if (val_7 != val_6) {
                    layer.msg('兩次輸入密碼不壹致');
                    return;
                }
                $.post("?m=index&c=helpreg", {
                    val_2: val_2,
                    val_4: val_4,
                    val_5: val_5,
                    val_6: val_6,
                    val_7: val_7
                }, function (ret) {
                    if (ret.code == 1) {
                        layer.msg(ret.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = "?m=team&c=user";
                        });
                    } else {
                        layer.msg(ret.msg);
                    }
                }, 'json');

            });
        });
    </script>
<?php }else{ ?>
    <div class="none_bar">
        <img src="/public/icon/no_team.png" alt="">
        <p class="fc_999">您的等級過低,暫無註冊權限</p>
        <div class="jui_h20"></div>
        <a href="?m=user&c=uplevel" class="none_btn">去升級</a>
    </div>
<?php } ?>
<?php include 'common.footer.php'; ?>
<!-- 主體end -->
</body>
</html>
