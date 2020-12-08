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
     <div class="jui_top_middle">LINE修改記錄</div>
</div>
<div class="jui_h12"></div>
<?php
foreach($wlogs as $row){
?>
<div class="lyfk_list">
     <div class="jui_flex jui_flex_justify_between">
          <div class="jui_flex_col">
              <p><span class="jui_fc_999">修改後：</span><?php echo $row['l_old'];?></p>
              <p><span class="jui_fc_999">修改前：</span><?php echo $row['l_new'];?></p>
          </div>
          <div class="lyfk_list_right">
               <div class="lyfk_list_btn <?php if($row['l_status']==1){echo 'jui_bg_zhuse jui_fc_fff jui_bor_none';}?>"><?php echo $row['status'];?></div>
          </div>
     </div>
     <div class="jui_fs12 jui_line_h12 jui_pad_t8"><?php echo date('Y-m-d H:i:s',$row['l_time']);?></div>
</div>
<?php
}
?>
<?php include 'common.footer.php';?>
</body>
</html>


