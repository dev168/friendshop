<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
    <?php include 'common.header.php'; ?>
</head>
<body class="jui_bg_grey">
<!-- 輪播圖 -->
<div class="swiper-container bor_rad_8">
    <div class="swiper-wrapper">
        <?php
        if ($banner) {
            foreach ($banner as $b) {
                echo '<div class="swiper-slide">';
                if (!empty($b['b_link'])) {
                    echo '<a href="' . $b['b_link'] . '">';
                }
                echo '<img src="' . $b['b_img'] . '"/>';
                if (!empty($b['b_link'])) {
                    echo '</a>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
<script src="/public/js/swiper.min.js"></script>
<script type="text/javascript">
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 3000,
        pagination: '.swiper-pagination',
        autoplayDisableOnInteraction: false,
        loop: true,
        paginationType: 'bullets',
        paginationClickable: true,
    })

</script>
<!-- 輪播圖end -->
<!-- 分類 -->
<div class="jui_bg_fff jui_flex jui_flex_wrap jui_pad_t5 jui_pad_b5">
    <?php
    foreach ($cates as $c) {
        ?>
        <a href="?m=shop&c=lists&id=<?php echo $c['id']; ?>" class="jui_grid_list jui_grid_w25">
            <img class="shop_fwicon" src="<?php if ($c['c_img'] != false) {
                echo $c['c_img'];
            } else {
                echo "/public/image/tx.jpg";
            } ?>">
            <p class="jui_pad_t5"><?php echo $c['c_name']; ?></p>
        </a>
        <?php
    }
    ?>

</div>
<!-- 分類end -->
<div class="jui_h12"></div>
<!-- 商鋪 -->
<div class="jui_bg_fff">
    <div class="jui_public_tit jui_bor_bottom">
        <span class="iconfont jui_fc_red jui_fs24">&#xe615;</span>
        <P class="jui_pad_l8 jui_fc_000 jui_font_weight">店鋪推薦</P>
    </div>
    <div class="shop_list_bar jui_pad_1216">
        <?php foreach ($shop as $k => $v) { ?>
            <a href="?m=shop&c=shop&id=<?php echo $v['id']; ?>" class="shop_list jui_flex">
                <div class="shop_img">
                    <img src="<?php echo $v['s_img']; ?>" alt="<?php echo $v['s_name']; ?>">
                </div>
                <div class="jui_flex1 jui_flex_col">
                    <div class="jui_flex_row_center jui_pad_b5">
                        <div class="jui_flex1 jui_flex_row_center">
                            <img class="shop_tx" src="<? if ($v['avatar'] == '') {
                                echo '/public/image/tx.jpg';
                            } else {
                                echo $v['avatar'];
                            } ?>" alt="<?php echo $v['s_name']; ?>">
                            <p class="jui_fc_000"><?php echo $v['s_name']; ?></p>
                        </div>
                        <p class="jui_fc_red">薦</p>
                    </div>
                    <p class="jui_ellipsis_3 jui_fs12 jui_fc_999"><?php echo $v['s_info']; ?> </p>
                    <p class="jui_fs12">產品：<?php echo $v['score']['product_score']; ?>分</p>
                    <p class="jui_fs12">物流：<?php echo $v['score']['logistics_score']; ?>分</p>
                    <p class="jui_fs12">服務：<?php echo $v['score']['sever_score']; ?>分</p>
                </div>
            </a>
        <?php } ?>
    </div>
</div>
<!-- 商鋪end -->
<!-- 產品 -->
<div class="jui_h12"></div>
<div class="jui_public_tit jui_bg_fff">
    <span class="iconfont jui_fc_orange jui_fs24">&#xe770;</span>
    <P class="jui_pad_l8 jui_fc_000 jui_font_weight jui_flex1">熱銷商品</P>
    <a href="?m=shop&c=gl" class="jui_fs12">查看更多</a>
</div>
<div class="pro_bar jui_flex jui_flex_wrap">
    <?php foreach ($goods as $k => $v) { ?>
        <div class="pro_list jui_grid_w50">
            <a href="?m=shop&c=gc&g_id=<?php echo $v['g_id']; ?>" class="pro_con">
                <div class="pro_img"><img src="<?php echo $v['g_pic']; ?>"></div>
                <div class="pro_text">
                    <p class="pro_tit jui_ellipsis_2"><?php echo $v['g_title']; ?></p>
                    <div class="jui_flex_row_center jui_flex_justify_between">
                        <p class="jui_fc_red">¥<span class="jui_fs16"><?php echo $v['g_price']; ?></span></p>
                        <!--                            <p class="jui_fc_999 jui_fs12">已售：15件</p>-->
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>

</div>
<!-- 產品end -->
<div class="jui_h80"></div>
<?php include 'common.footer.php'; ?>
</body>
<script>
    $(document).ready(function () {

        //控制圖片為正方形且居中不變形顯示
        $('.shop_img').each(function () {
            var img_w = $(this).find('img').width();
            var img_h = $(this).find('img').height();
            if (img_w > img_h) {
                $(this).find('img').css('height', '100%');
            } else {
                $(this).find('img').css('width', '100%');
            }
            //console.log(img_h);
        })


        $('.pro_img').height($('.pro_img').width());
        $('.pro_img').each(function () {
            var img_w = $(this).find('img').width();
            var img_h = $(this).find('img').height();
            if (img_w > img_h) {
                $(this).find('img').css('height', '100%');
            } else {
                $(this).find('img').css('width', '100%');
            }
            //console.log(img_h);
        })

    });
</script>
</html>
