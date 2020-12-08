<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<script language="javascript">
	function isNumber(obj) {
		return !isNaN(parseFloat(obj)) && isFinite(obj);
	}
	function isPhoneNumber(tel) {
		var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
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
		$('.hb_btn').click(function(){
			var verify_code	=$('#verify_code').val();
			var login_phone	=$('#r_phone').val();
			if(verify_code=='' || !isNumber(verify_code) || verify_code.length<6){
				layer.msg('請輸入正確驗證碼');
				return;
			}
			$.post("?m=index&c=checkrep",{code:verify_code,phone:login_phone},function(ret){
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
			var login_phone=$('#r_phone').val();
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
			var val_2=$('#r_phone').val();
			var val_3=$('#r_code').val();
			var val_6=$('#r_pass1').val();
			var val_7=$('#r_pass2').val();
			if(val_2==''){
				layer.msg('手機號不能為空');
				return;
			}
			if(!isPhoneNumber(val_2)){
				layer.msg('手機號格式不正確');
				return;
			}
			if(val_3==''){layer.msg('短信驗證碼不能為空');return;}
			if(val_6==''){layer.msg('新密碼不能為空');return;}
			if(val_7==''){layer.msg('確認密碼不能為空');return;}
			if(val_7!=val_6){layer.msg('兩次輸入密碼不壹致');return;}
			$.post("?m=index&c=find",{val_2:val_2,val_3:val_3,val_6:val_6,val_7:val_7},function(ret){
				if(ret.code==1){
					layer.msg(ret.msg,{icon:1,time:1000},function(){
						window.location.href="?m=index&c=login";
					});	
				}else{
					layer.msg(ret.msg);
				}
			},'json');			
			
		});
	});
</script>
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar"><a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
  <div class="jui_top_middle">註冊</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="login_bar">
  <div class="jui_h20"></div>
  <div class="jui_public_list jui_flex_justify_between">
      <div class="jui_flex1">
          <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999 jui_flex_no">&#xe613;</span>
          <input class="jui_flex1" style="max-width:4.5rem;" type="tel" value="" placeholder="手機號" id="r_phone">
      </div>
    <?php
        if($needs){echo '<div class="reg_yzm"><input class="reg_yzminput fc_zs" id="yzm" type="button" value="發送驗證碼"></div>';}
       ?>
  </div>
  <div class="jui_h12"></div>
  <?php if($needs){?>
  <div class="jui_public_list"> <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe624;</span>
    <input class="flex1" type="text" value="" placeholder="短信驗證碼" id="r_code">
  </div>
  <div class="jui_h12"></div>
  <?php	}?>
  <div class="jui_h12"></div>
  <div class="jui_public_list"> <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
    <input class="flex1" type="password" value="" placeholder="登錄密碼" id="r_pass1">
  </div>
  <div class="jui_h12"></div>
  <div class="jui_public_list"> <span class="iconfont jui_fs20 jui_pad_r12 jui_fc_999">&#xe665;</span>
    <input class="flex1" type="password" value="" placeholder="確認密碼" id="r_pass2">
  </div>
  <div class="jui_h20"></div>
<div class="jui_public_btn login_btn"><input type="button" value="立即註冊"></div>
</div>
<!-- 主體end -->
<div class="hb_bar" style="display: none;">
  <div class="hb_con">
    <div class="hb_top">
      <div class="hb_money">請輸入右側驗證碼</div>
      <div class="jui_public_list">
        <input class="flex1" type="text" value="" placeholder="驗證碼" id='verify_code'>
        <div class="login_yzm"> <img src="?m=index&c=captcha" onClick="this.src='?m=index&c=captcha&_='+Math.random();"> </div>
      </div>
      <div class="hb_close">X</div>
    </div>
    <div class="hb_btn">立即發送</div>
  </div>
</div>
</body>
</html>
