<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<style>
     .newscon_zt img{
          max-width: 100%;
     }
</style>
</head>
<body class="jui_bg_fff">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle"><?php echo $about['n_title'];?></div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="newscon_zt">
     <?php
		echo $about['n_content'];
	 ?>
</div>
<!-- 主体end -->
</body>
</html>
