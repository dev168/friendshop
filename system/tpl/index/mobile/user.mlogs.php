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
     <a class="jui_top_left" href="?m=user&c=message"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">投訴記錄</div>
     <a href="/?m=user&c=message" style="display: block;color:#fff;">我要投訴</a>
</div>
<div class="jui_h12"></div>
<?php
foreach($mlogs as $row){
?>
<div class="lyfk_list">
     <div class="jui_flex jui_flex_justify_between">
          <div class="jui_flex_col">
              <p><span class="jui_fc_999">對方信息：</span><?php echo $row['m_title'];?></p>
              <p><span class="jui_fc_999">投訴類型：</span><?php echo $this->suit_type[$row['m_type']];?></p>
          </div>
          <div class="lyfk_list_right">
               <div class="lyfk_list_btn <?php if($row['m_status']==1){echo 'jui_bg_zhuse jui_fc_fff jui_bor_none';}?>"><?php echo $row['status'];?></div>
          </div>
     </div>
     <div class="jui_fs12 jui_line_h12 jui_pad_t8"><?php echo $row['m_infos'];?></div>
</div>
<?php
}
if(empty($mlogs)){

 
?>
<div style="text-align: center;line-height:100px;">暫無投訴記錄</div>
<?php
}
?>
<?php include 'common.footer.php';?>
</body>
</html>



