<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
    <?php include 'common.header.php'; ?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar"><a class="jui_top_left" href="?m=index&c=index"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">我的店鋪</div>
    <?php if (!empty($shop) and $shop['s_status'] != 0) { ?>
        <a href="?m=shop&c=ag" class="jui_top_right jui_fc_fff">發布商品</a>
    <?php } ?>
</div>
<!-- 頭部end -->
<?php if (empty($shop)) { ?>
    <!-- 沒有店鋪 -->
    <div class="jui_none_bar"><img src="/public/icon/no_shop.png">
        <p class="jui_fc_999">您還沒有商鋪</p>
        <div class="jui_h20"></div>
        <a href="?m=shop&c=apply" class="jui_none_btn jui_bg_zhuse">申請入駐</a></div>
    <!-- 沒有店鋪end -->
<?php } else { ?>
    <?php if ($shop['s_status'] == 0) { ?>
        <!-- 沒有店鋪 -->
        <div class="jui_none_bar"><img src="/public/icon/no_shop.png">
            <p class="jui_fc_999">商鋪審核中</p>
            <div class="jui_h20"></div>
            <a href="#" class="jui_none_btn jui_bg_zhuse">請耐心等待</a></div>
        <!-- 沒有店鋪end -->
    <?php } else { ?>
        <!-- 我的店鋪 -->
        <div class="jui_bg_fff jui_pad_1216 jui_flex">
            <div class="shop_img"><img src="<?php echo $shop['s_img']; ?>" alt="<?php echo $shop['s_name']; ?>"></div>
            <div class="jui_flex1 jui_flex_col">
                <div class="jui_flex_row_center jui_pad_b5">
                    <div class="jui_flex1 jui_flex_row_center"><img class="shop_tx" src="<?php if ($shop['avatar'] == '') {
                            echo '/public/image/tx.jpg';
                        } else {
                            echo $shop['avatar'];
                        } ?>" alt="<?php echo $shop['s_name']; ?>">
                        <p class="jui_fc_000"><?php echo $shop['s_name']; ?></p>
                    </div>
                    <?php if ($shop['s_hot']) {
                        echo '<p class="jui_fc_red">薦</p>';
                    } ?>
                </div>
                <p class="jui_ellipsis_3 jui_fs12 jui_fc_999"><?php echo $shop['s_info']; ?> </p>
                <p style="padding-top: .2rem;">產品分類：<?php echo $cateslist['c_name']; ?></p>
                <p style="padding-top: .2rem;">產品：<?php echo $score['product_score']; ?>分</p>
                <p>物流：<?php echo $score['logistics_score']; ?>分</p>
                <p>服務：<?php echo $score['sever_score']; ?>分</p>
            </div>
        </div>
        <!-- 我的店鋪end -->
        <div class="jui_h12"></div>
        <!-- 商品列表 -->
        <?php if (!empty($goods)) { ?>
            <div class="jui_bg_fff">
                <div class="jui_public_tit jui_bor_bottom">
                    <P class="jui_fc_000 jui_font_weight">我的商品</P>
                </div>
                <div class="myshop_pro_con">
                    <?php foreach ($goods as $k => $v) { ?>
                        <div class="myshop_pro_list"><a href="?m=shop&c=gc&g_id=<?php echo $v['g_id']; ?>"
                                                        class="shop_list jui_flex">
                                <div class="shop_img"><img src="<?php echo $v['g_pic']; ?>"
                                                           alt="<?php echo $v['g_title']; ?>"></div>
                                <div class="jui_flex1 jui_flex_col">
                                    <p class="jui_fc_000 jui_fs15 jui_pad_b5"><?php echo $v['g_title']; ?></p>
                                    <p>價格：¥<?php echo $v['g_price']; ?></p>
                                </div>
                            </a>
                            <div class="jui_pad_12 jui_flex_row_center jui_flex_justify_end"><a
                                        href="?m=shop&c=eg&g_id=<?php echo $v['g_id']; ?>"
                                        class="myshop_btn jui_bg_zhuse jui_fc_fff jui_bor_none">修改</a>
                                <div class="myshop_btn jui_mar_l20 ck_del">刪除</div>
                                <input type="hidden" name="g_id" class="g_id" value="<?php echo $v['g_id']; ?>">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="jui_none_bar"><img src="/public/icon/gods.png" alt="無產品">
                <p class="jui_fc_999">暫無產品</p>
                <div class="jui_h20"></div>
                <a href="?m=shop&c=ag" class="jui_none_btn jui_bg_zhuse">去發布</a></div>
        <?php } ?>
        <!-- 商品列表end -->
    <?php } ?>

<?php } ?>
</body>
<script>
    $(document).ready(function () {
        $('.shop_img').each(function () {
            var img_w = $(this).find('img').width();
            var img_h = $(this).find('img').height();
            if (img_w > img_h) {
                $(this).find('img').css('height', '100%');
            } else {
                $(this).find('img').css('width', '100%');
            }
        });
        $('.pro_img').height($('.pro_img').width());
        $('.pro_img').each(function () {
            var img_w = $(this).find('img').width();
            var img_h = $(this).find('img').height();
            if (img_w > img_h) {
                $(this).find('img').css('height', '100%');
            } else {
                $(this).find('img').css('width', '100%');
            }
        });
        $(".ck_del").click(function () {
            var g_id = $(this).siblings(".g_id").val();
            $.post("?m=shop&c=gd", {g_id: g_id}, function (res) {
                layer.msg(res.msg);
                if (res.code == 1) {
                    setTimeout(function () {
                        window.location.reload();
                    }, '1000');
                }
            }, 'json');
        });
    });
</script>
</html>
