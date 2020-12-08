<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<script language="javascript">
$(document).ready(function(){
	$('.zt_ewm').click(function(){
		var phone=$(this).attr('id');
		$.post('?m=team&c=infos',{'phone':phone},function(retmsg){
            if(parseInt(retmsg.code)==1){
                $("#box_bar2").html(retmsg.msg);
                $("#box_bar2").removeClass('jui_none');
            }else{
               layer.msg(retmsg.msg);
            }
		},'json');			
	
	});
	$(document).on("click","#close2",function(){
		$("#box_bar2").addClass('jui_none');	   
	});	
	$('#m_levels').on('change',function(){
		var type_id = $(this).val();
		if(type_id){
			window.location.href = '?m=team&c=user&t=' + type_id;
		}
	});	
});
</script>
</head>
<body class="jui_bg_grey">
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">我的直推</div>
     <a href="?m=team&c=teams" class="jui_top_right jui_fc_fff">我的團隊</a>
</div>
<div class="zt_tit_bar jui_flex_row_center jui_flex_justify_between">
     <div class="zt_tit_left jui_flex_row_center">
           <p class="jui_flex_no">等級：</p>
           <select class="jui_pad_r12" id="m_levels">
               <option value="-1">全部</option>
               <?php
                foreach($this->base_levels as $k=>$v){
					if($level==$k){
						echo '<option value="'.$k.'" selected>'.$v.'</option>';
					}else{
                    	echo '<option value="'.$k.'">'.$v.'</option>';
					}
                }
               ?>
           </select>
           <img class="zt_tit_rimg" src="/public/icon/jt_right.png">
     </div>
     <div class="zt_tit_right">
         共<span class="jui_fc_zhuse"><?php echo count($teams);?></span>人
         <?php if($level<0){?>
         &nbsp;&nbsp;壹星以上<span class="jui_fc_zhuse"><?php echo $t_num_1;?></span>人
         <?php }?>
     </div>     
</div>
<div class="jui_h12"></div>
<div class="rm_con jui_bg_fff">
		<?php
            if($teams){
                foreach($teams as $t){
        ?>
          <div class="jui_public_list2">
               <div class="zt_tx"><img src="<?php echo empty($t['m_avatar'])?'/public/image/tx.jpg':$t['m_avatar'];?>" alt="<?php echo $t['m_name'];?>"></div>
               <div class="jui_flex1 jui_pad_l12 jui_pad_r20">
                    <p class="jui_fc_000"><?php echo $t['m_name'];?></p>
                    <P class="jui_fc_999 jui_ellipsis_2"><?php echo $t['m_infos'];?></P>
               </div>
               <div class="zt_ewm" id="<?php echo $t['m_phone'];?>"><img src="/public/image/ewm.png"></div>
          </div>
        <?php		
                }
            }
        ?>
</div>
<div class="jui_box_bar jui_none" id="box_bar2">
</div>
<?php include 'common.footer.php';?>
</body>
</html>
