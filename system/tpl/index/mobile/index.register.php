<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
   <!-- <style>
        .codeMsg{width: 92%;margin-left: 4%;margin-top: 1rem;padding: 1.2rem;text-align: center;background: #f7f7f7;border-radius: 0.26rem;}
        .codeMsg img{width: 2.8rem;height: 2.8rem;margin-left: 30%;}
        .codeMsg p{line-height: 0.62rem;color: #999;}
    </style>-->
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar"><a class="jui_top_left" href="javascript:history.back(-1)"><img
                src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">註冊</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe613;</span>
    <?php
    if ($tui_id == 0) {
        echo '<input class="flex1" type="tel" value="" placeholder="推薦人手機號" id="t_phone">';
    } else {
        echo '推薦人：' . $tui_name;
    }
    ?>
</div>
<div class="h12"></div>
<div class="jui_public_list jui_flex_justify_between">
    <div class="jui_flex1">
        <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999 jui_flex_no">&#xe613;</span>
        <input style="max-width:4.5rem;" type="tel" value="" placeholder="註冊手機號" id="r_phone">
    </div>
    <?php
    if ($needs) {
        echo '<div class="reg_yzm"><input class="reg_yzminput fc_zs" id="yzm" type="button" value="發送驗證碼"></div>';
    }
    ?>
</div>
<?php
if ($needs) {
    ?>
    <div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe624;</span>
        <input class="flex1" type="text" value="" placeholder="短信驗證碼" id="r_code">
    </div>
    <div class="jui_h12"></div>
    <?php
}
?>
<!--<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe60b;</span>
    <input class="flex1" name="r_twcode" type="text" value="" placeholder="圖形驗證碼" id="r_twcode">
    <div class="reg_yzm" style="margin-left: 17%;">
        <img src="/admin.php?m=index&amp;c=captcha"  style="width: 2.4rem;" class="layadmin-user-login-codeimg" onclick="this.src='admin.php?m=index&amp;c=captcha&amp;_='+Math.random();">
    </div>
</div>-->
<div class="jui_h12"></div>
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe60b;</span>
    <input class="flex1" type="text" value="" placeholder="昵稱" id="r_name">
</div>
<div class="jui_h12"></div>
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe821;</span>
    <input class="flex1" type="text" value="" placeholder="LINE號" id="r_weixin">
</div>
<div class="jui_h12"></div>
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
    <input class="flex1" type="password" value="" placeholder="登錄密碼" id="r_pass1">
</div>
<div class="jui_h12"></div>
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
    <input class="flex1" type="password" value="" placeholder="確認密碼" id="r_pass2">
</div>
<div class="jui_h20"></div>
<div class="jui_pad_l20 jui_pad_r20">
    <div class="jui_public_btn login_btn">
        <input type="button" value="立即註冊">
    </div>
    <a href="?m=user&c=about&id=2" class="jui_block jui_text_center jui_pad_t16 jui_fs12">註冊即表示同意
        <span class="jui_fc_zhuse">《平臺協議》</span>
    </a>
</div>
<?php /*if(!empty($t_user)){*/?><!--
    <div class="codeMsg">
        <img src="<?php /*if($t_user['m_qrcode'] == '' or $t_user['m_qrcode'] == false){ echo '/public/image/tx.jpg';}else{ echo "$t_user[m_qrcode]"; } */?>" alt="">
        <p style="margin-top: 0.2rem;">推薦人:<?php /*echo $t_user['m_name']; */?></p>
        <p>手機號:<?php /*echo $t_user['m_phone']; */?></p>
        <p>LINE:<?php /*echo $t_user['m_weixin']; */?></p>
        <p>等級:<?php /*echo $this->user_levels[$t_user['m_level']];*/?></p>
    </div>
--><?php /*} */?>
<!-- 主體end -->
<div class="hb_bar" style="display: none;">
    <div class="hb_con">
        <div class="hb_top">
            <div class="hb_money">請輸入右側驗證碼</div>
            <div class="jui_public_list jui_flex_justify_between" style="width: 100%;">
                <input style="max-width:3rem;" type="text" value="" placeholder="驗證碼" id='verify_code'>
                <div class="login_yzm">
                    <img style="width:3rem;" src="?m=index&c=captcha" onClick="this.src='?m=index&c=captcha&_='+Math.random();">
                </div>
            </div>
            <div class="hb_close">X</div>
        </div>
        <div class="hb_btn">立即發送</div>
    </div>
</div>
</body>
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
            <?php if ($tui_id == 0) {
            echo "var t_phone=$('#t_phone').val();";
        }?>
            if (verify_code == '' || !isNumber(verify_code) || verify_code.length < 6) {
                layer.msg('請輸入正確驗證碼');
                return;
            }
            $.post("?m=index&c=checkreg", {
                code: verify_code, phone: login_phone<?php if ($tui_id == 0) {
                    echo ",t_phone:t_phone";
                }?>}, function (ret) {
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
            <?php
            if($tui_id == 0){
            ?>
            var login_phone = $('#t_phone').val();
            if (login_phone == '') {
                layer.msg('推薦人手機號不能為空');
                return;
            }
            if (!isPhoneNumber(login_phone)) {
                layer.msg('推薦人手機號格式不正確');
                return;
            }
            <?php
            }
            ?>
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
    });
    $('.login_btn').click(function () {
        <?php if ($tui_id == 0) {
        echo "var val_1=$('#t_phone').val();if(val_1==''){layer.msg('推薦人手機號不能為空');return;}if(!isPhoneNumber(val_1)){layer.msg('推薦人手機號格式不正確');return;}";
    } ?>
        var val_2  = $('#r_phone').val();
        var val_4  = $('#r_name').val();
        var val_5  = $('#r_weixin').val();
        var val_6  = $('#r_pass1').val();
        var val_7  = $('#r_pass2').val();
        if (val_2 == '') {
            layer.msg('註冊手機號不能為空');
            return;
        }
        if (!isPhoneNumber(val_2)) {
            layer.msg('註冊手機號格式不正確');
            return;
        }
        <?php if ($needs) {
        echo "var val_3=$('#r_code').val();if(val_3==''){layer.msg('短信驗證碼不能為空');return;}";
    }?>
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

        // if(val_15 == ''){
        //     layer.msg('請輸入圖形驗證碼');
        //     return;
        // }
        $.post("?m=index&c=register", {
            <?php if ($tui_id == 0) {
                echo "val_1:val_1,";
            } ?>val_2: val_2<?php if ($needs) {
                echo ",val_3:val_3";
            }?>, val_4: val_4, val_5: val_5, val_6: val_6, val_7: val_7/*,val_15:val_15*/
        }, function (ret) {
            if (ret.code == 1) {
                layer.msg(ret.msg, {icon: 1, time: 1000}, function () {
                    window.location.href = "?m=index&c=login";
                });
            } else {
                 
                layer.msg(ret.msg);
            }
        }, 'json');

    });
</script>
</html>
