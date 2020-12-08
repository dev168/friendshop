<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">修改密碼</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<form action="">
<div class="jui_bg_fff">
     <div class="jui_public_list jui_flex_justify_between">
         <p class="mima_left">原密碼</p>
         <input class="jui_flex1" type="text" placeholder="原密碼" id="o_pass">
     </div>
     <div class="jui_public_list jui_flex_justify_between">
         <p class="mima_left">新密碼</p>
         <input class="jui_flex1" type="password" placeholder="新密碼" id="n_pass1">
     </div>
     <div class="jui_public_list jui_flex_justify_between">
         <p class="mima_left">確認新密碼</p>
         <input class="jui_flex1" type="password" placeholder="確認新密碼" id="n_pass2">
     </div>
</div>
<div class="jui_public_btn"><input type="button" value="保存"></div>
</form>
<script language="javascript">
$(function(){
	$('.jui_public_btn').click(function(){
		var o_pass	=$('#o_pass').val();
		var n_pass1	=$('#n_pass1').val();
		var n_pass2	=$('#n_pass2').val();
		if(o_pass=='' || o_pass.length<6){
			layer.msg('請輸入原密碼,最低六位');return;
		}
		if(n_pass1=='' || n_pass1.length<6){
			layer.msg('請輸入新密碼,最低六位');return;
		}
		if(n_pass2=='' || n_pass2.length<6){
			layer.msg('請確認新密碼,最低六位');return;
		}
		if(n_pass1!=n_pass2){
			layer.msg('兩次密碼輸入不壹致');return;
		}
		$.post("?m=user&c=repass",{o_pass:o_pass,n_pass:n_pass1},function(ret){
			if(ret.code==1){
				layer.msg(ret.msg,{icon:1,time:1000},function(){
					window.location.href='?m=user&c=index';
				});
			}else{
				layer.msg(ret.msg);
			}
		},'json');
	});
});
</script>
</body>
</html>

