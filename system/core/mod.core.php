<?php

class mod {
	protected $db_prefix;
	protected $version;
	protected $db;
	protected $post;
	protected $ispage;
	protected $time;
	protected $request_time_from;
	protected $request_time_to;
	protected $clients 		= array( 'web', 'mobile' );
	protected $client_type 	= 'mobile';
	protected $user_levels;
	protected $base_levels;
	protected $user_nick;
	protected $agent_levels;
	protected $user_prices  = array();
	protected $logs_type 	= array( 0 => '後臺充值', 1 => '後臺減扣', 2 => '用戶充值', 3 => '用戶消費');
	protected $admin_type 	= array( 0 => '系統禁用', 1 =>'正常使用');
	protected $logs_status 	= array( 0 => '待付款', 1 => '已完成');
	protected $user_gender 	= array( 0 => '未知', 1 => '男', 2 => '女');
	protected $banner_cate	= array( 0=>'',1=>'首頁',2=>'商盟',3=>'課堂',4=>'代理商');
	protected $suit_type	= array( 0=>'聯系不到對方',1=>'惡意擡高定價',2=>'銷售偽劣產品',3=>'交易存在欺詐',4=>'其他違規行為');
	protected $user_check 	= true;                 //登錄檢查
	protected $user_session = 'CLIENTUSER';
	protected $admin_session= 'CLIENTADMIN';
	protected $user;
	protected $config;
	protected $smsset;
	protected $viprice;
	public    $pagesize 	= 20;

