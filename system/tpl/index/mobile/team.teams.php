<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
</head>
<body class="jui_bg_grey">
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">我的團隊</div>
     <a href="?m=team&c=user" class="jui_top_right jui_fc_fff">我的直推</a>
</div>
<div class="jui_h12"></div>
<div class="jui_pad_t12 jui_pad_b12 jui_bg_fff jui_flex_row_center">
     <div class="jui_flex1 jui_flex_col_center jui_bor_right">
           <p class="jui_fc_zhuse jui_fs16 jui_font_weight"><?php echo $t_num_1;?><span class="jui_fs12">人</span></p>
           <p>團隊總人數</p>
     </div>
     <div class="jui_flex1 jui_flex_col_center">
           <p class="jui_fc_zhuse jui_fs16 jui_font_weight"><?php echo $t_num_2;?><span class="jui_fs12">人</span></p>
           <p>壹星及以上</p>
     </div>
</div>
<div class="jui_h12"></div>
<div class="jui_bg_fff">
	 <?php
     	foreach($t_nums as $v){
		echo '<div class="jui_public_list2 jui_flex_justify_between"><p>'.$v['t_name'].'</p><p class="jui_fc_zhuse jui_font_weight"> '.$v['t_num'].'<span class="jui_fc_666">人</span></p></div>';
		}
	 ?>
</div>
<?php include 'common.footer.php';?>
</body>
</html>
