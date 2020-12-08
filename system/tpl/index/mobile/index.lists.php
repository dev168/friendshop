<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
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

var n_cate	 =<?php echo $id;?>;
var page	 =1;
var limit	 =10;
var lock	 =1;

function load_html(result){
	var lists   =result;
	if(lists.length>0){
		for (i = 0, ii = lists.length; i < ii; i++) {
			var tmp_html	='';
			var tmp_data	=lists[i];	
			tmp_html=tmp_html + '<a href="?m=index&c=wens&id=' + tmp_data.id + '" class="notice_list">';
			tmp_html=tmp_html + '<div class="notice_img"><img src="' + tmp_data.n_img + '"></div>';
			tmp_html=tmp_html + '<div class="jui_pad_1216">';
			tmp_html=tmp_html + '<div class="jui_fs15 jui_fc_000 jui_font_weight jui_ellipsis_1">' + tmp_data.n_title + '</div>';
			tmp_html=tmp_html + '<div class="jui_flex_row_center jui_flex_justify_between jui_pad_t5">';
			tmp_html=tmp_html + '<p class="jui_fc_999 jui_fs12">發布時間:' + tmp_data.n_time + '</p>';
			tmp_html=tmp_html + '<p class="jui_fc_999 jui_fs12">閱讀:' + tmp_data.n_read + '</p>';
			tmp_html=tmp_html + '</div></div></a>';
			$('.notice_bar').append(tmp_html);	
		}
		if(lists.length<limit){
			$('.notice_bar').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');	
		}else{
			lock=0;//解除加載鎖
		}
	}else{
		$('.notice_bar').append('<div class="jui_pad_16 jui_text_center jui_fc_999 jui_fs12">- 加載完成 -</div>');	
	}
}
function load_url(){
	var url='?m=index&c=fetch&page=' + page + '&limit=' + limit + '&n_cate=' + n_cate;
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
</head>
<body class="jui_bg_fff">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle"><?php echo $cate_name;?></div>
</div>
<!-- 頭部end -->
<!-- 主體 -->
<div class="notice_bar">

</div>
<!-- 主體end -->
<?php include 'common.footer.php';?>
</body>
</html>
