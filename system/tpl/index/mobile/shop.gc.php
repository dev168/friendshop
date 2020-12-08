<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
    <script>
        $(function(){
            $('.procon_ztcon img').removeAttr('class');
            $('.procon_ztcon img').removeAttr('width');
            $('.procon_ztcon img').removeAttr('style');
            $('.procon_ztcon img').removeAttr('height');
            $('.procon_ztcon img').removeAttr('align');
            $('.procon_ztcon img').removeAttr('alt');
        });
    </script>
    <style>
        .procon_ztcon img{max-width: 100%;}
    </style>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">產品詳情</div>
</div>
<!-- 頭部end -->
<!-- 產品圖 -->
<div class="procon_topimg"><img src="<?php echo $goods['g_pic']; ?>"></div>
<div class="jui_bg_fff jui_pad_1216">
    <p class="jui_fc_000 jui_fs15 jui_line_h15"><?php echo $goods['g_title']; ?></p>
    <p class="jui_fc_red jui_fs20 jui_pad_t5">¥<?php echo $goods['g_price']; ?></p>
</div>
<!-- 產品圖end -->
<div class="jui_h12"></div>
<!-- 產品詳情end -->
<div class="jui_bg_fff">
    <div class="jui_public_tit jui_fc_000 jui_font_weight jui_bor_bottom">商品詳情</div>
    <div class="procon_ztcon flex flex_col">
        <?php echo $goods['g_content']; ?>
    </div>
</div>
<!-- 產品詳情end -->
<div class="jui_h60"></div>

<!-- 底部 -->
<div class="jui_footer procon_foot">
    <div class="procon_foot_btn jui_bg_zhuse" id="<?php echo $shop_user['m_phone']; ?>">咨詢商家</div>
</div>
<!-- 底部end -->

<!-- 彈出框 -->
<div class="jui_box_bar jui_none" id="box_bar2">

</div>
<!-- 彈出框end -->
</body>
<script>
    $(document).ready(function () {
        //彈出框2------帶連接按鈕
        $(document).on("click", ".procon_foot_btn", function () {
            var phone = $(this).attr('id');
            $.post('?m=team&c=infos', {'phone': phone}, function (retmsg) {
                if (parseInt(retmsg.code) == 1) {
                    $("#box_bar2").html(retmsg.msg);
                    $("#box_bar2").removeClass('jui_none');
                } else {
                    layer.msg(retmsg.msg);
                }
            }, 'json');
        });
        $(document).on("click", "#close2", function () {
            $("#box_bar2").addClass('jui_none');
        });

    });
</script>
</html>
