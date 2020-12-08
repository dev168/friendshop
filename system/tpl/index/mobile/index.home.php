<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
</head>
<body class="jui_bg_grey">
<!-- 輪播圖 -->
<div class="swiper-container bor_rad_8">
        <div class="swiper-wrapper">
        	<?php
            	if($banner){
					foreach($banner as $b){
						echo '<div class="swiper-slide">';
						if(!empty($b['b_link'])){
							echo '<a href="'.$b['b_link'].'">';
						}
						echo '<img src="'.$b['b_img'].'"/>';
						if(!empty($b['b_link'])){
							echo '</a>';
						}
						echo '</div>';
					}
				}
			?>
        </div>
        <div class="swiper-pagination"></div>			
</div>
<script src="/public/js/swiper.min.js"></script>
<script type="text/javascript">
		var mySwiper = new Swiper('.swiper-container', {
			autoplay: 3000,
			pagination: '.swiper-pagination',
			autoplayDisableOnInteraction: false,
			loop: true,
			paginationType: 'bullets',
			paginationClickable: true,
		})
		
</script>
<!-- 輪播圖end -->
<!--<div class="jui_h12"></div>-->
<!-- 公告 -->
<div class="jui_bg_fff jui_pad_t8 jui_pad_b8 jui_pad_l16 jui_pad_r16 jui_flex_row_center jui_mar_t8">
    <span class="iconfont jui_fc_zhuse jui_flex_no jui_fs24">&#xe627;</span>
    <div class="jui_pad_l12 jui_flex1" style="overflow:hidden;">
        <marquee scrollamount="5" id="ad-main" style="float: left; width: 84%;margin-left: 0.2rem;">
            <p><strong><?php echo $config['w_notice'];?></strong></p>
        </marquee>
    </div>
</div>
<div style="width:100%; height:0.16rem;"></div>

<!-- 快捷入口 -->
<div class="jui_flex jui_flex_wrap index_kjrk_bar1 <?php if($this->config['w_temp']==4){echo 'jui_bg_fff';}?>">
	<?php
    	foreach($styles as $s){
		if($this->config['w_temp']==2){
	?>
        <div class="jui_grid_w50 index_kjrk_list1">
             <a href="<?php echo $s['s_url'];?>" class="index_kjrk_con1 jui_flex_col_center jui_bg_zhuse">
                  <div class="index_kjrk_icon1"><img src="<?php echo $s['icon_img'];?>"></div>              
                  <p class="jui_pad_t5 jui_fc_fuse"><?php echo $s['s_name'];?></p>
             </a>
        </div>
	<?php	
		}elseif($this->config['w_temp']==3){
	?>
        <div class="jui_grid_w33 index_kjrk_list1">
             <a href="<?php echo $s['s_url'];?>" class="index_kjrk_con1 jui_flex_col_center jui_bg_zhuse">
                  <div class="index_kjrk_icon1"><img src="<?php echo $s['icon_img'];?>"></div>              
                  <p class="jui_pad_t5 jui_fc_fuse"><?php echo $s['s_name'];?></p>
             </a>
        </div>
	<?php	
		}else{
	?>
             <a href="<?php echo $s['s_url'];?>" class="jui_grid_list jui_grid_w25 jui_flex_col_center">
                  <div class="index_kjrk_icon2"><img src="<?php echo $s['icon_img'];?>"></div>              
                  <p class="jui_pad_t5"><?php echo $s['s_name'];?></p>
             </a>
	<?php	
		}
		}
	?>
    
    
    
</div>
<!-- 快捷入口end -->
<div class="jui_h12"></div>
<!-- 客服 -->
<?php if($this->config['w_online']==1){?>
<div class="jui_pad_l16 jui_pad_r16">
     <div class="index_kefu_list jui_flex_row_center jui_flex_justify_between">
          <div class="jui_flex_row_center">
              <div class="index_kefu_icon iconfont jui_fc_zhuse">&#xe7bb;</div>
              <div class="index_kefu_text jui_pad_l12">
                   <p class="jui_fs14 jui_fc_000">客服名稱：<?php echo $this->config['w_kefu'];?></p>
                   <p class="jui_fs12">聯系方式：<span id="index_kefu_tel"><?php echo $this->config['w_tel'];?></span></p>
              </div>
          </div>
          <div class="index_kefu_btn jui_bg_zhuse">壹鍵復制</div>
     </div>
</div>

<script language="javascript">
	$(function(){

		$('.index_kefu_btn').click(function(){
			clickToCopy('index_kefu_tel');
		});
	})
</script>
<?php }?>
<!-- 客服end -->
<!-- 彈出框 -->
<!--<div class="jui_box_bar jui_none" id="box_bar2">
    <div class="jui_box_conbar">
        <div class="jui_box_con">
            <div class="jui_public_tit jui_flex_justify_center jui_fc_000 jui_font_weight jui_fs18">商戶需知</div>
            <div class="box_rm_text">
                <p> 創客幫妳賣”是壹個幫助廣大實體商家拓客賣貨的工具，自由自願加入，特告知如下：</p>
                <p>1、本系統只為各位商戶推送買家的聯系方式，買賣雙方線下洽談，打款發貨，本平臺不收取費用。</p>
                <p>2、本系統規定，每單商品售價198元，貨值不得高於正常市場零售價。若有價格虛高、以次充好、收到款項後15日內未發貨，壹經查實，系統將給予封號處理，並協助客戶追究其法律責任。</p>
                <p>3、為了保障商家的權益，商家申請進入本系統，需如實填寫身份證號及上傳身份證照片。</p>
            </div>
            <div class="jui_h12"></div>
            <div class="jui_box_close iconfont" id="close2" style="cursor:pointer;">&#xe61f;</div>
        </div>
    </div>
</div>
<script>
    var xy_desc = localStorage.getItem('xy_desc');
    if(xy_desc == null){
        $("#box_bar2").removeClass('jui_none');
        localStorage.setItem('xy_desc','1');
    }
    $(document).on("click", "#close2", function () {
        $("#box_bar2").addClass('jui_none');
    });
</script>-->
<!-- 彈出框end -->
<?php include 'common.footer.php';?>
</body>
</html>
