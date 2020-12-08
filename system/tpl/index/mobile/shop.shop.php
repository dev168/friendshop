<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
    <a class="jui_top_left" href="javascript:history.back(-1)">
        <img src="/public/icon/back_111.png">
    </a>
    <div class="jui_top_middle"><?php echo $shop['s_name']; ?>的店鋪</div>
</div>
<!-- 頭部end -->
<!-- 頂部 -->
<div class="shopcon_top jui_flex jui_bg_zhuse">
    <div class="shopcon_tx jui_bor_rad_5 jui_mar_r16">
        <img src="<?php echo $shop['s_img']; ?>">
    </div>
    <div class="jui_flex1 jui_flex_col">
        <div class="jui_flex1 jui_flex">
            <div class="jui_flex1">
                <p class="jui_fc_fff"><?php echo $shop['s_name']; ?></p>
                <div class="shopcon_rz jui_bg_fuse jui_fc_zhuse"><?php echo $shop['hang']; ?></div>
            </div>
            <div class="jui_flex_col">
                <?php if ($shop['s_hot']) { ?>
                    <div class="shopcon_gz jui_fc_zhuse">推薦</div>
                <?php } ?>

                <p class="jui_fs12 jui_fc_fff">瀏覽：<span><?php echo $shop['s_read'];?></span>次</p>
            </div>
        </div>
        <div class="jui_fs12 jui_fc_fff jui_ellipsis_1" style="padding-top: .1rem;">
            <?php echo $shop['s_region'];?><?php echo $shop['s_address'];?>
        </div>
        <div  class="jui_fs12 jui_fc_fff jui_ellipsis_1" style="padding-top: .1rem;">
            <span>產品：<?php echo $shop['score']['product_score']; ?>分</span>
            &nbsp;&nbsp;&nbsp;
            <span>物流：<?php echo $shop['score']['logistics_score']; ?>分</span>
            &nbsp;&nbsp;&nbsp;
            <span>服務：<?php echo $shop['score']['sever_score']; ?>分</span>
        </div>
    </div>
</div>

<!-- 頂部end -->
<!-- 產品 -->
<div class="pro_bar jui_flex jui_flex_wrap">
    <?php foreach ($goods as $k => $v){ ?>
    <div class="pro_list jui_grid_w50">
        <a href="?m=shop&c=gc&g_id=<?php echo $v['g_id']; ?>" class="pro_con">
            <div class="pro_img">
                <img src="<?php echo $v['g_pic']; ?>">
            </div>
            <div class="pro_text">
                <p class="pro_tit jui_ellipsis_2"><?php echo $v['g_title']; ?></p>
                <div class="jui_flex_row_center jui_flex_justify_between">
                    <p class="jui_fc_red">¥<span class="jui_fs16"><?php echo $v['g_price']; ?></span></p>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>
</div>
<!-- 產品end -->
</body>
<script>
    $(document).ready(function () {


        $('.shopcon_tx').each(function () {
            var img_w = $(this).find('img').width();
            var img_h = $(this).find('img').height();
            if (img_w > img_h) {
                $(this).find('img').css('height', '100%');
            } else {
                $(this).find('img').css('width', '100%');
            }
            //console.log(img_h);
        })

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
