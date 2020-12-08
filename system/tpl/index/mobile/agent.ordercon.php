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
    <div class="jui_top_middle">訂單詳情</div>
</div>
<!-- 頭部end -->
<!-- 產品 -->
<div class="jui_flex_row_center jui_flex_justify_center jui_pad_16 jui_bg_fff jui_bor_bottom">
    <?php if($order['o_status'] < 2){?>
        <span class="iconfont jui_fs28 " style="color:#ffb11d;">&#xe628;</span><!-- 等待圖標 -->
        <p class="jui_pad_l12 jui_fs16 jui_fc_000">等待中</p>
    <?php }elseif ($order['o_status'] == 2){?>
        <span class="iconfont jui_fs28 jui_fc_green">&#xe66e;</span><!-- 訂單完成圖標 -->
        <p class="jui_pad_l12 jui_fs16 jui_fc_000">交易完成</p>
    <?php }elseif ($order['o_status'] > 2 ){?>
        <span class="iconfont jui_fs28 " style="color:#ffb11d;">&#xe628;</span><!-- 等待圖標 -->
        <p class="jui_pad_l12 jui_fs16 jui_fc_000">售後中</p>
    <?php }?>

</div>
<div class="jui_flex_row_center jui_bg_fff jui_pad_16">
    <div class="dl_order_address_icon iconfont">&#xe621;</div>
    <div class="jui_flex1 jui_flex_col jui_pad_l16">
        <p class="jui_fs15 jui_fc_000 jui_pad_b5"><?php echo $order['o_name']; ?><span class="jui_pad_l12"><?php echo $order['o_tel']; ?></span></p>
        <p class="jui_fs13 jui_line_h13"><?php echo $order['o_city']; ?></p>
    </div>
</div>
<div class="jui_h12"></div>
<a href="#" class="jui_pad_1216 jui_flex jui_bg_fff">
    <div class="dl_order_img"><img src="<?php echo $product['p_cover']; ?>"></div>
    <div class="jui_flex1 jui_flex_col">
        <p class="jui_pad_b5"><?php echo $product['p_title']; ?></p>
        <div class="jui_flex_row_center jui_flex_justify_between">
            <p class="jui_fc_red"><?php echo $product['p_price']; ?></p>
            <p>×<?php echo $order['p_num']; ?></p>
        </div>
    </div>
</a>
<div class="jui_bg_fff jui_pad_1216 jui_line_h30">
    <div class="jui_fs12 jui_flex_row_center jui_flex_justify_between jui_fc_999">
        <p>商品單價</p>
        <p>¥<?php echo $order['order_sum_price']; ?></p>
    </div>
</div>
<div class="jui_bg_fff jui_pad_16 jui_bor_top">
    <div class="jui_fs15 jui_flex_row_center jui_flex_justify_between">
        <p class="jui_fc_000">實付款</p>
        <p class="jui_fc_red">¥<?php echo $order['order_sum_price']; ?></p>
    </div>
</div>
<!-- 產品end -->
<div class="jui_h12"></div>
<?php if($order['o_status'] != 0){ ?>
    <!-- 訂單信息 -->
    <div class="jui_bg_fff">
        <div class="jui_public_tit jui_fc_000 jui_bor_bottom">物流信息</div>
        <div class="dl_ddcon_text_bar">
            <div class="dl_ddcon_text_list">
                <p>物流公司</p>
                <p><?php echo $order['o_express_name']; ?></p>
            </div>
            <div class="dl_ddcon_text_list">
                <p>快遞單號</p>
                <p><?php echo $order['o_express_num']; ?></p>
            </div>
            <div class="dl_ddcon_text_list">
                <p>發貨時間</p>
                <p><?php echo date("Y-m-d H:i",$order['o_express_time']); ?></p>
            </div>
        </div>
    </div>
    <!-- 訂單信息end -->
<?php } ?>

<div class="jui_h12"></div>
<!-- 訂單信息 -->
<div class="jui_bg_fff">
    <div class="jui_public_tit jui_fc_000 jui_bor_bottom">訂單信息</div>
    <div class="dl_ddcon_text_bar">
        <div class="dl_ddcon_text_list">
            <p>訂單編號</p>
            <p><?php echo $order['o_num']; ?></p>
        </div>
        <div class="dl_ddcon_text_list">
            <p>創建時間</p>
            <p><?php echo date("Y-m-d H:i",$order['order_addtime']); ?></p>
        </div>
        <div class="dl_ddcon_text_list">
            <p>付款時間</p>
            <p><?php echo date("Y-m-d H:i",$order['order_addtime']); ?></p>
        </div>
    </div>
</div>
<!-- 訂單信息end -->
<div class="jui_h60"></div>
<!-- 待付款訂單底部 訂單取消後只剩下刪除訂單 -->
<?php if($order['o_status'] == 0){?>
    <div class="jui_footer jui_flex_justify_end jui_pad_16">
        <div class="dl_order_btn">等待發貨</div>
    </div>
<?php }elseif ($order['o_status'] == 1){?>
    <div class="jui_footer jui_flex_justify_end jui_pad_16">
        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff ConfirmShop">確認收貨</div>
    </div>
<?php }elseif ($order['o_status'] == 2){?>
    <div class="jui_footer jui_flex_justify_end jui_pad_16">
        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff AfterSale">售後</div>
    </div>
<?php }elseif ($order['o_status'] == 3){?>
    <div class="jui_footer jui_flex_justify_end jui_pad_16">
        <div class="dl_order_btn">售後中</div>
        <div class="dl_order_btn DelOrder">刪除訂單</div>
    </div>
<?php }?>


<!-- 待收貨訂單底部 -->
</body>
<script>
    $(".ConfirmShop").click(function () {
        var o_id = <?php echo $order['o_id'];?>;
        $.post('?m=agent&c=confirm_shop', {'o_id': o_id}, function (res) {
            layer.msg(res.msg);
            if(res.code == 1){
                setTimeout(function () {
                    window.location.reload();
                },'1000')
            }
        }, 'json');
    });

    $(".AfterSale").click(function () {
        var o_id = <?php echo $order['o_id'];?>;
        $.post('?m=agent&c=after_sale', {'o_id': o_id}, function (res) {
            layer.msg(res.msg);
            if(res.code == 1){
                setTimeout(function () {
                    window.location.reload();
                },'1000')
            }

        }, 'json');
    });

    $(".DelOrder").click(function () {
        var o_id = <?php echo $order['o_id'];?>;
        $.post('?m=agent&c=del_order', {'o_id': o_id}, function (res) {
            layer.msg(res.msg);
            if(res.code == 1){
                setTimeout(function () {
                    window.location.reload();
                },'1000')
            }

        }, 'json');
    });
</script>
</html>
