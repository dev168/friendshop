<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME;?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<style>
     img{
          max-width: 100%;
     }
     table, table tr{
          width: 100%;
     }
      
</style>
</head>
<body class="jui_bg_fff">
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">在線課堂</div>
</div>
<div class="newscon_tit">
     <h2><?php echo $news['n_title'];?></h2>
     <span><?php echo date('Y-m-d H:i:s',$news['n_time']);?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $news['n_read'];?> 閱讀</span>
</div>
<div class="newscon_zt">
     <?php echo $news['n_content'];?>
</div>
<?php include 'common.footer.php';?>
</body>
</html>
