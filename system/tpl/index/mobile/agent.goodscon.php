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
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">代理產品</div>
</div>
<!-- 頭部end -->
<!-- 產品圖 -->
<div class="procon_topimg"><img src="<?php echo $product['p_cover']; ?>"></div>
<div class="jui_bg_fff jui_pad_1216">
    <p class="jui_fc_000 jui_fs15 jui_line_h15"><?php echo $product['p_title']; ?></p>
    <p class="jui_fc_999 jui_pad_t5" style=" text-decoration:line-through; ">原價:￥<?php echo $product['p_price']; ?></p>
    <p class="jui_fc_red jui_fs20 "><span class="jui_fs14 jui_fc_999">代理價:</span>￥<?php echo $p_a_price; ?></p>
</div>
<!-- 產品圖end -->
<div class="jui_h12"></div>
<!-- 產品詳情end -->
<div class="jui_bg_fff">
    <div class="jui_public_tit jui_fc_000 jui_font_weight jui_bor_bottom">商品詳情</div>
    <div class="procon_ztcon flex flex_col">
        <?php echo $product['p_desc']; ?>
    </div>
</div>
<!-- 產品詳情end -->
<div class="jui_h60"></div>
<!-- 底部 -->
<div class="jui_footer procon_foot"><a href="?m=agent&c=agent_qrorder&p_id=<?php echo $product['p_id']; ?>" class="procon_foot_btn jui_bg_zhuse">立即購買</a>
</div>
<!-- 底部end -->
</body>
</html>
