<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">余額明細</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_bg_fff">
    <?php foreach ($logs as $k=>$v){?>
        <div class="jui_public_list2 jui_flex_justify_between">
            <div class="jui_flex_col">
                <p><?php echo $v['l_info']; ?></p>
                <p class="jui_fs12 jui_fc_999"><?php echo date('Y-m-d H:i',$v['l_time']); ?></p>
            </div>
            <?php if($v['l_num'] < 0){ ?>
                <p class="jui_fs17 jui_fc_000"><?php echo $v['l_num']; ?></p>
            <?php }else{ ?>
                <p class="jui_fs17 jui_fc_green">+<?php echo $v['l_num']; ?></p>
            <?php } ?>

        </div>
    <?php } ?>
</div>
<!-- 主体end -->
</body>
</html>
