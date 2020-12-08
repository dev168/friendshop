<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php include 'common.header.php';?>
<link rel="stylesheet" type="text/css" href="/public/css/diqu.css">
<script src="/public/js/picker.min.js"></script>
<script src="/public/js/city.js?v=100"></script>
<body class="jui_bg_grey">
<!-- 頭部 -->
<div class="jui_top_bar">
  <a class="jui_top_left" href="?m=user&c=index"><img src="/public/icon/back_111.png"></a>
  <div class="jui_top_middle">編輯資料</div>
  <?php if($this->config['w_shenhe']==1){echo '<a href="?m=user&c=wlogs" class="jui_top_right jui_fc_fff">LINE記錄</a>';}?>
</div>
<?php if($this->config['w_shenhe']==1){echo '<div class="jui_public_tit jui_fs13">註意：為保障您的權益，修改LINE號需人工審核</div>';}?>
<form id="setform" name="setform">
  <div class="jui_bg_fff">
    <div class="jui_public_list">
      <p>姓名</p>
      <input class="jui_flex1 jui_text_right" type="text" placeholder="您的姓名" value="<?php echo $user['m_name'];?>" name="m_name" id="m_name">
    </div>
    <div class="jui_public_list jui_flex_justify_between">
      <p>性別</p>
      <div class="jui_flex_row_center">
        <label class="jui_flex_row_center jui_pad_r20">
        <input class="jui_form_radio" type="radio" value="0" name="m_gender" <?php echo $user['m_gender']==0?'checked':''?>>
        <P class="jui_pad_l5">保密</P>
        </label>
        <label class="jui_flex_row_center jui_pad_r20">
        <input class="jui_form_radio" type="radio" value="1" name="m_gender" <?php echo $user['m_gender']==1?'checked':''?>>
        <P class="jui_pad_l5">男</P>
        </label>
        <label class="jui_flex_row_center">
        <input class="jui_form_radio" type="radio" value="2" name="m_gender" <?php echo $user['m_gender']==2?'checked':''?>>
        <P class="jui_pad_l5">女</P>
        </label>
      </div>
    </div>
    <div class="jui_public_list">
      <p>行業</p>
      <select class="jui_flex1 jui_pad_r12" dir="rtl" name="m_hang">
        <?php
            foreach ($u_cates as $row) {
                if($user['m_hang']==$row['id']){
                    echo '<option value="' . $row['id'] . '" selected>' . $row['c_name'] . '</option>';
                }else{
                    echo '<option value="' . $row['id'] . '">' . $row['c_name'] . '</option>';
                }
            }
            ?>
      </select>
      <img class="jui_arrow_rimg" src="/public/icon/jt_right.png"> </div>
    <div class="jui_public_list">
      <P>地區</P>
      <a id="sel_city" class="jui_flex1 jui_pad_r12 jui_text_right">
      <?php
        if(trim($user['m_sheng']) != false || trim($user['m_shi']) != false){echo $user['m_sheng'].' '.$user['m_shi'];}else{echo '請選擇地區';}
	  ?>
      </a> <img class="jui_arrow_rimg" src="/public/icon/jt_right.png"> </div>
    <div class="jui_public_list">
      <p>LINE</p>
      <input class="jui_flex1 jui_text_right" type="text" value="<?php echo $user['m_weixin'];?>" name="m_weixin" id="m_weixin">
    </div>
    <div class="jui_public_list2 jui_flex_justify_between">
      <p>二維碼</p>
      <a href="?m=user&c=qrcode" class="jui_block"><img class="set_ewm" src="<?php if(trim($user['m_qrcode']) != false){ echo $user['m_qrcode']; }else{ echo '/public/image/tx.jpg';} ;?>"></a>
    </div>
      <!--<div class="jui_public_list">
          <p>小視頻</p>
          <input class="jui_flex1 jui_text_right" type="text" value="<?php /*echo $user['m_svideo'];*/?>" name="m_svideo" id="m_svideo">
      </div>-->
      <div class="jui_public_list">
          <p>收貨地址</p>
          <input class="jui_flex1 jui_text_right" type="text" value="<?php echo $user['m_blogs'];?>" name="m_blogs" id="m_blogs">
      </div>
  </div>
  <!--<div class="jui_h12"></div>
  <textarea class="set_textarea" name="m_goods" id="m_goods" placeholder="我的商品  請用  |  中劃線隔開"><?php /*echo $user['m_goods'];*/?></textarea>-->
  <div class="jui_h12"></div>
  <textarea class="set_textarea" name="m_infos" id="m_infos" placeholder="個人說明 60字以內"><?php echo $user['m_infos'];?></textarea>
  <div class="jui_public_btn">
    <input type="button" value="保存">
  </div>
</form>
<!-- 主體end -->
<script src="/public/js/cityjs.js"></script>
<script language="javascript">
	$(function(){
		$('.jui_public_btn').click(function(){
			var region	 = $('#sel_city').html();
			if(region.trim()=='' || region.trim()=='請選擇地區'){
				layer.msg('請選擇地區');return;
			}
			var m_name	 = $('#m_name').val();
			if(m_name.trim()==''){
				layer.msg('請填寫真實姓名');return;
			}
			var m_weixin	 = $('#m_weixin').val();
			if(m_weixin.trim()==''){
				layer.msg('請填寫LINE號');return;
			}
			var m_infos	 = $('#m_infos').val();
			if(m_infos.trim()==''){
				layer.msg('請選擇個人說明');return;
			}
			var xxx= new FormData(document.querySelector("form"));
			xxx.append("m_region",region.trim());
			$.ajax('?m=user&c=setting', {method: 'POST',data: xxx,processData: false,contentType: false,
			  success: function (data) {
				if(data.code==1){
					layer.msg(data.msg,{icon:1,time:1000},function(){
						if(data.msg=='修改成功'){
							window.location.href='?m=user&c=index';	
						}else{
							window.location.href='?m=user&c=wlogs';	
						}
					});	
				}else{
					layer.msg(data.msg);
				}
			  },dataType:'json'
			});
		});
	});
</script
</body>
</html>
