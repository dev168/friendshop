<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/public/css/diqu.css">
    <script src="/public/js/upload_img2.js"></script>
    <script src="/public/js/picker.min.js"></script>
    <script src="/public/js/city.js?v=1.5.9"></script>
    <?php include 'common.header.php'; ?>
    <style>
        input[placeholder], [placeholder], *[placeholder], textarea[placeholder] {
            color: #666;
        }

        input::-webkit-input-placeholder {
            color: #666;
        }

        input:-moz-placeholder {
            color: #666;
        }

        input::-moz-placeholder {
            color: #666;
        }

        input:-ms-input-placeholder {
            color: #666;
        }
    </style>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar jui_top_fixed">
    <a class="jui_top_left" href="?m=shop&c=myshop"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">商戶入駐</div>
</div>
<!-- 頭部end -->
<div class="jui_htop"></div>
<!-- 主體 -->
<form action="">
    <div class="jui_bg_fff">
        <div class="jui_public_list">
            <input class="jui_flex1" type="text" value="" placeholder="店鋪名稱" name="s_name" id="s_name">
        </div>
        <div class="jui_public_list jui_flex_justify_between">
            <p>所屬行業</p>
            <select class="jui_flex1 jui_bg_fff jui_pad_r12" dir="rtl" name="s_type" id="s_type">
                <?php
                foreach ($u_cates as $row) {
                    if ($user['m_hang'] == $row['id']) {
                        echo '<option value="' . $row['id'] . '" selected>' . $row['c_name'] . '</option>';
                    } else {
                        echo '<option value="' . $row['id'] . '">' . $row['c_name'] . '</option>';
                    }
                }
                ?>
            </select>
            <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
        </div>
        <div class="sqdp_textarea">
            <textarea name="s_info" id="s_info" cols="" rows="3" placeholder="商戶簡介 60字以內"></textarea>
        </div>
    </div>
    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_list">
            <div class="shop_left">店鋪地址</div>
            <a class="jui_flex1 jui_text_right jui_pad_r12" href="javascript:void(0)" id="sel_city">請選擇</a>
            <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
        </div>
        <div class="sqdp_textarea">
            <textarea name="s_address" id="s_address" cols="" rows="3" placeholder="店鋪詳細地址"></textarea>
        </div>
    </div>

    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_tit">上傳主圖</div>
        <div class="sqdp_upimg">
            <div id="preview">
                <img id="imghead" border="0" src="/public/icon/upimg1.jpg" onClick="$('#previewImg').click();">
            </div>
            <input type="file" onChange="previewImage(this)" style="display:none;" id="previewImg" name="s_img"/>

        </div>
    </div>
    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_tit">營業執照</div>
        <div class="sqdp_upimg">
            <div id="preview2">
                <img id="imghead2" border="0" src="/public/icon/upimg2.jpg" onClick="$('#previewImg2').click();">
            </div>
            <input type="file" onChange="previewImage2(this)" style="display:none;" id="previewImg2" name="s_zhizhao"/>
        </div>
    </div>
    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_tit">身份證正面</div>
        <div class="sqdp_upimg">
            <div id="preview3">
                <img id="imghead3" border="0" src="/public/icon/sfz.png" onClick="$('#previewImg3').click();">
            </div>
            <input type="file" onChange="previewImage3(this)" style="display:none;" id="previewImg3" name="s_idfront"/>
        </div>
    </div>
    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_tit">身份證反面</div>
        <div class="sqdp_upimg">
            <div id="preview4">
                <img id="imghead4" border="0" src="/public/icon/sfz.png" onClick="$('#previewImg4').click();">
            </div>
            <input type="file" onChange="previewImage4(this)" style="display:none;" id="previewImg4" name="s_idback"/>
        </div>
    </div>
    <div class="jui_public_btn">
        <input type="button" value="保存">
    </div>
</form>
<script src="/public/js/cityjs.js"></script>
<script language="JavaScript">
    function call_city() {
        var region = $('#sel_city').html();
        $('#region').val(region.trim());
    }

    $(function () {
        $('.jui_public_btn').click(function () {
            var region = $('#sel_city').html();
            if (region.trim() == '' || region.trim() == '請選擇') {
                layer.msg('請選擇地區');
                return;
            }
            var s_name = $('#s_name').val();
            if (s_name.trim() == '') {
                layer.msg('請填寫商戶名稱');
                return;
            }
            var s_info = $('#s_info').val();
            if (s_info.trim() == '') {
                layer.msg('請填寫商戶簡介');
                return;
            }
            var s_address = $('#s_address').val();
            if (s_address.trim() == '') {
                layer.msg('請填寫詳細地址');
                return;
            }
            var previewImg = $('#previewImg').val();
            if (previewImg.trim() == '') {
                layer.msg('請選擇商戶主圖');
                return;
            }
            var previewImg2 = $('#previewImg2').val();
            if (previewImg2.trim() == '') {
                layer.msg('請選擇營業執照照片');
                return;
            }
            var previewImg3 = $('#previewImg3').val();
            if (previewImg3.trim() == '') {
                layer.msg('請選擇身份證正面照片');
                return;
            }
            var previewImg4 = $('#previewImg4').val();
            if (previewImg4.trim() == '') {
                layer.msg('請選擇身份證反面照片');
                return;
            }
            var xxx = new FormData(document.querySelector("form"));
            xxx.append("s_region", region.trim());
            $.ajax('?m=shop&c=apply', {
                method: 'POST', data: xxx, processData: false, contentType: false,
                success: function (data) {
                    if (data.code == 1) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = '?m=shop&c=myshop';
                        });
                    } else {
                        layer.msg(data.msg);
                    }
                }, dataType: 'json'
            });
        });
    });

</script>
<!-- 主體end -->
</body>
</html>
