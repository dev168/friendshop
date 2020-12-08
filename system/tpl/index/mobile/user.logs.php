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
     <a class="jui_top_left" href="?m=user&c=uplevel"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">商家信息</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="jui_tab_bar">
     <ul class="jui_tab_tit">
         <li <?php if($type==0){echo 'class="jui_tab_on"';}?>><a href="?m=user&c=logs&type=0">正在申請<span></span></a></li>
         <li <?php if($type==1){echo 'class="jui_tab_on"';}?>><a href="?m=user&c=logs&type=1">歷史記錄<span></span></a></li>
     </ul>
     <div class="order_con">
     	  <?php
          	if($logs){
				foreach($logs as $w){
		  ?>
          <div class="order_list"> 
               <div class="jui_public_list2 jui_flex_justify_between">
                    <p class="fc_000 font_weight">申請升級:<?php echo $w['u_levels'];?></p>
                    <?php if($this->config['w_price']){?>
                    <p class="fc_000">價格:<?php echo $w['price'];?>元</p>
                    <?php }?>
               </div>
               <div class="order_text jui_flex jui_flex_justify_between">
                    <div class="jui_pad_r20 jui_flex1">
                         <p><span class="fc_999">審核商家：</span><?php echo $w['m_name'];?></p>
                         <div class="jui_flex_row_center">
                             <p class="order_text_leftcon"><span class="fc_999">商家電話：</span><?php echo $w['m_phone'];?></p>
                             <div class="jui_tag jui_bg_green jui_mar_l8 jui_flex_no"><a href="tel:<?php echo $w['m_phone'];?>" class="jui_fc_fff">壹鍵撥號</a></div>
                         </div>
                         <div class="jui_flex_row_center">
                             <p class="order_text_leftcon"><span class="fc_999">商家LINE：</span><span id="m_wei_<?php echo $w['id'];?>"><?php echo $w['m_weixin'];?></span></p>
                             <div class="jui_tag jui_bg_green jui_mar_l8 w_tag jui_flex_no" data-id="<?php echo $w['id'];?>">點擊復制</div>
                         </div>
                         <?php if($this->config['w_xinyu']){?>
                         <p><span class="fc_999">商家信譽：</span><?php echo $w['m_fen'];?> 分</p>
                         <?php }?>
                         <!--<p><span class="fc_999">商家等級：</span><?php echo $w['m_level'];?></p>-->
                     <!--   <?php /*if($w['m_svideo'] != false){ */?>
                            <p><span class="fc_999">商家小視頻：</span><?php /*echo $w['m_svideo'];*/?></p>
                        <?php /*} */?>

                        <?php /*if($w['m_blogs'] != false){ */?>
                            <p><span class="fc_999">商家微博：</span><?php /*echo $w['m_blogs'];*/?></p>
                        <?php /*} */?>

                        <?php /*if($w['m_goods'] != false){ */?>
                            <div class="jui_flex">
                                <span class="fc_999">推薦商品：</span>
                                <div class="jui_flex1 jui_line_h13">
                                    <?php /*foreach (explode('|',$w['m_goods']) as $k => $v){ */?>
                                         <p style="color:#a115;font-size: 15px;line-height: 0.67rem;"><?php /*echo $v;*/?></p>
                                    <?php /*} */?>
                                    <a href="?m=shop&c=index" style="font-size: 0.32rem;border: 0.02rem solid #eee;border-radius: 0.2rem;margin-top: 0.2rem;display: block; width: 1.8rem;line-height: 0.62rem; height: 0.62rem;text-align: center;color: #999;">更多商品</a>
                                 </div>
                            </div>
                        --><?php /*} */?>
                    </div>
                    <div class="flex flex_col jui_flex_no">
						  <?php
                            if($w['status']==0){
                                echo '<div class="order_btn jui_bg_zhuse jui_fc_fff jui_bor_none">審核中</div>';
                            }else{
                                echo '<div class="order_btn jui_bg_fff jui_fc_666">已通過</div>';
                                if($this->config['w_ping']){
									if($w['ping1']==0){
										echo '<a href="?m=user&c=ping&id='.$w['id'].'" class="order_btn jui_bg_zhuse jui_fc_fff jui_bor_none">去評價</a>';
									}else{
										echo '<div class="order_btn jui_bg_fff jui_fc_666">已評價</div>';
									}
								}
                            }
                          ?>
                    </div>
               </div>
               <div class="jui_text_right jui_pad_5 jui_fs12"><?php if($type){echo '審核時間';}else{echo '申請時間';}?>：<?php echo $w['m_time'];?></div>
          </div>
          <?php		
				}
			}else{
		  ?>
          <div class="jui_none_bar">
               <img src="/public/icon/no_team.png" alt="無會員">
               <p class="jui_fc_999">暫無記錄</p>
               <div class="jui_h20"></div>
               <a href="?m=user&c=uplevel" class="jui_none_btn jui_bg_zhuse">去升級</a>
          </div>
		  <?php	
			}
		  ?>
     </div>
</div>
<script language="javascript">
	$(function(){
		$('.w_tag').click(function(){
			var id=$(this).attr('data-id');
			clickToCopy('m_wei_' + id);
		});
	})
</script>

<?php include 'common.footer.php';?>
</body>
</html>
