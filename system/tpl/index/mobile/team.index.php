<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<link rel="stylesheet" type="text/css" href="/public/css/diqu.css">
<script src="/public/js/picker.min.js"></script>
<script src="/public/js/city.js?v=3.1.9"></script>
<script language="javascript">
$(function () {
	<?php if($setting){ ?>layer.msg('請先完善個人信息', function () {window.location.href = "?m=user&c=setting";});<?php }?>
	<?php if($user['m_level'] < 1){?>layer.msg('您的級別過低,請升級後使用', function () {window.location.href = "?m=user&c=uplevel";});<?php }?>
	<?php if($user['m_qrcode'] == ''){ ?>layer.msg('請先上傳LINE二維碼', function () {window.location.href = "?m=user&c=qrcode";});<?php }?>
});
</script>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<form name="search" id="search">
  <div class="jui_top_bar">
    <div class="rm_search jui_bor_rad_5 jui_flex1 jui_flex_row_center"> <span class="iconfont">&#xe618;</span>
      <input class="jui_flex1" style="line-height:.8rem;" type="search" value="" placeholder="搜索您的人脈" id="s_key">
    </div>
  </div>
</form>
<!-- 頭部end -->
<!-- 主體 -->
<div class="jui_bg_fff rm_tit_bar jui_flex_row_center">
  <div class="jui_flex1 jui_flex_row_center jui_flex_justify_between jui_pad_l12 jui_pad_r12 jui_bor_right">
    <div id="sel_city" class="jui_flex1 jui_pad_r5 jui_ellipsis_1">請選擇地區</div>
    <img class="jui_arrow_rimg" src="/public/icon/jt_right.png"> </div>
  <div class="jui_flex1 jui_flex_row_center jui_flex_justify_between jui_pad_l12 jui_pad_r12 jui_bor_right">
    <select id="m_hang">
      <option value="0">不限</option>
      <?php
            foreach ($u_cates as $row) {
                echo '<option value="' . $row['id'] . '">' . $row['c_name'] . '</option>';
            }
        ?>
    </select>
    <img class="jui_arrow_rimg" src="/public/icon/jt_right.png"> </div>
  <div class="jui_flex1 jui_flex_row_center jui_flex_justify_between jui_pad_l12 jui_pad_r12">
    <select id="m_gender">
      <option value="0">不限</option>
      <option value="1">男</option>
      <option value="2">女</option>
    </select>
    <img class="jui_arrow_rimg" src="/public/icon/jt_right.png"> </div>
</div>
<div class="jui_public_tit jui_fc_000">您當前已解鎖<span class="jui_fc_zhuse jui_pad_l5 jui_pad_r5"><?php echo $user['m_level']; ?></span>度人脈</div>
<div class="jui_bg_fff" id="rm_con">
</div>
<!-- 主體end -->
<!-- 彈出框 -->
<div class="jui_box_bar jui_none" id="box_bar2"></div>
<!-- 彈出框end -->
<?php include 'common.footer.php'; ?>
<script src="/public/js/cityjs_cb.js"></script>
<script language="javascript">
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
    var region = '';
    var s_key = '';
    var m_hang = 0;
    var m_gender = 0;
    var page = 1;
    var limit = 20;
    var lock = 1;
    function load_html(result) {
        var lists = result;
        if (lists.length > 0) {
            for (i = 0, ii = lists.length; i < ii; i++) {
                var tmp_html = '';
                var tmp_data = lists[i];
                if(tmp_data.m_avatar == false || tmp_data.m_avatar == '' ){
                    tmp_data.m_avatar = '/public/image/tx.jpg';
                }
                tmp_html = tmp_html + '<div class="jui_public_list2">';
                tmp_html = tmp_html + '<div class="rm_tx"><img src="' + tmp_data.m_avatar + '" alt=""></div>';
                tmp_html = tmp_html + '<div class="jui_flex1 jui_pad_l12 jui_pad_r20">';
                tmp_html = tmp_html + '<p class="jui_fc_000">' + tmp_data.m_name + '</p>';
                tmp_html = tmp_html + '<P class="jui_fc_999 ellipsis_2">' + tmp_data.m_infos + '</P>';
                tmp_html = tmp_html + '</div>';
				if(tmp_data.m_qrcode!=''){
                	tmp_html = tmp_html + '<div class="rm_ewm" id="' + tmp_data.m_phone + '"><img src="/public/image/ewm.png"></div>';
				}
                tmp_html = tmp_html + '</div>';
                $('#rm_con').append(tmp_html);
            }
            if (lists.length < limit) {
                $('#rm_con').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');
            } else {
                lock = 0;//解除加載鎖
            }
        } else {
            $('#rm_con').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');
        }
    }
    function load_url() {
        var url = '?m=team&c=fetch&page=' + page + '&s_hang=' + m_hang + '&s_gender=' + m_gender + '&s_region=' + encodeURI(region) + '&s_key=' + encodeURI(s_key) + '&limit=' + limit;
        $.get(url, function (ret) {
            load_html(ret);
        }, 'json');
    }
    function call_city() {
        region = $('#sel_city').html();
        if (region.trim() == '請選擇地區') {
            region = '';
        }
        m_hang = $('#m_hang').val();
        m_gender = $('#m_gender').val();
        s_key = $('#s_key').val();
        page = 1;
        $('#rm_con').html('');
        load_url();
    }
    $(document).ready(function () {
        $(document).on("click", ".rm_ewm", function () {
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
        $('#m_hang').change(function () {
            call_city();
        });
        $('#m_gender').change(function () {
            call_city();
        });
        $('#search').on('submit', function () {
            event.preventDefault();
            call_city();
        });
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
</body>
</html>
