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
     <a class="jui_top_left" href="?m=user&c=index"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">留言反饋</div>
     <a href="?m=user&c=mlogs" class="jui_top_right jui_fc_fff">反饋記錄</a>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<form id="setform" name="setform">
<div class="jui_h12"></div>
<div class="jui_bg_fff">
     <div class="jui_public_list jui_flex_justify_between">
         <p>手機/LINE</p>
         <input class="jui_flex1 jui_text_right" type="text" placeholder="對方手機或LINE號" name="m_title" id="m_title">
     </div>
     <div class="jui_public_list jui_flex_justify_between">
         <p>投訴類型</p>
         <select class="jui_flex1 jui_pad_r12" dir="rtl" name="m_type">
         	<?php
            	foreach($this->suit_type as $k=>$v){
					echo '<option value="'.$k.'">'.$v.'</option>';
				}
			?>
         </select>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </div>
</div>
<div class="jui_h12"></div>
<textarea class="lyfk_textarea" name="m_infos" cols="" rows="3" id="m_infos" placeholder="請詳細描述您的投訴內容"></textarea>
<div class="jui_public_btn"><input type="button" value="提交"></div>
</form>
<script language="javascript">
$(function(){
	$('.jui_public_btn').click(function(){
		var m_title	 = $('#m_title').val();
		if(m_title.trim()==''){
			layer.msg('請填寫您要投訴的手機/LINE');return;
		}
		var m_infos	 = $('#m_infos').val();
		if(m_infos.trim()==''){
			layer.msg('請填寫詳細投訴內容');return;
		}
		var xxx= new FormData(document.querySelector("form"));
		$.ajax('?m=user&c=message', {method: 'POST',data: xxx,processData: false,contentType: false,
		  success: function (data) {
			if(data.code==1){
				layer.msg(data.msg,{icon:1,time:1000},function(){
					window.location.href='?m=user&c=mlogs';	
				});	
			}else{
				layer.msg(data.msg);
			}
		  },dataType:'json'
		});
	});
});
</script>
<?php include 'common.footer.php';?>
</body>
</html>
