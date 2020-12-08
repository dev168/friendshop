<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>創客新零售</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
    <?php include 'common.header.php';?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar jui_none">
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">代理商城</div>
</div>
<!-- 頭部end -->
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
    foreach ($cate as $c) {
        ?>
        <a href="?m=agent&c=pl&id=<?php echo $c['id']; ?>" class="jui_grid_list jui_grid_w25">
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
<!-- 余額及記錄 -->
<div class="jui_bg_fff jui_pad_t12 jui_pad_b12 jui_flex">
    <a href="?m=agent&c=agent_alogs" class="jui_flex1 jui_flex_row_center jui_flex_justify_center jui_bor_right">
        <span class="iconfont jui_fc_orange jui_fs28">&#xe62c;</span>
        <p class="jui_pad_l12 jui_fs15">我的余額&nbsp;<span class="jui_fs12"><?php echo $user['m_money']; ?></span></p>
    </a>
    <a href="?m=agent&c=agent_order" class="jui_flex1 jui_flex_row_center jui_flex_justify_center">
        <span class="iconfont jui_fc_blue jui_fs28">&#xe655;</span>
        <p class="jui_pad_l12 jui_fs15">我的訂單</p>
    </a>
</div>
<!-- 余額及記錄end -->
<div class="jui_h12"></div>
<!-- 產品 -->
<div class="jui_bg_fff">
    <div class="jui_public_tit jui_bor_bottom">
        <span class="iconfont jui_fc_orange jui_fs24">&#xe770;</span>
        <P class="jui_pad_l8 jui_fc_000 jui_font_weight">熱銷商品</P>
    </div>
    <div class="pro_bar jui_flex jui_flex_wrap">
        <?php
        foreach ($product as $c) {
            ?>
            <div class="pro_list jui_grid_w50">
                <a href="?m=agent&c=agent_goodscon&p_id=<?php echo $c['p_id']; ?>" class="pro_con">
                    <div class="pro_img"><img src="<?php echo $c['p_cover']; ?>"></div>
                    <div class="pro_text">
                        <p class="pro_tit jui_ellipsis_2"><?php echo $c['p_title']; ?></p>
                        <div class="jui_flex_row_center jui_flex_justify_between">
                            <p class="jui_fc_red">¥<span class="jui_fs16"><?php echo $c['p_price']; ?></span></p>
                            <p class="jui_fc_999 jui_fs12">已售：<?php echo $c['p_yishou']; ?>件</p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!-- 產品end -->
<div class="jui_h60"></div>
<!-- 固定底部 -->
<div class="jui_footer">
    <a href="?m=index&c=index" class="jui_foot_list">
        <span class="iconfont">&#xe601;</span>
        <p>返回首頁</p>
    </a>
    <a href="?m=shop&c=index" class="jui_foot_list">
        <span class="iconfont">&#xe617;</span>
        <p>商盟</p>
    </a>
    <a href="?m=user&c=index" class="jui_foot_list">
        <span class="iconfont">&#xe63d;</span>
        <p>個人中心</p>
    </a>
</div>
<!-- 固定底部end -->
</body>
<script>
    $(document).ready(function () {

        //控制圖片為正方形且居中不變形顯示
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
