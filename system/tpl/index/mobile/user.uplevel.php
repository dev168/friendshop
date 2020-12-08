<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<style type="text/css">
    .level_btn2{
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        width: 6rem;
        height: .96rem;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        color: #fff;
        font-size: .3733rem;
        -webkit-align-items: center;
        -moz-align-items: center;
        -ms-align-items: center;
        align-items: center;
        -webkit-justify-content: center;
        -moz-justify-content: center;
        -ms-justify-content: center;
        justify-content: center;
    }
</style>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">會員升級</div>
     <a href="?m=user&c=logs" class="jui_top_right jui_fc_fff">商家信息</a>
</div>
<!-- 頭部end -->
<!-- 頭像 -->
<div class="level_topbg jui_bg_zhuse jui_flex_col_center">
      <div class="center_img level_img"><img src="<?php echo empty($user['m_avatar'])?'/public/image/tx.jpg':$user['m_avatar'];?>"></div>
      <div class="jui_fc_fff jui_text_center">
           <P class="jui_fs16 jui_pad_t5"><?php echo $user['m_name'];?></P>
           <P class="jui_fs12">等級：<?php echo $this->user_levels[$user['m_level']];?></P>
      </div>
</div>
<!-- 頭像end -->

<!-- 會員升級 -->
<?php if($is_upgrade==-1){ ?>
  <div class="none_bar">
	   <img src="/public/icon/no_team.png" alt="">
	   <div class="jui_h12"></div>
	   <p class="fc_999">您當前已是最高級別</p>
  </div>
<?php }else{?>
<div class="level_bar">
     <div class="jui_bg_fff jui_flex_col_center jui_bor_rad_8">
          <h3 class="jui_public_tit">會員升級</h3>
          <div class="jui_flex_col_center jui_line_h15">
               <p>您的等級：<?php echo $this->user_levels[$n_level];?></p>
               <p>下壹等級：<?php echo $this->user_levels[$u_level];?></p>
          </div>
	<?php 
        if($level['l_tnum']>0 || $level['l_znum']>0){
    ?>
    <div class="jui_h12"></div>
    <h3 class="jui_public_tit">升級條件</h3>
    <div class="jui_flex_col_center jui_line_h15">
        <?php if($level['l_tnum']>0){?><p>直推達到<?php echo $level['l_tnum'];?>人</p><?php } ?>
        <?php if($level['l_znum']>0){?><p>團隊達到<?php echo $level['l_znum'];?>人</p><?php } ?>
    </div>
    <?php
        }
    ?>
          <div class="jui_h12"></div>
          <h3 class="jui_public_tit">升級權益</h3>
          <div class="jui_flex_col_center jui_line_h15">
               <p>獲得<?php echo $u_level;?>代訂單</p>
               <p>解鎖<?php echo $u_level;?>度人脈</p>
          </div>
          <div class="jui_h20"></div>
         <!--新增實名認證邏輯判斷-->
         <?php  if($this->config['w_shiming'] == 0){ ?>
             <div class="level_btn jui_bg_zhuse" <?php if($is_upgrade<1){echo 'style="background:#ddd;"';}?>>立即升級</div>
         <?php }else{ ?>
              <?php if($user['m_rz'] > 0){ ?>
                 <div class="level_btn jui_bg_zhuse" <?php if($is_upgrade<1){echo 'style="background:#ddd;"';}?>>立即升級</div>
                <?php }else{ ?>
                    <?php if($user['m_carimg'] != '' and $user['m_carid'] != ''){ ?>
                        <div class="level_btn2 jui_bg_zhuse" data-rztype="1">立即升級</div>
                    <?php }else{ ?>
                        <div class="level_btn2 jui_bg_zhuse" data-rztype="2">立即升級</div>
                    <?php } ?>
              <?php } ?>
         <?php } ?>
         <!--end-->
          <div class="jui_h20"></div>
     </div>
</div>
<?php if($is_upgrade==1){?>
<script language="javascript">
$(function(){
	var click_lock = 0;
	$('.level_btn').click(function(){
		if(click_lock==0){
			click_lock = 1;
			$.post("?m=user&c=uplevel",{upgrade:1},function(ret){
				if(ret.code==1){
					layer.msg(ret.msg,{icon:1,time:1000},function(){
						window.location.href='?m=user&c=logs';
					});
				}else{
					layer.msg(ret.msg,{time:1000},function(){
						window.location.href='?m=user&c=logs';
					});
				}
			},'json');
		}
	});

	$('.level_btn2').click(function () {
       var rz_type = $(this).data('rztype');
       if(rz_type == 1){
           layer.msg('實名認證審核中,請耐心等待');
           return;
       }else if(rz_type == 2){
           layer.msg('請先進行實名認證');
           setTimeout(function () {
                window.location.href = '?m=index&c=renzheng'
           },'1000')
       }
    })
});
</script>
<?php
	}}
?>
<?php include 'common.footer.php';?>
</body>
</html>
