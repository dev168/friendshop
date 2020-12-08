<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
</head>
<body class="jui_bg_grey">
<div class="jui_top_bar"><a class="jui_top_left" href="javascript:history.back(-1)"><img
                src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">評價</div>
</div>
<div class="order_list">
    <div class="jui_public_list2 jui_flex_justify_between">
        <p class="fc_000 font_weight">申請升級:<?php echo $logs['u_levels']; ?></p>
        <?php if ($this->config['w_price']) { ?>
            <p class="fc_000">價格:<?php echo $logs['price']; ?>元</p>
        <?php } ?>
    </div>
    <div class="order_text">
        <p><span class="fc_999">審核商家：</span><?php echo $logs['m_name']; ?></p>
        <p><span class="fc_999">商家電話：</span><?php echo $logs['m_phone']; ?></p>
        <p><span class="fc_999">商家LINE：</span><?php echo $logs['m_weixin']; ?></p>
        <?php if ($this->config['w_xinyu']) { ?>
            <p><span class="fc_999">商家信譽：</span><?php echo $logs['m_fen']; ?> 分</p>
        <?php } ?>
    </div>
    <div class="jui_text_right jui_pad_5 jui_fs12">審核時間：<?php echo $logs['m_time']; ?></div>
</div>
<div class="jui_h12"></div>
<form id="setform" name="setform">
    <div class="jui_bg_fff">
        <div class="jui_pad_16 jui_flex_row_center">
            <p class="jui_fc_000 jui_fs15 jui_font_weight jui_pad_r12">信譽：</p>
            <div class="jui_flex_row_center">
                <label class="jui_flex_row_center jui_pad_r20">
                    <input class="jui_form_radio" type="radio" value="1" checked="checked" name="ping">
                    <P class="jui_pad_l5">好評</P>
                </label>
                <label class="jui_flex_row_center jui_pad_r20">
                    <input class="jui_form_radio" type="radio" value="2" name="ping">
                    <P class="jui_pad_l5">中評</P>
                </label>
                <label class="jui_flex_row_center">
                    <input class="jui_form_radio" type="radio" value="3" name="ping">
                    <P class="jui_pad_l5">差評</P>
                </label>
            </div>
        </div>
        <div class="jui_pad_16 jui_flex_row_center">
            <p class="jui_fc_000 jui_fs15 jui_font_weight">產品：</p>
            <div class="jui_flex_row_center pj_star_bar">
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <input type="hidden" value="0" name="ping1" class="pings" id="ping1">
            </div>
        </div>
        <div class="jui_pad_16 jui_flex_row_center">
            <p class="jui_fc_000 jui_fs15 jui_font_weight">物流：</p>
            <div class="jui_flex_row_center pj_star_bar">
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <input type="hidden" value="0" name="ping2" class="pings" id="ping2"></div>
        </div>
        <div class="jui_pad_16 jui_flex_row_center">
            <p class="jui_fc_000 jui_fs15 jui_font_weight">服務：</p>
            <div class="jui_flex_row_center pj_star_bar">
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <span class="iconfont">&#xe6d5;</span>
                <input type="hidden" value="0" name="ping3" class="pings" id="ping3"></div>
        </div>
    </div>
    <div class="jui_public_btn">
        <input type="button" value="提交">
    </div>
</form>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        var pj_index = 0;
        $(document).on("click", ".pj_star_bar span", function () {
            pj_index = $(this).index();
            $(this).parent().children('.pings').val(pj_index + 1);
            $(this).addClass("pj_on");
            $(this).prevAll("span").addClass("pj_on");
            $(this).nextAll("span").removeClass("pj_on");
        });
        $('.jui_public_btn').click(function () {
            var ping1 = parseInt($('#ping1').val());
            if (ping1 == 0) {
                layer.msg('請對產品做出評價');
                return;
            }
            var ping2 = parseInt($('#ping2').val());
            if (ping2 == 0) {
                layer.msg('請對物流做出評價');
                return;
            }
            var ping3 = parseInt($('#ping3').val());
            if (ping3 == 0) {
                layer.msg('請對服務做出評價');
                return;
            }
            console.log(ping1);
            console.log(ping2);
            console.log(ping3);
            var xxx = new FormData(document.querySelector("form"));
            $.ajax('?m=user&c=ping&id=<?php echo $id;?>', {
                method: 'POST', data: xxx, processData: false, contentType: false,
                success: function (data) {
                    if (data.code == 1) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = '?m=user&c=logs&type=1';
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
