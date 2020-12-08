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
    <a class="jui_top_left" href="?m=agent&c=agent_shop"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">我的訂單</div>
</div>
<!-- 頭部end -->
<!-- 搜索 -->
<div class="jui_top_bar">
    <div class="rm_search jui_bor_rad_5 jui_flex1 jui_flex_row_center">
        <span class="iconfont">&#xe618;</span>
        <input class="jui_flex1" id="jui_flex1" style="line-height:.8rem;" onblur="inputOnBlur();" type="search" value="<?php if(array_key_exists('hot_search',$_GET)){ echo $_GET['hot_search']; }?>" placeholder="搜索收貨人/聯系電話">
    </div>
</div>
<!-- 搜索end -->
<!-- 主體 -->
<div class="jui_tab_bar">
    <ul class="jui_tab_tit">
        <li class="jui_tab_on">全部<span></span></li>
        <li>待發貨<span></span></li>
        <li>待收貨<span></span></li>
        <li>已完成<span></span></li>
    </ul>

    <!-- 全部 -->
    <div class="dl_order_con">
        <?php foreach ($order_1 as $k1 => $v1) { ?>
            <div class="dl_order_list">
                <div class="jui_pad_1216 jui_flex_row_center jui_flex_justify_between jui_bor_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['order_addtime']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待發貨</p>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_express_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待收貨</p>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">已完成</p>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shouhou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">售後</p>
                    <?php } ?>
                </div>

                <div class="jui_pad_l16 jui_pad_r16 jui_pad_t12 jui_flex_row_center">
                    <p class="iconfont jui_fc_zhuse jui_fs18">&#xe64b;</p>
                    <p class="jui_pad_l12 jui_fc_000"><?php echo $v1['o_name']; ?>
                        <span class="jui_pad_l8"><?php echo $v1['o_tel']; ?></span>
                    </p>
                </div>
                <a href="?m=agent&c=agent_ordercon&o_id=<?php echo $v1['o_id'];?>">
                    <div class="jui_pad_1216 jui_flex">
                        <div class="dl_order_img"><img src="<?php echo $v1['p_cover']; ?>"></div>
                        <div class="jui_flex1 jui_flex_col">
                            <p class="jui_pad_b5"><?php echo $v1['p_title']; ?></p>
                            <div class="jui_flex_row_center jui_flex_justify_between">
                                <p class="jui_fc_red"><?php echo $v1['p_price']; ?></p>
                                <p>×<?php echo $v1['p_num']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dl_order_shop_total">共<?php echo $v1['p_num']; ?>件商品&nbsp;&nbsp;合計¥<span
                            class="jui_fs15"><?php echo $v1['order_sum_price']; ?></span>
                </div>
                <input type="hidden" id="o_id" name="o_id" value="<?php echo $v1['o_id'];?>">
                <div class="jui_flex_row_center jui_flex_justify_end dl_order_shop_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <div class="dl_order_btn">待發貨</div>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <div class="dl_order_btn">待收貨</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none ConfirmShop">確認收貨</div>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none AfterSale">售後</div>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- 全部end -->

    <!-- 待發貨 -->
    <div class="dl_order_con jui_none">
        <?php foreach ($order_2 as $k1 => $v1) { ?>
            <div class="dl_order_list">
                <div class="jui_pad_1216 jui_flex_row_center jui_flex_justify_between jui_bor_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['order_addtime']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待發貨</p>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_express_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待收貨</p>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">已完成</p>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shouhou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999 ">售後</p>
                    <?php } ?>
                </div>

                <div class="jui_pad_l16 jui_pad_r16 jui_pad_t12 jui_flex_row_center">
                    <p class="iconfont jui_fc_zhuse jui_fs18">&#xe64b;</p>
                    <p class="jui_pad_l12 jui_fc_000"><?php echo $v1['o_name']; ?>
                        <span class="jui_pad_l8"><?php echo $v1['o_tel']; ?></span>
                    </p>
                </div>
                <a href="?m=agent&c=agent_ordercon&o_id=<?php echo $v1['o_id'];?>">
                    <div class="jui_pad_1216 jui_flex">
                        <div class="dl_order_img"><img src="<?php echo $v1['p_cover']; ?>"></div>
                        <div class="jui_flex1 jui_flex_col">
                            <p class="jui_pad_b5"><?php echo $v1['p_title']; ?></p>
                            <div class="jui_flex_row_center jui_flex_justify_between">
                                <p class="jui_fc_red"><?php echo $v1['p_price']; ?></p>
                                <p>×<?php echo $v1['p_num']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dl_order_shop_total">共<?php echo $v1['p_num']; ?>件商品&nbsp;&nbsp;合計¥<span
                            class="jui_fs15"><?php echo $v1['order_sum_price']; ?></span>
                </div>
                <input type="hidden" id="o_id" name="o_id" value="<?php echo $v1['o_id'];?>">
                <div class="jui_flex_row_center jui_flex_justify_end dl_order_shop_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <div class="dl_order_btn">待發貨</div>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <div class="dl_order_btn">待收貨</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none ConfirmShop">確認收貨</div>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none AfterSale">售後</div>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- 待發貨end -->

    <!-- 待收貨 -->
    <div class="dl_order_con jui_none">
        <?php foreach ($order_3 as $k1 => $v1) { ?>
            <div class="dl_order_list">
                <div class="jui_pad_1216 jui_flex_row_center jui_flex_justify_between jui_bor_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['order_addtime']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待發貨</p>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_express_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待收貨</p>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">已完成</p>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shouhou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">售後</p>
                    <?php } ?>
                </div>

                <div class="jui_pad_l16 jui_pad_r16 jui_pad_t12 jui_flex_row_center">
                    <p class="iconfont jui_fc_zhuse jui_fs18">&#xe64b;</p>
                    <p class="jui_pad_l12 jui_fc_000"><?php echo $v1['o_name']; ?>
                        <span class="jui_pad_l8"><?php echo $v1['o_tel']; ?></span>
                    </p>
                </div>
                <a href="?m=agent&c=agent_ordercon&o_id=<?php echo $v1['o_id'];?>">
                    <div class="jui_pad_1216 jui_flex">
                        <div class="dl_order_img"><img src="<?php echo $v1['p_cover']; ?>"></div>
                        <div class="jui_flex1 jui_flex_col">
                            <p class="jui_pad_b5"><?php echo $v1['p_title']; ?></p>
                            <div class="jui_flex_row_center jui_flex_justify_between">
                                <p class="jui_fc_red"><?php echo $v1['p_price']; ?></p>
                                <p>×<?php echo $v1['p_num']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dl_order_shop_total">共<?php echo $v1['p_num']; ?>件商品&nbsp;&nbsp;合計¥<span
                            class="jui_fs15"><?php echo $v1['order_sum_price']; ?></span>
                </div>
                <input type="hidden" id="o_id" name="o_id" value="<?php echo $v1['o_id'];?>">
                <div class="jui_flex_row_center jui_flex_justify_end dl_order_shop_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <div class="dl_order_btn">待發貨</div>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <div class="dl_order_btn">待收貨</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none ConfirmShop">確認收貨</div>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none AfterSale">售後</div>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- 待收貨end -->

    <!-- 售後 -->
    <div class="dl_order_con jui_none">
        <?php foreach ($order_4 as $k1 => $v1) { ?>
            <div class="dl_order_list">
                <div class="jui_pad_1216 jui_flex_row_center jui_flex_justify_between jui_bor_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['order_addtime']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待發貨</p>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_express_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">待收貨</p>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">已完成</p>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <p class="jui_fs12"><?php echo date('Y-m-d H:i', $v1['o_shouhou_time']); ?></p>
                        <p class="jui_fs12 jui_fc_999">售後</p>
                    <?php } ?>
                </div>

                <div class="jui_pad_l16 jui_pad_r16 jui_pad_t12 jui_flex_row_center">
                    <p class="iconfont jui_fc_zhuse jui_fs18">&#xe64b;</p>
                    <p class="jui_pad_l12 jui_fc_000"><?php echo $v1['o_name']; ?>
                        <span class="jui_pad_l8"><?php echo $v1['o_tel']; ?></span>
                    </p>
                </div>
                <a href="?m=agent&c=agent_ordercon&o_id=<?php echo $v1['o_id'];?>">
                    <div class="jui_pad_1216 jui_flex">
                        <div class="dl_order_img"><img src="<?php echo $v1['p_cover']; ?>"></div>
                        <div class="jui_flex1 jui_flex_col">
                            <p class="jui_pad_b5"><?php echo $v1['p_title']; ?></p>
                            <div class="jui_flex_row_center jui_flex_justify_between">
                                <p class="jui_fc_red"><?php echo $v1['p_price']; ?></p>
                                <p>×<?php echo $v1['p_num']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dl_order_shop_total">共<?php echo $v1['p_num']; ?>件商品&nbsp;&nbsp;合計¥<span
                            class="jui_fs15"><?php echo $v1['order_sum_price']; ?></span>
                </div>
                <input type="hidden" id="o_id" name="o_id" value="<?php echo $v1['o_id'];?>">
                <div class="jui_flex_row_center jui_flex_justify_end dl_order_shop_bottom">
                    <?php if ($v1['o_status'] == 0) { ?>
                        <div class="dl_order_btn">待發貨</div>
                    <?php } elseif ($v1['o_status'] == 1) { ?>
                        <div class="dl_order_btn">待收貨</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none ConfirmShop">確認收貨</div>
                    <?php } elseif ($v1['o_status'] == 2) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                        <div class="dl_order_btn jui_bg_zhuse jui_fc_fff jui_bor_none AfterSale">售後</div>
                    <?php } elseif ($v1['o_status'] == 3) { ?>
                        <div class="dl_order_btn DelOrder">刪除訂單</div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- 售後 end-->
</div>
<!-- 主體end -->
</body>
<script type="text/javascript">
    $(document).ready(function () {
        //Tab選項卡
        $(".jui_tab_tit li").click(function () {
            $(this).siblings().removeClass("jui_tab_on");
            $(this).addClass("jui_tab_on");
            hIndex = $(this).index();
            hparent = $(this).parent(".jui_tab_tit");
            hparent.siblings(".dl_order_con").addClass("jui_none");
            hparent.siblings(".dl_order_con").eq(hIndex).removeClass("jui_none");
        });
    });
    $(".ConfirmShop").click(function () {
        var o_id = $(this).parents(".dl_order_shop_bottom").siblings("#o_id").val();
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
        var o_id = $(this).parents(".dl_order_shop_bottom").siblings("#o_id").val();
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
        var o_id = $(this).parents(".dl_order_shop_bottom").siblings("#o_id").val();
        $.post('?m=agent&c=del_order', {'o_id': o_id}, function (res) {
            layer.msg(res.msg);
            if(res.code == 1){
                setTimeout(function () {
                    window.location.reload();
                },'1000')
            }

        }, 'json');
    });

    function inputOnBlur() {
        var hot_search = $('#jui_flex1').val();
        if(hot_search != ''){
            window.location.href = '?m=agent&c=agent_order&hot_search='+hot_search;
        }else{
            window.location.href = '?m=agent&c=agent_order';
        }
    }

</script>
</html>
