<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
    <?php include 'common.header.php'; ?>
    <style>
        .shop_list {
            border-bottom: 1px solid #eee;
            padding: .4266rem 0px;
        }

        .shop_img {
            box-shadow: 0 0 8px #f5f5f5;
        }
    </style>
</head>
<body class="jui_bg_grey">
<div class="jui_top_bar">
    <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle"><?php echo $cate_name; ?></div>
</div>
<!-- 店鋪推薦 -->
<div class="jui_bg_fff">
    <div class="jui_shop_con jui_pad_l16 jui_pad_r16">

    </div>
</div>
<!-- 店鋪推薦end -->
<script>
    function getScrollTop() {
        var scrollTop = 0;
        if (document.documentElement && document.documentElement.scrollTop) {
            scrollTop = document.documentElement.scrollTop;
        } else if (document.body) {
            scrollTop = document.body.scrollTop;
        }
        return scrollTop;
    }

    function getClientHeight() {
        var clientHeight = 0;
        if (document.body.clientHeight && document.documentElement.clientHeight) {
            clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
        } else {
            clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
        }
        return clientHeight;
    }

    function getScrollHeight() {
        return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    }

    var s_type =<?php echo $typeid;?>;
    var s_hot = 0;
    var page = 1;
    var limit = 10;
    var lock = 1;

    function load_html(result) {
        var lists = result;
        if (lists.length > 0) {
            for (i = 0, ii = lists.length; i < ii; i++) {
                var tmp_html = '';
                var tmp_data = lists[i];
                if (tmp_data.avatar == false || tmp_data.avatar == '') {
                    tmp_data.avatar = '/public/image/tx.jpg';
                }
                tmp_html = tmp_html + '<a href="?m=shop&c=shop&id=' + tmp_data.id + '" class="shop_list jui_flex">';
                tmp_html = tmp_html + '    <div class="shop_img"><img src="' + tmp_data.s_img + '" alt=""></div>';
                tmp_html = tmp_html + '    <div class="jui_flex1 jui_flex_col">';
                tmp_html = tmp_html + '         <div class="jui_flex_row_center jui_pad_b5">';
                tmp_html = tmp_html + '         <div class="jui_flex1 jui_flex_row_center">';
                tmp_html = tmp_html + '              <img class="shop_tx" src="' + tmp_data.avatar + '" alt="土包子的店鋪">';
                tmp_html = tmp_html + '              <p class="jui_fc_000">' + tmp_data.s_name + '</p>';
                tmp_html = tmp_html + '         </div>';
                if (tmp_data.s_hot) {
                    tmp_html = tmp_html + '<p class="jui_fc_red">薦</p>';
                }
                tmp_html = tmp_html + '       </div>';
                tmp_html = tmp_html + '       <p class="jui_ellipsis_3 jui_fs12 jui_fc_999">' + tmp_data.s_info + '</p>';
                tmp_html = tmp_html + '        <p class="jui_pad_t8 jui_fs12">瀏覽量：' + tmp_data.s_read + '</p>';
                tmp_html = tmp_html + '    </div>';
                tmp_html = tmp_html + '</a>';
                $('.jui_shop_con').append(tmp_html);
            }
            if (lists.length < limit) {
                $('.jui_shop_con').append('<p align="center" class="jui_pad_16 jui_fc_000">- 加載完成 -</p>');
            } else {
                lock = 0;//解除加載鎖
            }
        } else {
            $('.jui_shop_con').append('<p align="center" class="jui_pad_16 jui_fc_000">- 加載完成 -</p>');
        }
    }

    function load_url() {
        var url = '?m=shop&c=fetch&page=' + page + '&s_type=' + s_type + '&s_hot=' + s_hot + '&limit=' + limit;
        $.get(url, function (ret) {
            load_html(ret);
        }, 'json');
    }

    $(function () {
        $(window).scroll(function () {
            var sH = getScrollHeight();
            var sT = getScrollTop();
            var cH = getClientHeight();
            if (sH - cH - sT < 50) {
                if (lock == 0) {
                    lock = 1;//防止重復加載
                    page = page + 1;
                    load_url();
                }
            }
            console.log(sH + ',' + sT + ',' + cH);
        });
        load_url();
    });
</script>

<?php include 'common.footer.php'; ?>
<!-- 固定底部end -->
</body>
</html>