	public function __construct() {
		$this->db_prefix 	= DB_PREFIX;
		$this->db 			= core::lib( 'db' );
		$this->post 		= strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) === 'post' ? true : false;
		$this->ispage 		= ( array_key_exists( 'ispage', $_POST ) && $_POST[ 'ispage' ] === 'true' ) ? true : false;
		$this->time 		= time();
		$this->config 		= $this->db->query('select * from w_config where id=1',2);
		$this->smsset 		= $this->db->query('select * from w_sms where id=1',2);
		define('WEBNAME', $this->config['w_name']);
		$levels				=$this->db->query('select * from w_level order by id asc',3);
		$user_level			=array(0=>'普通會員');
		$base_level			=array(0=>'普通會員');
        $user_nick			=array(0=>'暫無');
		foreach($levels as $l){
			$user_level[$l['id']] =$l['l_name'];
            $user_nick[$l['id']]  =$l['l_nick'];
			if($l['id']<=$this->config['w_level']){
				$base_level[$l['id']]=$l['l_name'];
			}
		}
		$this->user_levels	= $user_level;
		$this->base_levels	= $base_level;
		$this->user_nick	= $user_nick;
        $agent				=$this->db->query('select * from w_agent order by a_level asc',3);
        $agent_level		=array(0=>'普通用戶');
        foreach($agent as $k => $v){
            $agent_level[$v['a_level']] = $v['a_name'];
        }
        $this->agent_levels 	= $agent_level;
		$this->webname 		= WEBNAME;
		if($this->config['w_hour']>0){
			$this->autofinish();
		}

	}
	public function changepid($uid,$pid){ //修改接點人關系
		//$old_pid $new_pid $old_line $new_line
		$cur_user 	=$this->db->query('select * from w_users where id='.$uid,2);
		$old_pid	=$cur_user['m_pid'];
		$old_line	=$cur_user['m_line'];
		
		//更新老節點人的首層人數
		$old_user	=$this->db->query('select * from w_users where id='.$old_pid,2);
        if(!empty($old_user)){
            $old_num	=intval($old_user['m_num']>1)?intval($old_user['m_num']-1):0;
            $this->db->update('w_users', array('m_num'=>$old_num),array('id'=>$old_pid));
        }
		
		//更新新節點人的首層人數
		$new_user	=$this->db->query('select * from w_users where id='.$pid,2);
        if(!empty($new_user)){
            $new_num	=intval($new_user['m_num']+1);
            $new_line	=$new_user['m_line'].','.$uid;//新的節點
            $this->db->update('w_users', array('m_num'=>$new_num),array('id'=>$pid));
        }else{
            $new_line	='0,'.$uid;//新的節點
        }
		$new_layer  =count(explode(',',$new_line))-1;
		//更新當前會員的 m_line m_layer m_pid 信息
		$this->db->update('w_users', array('m_line'=>$new_line,'m_layer'=>$new_layer,'m_pid'=>$pid),array('id'=>$uid));
		//查找所有uid的下級 循環更新 m_line和m_layer信息
		$all_down	=$this->db->query("select * from w_users where m_line like '%,".$uid.",%'",3);
		foreach($all_down as & $down){
			$down_line	=str_replace($old_line,$new_line,$down['m_line']);
			$down_layer	=count(explode(',',$down_line))-1;
			$this->db->update('w_users', array('m_line'=>$down_line,'m_layer'=>$down_layer),array('id'=>$down['id']));
		}
		return 1;
	}
	
	public function autofinish(){
		$mintime	=3600*$this->config['w_hour'];
		$startime 	=time()-$mintime;
		$users		=$this->db->query('select * from w_users where m_del=0 and m_level=0 and m_regtime<='.$startime, 3);
		if(count($users)>0){
			foreach($users as $u){
				$userid		= $u['id'];
				$this->db->update('w_users', array('m_del'=>1,'m_level'=>0),array('id'=>$userid));
				if($u['m_pid']){//到期自動刪除會員 並更新節點人的壹層人數
					$m_pid		= $u['m_pid'];
					$query		= "select * from w_users where id='".$m_pid."' and m_del=0";
					$member		= $this->db->query($query, 2);
					$m_num		= $member['m_num']-1;
					if($m_num<0){$m_num=0;}
					$this->db->update('w_users', array('m_num'=>$m_num),array('id'=>$m_pid));	
				}
				//刪除會員的訂單記錄
				$this->db->query('delete from w_uplevel where uid='.$userid.' or sid='.$userid,0);
			}
		}
	}
    //mod.mod

    //統計商鋪信息
    public function CountScore($sid){
        $product_score = 3;   //產品
        $sever_score = 3;     //服務
        $logistics_score = 3; //物流
	    $score = $this->db->query("select id,sid,ping1,ping2,ping3 from w_uplevel where status=1 and sid='".$sid."' and ping1 <> 0 or ping2 <> 0 or ping3 <> 0",3);
	    if(!empty($score)){
           $score_count = count($score);
           $ping1 = array_sum(array_map(function($val){return $val['ping1'];},$score));
           $ping2 = array_sum(array_map(function($val){return $val['ping2'];},$score));
           $ping3 = array_sum(array_map(function($val){return $val['ping3'];},$score));
           $product_score = $ping1/$score_count;
           $sever_score = $ping2/$score_count;
           $logistics_score = $ping3/$score_count;
        }
        return array(
            'product_score'=>$product_score,
            'sever_score'=>$sever_score,
            'logistics_score'=>$logistics_score,
        );

    }

    public function getUpID($lines,$level,$index,$layer){
        $ret_id  = 0;
        $m_layer = $layer-$index;
        if($m_layer>0){
            if($level>0){       //level = index
                $t_user=$this->db->query('select id,m_del,m_layer from w_users where m_lock=0 and m_del=0 and id in ('.$lines.') and m_layer<='.$m_layer.' and m_level>='.$level.' order by m_layer desc',2);
            }else{
                $t_user=$this->db->query('select id,m_del,m_layer from w_users where m_lock=0 and m_del=0 and id in ('.$lines.') and m_layer='.$m_layer.' order by m_layer desc',2);
            }
            if(!empty($t_user)){
                $ret_id  = $t_user['id'];
            }
        }
        return $ret_id;
    }


	public function getDowns($id,$t){
		$user		 =$this->db->query('select id,m_level,m_name,m_del,m_phone,m_lock from w_users where id='.$id,2);
		$up_level    =$this->db->query('select count(id) as up_level_num from w_uplevel where sid='.$id,2);
        $level_num   =empty($up_level['up_level_num'])?0:intval($up_level['up_level_num']);//團隊總人數
        $ret_array	=array(
            'name' =>'<a href="?m=user&c=tree&id='.$user['id'].'">'.$user['m_name'].'('.$user['id'].')</a>',
        );

        $m_title =  $user['m_phone'].'<br/>'.$this->user_levels[$user['m_level']].'<br/><span>成單數量：'.$level_num.'</span><br/>'.'<span style="color: #00c1ff">狀態：運營中</span>';
        if($user['m_lock'] > 0){
            $m_title =  $user['m_phone'].'<br/>'.$this->user_levels[$user['m_level']].'<br/><span>成單數量：'.$level_num.'</span><br/>'.'<span style="color:#ffb11d">狀態：已鎖定</span>';
        }
        if($user['m_del'] > 0){
            $m_title =  $user['m_phone'].'<br/>'.$this->user_levels[$user['m_level']].'<br/><span>成單數量：'.$level_num.'</span><br/>'.'<span style="color:red">狀態：已刪除</span>';
        }
        $ret_array['title'] = $m_title;
		$childs =array();
		if($t<3){
			$t			=$t+1;
			$users		=$this->db->query('select id,m_level,m_name,m_del,m_phone from w_users where m_pid='.$id.' order by id asc',3);
			if($users){
				foreach($users as $u){
					$d_user=$this->getDowns($u['id'],$t);
					array_push($childs,$d_user);
				}
			}
		}
		$ret_array['children']=$childs;
		return $ret_array;
	}


	public function do_score($uid,$ping){
        $user  		= $this->db->query('select * from w_users where id='.$uid,2);
		if($user){
			$ping_str	= 'w_ping'.$ping;
			$score 		= $user['m_score'] + $this->config[$ping_str];
			$this->db->update('w_users', array('m_score' => $score), array('id'=> $uid));
		}
		return 1;
	}
	
    public function do_logs($uid,$type, $num, $minfo){
        $user = $this->db->query('select * from w_users where id=' . $uid, 2);
        $field = 'm_money';
        if ($user) {
            $money = $user[$field] + $num;
            $this->db->update('w_users', array($field => $money), array('id' => $uid));
            $logs = array(
                'l_uid' => $uid,
                'l_type' => $type,
                'l_num' => $num,
                'l_info' => $minfo,
                'l_time' => time()
            );
            $this->db->insert('w_logs', $logs);
            return 1;
        } else {
            return 0;
        }
    }

    //生成訂單號
    public function getNum(){
        $str='1234597890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str),0,5). time().rand(100,999);
    }




	public function getPidbyTid($tid){
		$max_num  = $this->config['w_frame'];
        $w_huanum = $this->config['w_huanum'];        //接收滑落的數量
		if($max_num==1){
			if($this->config['w_hualuo']==0){
				return $tid;
			}else{
                //判斷推薦人是否滿足直推人數的條件
                $s_user  = $this->db->query("select id,m_level,m_tid,m_pid from w_users where `m_del`='0' and `m_tid` = '$tid'",3);
                $s_count = count($s_user);
                if($s_count < $w_huanum){
                    return $tid;
                }else{
                    return $this->GetSlipingPidByTid($tid);
                }
			}
		}else{
			$p_user	 = $this->db->query('select count(id) as p_count from w_users where m_del=0 and m_pid='.$tid,2); 
			$p_count = empty($p_user['p_count'])?0:intval($p_user['p_count']);
			if($p_count<$max_num){                  //如果自己下面沒有滿員，則放到自己下面
				return $tid;
			}else{                                  //找出當前會員下所有壹星會員及以上會員 且第壹層會員數量小於架構數量的會員
                $w_hlevel = $this->config['w_hlevel'];
                $query = "select * from `w_users` where m_line like '%," . $tid . ",%' and m_del=0 and m_lock=0 and m_level>=" . $w_hlevel . " and m_num<" . $max_num . " order by id asc limit 0,1";
                $puser = $this->db->query($query, 2);
                if (!empty($puser)) {
                    return $puser['id'];
                } else {
                    return $tid;
                }
			}
		}
	}

    //會員滑落機制
    public function GetSlipingPidByTid($tid){
        $w_hlevel=$this->config['w_hlevel'];        //接收滑落的級別
        $w_huanum=$this->config['w_huanum'];        //接收滑落的數量
        $s_user  = $this->db->query("select id,m_level,m_tid,m_pid from w_users where `m_del`='0' and `m_tid` = '$tid' and `m_level`>='$w_hlevel' and `m_lock` = '0' order by m_regtime asc",3);
        if(!empty($s_user)){
            $data = array();
            foreach ($s_user as $row){
                $row_id = $row['id'];
                $z_user  = $this->db->query("select count(id) as z_count from w_users where `m_del`='0' and `m_pid` = '$row_id' and `m_tid` = '$row_id' order by m_regtime desc",2);
                $z_count = empty($z_user['z_count'])?0:intval($z_user['z_count']);      //直推人數
                $n_user  = $this->db->query("select count(id) as n_count from w_users where `m_del`='0' and `m_pid` = '$row_id' and `m_tid` <> '$row_id' order by m_regtime desc",2);
                $n_count = empty($n_user['n_count'])?0:intval($n_user['n_count']);      //已滑落的人數
                $data[] = array(
                    'uid'          =>   $row_id,
                    'z_num'        =>   $z_count,
                    'n_num'        =>   $n_count,
                );
            }
            $arr = $this->arraySort($data,'z_num','desc');
            foreach ($arr as $row2){
                if($row2['z_num'] != 0 and $row2['n_num'] < $w_huanum and $row2['n_num'] < $row2['z_num']){
                    return $row2['uid'];
                }
            }
        }
        return $tid;
    }

    function arraySort($arr,$keys,$type='asc'){
        $keys_value = $new_array = array();
        foreach ($arr as $k=>$v){
            $keys_value[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keys_value);
        }else{
            arsort($keys_value);
        }
        reset($keys_value);
        foreach ($keys_value as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

    public function GetUpMember($uid){
	    $num = 0;
        $team = $this->db->query("select * from w_users where m_line like '%,".$uid.",%' and m_del=0 and m_level >= 1",3);
        if(!empty($team)){
            foreach($team as $k => $v){
                $p_user =  $this->db->query("select count(id) as p_num from w_users where m_line like '%,".$v['id'].",%' and m_del=0 and m_level >= 1",2);
                if(!empty($p_user['p_num']) and intval($p_user['p_num']) >= 4){
                    $num = $num+1;
                }
            }
        }
        return $num;
    }



	public function upgrade_do($logid){
		$u_log=$this->db->query('select * from w_uplevel where id='.$logid, 2);
		if($u_log){
			if($u_log['status']==0){
				$this->db->update('w_uplevel', array('status'=>1,'d_time'=>time()),array('id'=>$logid));
				$userid=$u_log['uid'];
				$logs  =$this->db->query('select * from w_uplevel where status=0 and uid='.$userid,3);
				if(count($logs)<=0){//沒有未審核的記錄
					$level =$u_log['level'];
//                  $agent = 0;
//					if($level >= 1){
//                        $agent = 1;
//                    }
//                    if($level == 1){
//                        $up_level = time();
//                        $this->db->update('w_users', array('m_upleveltime'=>$up_level),array('id'=>$userid));
//                    }
					//$this->db->update('w_users', array('m_level'=>$level,'m_upleveltime'=>$up_level),array('id'=>$userid));
					$this->db->update('w_users', array('m_level'=>$level),array('id'=>$userid));
					if($this->smsset['w_user_snt']){
						$v_phone=$this->getMember($userid,'m_phone');
						$this->sendcode($v_phone,'snt');
					}
					return 2;
				}else{
					return 1;	
				}
			}else{				
				return 0;				
			}			
		}else{
			return 0;
		}	
	}
	public function creatNo(){
		return date('YmdHis',time()).$this->generate_code(6);
	}

	public function creatSeed(){
		return date('ymd',time()).$this->generate_code(5);	
	}
	function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}

	protected function getMember( $uid, $keys ) {
		$sql 	 = 'select id,'.$keys.' from w_users where id=' . $uid;
		$members = $this->db->query( $sql, 2 );
		if(empty($members)){
			return '暫無';
		}
		return $members[ $keys ];
	}
    protected function getProduct($pid, $keys) {
        $sql 	 = 'select p_id,'.$keys.' from w_product where p_id=' . $pid;
        $product = $this->db->query( $sql, 2 );
        if(empty($product)){
            return '暫無';
        }
        return $product[$keys];
    }
	protected function getHang($cid,$key){
		$sql	 ='select id,'.$key.'  from w_cates where id='.$cid;
		$cate	 =$this->db->query($sql, 2);
		if(empty($cate)){
			return '無';
		}
		return $cate[$key];
	}
	
	protected function getUser( $uid) {
		$sql 	 = 'select id,m_name,m_phone from w_users where id=' . $uid;
		$members = $this->db->query( $sql, 2 );
		if(empty($members)){
			return '未知';
		}
		return $members['m_name'].'('.$members['id'].')<br/>'.$members['m_phone'];
	}

    protected function getUsers( $uid) {
        $sql 	 = 'select id,m_name,m_phone from w_users where id=' . $uid;
        $members = $this->db->query( $sql, 2 );
        if(empty($members)){
            return '未知';
        }
        return '昵稱：'.$members['m_name'].' 手機號：'.$members['m_phone'];
    }

	public function blankmsg($title,$alert='',$url=''){
		header("Content-type:text/html;charset=utf-8");
		echo '<!DOCTYPE html>';
		echo '	 <html lang="zh-CN">';
		echo '	 <head>';
		echo '	 <meta charset="utf-8">';
		echo '	 <meta name="viewport" content="minimum-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">';
		echo '	 <title>'.$title.'</title>';
		echo '	 </head>';
		echo '	 <body>';
		echo '	<script>';
		if($alert!=''){echo 'alert("'.$alert.'");';}
		if($url!=''){echo 'window.location.href="'.$url.'";';}
		echo '	</script>';
		echo '	 </body>';
		echo '	 </html>';
	}
	protected function checkuser() {
		$url_login = '?m=index&c=login';
		if ($_SESSION['uid'] && $_SESSION['uid'] != '' ) {
			$uid	=intval($_SESSION['uid']);
			$sql		="select * from w_users where id=".$uid;
			$user		= $this->db->query($sql, 2);
			if($user){
				$_SESSION[$this->user_session] = serialize($user);
				return $user;
			}else{
				header( 'Location: ' . $url_login );
				exit;
			}
		} else {
			header( 'Location: ' . $url_login );
			exit;
		}
	}
	protected function checkadmin() {
		$url_login = 'admin.php?m=index&c=login';
		if ( $_SESSION['admin_id'] && $_SESSION['admin_id'] != '' ) {
			$admin_id	=intval($_SESSION['admin_id']);
			$sql		="select * from w_admin where id=".$admin_id;
			$user		= $this->db->query($sql, 2);
			if(!empty($user)){
                $index_url = 'admin.php?m=index&c=index';
                $m = isset($_GET['m']) ? $_GET['m'] : 'index';
                $c = isset($_GET['c']) ? $_GET['c'] : 'index';
                $auth = $this->db->query("select * from w_auth where `a_ctl`='$m' and `a_fun` = '$c'", 2);
                if(!empty($auth)){
                    $auth_id = ','.$auth['id'].',';
                    $role    = $this->db->query("select * from w_role where r_auth_ids like '%$auth_id%' and id = ".$user['w_role'],2);
//                    $_SESSION[$this->admin_session] = serialize($user);
//                    return $user;
                    if(!empty($role) and $role['id'] == $user['w_role']){
                        $_SESSION[$this->admin_session] = serialize($user);
                        return $user;
                    }else{
                        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                            return 1;
                        }else{
                            header('Content-Type:text/html;charset=utf-8');
                            echo "<script type='text/javascript'>";
                            echo "alert('您當前沒有訪問權限！');";
                            echo "top.location.href='?m=index&c=index';";
                            echo "</script>";
                            exit;
                        }
                    }
                }else{
                    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                        return 1;
                    }else{
                        // 正常請求的處理方式
                        header('Content-Type:text/html;charset=utf-8');
                        echo "<script type='text/javascript'>";
                        echo "alert('暫無該權限,請前往添加');";
                        echo "top.location.href = 'admin.php?m=index&c=auth_index';";
                        echo "</script>";
                        exit;
                    }
                }

			}else{
				header( 'Location: ' . $url_login );
				exit;
			}
		} else {
			header( 'Location: ' . $url_login );
			exit;
		}
	}
 	public function exportToExcel($filename, $tileArray=[], $dataArray=[]){
        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$filename);
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp,$tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if($index==1000){
                $index=0;
                ob_flush();
                flush();
            }
            $index++;
            fputcsv($fp,$item);
        }
        ob_flush();
        flush();
        ob_end_clean();
 	}
	public function retEmptyImg(){
		header('Content-type:image/png');
		$EmptyImg = imagecreatetruecolor(1,1);
		$color 	  = imagecolorallocate($EmptyImg, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
		imagefilledrectangle($EmptyImg,0,1,1,0,$color);
		imagepng($EmptyImg);
		imagedestroy($EmptyImg);
	}
	public function captcha(){
		$_vc				= core::lib( 'captcha' );
		$_vc->doimg();  
		$_SESSION['captcha']= $_vc->getCode();
	}
	public function sendsms($pnum,$psms){
		$sendurl='http://api.smsbao.com/sms?u='.$this->smsset['w_user_name'].'&p='.md5($this->smsset['w_user_pass']).'&m='.$pnum.'&c='.urlencode($psms);
		return file_get_contents($sendurl);
	}
	public function sendcode($phonenum,$type){
		$sms_key	='w_user_'.$type.'_sms';
		$sms_txt	=$this->smsset[$sms_key];
		$sms_name	='用戶';
		$member			=$this->db->query("select id,m_phone,m_name from w_users where m_phone='$phonenum'",2);
		if($member){
			$sms_name	=$member['m_name'];
		}
		$verifycode =$this->generate_code(6);
		$sms_txt	=str_replace("{NAME}",$sms_name,$sms_txt);
		$sms_txt	=str_replace("{CODE}",$verifycode,$sms_txt);
		$_SESSION['verycode']=$verifycode;
		return $this->sendsms($phonenum,$sms_txt);
	}
	public function verifycode(){
		$sendcode	=$_GET['verifycode'];
		if($_SESSION['verycode']==$sendcode){
			echo 1;
		}else{
			echo 0;
		}
	}
	public function generate_code($length) {
		return rand(pow(10,($length-1)), pow(10,$length)-1);
	}	
	protected function dialogue( $opt ) {
		header( 'X-Error-Message: dialogue' );
		echo json_encode( $opt );
		exit;
	}
	protected function display( $tpl_name, $args = array() ) {
		define( 'TPL', SYSTEM . '/tpl/' . MODULE . '/' . $this->client_type );
		extract( $args );
        $path = TPL . '/' . $tpl_name . '.php';
        if(file_exists($path)){
            require($path);
        }else{
            echo " <script>
                window.location.href = '?m=index&c=index'
</script>";
        }
	}
	private function randomkeys( $length ) {
		$key = "";
		$pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$pattern1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pattern2 = '0123456789';
		for ( $i = 0; $i < $length; $i++ ) {
			$key .= $pattern {
				mt_rand( 0, 35 )
			};
		}
		return $key;
	}
  	public function getip() {
      if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
          $ip = getenv('HTTP_CLIENT_IP');
      } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
          $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
          $ip = getenv('REMOTE_ADDR');
      } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
          $ip = $_SERVER['REMOTE_ADDR'];
      }
      $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
      return $res;
	}
	public function random( $length, $numeric = FALSE ) {
		$seed = base_convert( md5( microtime() . $_SERVER[ 'DOCUMENT_ROOT' ] ), 16, $numeric ? 10 : 35 );
		$seed = $numeric ? ( str_replace( '0', '', $seed ) . '012340567890' ) : ( $seed . 'zZ' . strtoupper( $seed ) );
		if ( $numeric ) {
			$hash = '';
		} else {
			$hash = chr( rand( 1, 26 ) + rand( 0, 1 ) * 32 + 64 );
			$length--;
		}
		$max = strlen( $seed ) - 1;
		for ( $i = 0; $i < $length; $i++ ) {
			$hash .= $seed {
				mt_rand( 0, $max )
			};
		}
		return $hash;
	}
	public function SafeFilter($arr){
		$ra = Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
		if (is_array($arr)){
		 foreach ($arr as $key => $value){
			if (!is_array($value)){
			  if (!get_magic_quotes_gpc()){
				 $value  = addslashes($value);                              //給單引號（'）、雙引號（"）、反斜線（\）與NUL（NULL字符）加上反斜線轉義
			  }
			  $value       = preg_replace($ra,'',$value);      //刪除非打印字符，粗暴式過濾xss可疑字符串
			  $arr[$key]   = $value;                                       //去除 HTML 和 PHP 標記並轉換為HTML實體
			}else{
			  SafeFilter($arr[$key]);
			}
		 }
	    }
		return $arr;
	}
}