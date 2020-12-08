<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<script language="javascript">
	function shen(id){
	 layer.confirm('該操作不能恢復,確認審核?', function(index){
	 	$.post('?m=user&c=shen_up',{'id':id},function(retmsg){
		if(parseInt(retmsg.code)==1){
		   layer.msg(retmsg.msg);
		   $('#l_'+id).html('已審核');
		   $('#l_'+id).removeClass('order_sh');
		}else{
		   layer.msg(retmsg.msg);
		}
		},'json');
	 });		
	}
</script>
</head>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar"> <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
  <div class="jui_top_middle">我的訂單</div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="jui_tab_bar">
  <ul class="jui_tab_tit">
    <li <?php if($type==0){echo 'class="jui_tab_on"';}?>><a href="?m=user&c=order&type=0">待審核<span></span></a></li>
    <li <?php if($type==1){echo 'class="jui_tab_on"';}?>><a href="?m=user&c=order&type=1">已審核<span></span></a></li>
  </ul>
  <div class="order_con"> </div>
</div>
<script>
	function getScrollTop() { 
		var scrollTop = 0; 
		if (document.documentElement && document.documentElement.scrollTop) { 
			scrollTop = document.documentElement.scrollTop; 
		}else if (document.body) { 
			scrollTop = document.body.scrollTop; 
		} 
		return scrollTop; 
	}
	function getClientHeight() { 
		var clientHeight = 0; 
		if (document.body.clientHeight && document.documentElement.clientHeight) { 
			clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight); 
		}else { 
			clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight); 
		} 
		return clientHeight; 
	}
	function getScrollHeight() { 
		return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight); 
	}

var type	 =<?php echo $type;?>;
var page	 =1;
var limit	 =10;
var lock	 =1;

function load_html(result){
	var lists   =result;
	if(lists.length>0){
		for (i = 0, ii = lists.length; i < ii; i++) {
			var tmp_html	='';
			var tmp_data	=lists[i];
			tmp_html=tmp_html + '<div class="order_list">';
			tmp_html=tmp_html + '<div class="jui_public_list2 jui_flex_justify_between">';
			tmp_html=tmp_html + '<p class="fc_000 font_weight">申請升級:' + tmp_data.m_level + '</p>';
			<?php if($this->config['w_price']){?>
			tmp_html=tmp_html + '<p class="fc_000">價格:' + tmp_data.price + '元</p>';
			<?php }?>
			tmp_html=tmp_html + '</div>';
			tmp_html=tmp_html + '<div class="order_text jui_flex jui_flex_justify_between">';
			tmp_html=tmp_html + '<div class="jui_pad_r20">';
			tmp_html=tmp_html + '<p><span class="fc_999">會員姓名：</span>' + tmp_data.m_name + '</p>';
			
			tmp_html=tmp_html + '<div class="jui_flex_row_center">';
			tmp_html=tmp_html + '<p class="order_text_leftcon"><span class="fc_999">會員電話：</span>' + tmp_data.m_phone + '</p>';
			tmp_html=tmp_html + '<div class="jui_tag jui_bg_green jui_mar_l8 jui_flex_no"><a href="tel:' + tmp_data.m_phone + '" class="jui_fc_fff">壹鍵撥號</a></div>';
			tmp_html=tmp_html + '</div>';
			
			tmp_html=tmp_html + '<div class="jui_flex_row_center">';
			tmp_html=tmp_html + '<p class="order_text_leftcon"><span class="fc_999">會員LINE：</span><span id="m_wei_' + tmp_data.id + '">' + tmp_data.m_weixin + '</span></p>';
			tmp_html=tmp_html + '<div class="jui_tag jui_bg_green jui_mar_l8 w_tag jui_flex_no" onclick="javascript:clickToCopy(\'m_wei_' + tmp_data.id + '\');">點擊復制</div>';
			tmp_html=tmp_html + '</div>';
			
			tmp_html=tmp_html + '</div><div class="flex flex_col jui_flex_no">';
			if(tmp_data.status==0){
				tmp_html=tmp_html + '<div class="order_btn jui_bg_zhuse jui_fc_fff jui_bor_none" onclick="javascript:shen(' + tmp_data.id + ');" id="l_' + tmp_data.id + '">審核</div>';
			}else{
				tmp_html=tmp_html + '<div class="order_btn jui_bg_fff jui_fc_666">已審核</div>';
			}
			tmp_html=tmp_html + '</div></div><div class="jui_text_right jui_pad_5 jui_fs12">';
			if(type){
				tmp_html=tmp_html + '審核時間：';
			}else{
				tmp_html=tmp_html + '申請時間：';
			}
			tmp_html=tmp_html + tmp_data.m_time + '</div>';
			tmp_html=tmp_html + '</div>';
			$('.order_con').append(tmp_html);	
		}
		if(lists.length<limit){
			$('.order_con').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');	
		}else{
			lock=0;//解除加載鎖
		}
	}else{
		if(page==1){
			$('.order_con').append('<div class="jui_none_bar"><img src="/public/icon/no_team.png" alt="無會員"><p class="jui_fc_999">暫無已審核會員</p><div class="jui_h20"></div><a href="?m=user&c=uplevel" class="jui_none_btn jui_bg_zhuse">去升級</a></div>');	
		}else{
			$('.order_con').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');	
		}
	}
}
function load_url(){
	var url='?m=user&c=fetch&page=' + page + '&limit=' + limit + '&type=' + type;
	$.get(url, function(ret){
		load_html(ret);
	},'json');
}
$(function(){
	$(window).scroll(function(){
		var sH=	getScrollHeight();
		var sT=	getScrollTop();
		var cH= getClientHeight();
		if(sH-cH-sT<50){
			if(lock==0){
				lock	=1;//防止重復加載
				page	=page+1;
				load_url();
			}
		}
		console.log(sH + ',' + sT + ',' + cH);	
	});	
	load_url();
});
</script>
<?php include 'common.footer.php';?>
</body>
</html>
