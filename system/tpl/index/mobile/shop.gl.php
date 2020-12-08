<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" type="text/css" href="/public/css/swiper.min.css">
<?php include 'common.header.php'; ?>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">熱門商品</div>
</div>
<!-- 頭部end -->
<!-- 產品 -->
<div class="pro_bar jui_flex jui_flex_wrap">
    <?php foreach ($goods as $k => $v){ ?>
     <div class="pro_list jui_grid_w50">
          <a href="?m=shop&c=gc&g_id=<?php echo $v['g_id']; ?>" class="pro_con">
              <div class="pro_img"><img src="<?php echo $v['g_pic']; ?>"></div>
              <div class="pro_text">
                   <p class="pro_tit jui_ellipsis_2"><?php echo $v['g_title']; ?></p>
                   <div class="jui_flex_row_center jui_flex_justify_between">
                        <p class="jui_fc_red">¥<span class="jui_fs16"><?php echo $v['g_price']; ?></span></p>
                   </div>
              </div>
          </a>
     </div>
    <?php } ?>
</div>
<!-- 產品end -->
</body>
<script>
$(document).ready(function(){
    //控制圖片為正方形且居中不變形顯示
    $('.pro_img').height($('.pro_img').width());
	$('.pro_img').each(function(){
			var img_w = $(this).find('img').width();
			var img_h = $(this).find('img').height();
			if( img_w>img_h ){
				$(this).find('img').css('height','100%');
				}else{
					$(this).find('img').css('width','100%');
					}
			//console.log(img_h);
		})
		
});		
</script>
</html>
