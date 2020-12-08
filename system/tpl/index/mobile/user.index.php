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
<div class="center_top jui_bg_zhuse">
     <div class="jui_flex_row_center">
           <div class="center_tx"><a href="?m=user&c=avatar" class="center_img"><img src="<?php echo empty($user['m_avatar'])?'/public/image/tx.jpg':$user['m_avatar'];?>"></a></div>
           <div class="jui_flex1 jui_flex_col">
                <div class="jui_flex_row_center jui_flex_justify_between">
                      <div class="jui_flex_row_center">
                           <p class="jui_fs16">姓名：<?php echo $user['m_name'];?></p>
                           <?php if($this->config['w_xinyu']){ ?>
                                <div class="center_xyf jui_bg_fuse jui_fc_zhuse">信譽分：<?php echo $user['m_score'];?></div>
                           <?php } ?>
                      </div>
                      <a href="?m=user&c=share" class="iconfont jui_fc_fff jui_fs20">&#xe602;</a>
                </div>
                <p>等級：<?php echo $this->user_levels[$user['m_level']];?></p>
                <?php if($this->config['w_nick'] == 1){?>
                    <p>別名：<?php echo $this->user_nick[$user['m_level']];?></p>
                <?php }?>
           </div>
     </div>
     <div class="center_tuijian">推薦人：<?php echo $t_user['m_name']; ?>&nbsp;&nbsp;<?php echo $t_user['m_phone']; ?></div>
</div>
<!-- 頭部end -->
<!-- 公告課堂 -->
<div class="jui_bg_fff jui_flex_row_center jui_pad_t16 jui_pad_b16 jui_bor_rad_5">
     <a href="?m=index&c=notice" class="jui_flex1 jui_flex_row_center jui_flex_justify_center jui_bor_right">
          <img class="center_icon" src="/public/icon/icon_gg.png">
          <p class="jui_pad_l12">公告</p>
     </a>
     <a href="?m=index&c=school" class="jui_flex1 jui_flex_row_center jui_flex_justify_center">
          <img class="center_icon" src="/public/icon/icon_kt.png">
          <p class="jui_pad_l12">課堂</p>
     </a>
</div>
<!-- 公告課堂end -->
<div class="jui_h12"></div>
<!-- 訂單數 -->
<div class="jui_bg_fff jui_flex jui_pad_t5 jui_pad_b5">
     <a href="?m=user&c=order" class="jui_grid_list jui_grid_w33">
          <P class="jui_fc_000 jui_font_weight"><?php echo $j_num;?></P>
          <P>今日訂單數</P>
     </a>
     <a href="?m=user&c=order&type=0" class="jui_grid_list jui_grid_w33">
          <P class="jui_fc_000 jui_font_weight"><?php echo $d_num;?></P>
          <P>待審核</P>
     </a>
     <a href="?m=user&c=order&type=1" class="jui_grid_list jui_grid_w33">
          <P class="jui_fc_000 jui_font_weight"><?php echo $y_num;?></P>
          <P>已審核</P>
     </a>
</div>
<!-- 訂單數end -->
<div class="jui_h12"></div>
<!-- 列表 -->
<div class="jui_bg_fff">
     <a href="?m=user&c=share" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe602;</div>
         <p class="jui_flex1">邀請好友</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
     <a href="?m=user&c=setting" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe654;</div>
         <p class="jui_flex1">個人資料</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
     <a href="?m=user&c=repass" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe80f;</div>
         <p class="jui_flex1">修改密碼</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
</div>
<div class="jui_h12"></div>
<div class="jui_bg_fff">
    <?php if($user['m_agent'] < 1){ ?>
        <a href="?m=agent&c=apply" class="jui_public_list">
            <div class="iconfont center_list_icon jui_fc_zhuse">&#xe850;</div>
            <p class="jui_flex1">申請代理</p>
            <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
        </a>
    <?php }else{ ?>
   <!-- --><?php /*if($user['m_agent'] >= 1){ */?>
        <a href="?m=agent&c=agent_shop" class="jui_public_list">
            <div class="iconfont center_list_icon jui_fc_zhuse">&#xe850;</div>
            <p class="jui_flex1">代理商城</p>
            <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
        </a>
    <?php } ?>
     <a href="?m=user&c=message" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse" style="font-size:.58rem;">&#xe626;</div>
         <p class="jui_flex1">留言反饋</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
     <a href="?m=user&c=about&id=3" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe63e;</div>
         <p class="jui_flex1">常見問題</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
     <a href="?m=user&c=about&id=1" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe6e6;</div>
         <p class="jui_flex1">關於我們</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
     <a href="?m=index&c=logout" class="jui_public_list">
         <div class="iconfont center_list_icon jui_fc_zhuse">&#xe62b;</div>
         <p class="jui_flex1">安全退出</p>
         <img class="jui_arrow_rimg" src="/public/icon/jt_right.png">
     </a>
</div>
<?php include 'common.footer.php';?>
</body>
</html>
