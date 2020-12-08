<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<script language="javaScript">

	function isNumber(obj) {
		return !isNaN(parseFloat(obj)) && isFinite(obj);
	}
	function isPhoneNumber(tel) {
		var reg =/^[1][3-8]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/;
		return reg.test(tel);
	}
	function settime(num){
	var yzm_input=document.getElementById("yzm");
	var num;
	if( num==0 ){
		yzm_input.value="重新發送";
		yzm_input.removeAttribute("disabled");
		yzm_input.setAttribute("class","reg_yzminput");
		num = 60;
		return false;
		}else{
			yzm_input.setAttribute("disabled","disabled");
			yzm_input.setAttribute("class","reg_yzminput reg_disable")
			yzm_input.value=num+"s後重發";
			num--;
			}
	 setTimeout("settime("+num+")", 1000);
	}
	$(function(){
	    var logout_type=<?php if(array_key_exists('logout_type',$_GET)){ echo $_GET['logout_type']; }else{ echo 0; } ?>;
	    if(logout_type == 1){
            localStorage.removeItem('u_access');
        }
        var u_access = localStorage.getItem('u_access');
        if(u_access != null){
            $.post("?m=index&c=login",{u_access:u_access},function(){
                window.location.href="?m=index&c=index";
            },'json');
        }else{
            $('.hb_btn').click(function(){
                var verify_code=$('#verify_code').val();
                var login_phone=$('#login_phone').val();
                if(verify_code=='' || !isNumber(verify_code) || verify_code.length<6){
                    layer.msg('請輸入正確驗證碼');
                    return;
                }
                $.post("?m=index&c=checkcode",{code:verify_code,phone:login_phone},function(ret){
                    if(ret.code==1){
                        layer.msg(ret.msg);
                        settime(60);
                        $('.hb_bar').hide();
                    }else{
                        layer.msg(ret.msg);
                    }
                },'json');
            });
            $('#yzm').click(function(){
                var login_phone=$('#login_phone').val();
                if(login_phone==''){
                    layer.msg('手機號不能為空');
                    return;
                }
                if(!isPhoneNumber(login_phone)){
                    layer.msg('手機號格式不正確');
                    return;
                }
                $('#verify_code').val('');
                $('.login_yzm img').attr('src','?m=index&c=captcha&_='+Math.random())
                $('.hb_bar').show();
            })
            $('.hb_close').click(function(){
                $('.hb_bar').hide();
            });
            $('.login_btn').click(function(){
                var val_1=$('#login_phone').val();
                <?php echo $needs?'var val_2=$("#login_code").val();':'var val_2=$("#login_pass").val();';?>
                if(val_1==''){
                    layer.msg('手機號不能為空');
                    return;
                }
                if(!isPhoneNumber(val_1)){
                    layer.msg('手機號格式不正確');
                    return;
                }
                if(val_2==''){
                    layer.msg('<?php echo $needs?'驗證碼不能為空':'密碼不能為空';?>');
                    return;
                }
                $.post("?m=index&c=login",{val_1:val_1,val_2:val_2},function(ret){
                    if(ret.code==1){
                        layer.msg(ret.msg,{icon:1,time:1000},function(){
                            localStorage.setItem('u_access',ret.u_access);
                            window.location.href="?m=index&c=index";
                        });
                    }else{
                        layer.msg(ret.msg);
                    }
                },'json');

            });
        }
	});
</script>
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img class="jui_none" src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">登錄</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="login_bar">
      <div class="jui_flex_col_center logo"><img src="<?php echo $this->config['w_logo'];?>" alt="<?php echo $this->config['w_name'];?>"></div>
      <div class="jui_public_list jui_flex_justify_between">
          <div class="jui_flex1">
              <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999 jui_flex_no">&#xe613;</span>
              <input class="jui_flex1" style="max-width:4.5rem;" type="text" value="" placeholder="手機號" id="login_phone">
          </div>
           <?php
			if($needs){echo '<div class="reg_yzm"><input class="reg_yzminput fc_zs" id="yzm" type="button" value="發送驗證碼"></div>';}
		   ?>
      </div>
      <div class="jui_h12"></div>
	  <?php
	  if($needs){
	  ?>
      <div class="jui_public_list">
           <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
           <input class="flex1" type="text" value="" placeholder="驗證碼" id="login_code">
      </div>	  
	  <?php	  
	  }else{
	  ?>
      <div class="jui_public_list">
           <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
           <input class="flex1" type="password" value="" placeholder="登錄密碼" id="login_pass">
      </div>	  
	  <?php	  		  
	  }
	  ?>
      <div class="jui_h20"></div>
      <div class="jui_public_btn login_btn"><input type="button" value="立即登錄"></div>
      <div class="jui_flex jui_flex_justify_between jui_pad_t16">
          <?php
            if($this->config['w_reg']==2){
                echo '<a href="?m=index&c=register" class="jui_block jui_fs12">立即註冊</a>';
            }
          ?>
          <a href="?m=index&c=find" class="jui_block jui_fs12">忘記密碼？</a>
      </div>
</div>
<div class="hb_bar" style="display: none;">
    <div class="hb_con">
         <div class="hb_top">
              <div class="hb_money">請輸入右側驗證碼</div>
              <div class="jui_public_list jui_flex_justify_between" style="width: 100%;">
                   <input style="max-width:3rem;" type="text" value="" placeholder="驗證碼" id='verify_code' style="max-width: 2rem;">
                   <div class="login_yzm">
					   <img style="width:3rem;" src="?m=index&c=captcha" onClick="this.src='?m=index&c=captcha&_='+Math.random();">
                   </div>
              </div>
              <div class="hb_close">X</div>
         </div>
         <div class="hb_btn">立即發送</div>
    </div>
</div>
<!-- 主體end -->
</body>
</html>
