<?php
	if($this->config['w_online']==2){
		echo '<a href="'.$this->config['w_lineurl'].'" class="iconfont index_xfkf jui_bg_zhuse" target="_blank">&#xe616;</a>';
	}
?>
<?php if($this->config['w_online']==3){?>
<div class="iconfont index_xfkf" id="kefu"><img src="/public/funny/service.png" width="38px" alt=""></div>
<div class="jui_box_bar jui_none" id="box_bar2">
     <div class="jui_box_conbar" style="top:20%;">
         <div class="jui_box_con">
               <div class="jui_public_tit jui_flex_justify_center jui_fc_000 jui_font_weight jui_fs15">掃二維碼加客服</div>
               <div class="jui_h12"></div>
               <div class="box_rm_ewm"><img src="<?php echo $this->config['w_linecode'];?>"></div>
               <p class="jui_text_center jui_pad_t5"><?php echo $this->config['w_kefu'];?></p>
               <div class="jui_h20"></div>
               <div class="jui_box_close iconfont" id="close2">&#xe61f;</div>
         </div>
     </div>
</div>
<script language="javascript">
$(document).ready(function(){
    $(document).on("click","#kefu",function(){
		$("#box_bar2").removeClass('jui_none');	   
	});
	$(document).on("click","#close2",function(){
		$("#box_bar2").addClass('jui_none');	   
	});
});
</script>
<?php }?>

<div class="jui_h80"></div>
<style>
    .jui_foot_list img{
        width: 30px;
    }
</style>
<!-- 固定底部 -->
<div class="jui_footer">
    <a href="?m=index&c=index" class="jui_foot_list <?php if(empty($_GET['m'])||$_GET['m']=='index'){echo ' jui_hover';}?>">
        <img src="/public/funny/menu1.png" alt="">
        <p>首頁</p>
    </a>
    <a href="?m=shop&c=index" class="jui_foot_list <?php if(!empty($_GET['m']) && $_GET['m']=='shop'){echo ' jui_hover';}?>">
        <!-- <span class="iconfont">&#xe617;</span> -->
        <img src="/public/funny/menu2.png" alt="">
        <p>商盟</p>
    </a>
    <a href="?m=user&c=uplevel" class="jui_foot_list">
        <div class="jui_foot_sjbar jui_flex_col_center">
            <div class="jui_foot_sjcon jui_bor_rad_50 jui_flex_no">
                <img src="/public/funny/menu3.png" alt="">
            </div>
            <p>升級</p>
        </div>
    </a>
    <a href="?m=team&c=index" class="jui_foot_list <?php if(!empty($_GET['m']) && $_GET['m']=='team'){echo ' jui_hover';}?>">
        <img src="/public/funny/menu5.png" alt="">
        <p>人脈</p>
    </a>
    <a href="?m=user&c=index" class="jui_foot_list <?php if(!empty($_GET['m']) && $_GET['m']=='user'){echo ' jui_hover';}?>">
        <img src="/public/funny/menu6.png" alt="">
        <p>我的</p>
    </a>
</div>
<!-- 固定底部end -->

