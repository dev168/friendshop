<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<style>
.ewm_top_bar{ height:3rem;}
.ewm_con_bar{ position:relative; top:-1.8rem; padding:0px 1rem; width:100%;}
.ewm_con{ background:#fff; box-shadow:0 0 8px #f5f5f5; overflow:hidden;}
.ewm_btn{ width:4.4rem; height:.96rem; line-height:.96rem; color:#fff; text-align:center; -webkit-border-radius:.48rem; border-radius:.48rem; font-size:.4rem;}
</style>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">邀請好友</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<?php
	$url='http://'.$_SERVER['HTTP_HOST'].'/?m=index&c=register&t='.$user['id'];
	if($user['m_level']>0){

?>
<div class="ewm_top_bar jui_bg_zhuse"></div>
<div class="jui_flex_col jui_flex_items_center">
    <div class="ewm_con_bar">
         <div class="ewm_con jui_bor_rad_5 jui_flex_col_center">
              <div class="jui_h20"></div>
              <h3>邀請好友</h3>
              <div class="jui_h12"></div>
              <p class="jui_fc_999">邀請好友掃描二維碼或復制鏈接</p>
              <div class="jui_h30"></div>
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($url);?>" style="width:4.6rem;">
              <div class="jui_h20"></div>
              <div class="jui_pad_12">
                <textarea name="shareUrl" id="shareUrl" style="width:5.8rem; height:60px;word-break: break-all; padding:.2rem; font-size:12px;" readonly><?php echo $url;?></textarea>
              </div>
              <div class="ewm_btn jui_bg_zhuse">複製鏈接</div>
              <div class="jui_h30"></div>
         </div>
    </div>
    <div><?php echo WEBNAME?></div>
</div>
<?php }else{?>
  <div class="none_bar">
	   <img src="/public/icon/no_team.png" alt="">
	   <p class="fc_999">您的等級過低,暫無邀請權限</p>
	   <div class="h20"></div>
	   <a href="?m=user&c=uplevel" class="none_btn">去升級</a>
  </div>
<?php }?>
<script language="javascript">
	$(function(){
		$('.ewm_btn').click(function(){
			clickToCopy('shareUrl');
		});
	})
</script>
</body>
</html>

