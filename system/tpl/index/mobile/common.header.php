<?php if(!empty($this->config['w_icon'])){ ?>
<link rel="shortcut icon" href="<?php echo $this->config['w_icon'];?>" type="image/png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $this->config['w_icon'];?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="/public/css/style.css?v=1.0.3">
<link rel="stylesheet" type="text/css" href="/public/css/css.css">
<style type="text/css"> 
	.jui_fc_zhuse{ color:<?php echo $this->config['w_color1'];?>;}
	.jui_fc_fuse{ color:<?php echo $this->config['w_color2'];?>;}
	.jui_bg_zhuse{ background:<?php echo $this->config['w_color1'];?>;}
	.jui_bg_fuse{background:<?php echo $this->config['w_color2'];?>;}
	.jui_top_bar{ background:<?php echo $this->config['w_color1'];?>; }
	.jui_public_btn input,.jui_public_btn a,.jui_public_btn button{ background:<?php echo $this->config['w_color1'];?>;}
	.jui_foot_list.jui_hover span,.jui_foot_list.jui_hover p{ color:<?php echo $this->config['w_color1'];?>;}
	.jui_foot_sjcon{background:<?php echo $this->config['w_color1'];?>;}
	.none_btn{background:<?php echo $this->config['w_color1'];?>;}
     ul.jui_tab_tit li.jui_tab_on span{background:<?php echo $this->config['w_color1'];?>;}
</style>
<script src="/public/js/jquery-3.3.1.min.js"></script>
<script src="/public/js/flexible.js"></script>
<script src="/public/layer/layer.js"></script>
<script language="javascript">
	function clickToCopy(nodeName){
		const range 	= document.createRange();
		range.selectNode(document.getElementById(nodeName));
		const selection = window.getSelection();
		if(selection.rangeCount > 0) selection.removeAllRanges();
		selection.addRange(range);
		document.execCommand('copy');
		layer.msg('復制成功');
	}
</script>
