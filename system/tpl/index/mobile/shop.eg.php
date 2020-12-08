<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link media="all" rel="stylesheet" type="text/css" href="/public/assets/styles/simditor.css" />
    <link media="all" rel="stylesheet" type="text/css" href="/public/assets/styles/mobile.css" />
    <?php include 'common.header.php'; ?>
    <script src="/public/js/pro_upload.js"></script>
    <script type="text/javascript" src="/public/assets/scripts/module.js"></script>
    <script type="text/javascript" src="/public/assets/scripts/uploader.js"></script>
    <script type="text/javascript" src="/public/assets/scripts/hotkeys.js"></script>
    <script type="text/javascript" src="/public/assets/scripts/simditor.js"></script>
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
        .edui-editor-breadcrumb {
            display: none;
        }
    </style>
    <script>
        $(function(){
            var $preview, editor, mobileToolbar, toolbar;
            Simditor.locale  = 'zh-CN';
            toolbar			 = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'image', 'hr',  'indent', 'outdent', 'alignment'];
            editor = new Simditor({
                textarea: $('#txt-content'),
                placeholder: '這裏輸入文字...',
                toolbar: toolbar,
                imageButton:'upload',
                upload: {
                    url: '/index.php?m=user&c=shopfile'
                }
            });

            $('.jui_public_btn').click(function(){
                var xxx= new FormData(document.querySelector("form"));
                var previewImg	=$('#previewImg').val();
                if(previewImg.trim()==''){
                    xxx.append("g_pic","<?php echo $goods['g_pic']; ?>");
                }
                xxx.append("g_content",editor.getValue());
                $.ajax('?m=shop&c=eg&g_id=<?php echo $_GET['g_id'];?>', {
                    method: 'POST',
                    data: xxx,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.code==1){
                            layer.msg(data.msg,{icon:1,time:1000},function(){
                                window.location.href='?m=shop&c=myshop';
                            });
                        }else{
                            layer.msg(data.msg);
                        }
                    },dataType:'json'
                });
            });
        });
    </script>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar jui_top_fixed">
    <a class="jui_top_left" href="?m=shop&c=myshop"><img src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">修改商品</div>
</div>
<!-- 頭部end -->
<div class="jui_htop"></div>
<!-- 主體 -->
<form action="">
    <div class="jui_bg_fff">
        <div class="jui_public_list">
            <p class="jui_flex_no jui_pad_r8"></p>
            <input class="jui_flex1" name="g_title" type="text" value="<?php echo $goods['g_title']; ?>" placeholder="請輸入產品名稱">
        </div>
        <div class="jui_public_list jui_flex_row_center">
            <p class="jui_flex_no jui_pad_r8"></p>
            <input class="jui_flex1" name="g_price" type="number" placeholder="產品價格 （請輸入數字）" value="<?php echo $goods['g_price']; ?>">
        </div>
    </div>
    <div class="jui_h12"></div>
    <div class="jui_bg_fff">
        <div class="jui_public_tit">上傳主圖</div>
        <div class="addpro_upimg">
            <div id="addpro_preview">
                <img id="imghead" border="0" src="<?php echo $goods['g_pic']; ?>" onClick="$('#previewImg').click();">
            </div>
            <input type="file" onChange="previewImage(this)" style="display:none;" id="previewImg" name="g_pic" value="1"/>

        </div>
    </div>
    <div class="jui_h12"></div>
    <!-- 富文本 -->
    <div class="jui_bg_fff">
        <div class="jui_public_tit">編輯內容</div>
        <!-- 富文本 -->
        <div class="edit_con">
            <textarea id="txt-content" name="g_content" data-autosave="editor-content" autofocus required style="height: 50rem;"><?php echo $goods['g_content'];?></textarea>
        </div>
    </div>
    <!-- 富文本end -->
    <div class="jui_public_btn">
        <input type="button" value="立即發布">
    </div>
</form>
<!-- 主體end -->
</body>
</html>
