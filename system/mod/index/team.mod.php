<?php
class mod_team extends mod {
	public function index(){
		$user		=$this->checkuser();
		$u_cates 	=$this->db->query("select * from `w_cates` where c_type=1 order by c_index asc", 3);
		$setting	=0;
		if($user['m_name']==''){$setting=1;}
		if($user['m_weixin']==''){$setting=1;}
		if($user['m_infos']==''){$setting=1;}
		if($user['m_sheng']==''){$setting=1;}
		if($user['m_shi']==''){$setting=1;}
		$this->display('team.index',array('user'=>$user,'u_cates'=>$u_cates,'setting'=>$setting));			 
	}
	public function teams(){
		$user	     =$this->checkuser();
        $teams       =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$user['id'].",%' and m_del=0",2);
        $t_num_1     =empty($teams['t_num'])?0:intval($teams['t_num']);//团队总人数
		
        $teams       =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$user['id'].",%' and m_del=0 and m_level>0",2);
        $t_num_2     =empty($teams['t_num'])?0:intval($teams['t_num']);//一星及以上人数
		
		$t_nums		 =array();
		foreach($this->base_levels as $k=>$v){
			$teams       =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$user['id'].",%' and m_del=0 and m_level=".$k,2);
			$t_num_3     =empty($teams['t_num'])?0:intval($teams['t_num']);
			$t_nums[$k]	 =array('t_name'=>$v,'t_num'=>$t_num_3);
		}
		
		$this->display('team.teams',array('user'=>$user,'t_nums'=>$t_nums,'t_num_1'=>$t_num_1,'t_num_2'=>$t_num_2));			 
	}
	public function fetch(){
		$user		= $this->checkuser();
		$deeps		= $user['m_layer']+$user['m_level'];//查找层级
		$page   	= isset($_GET['page']) && $_GET['page']!=''?intval($_GET['page']):1;
		$limit  	= isset($_GET['limit']) && $_GET['limit']!=''?intval($_GET['limit']):20;
		$condtion	= "m_del=0 and m_line like '%,".$user['id'].",%' and m_layer<=".$deeps." and id<>".$user['id'];
		$fields 	= $this->SafeFilter($_GET);
		if(isset($_GET['s_region']) && $_GET['s_region']!=''){
			$regions	=explode(' ',urldecode($fields['s_region']));
			$m_sheng	=$regions[0];
			$m_shi		='';
			if(count($regions)>1){
				$m_shi	=$regions[1];
			}
			$condtion.=" and (m_sheng like '%".$m_sheng."%' and m_shi like '%".$m_shi."%')";
		}
		if(isset($_GET['s_key']) && $_GET['s_key']!=''){
			$s_key=urldecode($fields['s_key']);
			$condtion.=" and (m_name like '%".$s_key."%' or m_weixin like '%".$s_key."%' or m_phone like '%".$s_key."%')";
		}
		$s_gender   =isset($_GET['s_gender'])?intval($_GET['s_gender']):0;
		$s_hang	    =isset($_GET['s_hang'])?intval($_GET['s_hang']):0;
		if($s_gender){
			$condtion.=" and m_gender=".$s_gender;
		}
		if($s_hang){
			$condtion.=" and m_hang=".$s_hang;
		}
		$query  	="select id,m_qrcode,m_avatar,m_name,m_phone,m_infos from w_users where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;
		$data 		=$this->db->query($query, 3);
		echo json_encode($data);
	}

	public function user(){
        $user		=$this->checkuser();
		$level		=isset($_GET['t'])?intval($_GET['t']):-1;
        $team_1     =$this->db->query("select count(id) as t_num from w_users where m_tid=".$user['id']." and m_del=0 and m_level>0",2);
        $t_num_1    =empty($team_1['t_num'])?0:intval($team_1['t_num']);//一星及以上人数
		if($level>=0){
        	$query  	="select * from `w_users` where m_tid=".$user['id']." and m_del=0 and m_level=".$level." order by id desc";
		}else{
        	$query  	="select * from `w_users` where m_tid=".$user['id']." and m_del=0 order by id desc";
		}
        $teams	 	=$this->db->query($query, 3);
		$t_num		=count($teams);//直推人数
        $this->display('team.user',array('user'=>$user,'teams'=>$teams,'t_num'=>$t_num,'t_num_1'=>$t_num_1,'level'=>$level));
	}

	public function infos(){
		$user		=$this->checkuser();
		if ($this->post) {
			$fields = $this->SafeFilter($_POST);
			if(empty($fields['phone'])){
                echo json_encode(array('code'=>0,'msg'=>'无效会员'));exit();
			}
			$val_1	 = $fields['phone'];
			$sql     = "select * from w_users where m_phone='$val_1' and m_del=0";
			$member  = $this->db->query($sql, 2);
			if(empty($member)){
                echo json_encode(array('code'=>0,'msg'=>'无效会员'));exit();
			}
			$u_cate	=$this->db->query("select * from `w_cates` where id=".$member['m_hang'], 2);
			if($u_cate){
				$m_hang=$u_cate['c_name'];
			}else{
				$m_hang='';
			}
			$ret_html='
			 <div class="jui_box_conbar">
				 <div class="jui_box_con">
					   <div class="jui_public_tit jui_flex_justify_center jui_fc_000 jui_font_weight jui_fs15">'.$member['m_name'].' 的名片</div>
					   <div class="jui_h12"></div>
					   <div class="box_rm_ewm"><img src="'.$member['m_qrcode'].'"></div>
					   <p class="jui_text_center jui_pad_t5">LINE号：'.$member['m_weixin'].'</p>
					   <div class="jui_h12"></div>
					   <div class="box_rm_text">
							<p>级别：'.$this->user_levels[$member['m_level']].'</p>
							<p>电话：'.$member['m_phone'].'</p>
							<p>地区：'.$member['m_sheng'].' '.$member['m_shi'].'</p>
							<p>行业：'.$m_hang.'</p>
							<p>注册时间：'.date('Y-m-d H:i:s',$member['m_regtime']).'</p>
							<p>'.$member['m_infos'].'</p>
					   </div>
					   <div class="jui_h20"></div>
					   <div class="jui_box_close iconfont" id="close2" style="cursor:pointer;">&#xe61f;</div>
				 </div>
			 </div>';
			echo json_encode(array('code'=>1,'msg'=>$ret_html));exit();	
		}
		$this->display('user.message',array('user'=>$user));
	}
	
		
}
?>