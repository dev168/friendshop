<?php
class mod_shop extends mod {
	public function cates(){
		$user	=$this->checkadmin();
        if(!isset($_GET['c_type'])){
            $c_type = 1;
        }else{
            $c_type = $_GET['c_type'];
        }
		$this->display('shop.cate',array('user'=>$user,'c_type'=>$c_type));
	}
	public function catelist(){
        $c_type     =$_GET['c_type'];
        $user		=$this->checkadmin();
        $query  	="select * from `w_cates` WHERE `c_type` = $c_type order by c_index asc";
        $banks	 	=$this->db->query($query, 3);
		foreach($banks as &$rows){
			$rows['c_img']	= $rows['c_img']==''?'':'<img src="'.$rows['c_img'].'" height="30">';
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>count($banks),'data'=>$banks));
		exit();
	}
	public function addcate(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $c_type     =$_GET['c_type'];
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['c_name']==''){echo json_encode(array('status'=>0,'msg'=>'分类名称不能为空'));exit();}
			if($fields['c_img']==''){echo json_encode(array('status'=>0,'msg'=>'分类图片不能为空'));exit();}
			if($fields['c_index']==''){echo json_encode(array('status'=>0,'msg'=>'分类排序不能为空'));exit();}
  			$cates	=array(
				'c_name'			=>$fields['c_name'],
				'c_img'				=>$fields['c_img'],
				'c_index'			=>$fields['c_index'],
				'c_type'			=>$c_type
			);
			$cateid=$this->db->insert('w_cates', $cates);
			if($cateid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
			$this->display('shop.addcate',array('user'=>$user,'cateid'=>0,'c_type'=>$c_type));
		}
	}
	public function editcate(){
		$user	 =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid	 =$_GET['id'];
		$sql	 ="select * from w_cates where id=".$cateid;
		$cates	 =$this->db->query($sql, 2);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['c_name']==''){echo json_encode(array('status'=>0,'msg'=>'分类名称不能为空'));exit();}
			if($fields['c_img']==''){echo json_encode(array('status'=>0,'msg'=>'分类图片不能为空'));exit();}
			if($fields['c_index']==''){echo json_encode(array('status'=>0,'msg'=>'分类排序不能为空'));exit();}
  			$cates	=array(
				'c_name'			=>$fields['c_name'],
				'c_img'				=>$fields['c_img'],
				'c_index'			=>$fields['c_index'],
			);
			$this->db->update('w_cates', $cates,array('id'=>$cateid));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
			$this->display('shop.addcate',array('user'=>$user,'cateid'=>$cateid,'cates'=>$cates));
		}
	}
	public function delcate(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid		=intval($_POST['id']);
		$this->db->query('delete from w_cates where id='.$cateid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
	public function getcate($id){
		$query  	="select * from `w_cates` where id=".$id;
		$cates	 	=$this->db->query($query, 2);
		if($cates){
			return $cates['c_name'];
		}else{
			return '无分类';
		}
	}

    public function GetShop($id){
        $query  	="select * from `w_shops` where id=".$id;
        $shop	 	=$this->db->query($query, 2);
        if(empty($shop)){
            return $shop['s_name'];
        }else{
            return '后台发布';
        }
    }

	public function apply(){
		$user	= $this->checkadmin();
		$type	= intval($_GET['type']);
		$cates 	= $this->db->query("select * from `w_cates` WHERE `c_type` = '1' order by c_index asc", 3);
		$this->display('shop.index',array('user'=>$user,'type'=>$type,'cates'=>$cates));	
	}
	public function shop_add(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$query  	="select * from `w_cates` WHERE `c_type` = '1' order by c_index asc";
		$cates	 	=$this->db->query($query, 3);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['s_name']==''){echo json_encode(array('status'=>0,'msg'=>'商户名称不能为空'));exit();}
			if($fields['s_uid']==''){echo json_encode(array('status'=>0,'msg'=>'所属用户不能为空'));exit();}
			if($fields['s_type']=='' || $fields['s_type']==0){echo json_encode(array('status'=>0,'msg'=>'请选择行业分类'));exit();}
			if($fields['s_region']==''){echo json_encode(array('status'=>0,'msg'=>'地区不能为空'));exit();}
			if($fields['s_address']==''){echo json_encode(array('status'=>0,'msg'=>'详细地址不能为空'));exit();}
			if($fields['s_info']==''){echo json_encode(array('status'=>0,'msg'=>'商户简介不能为空'));exit();}
 
 			if($fields['s_img']==''){echo json_encode(array('status'=>0,'msg'=>'商户主图不能为空'));exit();}
			if($fields['s_info']==''){echo json_encode(array('status'=>0,'msg'=>'商户简介不能为空'));exit();}

 			$shop	=array(
				's_name'			=>$fields['s_name'],
				's_type'			=>$fields['s_type'],
				's_uid'				=>$fields['s_uid'],
				's_region'			=>$fields['s_region'],
				's_address'			=>$fields['s_address'],
				's_info'			=>strlen($fields['s_info'])>180?substr($fields['s_info'],0,180):$fields['s_info'],
				
				's_img'				=>$fields['s_img'],
				's_zhizhao'			=>$fields['s_zhizhao'],
				's_idfront'			=>$fields['s_idfront'],
				's_idback'			=>$fields['s_idback'],
				's_content'			=>$fields['s_content'],
				
				's_status'			=>$fields['s_status'],
				's_hot'				=>$fields['s_hot'],
				's_read'			=>$fields['s_read'],
				
				's_ctime'			=>strtotime($fields['s_ctime']),
				's_dtime'			=>strtotime($fields['s_dtime'])
			);
			$shopid=$this->db->insert('w_shops', $shop);
			if($shopid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
			$this->display('shop.add',array('user'=>$user,'shopid'=>0,'cates'=>$cates));
		}
	}
	public function shop_edit(){
		$user	 	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$shopid 	=$_GET['id'];
		$sql	 	="select * from w_shops where id=".$shopid;
		$shop	 	=$this->db->query($sql, 2);
		$query  	="select * from `w_cates` WHERE `c_type` = '1' order by c_index asc";
		$cates	 	=$this->db->query($query, 3);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['s_name']==''){echo json_encode(array('status'=>0,'msg'=>'商户名称不能为空'));exit();}
			if($fields['s_uid']==''){echo json_encode(array('status'=>0,'msg'=>'所属用户不能为空'));exit();}
			if($fields['s_type']=='' || $fields['s_type']==0){echo json_encode(array('status'=>0,'msg'=>'请选择行业分类'));exit();}
			if($fields['s_region']==''){echo json_encode(array('status'=>0,'msg'=>'地区不能为空'));exit();}
			if($fields['s_address']==''){echo json_encode(array('status'=>0,'msg'=>'详细地址不能为空'));exit();}
			if($fields['s_info']==''){echo json_encode(array('status'=>0,'msg'=>'商户简介不能为空'));exit();}
 			if($fields['s_img']==''){echo json_encode(array('status'=>0,'msg'=>'商户主图不能为空'));exit();}
			if($fields['s_info']==''){echo json_encode(array('status'=>0,'msg'=>'商户简介不能为空'));exit();}
 			$shop	=array(
				's_name'			=>$fields['s_name'],
				's_type'			=>$fields['s_type'],
				's_uid'				=>$fields['s_uid'],
				's_region'			=>$fields['s_region'],
				's_address'			=>$fields['s_address'],
				's_info'			=>strlen($fields['s_info'])>180?substr($fields['s_info'],0,180):$fields['s_info'],
				
				's_img'				=>$fields['s_img'],
				's_zhizhao'			=>$fields['s_zhizhao'],
				's_idfront'			=>$fields['s_idfront'],
				's_idback'			=>$fields['s_idback'],
				's_content'			=>$fields['s_content'],
				
				's_status'			=>$fields['s_status'],
				's_hot'				=>$fields['s_hot'],
				's_read'			=>$fields['s_read'],
				
				's_ctime'			=>strtotime($fields['s_ctime']),
				's_dtime'			=>strtotime($fields['s_dtime'])
			);
			$this->db->update('w_shops', $shop,array('id'=>$shopid));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
			$this->display('shop.add',array('user'=>$user,'shopid'=>$shopid,'shop'=>$shop,'cates'=>$cates));
		}
	}
	public function del(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$bankid		=intval($_POST['id']);
		$this->db->query('delete from w_shops where id='.$bankid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}

	//商户列表
    public function shop_list(){
        $status_name	=array('待审核','已审核');
        $type   		=isset($_GET['type'])?intval($_GET['type']):0;
        $s_type	    	=(isset($_GET['s_type']) && !empty($_GET['s_type']))?intval($_GET['s_type']):0;

        $page     =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit    =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;

        $condtion="1";
        $condtion	 .=' and s_status='.$type;
        if($s_type){$condtion	 .=' and s_type='.$s_type;}

        if(isset($_GET['s_regt']) && $_GET['s_regt']!=''){
            $s_regt	  	=urldecode($_GET['s_regt']);
            $s_times  	=explode(' - ',$s_regt);
            $s_btime	=strtotime(trim($s_times[0]));
            $s_etime	=strtotime(trim($s_times[1]));
            if($type){
                $condtion.=" and s_dtime>=".$s_btime." and s_dtime<=".$s_etime;
            }else{
                $condtion.=" and s_ctime>=".$s_btime." and s_ctime<=".$s_etime;
            }
        }
        if(isset($_GET['s_name']) && $_GET['s_name']!=''){
            $s_name	  	=urldecode($_GET['s_name']);
            $condtion.=" and (s_name like '%".$s_name."%' or s_info like '%".$s_name."%')";
        }
        $query1  	= "select * from w_shops where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;
       
        $query2  	= "select count(id) as total from `w_shops` where ".$condtion;
        $data1 		= $this->db->query($query1, 3);
        $data2 		= $this->db->query($query2, 2);
        foreach($data1 as &$row){
            $row['user_info']	=$this->getUser($row['s_uid']);
            $row['shop_name']	=$row['s_name'];
            $row['shop_cate']	=$this->getcate($row['s_type']);
            $row['shop_img']	=$row['s_img']==''?'':'<img src="'.$row['s_img'].'" height="60">';
            $row['shop_add']	=$row['s_region'].'<br/>'.$row['s_address'];
            $row['shop_info']	=$row['s_info'];
            $row['shop_photo']	='<a href="'.$row['s_zhizhao'].'" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">营业执照</a>
								 <br/><a href="'.$row['s_idfront'].'" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">正面</a>
								 <a href="'.$row['s_idback'].'" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">反面</a>';
            $row['shop_read']	=$row['s_read'];
            if($type){
                $row['shop_time']	=date('Y-m-d H:i:s',$row['s_dtime']);
            }else{
                $row['shop_time']	=date('Y-m-d H:i:s',$row['s_ctime']);
            }
            if($row['s_hot']){
                $row['shop_tui']='<a class="layui-btn layui-btn-danger layui-btn-xs">是</a>';
            }else{
                $row['shop_tui']='<a class="layui-btn layui-btn-primary layui-btn-xs">否</a>';
            }
        }

        echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
        exit();
    }

    public function goods_index(){
        $user	= $this->checkadmin();
        $this->display('goods.index',array('user'=>$user));
    }

    //商品列表
	public function goods_data(){
        $user	 	=$this->checkadmin();
        $page       =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit      =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condtion   ="`g_addtime` <> '0'";
        if(isset($_GET['g_title']) && $_GET['g_title']!=''){
            $g_title	  	= urldecode($_GET['g_title']);
            $condtion.=" and (g_title like '%".$g_title."%' or g_price like '%".$g_title."%')";
        }
        $query1  	= "select * from w_goods where ".$condtion." order by g_addtime desc limit ".$limit*($page-1).",".$limit;
        $query2  	= "select count(g_id) as total from `w_goods` where ".$condtion;
        $goods 		= $this->db->query($query1, 3);
        $g_count 	= $this->db->query($query2, 2);
        foreach($goods as &$row){
            $row['g_id']	    =$row['g_id'];
            $row['g_title']	    =$row['g_title'];
            $row['g_price']	    =$row['g_price'];
            $row['g_pic']	    =$row['g_pic']==''?'':'<img src="'.$row['g_pic'].'" height="60">';
            $row['g_shop']	    =$this->GetShop($row['g_shop']);
            $row['g_addtime']	=date('Y-m-d H:i',$row['g_addtime']);
        }
        echo json_encode(array('code'=>0,'count'=>$g_count['total'],'data'=>$goods));
    }

    public function goods_add(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if ($this->post) {
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['g_title']==''){echo json_encode(array('status'=>0,'msg'=>'商品名称不能为空'));exit();}
            if($fields['g_shop']==''){echo json_encode(array('status'=>0,'msg'=>'所属商铺不能为空'));exit();}
            if($fields['g_price']==''){echo json_encode(array('status'=>0,'msg'=>'商品价格不能为空'));exit();}
            if($fields['g_content']==''){echo json_encode(array('status'=>0,'msg'=>'商品详情不能为空'));exit();}
            if($fields['g_pic']==''){echo json_encode(array('status'=>0,'msg'=>'商品封面不能为空'));exit();}
            $shop 	= $this->db->query("select * from w_shops where `id` = '".$fields['g_shop']."'", 3);
            if(empty($shop)){echo json_encode(array('status'=>0,'msg'=>'所属商铺不存在'));exit();}
            $goods	=array(
                'g_title'			=>$fields['g_title'],
                'g_price'			=>$fields['g_price'],
                'g_pic'				=>$fields['g_pic'],
                'g_shop'			=>$fields['g_shop'],
                'g_tui'			    =>$fields['g_tui'],
                'g_content'			=>$fields['g_content'],
                'g_addtime'			=>time(),
            );
            $g_id=$this->db->insert('w_goods', $goods);
            if($g_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
            }
        }else{
            $this->display('goods.add',array('user'=>$user,'g_id'=>0));
        }
    }

    public function goods_edit(){
        $user	 	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $g_id 	=$_GET['g_id'];
        $sql	 	="select * from w_goods where g_id=".$g_id;
        $gs	 	=$this->db->query($sql, 2);
        if ($this->post) {
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['g_title']==''){echo json_encode(array('status'=>0,'msg'=>'商品名称不能为空'));exit();}
            if($fields['g_shop']==''){echo json_encode(array('status'=>0,'msg'=>'所属商铺不能为空'));exit();}
            if($fields['g_price']==''){echo json_encode(array('status'=>0,'msg'=>'商品价格不能为空'));exit();}
            if($fields['g_content']==''){echo json_encode(array('status'=>0,'msg'=>'商品详情不能为空'));exit();}
            if($fields['g_pic']==''){echo json_encode(array('status'=>0,'msg'=>'商品封面不能为空'));exit();}
            $shop 	= $this->db->query("select * from w_shops where `id` = '".$fields['g_shop']."'", 3);
            if(empty($shop)){echo json_encode(array('status'=>0,'msg'=>'所属商铺不存在'));exit();}
            $goods	=array(
                'g_title'			=>$fields['g_title'],
                'g_price'			=>$fields['g_price'],
                'g_pic'				=>$fields['g_pic'],
                'g_shop'			=>$fields['g_shop'],
                'g_content'			=>$fields['g_content'],
                'g_tui'			    =>$fields['g_tui'],
                'g_addtime'			=>time(),
            );
            $this->db->update('w_goods', $goods,array('g_id'=>$g_id));
            echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();
        }else{
            $this->display('goods.add',array('user'=>$user,'g_id'=>$g_id,'goods'=>$gs));
        }
    }

    public function goods_del(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $g_id		=intval($_POST['g_id']);
        $this->db->query('delete from w_goods where g_id='.$g_id,0);
        echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
    }


}

?>