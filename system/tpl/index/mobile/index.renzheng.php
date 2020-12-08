<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <?php include 'common.header.php'; ?>
    <script src="/public/js/upload_img2.js"></script>
    <!-- <style>
         .codeMsg{width: 92%;margin-left: 4%;margin-top: 1rem;padding: 1.2rem;text-align: center;background: #f7f7f7;border-radius: 0.26rem;}
         .codeMsg img{width: 2.8rem;height: 2.8rem;margin-left: 30%;}
         .codeMsg p{line-height: 0.62rem;color: #999;}
     </style>-->
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar"><a class="jui_top_left" href="javascript:history.back(-1)"><img
            src="/public/icon/back_111.png"></a>
    <div class="jui_top_middle">實名認證</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe60b;</span>
    <input class="flex1" type="text" value="" placeholder="真實姓名" id="m_zsxm">
</div>
<div class="jui_h12"></div>
<div class="jui_public_list"><span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe60b;</span>
    <input class="flex1" type="number" value="" placeholder="身份證號" id="m_carid">
</div>
<div class="jui_h12"></div>
<div class="jui_bg_fff">
    <div class="jui_public_tit">身份證正面</div>
    <div class="sqdp_upimg">
        <div id="preview3">
            <img id="imghead3" border="0" src="/public/icon/sfz.png" onClick="$('#previewImg3').click();">
        </div>
        <input type="file" onChange="previewImage3(this)" style="display:none;" id="previewImg3" />
        <input type="hidden"  id="m_carimg1" name="m_carimg1" value="" />
    </div>
</div>
<div class="jui_h12"></div>
<div class="jui_bg_fff">
    <div class="jui_public_tit">身份證反面</div>
    <div class="sqdp_upimg">
        <div id="preview4">
            <img id="imghead4" border="0" src="/public/icon/sfz.png" onClick="$('#previewImg4').click();">
        </div>
        <input type="file" onChange="previewImage4(this)" style="display:none;" id="previewImg4" />
        <input type="hidden"  id="m_carimg2" name="m_carimg2" value="" />
    </div>
</div>
<div class="jui_h20"></div>
<div class="jui_pad_l20 jui_pad_r20">
    <div class="jui_public_btn login_btn">
        <input type="button" value="立即認證">
    </div>
</div>
<!-- 主體end -->
</body>
<script language="javascript">
    $('.login_btn').click(function () {
        var val_2  = $('#m_zsxm').val();
        var val_4  = $('#m_carid').val();
        var val_5 = $('#m_carimg1').val();
        var val_6 = $('#m_carimg2').val();
        var is_val_4 = isCardID(val_4);
        if (val_2 == ''){
            layer.msg('真實姓名不能為空');
            return;
        }
        if (is_val_4 !== true) {
            layer.msg(is_val_4);
            return;
        }
        if (val_5.trim() == '') {
            layer.msg('請選擇身份證正面照片');
            return;
        }
        if (val_6.trim() == '') {
            layer.msg('請選擇身份證反面照片');
            return;
        }
        $.post("?m=index&c=renzheng", {val_2:val_2,val_4: val_4, val_5: val_5, val_6: val_6}, function (ret) {
            if (ret.code == 1) {
                layer.msg(ret.msg, {icon: 1, time: 1000}, function () {
                    window.location.href = "?m=index&c=index";
                });
            } else {
                layer.msg(ret.msg);
            }
        }, 'json');

    });

    function isCardID(sId){
        var aCity ={11:"北京",12:"天津",13:"河北",14:"山西",15:"內蒙古",21:"遼寧",22:"吉林",23:"黑龍江",31:"上海",32:"江蘇",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山東",41:"河南",42:"湖北",43:"湖南",44:"廣東",45:"廣西",46:"海南",50:"重慶",51:"四川",52:"貴州",53:"雲南",54:"西藏",61:"陜西",62:"甘肅",63:"青海",64:"寧夏",65:"新疆",71:"臺灣",81:"香港",82:"澳門",91:"國外"}
        var iSum=0 ;
        var info="" ;
        if(!/^\d{17}(\d|x)$/i.test(sId)) {
            return "妳輸入的身份證長度或格式錯誤";
        }
        sId=sId.replace(/x$/i,"a");
        if(aCity[parseInt(sId.substr(0,2))]==null){
            return "妳的身份證地區非法";
        }
        sBirthday=sId.substr(6,4)+"-"+Number(sId.substr(10,2))+"-"+Number(sId.substr(12,2));
        var d=new Date(sBirthday.replace(/-/g,"/")) ;
        if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate())){
            return "身份證上的出生日期非法";
        }
        for(var i = 17;i>=0;i --){
            iSum += (Math.pow(2,i) % 11) * parseInt(sId.charAt(17 - i),11) ;
        }
        if(iSum%11!=1){
            return "妳輸入的身份證號非法";
        }
        return true;
    }
</script>
</html>
