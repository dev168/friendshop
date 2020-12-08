<?php
class mod_user extends mod {
	public function index(){
		$user	=$this->checkuser();
		$j_time =strtotime(date('Y-m-d',time()));
		$orders =$this->db->query('select count(id) as j_num from w_uplevel where c_time>'.$j_time.' and sid='.$user['id'],2);
		$j_num  =empty($orders['j_num'])?0:intval($orders['j_num']);
		$orders =$this->db->query('select count(id) as d_num from w_uplevel where status=0 and sid='.$user['id'],2);
		$d_num  =empty($orders['d_num'])?0:intval($orders['d_num']);
		$orders =$this->db->query('select count(id) as y_num from w_uplevel where status=1 and sid='.$user['id'],2);
		$y_num  =empty($orders['y_num'])?0:intval($orders['y_num']);
		$t_user =$this->db->query('select * from w_users where `id` = '.$user['m_tid'],2);
		$this->display('user.index',array('user'=>$user,'j_num'=>$j_num,'d_num'=>$d_num,'y_num'=>$y_num,'t_user'=>$t_user));
	}
	
	public function fetch(){
		$user		=$this->checkuser();

		$page   	=isset($_GET['page']) && $_GET['page']!=''?intval($_GET['page']):1;
		$limit  	=isset($_GET['limit']) && $_GET['limit']!=''?intval($_GET['limit']):20;
		$condtion	="sid=".$user['id'];

		$type		=isset($_GET['type']) && !empty($_GET['type'])?intval($_GET['type']):0;
		$condtion.=" and status=".$type;

		$query  	="select * from w_uplevel where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;		
		$data 		=$this->db->query($query, 3);
		foreach($data as &$row){
			$row['m_phone']	=$this->getMember($row['uid'],'m_phone');
			$row['m_id']	=$row['uid'];
			$row['m_weixin']=$this->getMember($row['uid'],'m_weixin');
			$row['m_name']	=$this->getMember($row['uid'],'m_name');
			if($type==0){
				$row['m_time']	=date('Y-m-d H:i:s',$row['c_time']);
			}else{
				$row['m_time']	=date('Y-m-d H:i:s',$row['d_time']);
			}
			$row['m_level']	=$this->user_levels[$row['level']];
		}
		echo json_encode($data);
	}
	
