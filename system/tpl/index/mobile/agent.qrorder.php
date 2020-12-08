<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/diqu.css">
    <?php include 'common.header.php';?>
    <script src="/public/js/picker.min.js"></script>
    <script src="/public/js/city.js"></script>
    <script src="/public/layer/layer.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">確認訂單</div>
</div>
<!-- 頭部end -->
<form action="">
    <!-- 填寫地址 -->
    <div class="jui_public_tit jui_fc_000 jui_font_weight">填寫收貨地址</div>
    <div class="jui_bg_fff">
        <div class="jui_public_list">
            <input class="jui_flex1" name="o_name" type="text" value="" placeholder="收貨人姓名" id="o_name">
        </div>
        <div class="jui_public_list">
            <input class="jui_flex1" name="o_tel" type="tel" value="" placeholder="收貨人手機號" id="o_tel">
        </div>
        <div class="jui_public_list">
            <div class="shop_left">所在地區</div>
            <a class="jui_flex1 jui_text_right jui_pad_r12" href="javascript:void(0)" id="sel_city">請選擇</a>
            <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
        </div>
        <div class="sqdp_textarea">
            <textarea name="o_city2" cols="" rows="3" placeholder="詳細收貨地址" id="o_city2"></textarea>
        </div>
    </div>
    <!-- 填寫地址end -->
    <div class="jui_h12"></div>
    <!-- 主體 -->
    <div class="jui_flex jui_bg_fff jui_pad_16 jui_bor_bottom">
        <img class="daili_qrdd_img" src="<?php echo $product['p_cover']; ?>">
        <div class="jui_flex_col">
            <p><?php echo $product['p_title']; ?></p>
            <p class="fc_red pad_t_5 qrdd_price">
                ¥<span><?php echo $p_a_price; ?></span>
            </p>
        </div>
    </div>
    <div class="jui_flex_row_center jui_flex_justify_between jui_bg_fff jui_pad_16">
        <p>購買數量</p>
        <div class="daili_buy_jj jui_flex_row_center">
            <i class="min">-</i>
            <input class="text_box" name="p_num" type="text" value="1"  readonly>
            <i class="add">+</i>
        </div>
    </div>
    <!-- 主體end -->

    <!-- 新增客服-->
<!--        <a href="#" class="iconfont index_xfkf jui_bg_zhuse" target="_blank">&#xe63e;</a>-->
    <!-- 新增客服end-->

    <div class="h60"></div>
    <!-- 底部 -->
    <div class="jui_footer jui_flex_justify_between jui_pad_l16">
        <div class="jui_flex_row_center">
            <p>合計：</p>
            <p class="jui_fc_red">
                ¥<span class="jui_fs15" id="total"><?php echo $p_a_price; ?></span>
            </p>
        </div>
        <div class="daili_qrdd_btn jui_bg_zhuse">提交訂單</div>
    </div>
</form>
<!-- 底部end -->
</body>
<script src="/public/js/cityjs.js"></script>
<script>
    $(document).ready(function () {
        //確認訂單合計
        $(".add").click(function () {
            var t = $(this).parent().find('input[class*=text_box]');
            t.val(parseInt(t.val()) + 1)
            setTotal();
        })
        $(".min").click(function () {
            var t = $(this).parent().find('input[class*=text_box]');
            t.val(parseInt(t.val()) - 1)
            if (parseInt(t.val()) < 1) {
                t.val(1);
            }
            setTotal();
        })

        function setTotal() {
            var a = $(".qrdd_price span").html();
            var t = $(".text_box").val();
            var c = t * a;

            $("#total").html(c.toFixed(2));
        }

        setTotal();
    });

    function isPhoneNumber(tel) {
        var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        return reg.test(tel);
    }

    $('.jui_bg_zhuse').click(function () {
        var o_name = $('#o_name').val();
        if (o_name.trim() == '') {
            layer.msg('請輸入收貨人的姓名');
            return;
        }
        var  o_tel = $('#o_tel').val();
        if (o_tel.trim() == '') {
            layer.msg('請輸入收貨人的電話');
            return;
        }
        if (!isPhoneNumber(o_tel)) {
            layer.msg('電話號格式有誤');
            return;
        }
        var region	 = $('#sel_city').html();
        if(region.trim()=='' || region.trim()=='請選擇'){
            layer.msg('請選擇地區');return;
        }
        var o_city2 = $('#o_city2').val();
        if (o_city2.trim() == '') {
            layer.msg('請輸入詳細地址');
            return;
        }
        var sum_price = $("#total").html();
        var xxx = new FormData(document.querySelector("form"));
        xxx.append("o_city1",region.trim());
        xxx.append("order_sum_price",sum_price.trim());
        $.ajax('?m=agent&c=agent_qrorder&p_id=<?php echo $p_id; ?>', {
            method: 'POST',
            data: xxx,
            processData: false,
            contentType: false,
            success: function (data){
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                        window.location.href = '?m=agent&c=agent_order';
                    });
                }else{
                    layer.msg(data.msg);
                }
            }, dataType: 'json'
        });
    });
</script>
</html>
