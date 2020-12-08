<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<link rel="stylesheet" type="text/css" href="/public/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/public/css/cropper.css">
<script src="/public/js/cropper.js"></script>
<style>
	.input_file{ position:absolute; z-index:2; appearance:none; -moz-appearance:none; -webkit-appearance:none; opacity:0; width:100%;}
	.btn-back{color:#666; line-height:40px; font-size:16px;text-decoration:none; padding-top:3rem;}
	.container{ width:80%; position:relative;margin:0px auto;}
	.img-container{width:100%;margin-top:3rem;text-align: center;position:absolute;}
	.img-container img{ max-width:100%;}
	.footer{width: 100%;height:1.17rem; position:absolute; bottom:0px;}
	.toolbar{height:30px; margin:0px auto; text-align:center; font-size:0.33rem;}
	.toolbar span{background:<?php echo $this->config['w_color1'];?>;color:#fff; padding:0.16rem 0.26rem;border-radius:3px;margin-right:10px;}
	.toolbar span#up-btn-submit{padding:0.12rem 0.26rem;}
</style>
</head>

<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="?m=user&c=index"><img src="/public/icon/back_111.png"></a>
     <div class="jui_top_middle">上傳二維碼</div>
     <div class="jui_top_right jui_fc_fff" style="position:relative;">
          <input type="file" class="input_file" id="input" name="image" accept="image/*">
          <P>選擇圖片</P>
     </div>
</div>
<div class="jui_h12"></div>
<!-- 頭部end -->

<div class="container">
    <div class="img-container">
        <img id="image" src="<?php echo $user['m_qrcode'];?>">
    </div>
</div>
<div class="footer">
    <div class="toolbar">
        <span id="up-btn-left" class="fa fa-rotate-left"></span>
        <span id="up-btn-right" class="fa fa-rotate-right"></span>
        <span id="up-btn-submit">保存截圖</span>
    </div>
</div>
</body>
<script language="javascript">
      var image = document.getElementById('image');
      var input = document.getElementById('input');
 	  var cropper;
	  input.addEventListener('change', function (e) {
        if(typeof(cropper)!='undefined'){
			cropper.destroy();
			cropper = null;
		}
        var files = e.target.files;
        var done  = function (url) {
          input.value 	= '';
          image.src 	= url;
          cropper 		= new Cropper(image, {
          	aspectRatio: 1
          });
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
          file = files[0];
          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });
	  $('#up-btn-left').on('click',function() {
		  if(typeof(cropper)!='undefined'){
		  	cropper.rotate(90);
		  }
	  });
	  $('#up-btn-right').on('click',function() {
		  if(typeof(cropper)!='undefined'){
		  	cropper.rotate(-90);
		  }
	  });
      document.getElementById('up-btn-submit').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;
        if (cropper) {
          canvas = cropper.getCroppedCanvas({
            width: 320,
            height: 320,
          });
          canvas.toBlob(function (blob) {
				var formData = new FormData();
				formData.append('headimg', blob, 'avatar.jpg');			
				$.ajax('?m=user&c=qrcode', {method: 'POST',data: formData,processData: false,contentType: false,
				  success: function (data) {
					if(data.code==1){
						layer.msg(data.msg,{icon:1,time:1000},function(){
							window.location.href='?m=user&c=setting';	
						});	
					}else{
						layer.msg(data.msg);
					}
				  },dataType:'json'
				});
          });
        }else{
			alert('請先選擇圖片');
		}
      });
</script>
</html>