	public function order(){
		$user		=$this->checkuser();
		$type		=isset($_GET['type']) && !empty($_GET['type'])?intval($_GET['type']):0;
        $condtion	="sid=".$user['id'];
        $condtion.=" and status=".$type;
        $query  	="select * from w_uplevel where ".$condtion." order by id desc";
        $data 		=$this->db->query($query, 3);
        foreach($data as &$row){
            $row['m_phone']	=$this->getMember($row['uid'],'m_phone');
            $row['m_id']	=$row['uid'];
            $row['m_weixin']=$this->getMember($row['uid'],'m_weixin');
            $row['m_name']	=$this->getMember($row['uid'],'m_name');
            if($type==0){
                $row['m_time']	=date('Y-m-d H:i:s',$row['c_time']);
            }else{
                $row['m_time']	=date('Y-m-d H:i:s',$row['d_time']);
            }
            $row['m_level']	=$this->user_levels[$row['level']];
        }
		$this->display('user.order',array('user'=>$user,'type'=>$type,'data'=>$data));
	}
	public function shen_up(){
		$user		=$this->checkuser();
		if ($this->post) {
			$logid=intval($_POST['id']);
			$u_log=$this->db->query('select * from w_uplevel where id='.$logid, 2);
			if($u_log && $u_log['sid']==$user['id']){
//                $s_user = $this->db->query('select * from w_users where id='.$u_log['sid'], 2);
//                if($u_log['level'] == 1 and $s_user['m_level'] < 2){
//                    echo json_encode(array('code'=>0,'msg'=>'您的級別過低,請升級後重試'));exit();
//                }
				if($u_log['level']>$user['m_level']){
					echo json_encode(array('code'=>0,'msg'=>'您的級別過低,請升級後重試'));exit();
				}

				if($u_log['status']){					
					echo json_encode(array('code'=>0,'msg'=>'已審核,請勿重復審核'));exit();				 
				}else{
					if($this->upgrade_do($logid)>0){
						echo json_encode(array('code'=>1,'msg'=>'審核成功'));exit();
					}else{
						echo json_encode(array('code'=>0,'msg'=>'發生未知錯誤'));exit();
					}					
				}
			}else{
				echo json_encode(array('code'=>0,'msg'=>'沒有權限'));exit();
			}	
		}		
	}
	public function share(){
		$user		 = $this->checkuser();
		$this->display('user.share',array('user'=>$user));
	}
	public function shopfile(){
		$user	=$this->checkuser();
		if ($this->post) {
			$m_avatar=$this->upload('upload_file');
			if(!empty($m_avatar)){
				echo json_encode(array('success'=>true,'msg'=>'上傳成功','file_path'=>$m_avatar));exit();
			}
		}
		$this->display('user.avatar',array('user'=>$user));			 
	}
	public function avatar(){
		$user	=$this->checkuser();
		if ($this->post) {
			$m_avatar=$this->upload('headimg');
			if(!empty($m_avatar)){
				$this->db->update('w_users',array('m_avatar'=>$m_avatar),array('id'=>$user['id']));
				echo json_encode(array('code'=>1,'msg'=>'上傳成功'));exit();
			}else{
				echo json_encode(array('code'=>0,'msg'=>'上傳失敗'));exit();
			}
		}
		$this->display('user.avatar',array('user'=>$user));			 
	}
	public function qrcode(){
		$user	=$this->checkuser();
		if ($this->post) {
			$m_qrcode=$this->upload('headimg');
			if(!empty($m_qrcode)){
				$this->db->update('w_users',array('m_qrcode'=>$m_qrcode),array('id'=>$user['id']));
				echo json_encode(array('code'=>1,'msg'=>'上傳成功'));exit();
			}else{
				echo json_encode(array('code'=>0,'msg'=>'上傳失敗'));exit();
			}
		}
		$this->display('user.qrcode',array('user'=>$user));			 
	}
	public function logout(){
		session_destroy();
		$url_index = '?m=index&c=login&logout_type=1';
		header('Location: '.$url_index);
		exit();
	}
	public function wlogs(){
		$user		=$this->checkuser();
		$status_txt	=array('審核中','已審核');
		$wlogs	=$this->db->query('select * from w_wlog where l_uid='.$user['id'].' order by id desc',3);
		if($wlogs){
			foreach($wlogs as &$row){
				$row['status']=$status_txt[$row['l_status']];
			}
		}
		$this->display('user.wlogs',array('user'=>$user,'wlogs'=>$wlogs));			 
	}
	public function setting(){
		$user		=$this->checkuser();
		$u_cates 	=$this->db->query("select * from `w_cates` where c_type=1 order by c_index asc", 3);
		if ($this->post) {
			$fields = $this->SafeFilter($_POST);
			if(empty($fields['m_name'])){
                echo json_encode(array('code'=>0,'msg'=>'姓名不能為空'));exit();
			}
			if(empty($fields['m_weixin'])){
                echo json_encode(array('code'=>0,'msg'=>'LINE不能為空'));exit();
			}
			if(empty($fields['m_infos'])){
                echo json_encode(array('code'=>0,'msg'=>'個人簡介不能為空'));exit();
			}
			if(empty($fields['m_region'])){
                echo json_encode(array('code'=>0,'msg'=>'地區不能為空'));exit();
			}
			$regions	=explode(' ',$fields['m_region']);
			$m_sheng	=$regions[0];
			$m_shi		='';
			if(count($regions)>1){
				$m_shi		=$regions[1];
			}
			$member	=array(
				'm_name'			=>$fields['m_name'],
				'm_gender'			=>$fields['m_gender'],
				'm_hang'			=>intval($fields['m_hang']),
				'm_sheng'			=>$m_sheng,
				'm_shi'				=>$m_shi,
				//'m_svideo'			=>$fields['m_svideo'],
				'm_blogs'			=>$fields['m_blogs'],
				//'m_goods'			=>$fields['m_goods'],
				'm_infos'			=>strlen($fields['m_infos'])>180?substr($fields['m_infos'],0,180):$fields['m_infos']
			);
			
			$msg='修改成功';
			if($fields['m_weixin']!=$user['m_weixin'] && $this->config['w_shenhe']==1){//2019-04-23新增代碼
				$w_wlog=array(
					'l_uid'		=>$user['id'],
					'l_old'		=>$user['m_weixin'],
					'l_new'		=>$fields['m_weixin'],
					'l_time'	=>time(),
					'l_status'	=>0
				);
				$this->db->insert('w_wlog', $w_wlog);
				$msg='您修改了LINE號,請聯系客服審核';
			}else{
				$member['m_weixin']	=$fields['m_weixin'];
			}
			$this->db->update('w_users',$member,array('id'=>$user['id']));	
			echo json_encode(array('code'=>1,'msg'=>$msg));exit();	
		}
		$this->display('user.setting',array('user'=>$user,'u_cates'=>$u_cates));			 
	}
	
	public function repass(){
		$user		=$this->checkuser();
		if ($this->post) {
			$fields = $this->SafeFilter($_POST);
			$o_pass = $fields['o_pass'];
			$n_pass = $fields['n_pass'];
			if(md5($o_pass)!=$user['m_pass']){
				echo json_encode(array('code'=>0,'msg'=>'原密碼不正確'));exit();	
			}
			if(empty($n_pass) || strlen($n_pass)<6){
				echo json_encode(array('code'=>0,'msg'=>'新密碼最低6位'));exit();	
			}
			$this->db->update('w_users',array('m_pass'=>md5($n_pass)),array('id'=>$user['id']));	
			echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit();	
		}
		$this->display('user.repass',array('user'=>$user));			 
	}
	
	public function uplevel(){
		$user		=$this->checkuser();
		$n_level	=$user['m_level'];
		$u_level	=$user['m_level']+1;
		$is_upgrade	=1;
		$level		=$this->db->query('select * from w_level where id='.$u_level,2);
		if(empty($level)){
			$is_upgrade=0;
			$msg		='未找到升級級別';
		}
		if($level['l_tnum']>0){
			$members    =$this->db->query('select id,m_tid,m_del from w_users where m_del=0 and `m_level` >= '.$level['l_tlevel'].' and m_tid='.$user['id'],3);
			if(count($members)<$level['l_tnum']){
				$is_upgrade=0;
				$msg		='直推人數未達標';
			}
		}
		if($level['l_znum']>0){
			$members    =$this->db->query("select id,m_line,m_del from w_users where m_del=0 and `m_level` >= ".$level['l_zlevel']." and m_line like '%,".$user['id'].",%'",3);
			if(count($members)<$level['l_znum']){
				$is_upgrade=0;
				$msg		='團隊人數未達標';
			}
		}
		if($u_level>$this->config['w_level']){
			$is_upgrade	=-1;
			$msg		='您當前已是最高級別';
		}

        //新增加的代碼
        $lines  = $user['m_line'];          //當前用戶的所有上級
        $layer  = $user['m_layer'];         //當前用戶所在層級
        //$u_level 要升級的級別
        $one_index   = $level['l_user1'];     //壹單匹配位置  1
        $one_level1   = $level['l_level1'];   //壹單匹配等級  1


        #####20190517新增邏輯 ######
       /* if($u_level==1 && $user['m_pid'] != $user['m_tid']){              //第壹單匹配給推薦人,
            $one_id    =  $user['m_tid'];
        }elseif($one_index>0){
            $one_id = $this->getUpID($lines,$one_level1,$one_index,$layer);
        }else{
            $one_id = 0;
        }
        $two_index   = $level['l_user2'];                                 //二單匹配位置 5
        $two_level1  = $level['l_level2'];   //壹單匹配等級  1
        if($u_level==1 && $user['m_pid'] != $user['m_tid']){              //即使不要求2單的匹配，第二單給節點人
            $two_id    =  $user['m_tid'];
        }elseif($two_index>0){
            $two_id     = $this->getUpID($lines,$two_level1,$two_index,$layer);
        }else{
            $two_id     = 0;
        }*/
        ###########END############

        #####原有模式 ######
        if($u_level==1 && $user['m_pid'] != $user['m_tid']){              //即使不要求2單的匹配，也要給推薦人和節點人各壹單
            $one_id    =  $user['m_tid'];
        }elseif($one_index>0){
            $one_id = $this->getUpID($lines,$one_level1,$one_index,$layer);
        }else{
            $one_id = 0;
        }
        $two_index   = $level['l_user2'];       //二單匹配位置 5
        $two_level1   = $level['l_level2'];     //二單匹配等級 1
        if($two_index>0){
            $two_id     = $this->getUpID($lines,$two_level1,$two_index,$layer);
        }else{
            $two_id     = 0;
        }
        ###########END############
        if($one_id==0 && $level['l_user1']>0){      //如果系統要求匹配而沒有找到
            $one_id = $this->config['w_user'];

        }
        if($two_id==0 && $level['l_user2']>0){      //如果系統要求匹配而沒有找到
            $two_id = $this->config['w_user2'];
        }
        #####新增代碼避免兩單匹配給同壹個人######
       /* if($one_id == $two_id){

        }*/
        ###########END############

        $up_user = array();
        if($one_id != false){
            $up_user['0'] = array(
                'm_name'=>$this->getMember($one_id,'m_name'),
                'm_level'=>$this->getMember($one_id,'m_level'),
            );
        }

        if($two_id != false){
            $up_user['1'] = array(
                'm_name'=>$this->getMember($two_id,'m_name'),
                'm_level'=>$this->getMember($two_id,'m_level'),
            );
        }
		if ($this->post) {
			if($is_upgrade<1){
				echo json_encode(array('code'=>0,'msg'=>$msg));exit();
			}
			$w_up_level  =  $this->db->query("select * from `w_uplevel` WHERE `uid` = '".$user['id']."' AND `status` = '0'",3);
			if(count($w_up_level)>0){
				echo json_encode(array('code'=>0,'msg'=>'升級審核中,請耐心等待'));exit();
			}
			if($one_id){
				$uplevel = array(
					'uid'		=>$user['id'],
					'sid'		=>$one_id,
					'level'		=>$u_level,
					'status'	=>0,
					'c_time'	=>time(),
					'd_time'	=>0,
					'price'		=>$level['l_price1'],
					'l_type'	=>1
				);
				$this->db->insert('w_uplevel', $uplevel);
				if($this->smsset['w_user_dnt']){
					$v_phone=$this->getMember($one_id,'m_phone');
					$this->sendcode($v_phone,'dnt');
				}
			}
			if($two_id){
				$uplevel = array(
					'uid'		=>$user['id'],
					'sid'		=>$two_id,
					'level'		=>$u_level,
					'status'	=>0,
					'c_time'	=>time(),
					'd_time'	=>0,
					'price'		=>$level['l_price2'],
                    'l_type'	=>2
				);
				$this->db->insert('w_uplevel', $uplevel);
				if($this->smsset['w_user_dnt']){
					$v_phone=$this->getMember($two_id,'m_phone');
					$this->sendcode($v_phone,'dnt');
				}
			}
			echo json_encode(array('code'=>1,'msg'=>'申請成功'));exit();
		}
        $team2      =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$user['id'].",%' and id<>".$user['id']." and m_del=0 and m_level>0",2);
        $t_num      =empty($team2['t_num'])?0:intval($team2['t_num']);
		$this->display('user.uplevel',array('user'=>$user,'level'=>$level,'n_level'=>$n_level,'u_level'=>$u_level,'is_upgrade'=>$is_upgrade,'t_num'=>$t_num,'up_user'=>$up_user));
	}
	public function logs(){
		$user		=$this->checkuser();
		$type		=isset($_GET['type']) && !empty($_GET['type'])?intval($_GET['type']):0;
		$w_up_level =$this->db->query('select * from `w_uplevel` WHERE `uid` = '.$user['id'].' AND `status` ='.$type.' order by id desc',3);
		if($w_up_level){
			foreach($w_up_level as &$row){
				$row['m_phone']	=$this->getMember($row['sid'],'m_phone');
				$row['m_id']	=$row['sid'];
				$row['m_weixin']=$this->getMember($row['sid'],'m_weixin');
				$row['m_name']	=$this->getMember($row['sid'],'m_name');
				if($type==0){
					$row['m_time']	=date('Y-m-d H:i:s',$row['c_time']);
				}else{
					$row['m_time']	=date('Y-m-d H:i:s',$row['d_time']);
				}
                $row['m_levels']	= $this->getMember($row['sid'],'m_level');
                $row['m_fen']		= $this->getMember($row['sid'],'m_score');
                $row['m_level']		= $this->user_levels[$row['m_levels']];
                $row['u_levels']	= $this->user_levels[$row['level']];
                $row['m_svideo']	=$this->getMember($row['sid'],'m_svideo');
                $row['m_blogs']	=$this->getMember($row['sid'],'m_blogs');
                $row['m_goods']	=$this->getMember($row['sid'],'m_goods');
			}
		}
		$this->display('user.logs',array('user'=>$user,'logs'=>$w_up_level,'type'=>$type));			 
	}
	public function ping(){
		$user		=$this->checkuser();
		$id			=isset($_GET['id']) && !empty($_GET['id'])?intval($_GET['id']):0;
		$w_up_level =$this->db->query('select * from `w_uplevel` WHERE `uid` = '.$user['id'].' AND `id` ='.$id,2);
		if($w_up_level){
				if ($this->post){
					$sc_id	= $w_up_level['sid'];
					$fields = $this->SafeFilter($_POST);
					$pings=array(
						'ping'	=>$fields['ping'],
						'ping1'	=>$fields['ping1'],
						'ping2'	=>$fields['ping2'],
						'ping3'	=>$fields['ping3'],
					);
					$this->db->update('w_uplevel', $pings,array('id'=>$id));
					$this->do_score($sc_id,$fields['ping']);
					echo json_encode(array('code'=>1,'msg'=>'評價成功'));exit();
				}
				$w_up_level['m_phone']		= $this->getMember($w_up_level['sid'],'m_phone');
				$w_up_level['m_weixin']		= $this->getMember($w_up_level['sid'],'m_weixin');
				$w_up_level['m_name']		= $this->getMember($w_up_level['sid'],'m_name');
                $w_up_level['m_fen']		= $this->getMember($w_up_level['sid'],'m_score');
				$w_up_level['m_time']		= date('Y-m-d H:i:s',$w_up_level['d_time']);
                $w_up_level['m_level']		= $this->getMember($w_up_level['sid'],'m_level');
                $w_up_level['m_levels']		= $this->user_levels[$w_up_level['m_level']];
                $w_up_level['u_levels']		= $this->user_levels[$w_up_level['level']];
			$this->display('user.ping',array('user'=>$user,'logs'=>$w_up_level,'id'=>$id));			 
		}else{
			$this->blankmsg('提示','未找到訂單','?m=user&c=logs');
			exit();
		}
	}
	public function upload($name){
		if($_FILES[$name]["error"]){
			echo json_encode(array('code'=>1,'msg'=>'發生錯誤'));exit();
		}else{
			if(($_FILES[$name]["type"]=="image/png"||$_FILES[$name]["type"]=="image/jpeg")&&$_FILES[$name]["size"]<10240000){
					$filename =substr(strrchr($_FILES[$name]["name"], '.'), 1);
					$filename ="./static/upload/".date('Ymd',time()).$this->getMillisecond().'.'.$filename;
					if(file_exists($filename)){
						return '';
					}else{  
						move_uploaded_file($_FILES[$name]["tmp_name"],$filename);
						return $filename;    
					}        
			}else {
				return '';
			}
		}
	}
	public function about(){
		$id 	=intval($_GET['id']);
		$about	=$this->db->query('select * from w_about where id='.$id,2);
		$this->display('user.about',array('about'=>$about));
	}
	public function message(){
		$user		=$this->checkuser();
		if ($this->post) {
			$fields = $this->SafeFilter($_POST);
			if(empty($fields['m_title'])){
                echo json_encode(array('code'=>0,'msg'=>'請填寫您要投訴的手機/LINE'));exit();
			}
			if(empty($fields['m_infos'])){
                echo json_encode(array('code'=>0,'msg'=>'請填寫詳細投訴內容'));exit();
			}
			$message=array(
					'm_uid'		=>$user['id'],
					'm_title'	=>$fields['m_title'],
					'm_type'	=>$fields['m_type'],
					'm_infos'	=>$fields['m_infos'],
					'm_ctime'	=>time(),
					'm_dtime'	=>0,
					'm_status'	=>0
			);
			$this->db->insert('w_message', $message);
			echo json_encode(array('code'=>1,'msg'=>'投訴成功,請等待平臺處理'));exit();	
		}
		$this->display('user.message',array('user'=>$user));
	}
	public function mlogs(){
		$user		=$this->checkuser();
		$status_txt	=array('待處理','已處理');
		$mlogs		=$this->db->query('select * from w_message where m_uid='.$user['id'],3);
		if($mlogs){
			foreach($mlogs as &$row){
				$row['status']=$status_txt[$row['m_status']];
			}
		}
		$this->display('user.mlogs',array('user'=>$user,'mlogs'=>$mlogs));			 
	}
//	public function three_index(){
//        $user = $this->checkuser();
//        $uid = ",".$user['id'].",";
//        $members    =$this->db->query("select * from w_users where m_del=0 and m_line like '%,$uid,%' OR id ='".$user['id']."'",3);
//        if(!empty($members)){
//            foreach ($members as $k => $v){
//                if($v['id'] == $user['id']){
//                    $v['m_pid'] = 0;
//                }
//                $a = array(
//                    'id'=> $v['id'],
//                    'name'=> $v['id'],
//                    'pid'=> $v['m_pid'],
//                    'uname'=> $v['m_name'],
//                    'level'=> $this->user_levels[$v['m_level']],
//                );
//                $arr[] = $a;
//            }
//        }else{
//           $arr = [];
//        }
//        echo json_encode(
//            array(
//                'code'=>0,
//                'data'=>$arr
//            )
//        );exit();
//
//    }
}
?>