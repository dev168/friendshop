<?php
class mod_agent extends mod {
    //产品列表
    public function product_list(){
        $user	= $this->checkadmin();
        $cate 	= $this->db->query("select * from `w_cates` WHERE `c_type` = '2' order by c_index asc", 3);
        $this->display('product.index',array('user'=>$user,'cate'=>$cate));
    }

    //产品数据
    public function product_data(){
        $p_type	        =(isset($_GET['p_type']) && !empty($_GET['p_type']))?intval($_GET['p_type']):0;
        $page           =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit          =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condition       ="`p_addtime` <> '0'";
        if($p_type != 0){
            $condition	    .=' and `p_type`='.$p_type;
        }
        if(isset($_GET['p_title']) && $_GET['p_title']!='') {
            $p_title = urldecode($_GET['p_title']);
            $condition .= " and (p_title like '%" . $p_title . "%' or p_price like '%" . $p_title . "%')";
        }
        $sql  	= "select * from w_product where ".$condition." order by p_id desc limit ".$limit*($page-1).",".$limit;
        $query  	= "select count(p_id) as total from `w_product` where ".$condition;
        $pro 		= $this->db->query($sql, 3);
        $pro_count 		= $this->db->query($query, 2);
        foreach($pro as &$row){
            $row['p_cover']	            =$row['p_cover']==''?'':'<a target="_blank" href="'.$row['p_cover'].'"><img src="'.$row['p_cover'].'" height="60"></a>';
            $row['p_addtime']	        =date('Y-m-d H:i',$row['p_addtime']);
            $row['p_type']              =$this->getcate($row['p_type']);
            $row['p_price_type']        =$row['p_price_type']==1?'代理折扣':'单独定价';
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$pro_count['total'],'data'=>$pro));
        exit();
    }

    //产品添加
    public function product_add(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $query  	="select * from `w_cates` WHERE `c_type` = '2' order by c_index asc";
        $cate	 	=$this->db->query($query, 3);
        $query  	="select * from `w_agent` order by a_level asc";
        $agent	 	=$this->db->query($query, 3);
        if ($this->post){
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['p_title']==''){echo json_encode(array('status'=>0,'msg'=>'产品标题不能为空'));exit();}
            if($fields['p_cover']==''){echo json_encode(array('status'=>0,'msg'=>'产品主图不能为空'));exit();}
            if($fields['p_type']=='' || $fields['p_type']==0){echo json_encode(array('status'=>0,'msg'=>'请选择行业分类'));exit();}
            if($fields['p_price']==''){echo json_encode(array('status'=>0,'msg'=>'产品原价不能为空'));exit();}
            if($fields['p_sort']==''){echo json_encode(array('status'=>0,'msg'=>'请输入产品排序'));exit();}
            if($fields['p_desc']==''){echo json_encode(array('status'=>0,'msg'=>'产品描述不能为空'));exit();}
            if($fields['p_price_type'] == 2){
                $p_a_price = [];
                foreach($fields as $k=>$v){
                    if(is_int($k)){
                        if($v == '' and $v == false){
                            echo json_encode(array('status'=>0,'msg'=>'代理商价格不能为空'));exit();
                        }
                        $p_a_price[$k] = $v;
                    }
                }
                $p_a_price = json_encode($p_a_price,true);
            }else{
                $p_a_price = 0;
            }
            $product	=array(
                'p_title'			=>$fields['p_title'],
                'p_sort'			=>$fields['p_sort'],
                'p_price'			=>$fields['p_price'],
                'p_cover'			=>$fields['p_cover'],
                'p_type'			=>$fields['p_type'],
                'p_desc'			=>$fields['p_desc'],
                'p_tui'			    =>$fields['p_tui'],
                'p_yishou'			=>$fields['p_yishou'],
                'p_a_price'			=>$p_a_price,
                'p_price_type'		=>$fields['p_price_type'],
                'p_addtime'			=>time(),
            );
            $p_id = $this->db->insert('w_product', $product);
            if($p_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
            }
        }else{
            $this->display('product.add',array('user'=>$user,'p_id'=>0,'cate'=>$cate,'agent'=>$agent));
        }
    }

    //产品添加
    public function product_edit(){
        $user		= $this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $p_id 	    = $_GET['p_id'];
        $sql	 	= "select * from w_product where p_id=".$p_id;
        $product	= $this->db->query($sql, 2);
        $p_a_price = array();
        if($product['p_price_type'] == 2){
            $p_a_price = json_decode($product['p_a_price'],true);
        }
        $query  	="select * from `w_cates` WHERE `c_type` = '2' order by c_index asc";
        $cate	 	=$this->db->query($query, 3);
        $query  	="select * from `w_agent` order by a_level asc";
        $agent	 	=$this->db->query($query, 3);
        if ($this->post){
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['p_title']==''){echo json_encode(array('status'=>0,'msg'=>'产品标题不能为空'));exit();}
            if($fields['p_cover']==''){echo json_encode(array('status'=>0,'msg'=>'产品主图不能为空'));exit();}
            if($fields['p_type']=='' || $fields['p_type']==0){echo json_encode(array('status'=>0,'msg'=>'请选择行业分类'));exit();}
            if($fields['p_price']==''){echo json_encode(array('status'=>0,'msg'=>'产品原价不能为空'));exit();}
            if($fields['p_sort']==''){echo json_encode(array('status'=>0,'msg'=>'请输入产品排序'));exit();}
            if($fields['p_desc']==''){echo json_encode(array('status'=>0,'msg'=>'产品描述不能为空'));exit();}
            if($fields['p_price_type'] == 2){
                $p_a_price = [];
                foreach($fields as $k=>$v){
                    if(is_int($k)){
                        if($v == '' and $v == false){
                            echo json_encode(array('status'=>0,'msg'=>'代理商价格不能为空'));exit();
                        }
                        $p_a_price[$k] = $v;
                    }
                }
                $p_a_price = json_encode($p_a_price,true);
            }else{
                $p_a_price = 0;
            }
            $product	=array(
                'p_title'			=>$fields['p_title'],
                'p_sort'			=>$fields['p_sort'],
                'p_price'			=>$fields['p_price'],
                'p_cover'			=>$fields['p_cover'],
                'p_type'			=>$fields['p_type'],
                'p_desc'			=>$fields['p_desc'],
                'p_tui'			    =>$fields['p_tui'],
                'p_yishou'			=>$fields['p_yishou'],
                'p_a_price'			=>$p_a_price,
                'p_price_type'		=>$fields['p_price_type'],
                'p_addtime'			=>time(),
            );
            $this->db->update('w_product', $product,array('p_id'=>$p_id));
            if($p_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
            }
        }else{
            $this->display('product.add',array('user'=>$user,'p_id'=>$p_id,'cate'=>$cate,'agent'=>$agent,'product'=>$product,'p_a_price'=>$p_a_price));
        }
    }

    //产品删除
    public function product_del(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $p_id		= intval($_POST['p_id']);
        $this->db->query('delete from w_product where p_id='.$p_id,0);
        echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
    }

    //用户入驻
    public function agent_apply(){
        $user	= $this->checkadmin();
        $this->display('agent.apply',array('user'=>$user));
    }

    //入驻申请数据
    public function apply_data(){
        $page           =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit          =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condition       ="`l_atime` <> '0'";
        if(isset($_GET['l_name']) && $_GET['l_name']!='') {
            $l_name = urldecode($_GET['l_name']);
            $condition .= " and (l_name like '%" . $l_name . "%' or l_tel like '%" . $l_name . "%' or l_weichat like '%" . $l_name ."%')";
        }

        if(isset($_GET['l_stime']) && $_GET['l_stime']!=''){
            $l_time	  	=urldecode($_GET['l_stime']);
            $l_stime  	=explode(' - ',$l_time);
            $l_atime_one	=strtotime(trim($l_stime[0]));
            $l_atime_two	=strtotime(trim($l_stime[1]));
            $condition.=" and l_atime>=".$l_atime_one." and l_atime<=".$l_atime_two;
        }

        if(isset($_GET['l_etime']) && $_GET['l_etime']!=''){
            $l_time	  	=urldecode($_GET['l_etime']);
            $l_etime  	=explode(' - ',$l_time);
            $l_ctime_one	=strtotime(trim($l_stime[0]));
            $l_ctime_two	=strtotime(trim($l_stime[1]));
            $condition.=" and l_ctime>=".$l_ctime_one." and l_ctime<=".$l_ctime_two;
        }
        $sql  	            = "select * from w_apply where ".$condition." order by l_atime desc limit ".$limit*($page-1).",".$limit;
        $query  	        = "select count(l_id) as total from `w_apply` where ".$condition;
        $apply 		        = $this->db->query($sql, 3);
        $apply_count 		= $this->db->query($query, 2);
        foreach($apply as &$row){
            $row['m_name']  = $this->getMember($row['l_uid'],'m_name');
            $row['l_level'] = $this->GetAgent($row['l_level']);
            $row['l_atime'] = date('Y-m-d H:i:s',$row['l_atime']);
            $row['l_ctime'] = $row['l_ctime'] == '0'?' ':date('Y-m-d H:i:s',$row['l_ctime']);
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$apply_count['total'],'data'=>$apply));
        exit();
    }

    //代理商审核
    public function apply_sta(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $l_id		=intval($_POST['l_id']);
        $l_apply		=$this->db->query('select * from w_apply where l_id='.$l_id,2);
        if(!empty($l_apply)){
            if($l_apply['l_status']==0){
                $this->db->update('w_users', array('m_agent'=>$l_apply['l_level']),array('id'=>$l_apply['l_uid']));
                $this->db->update('w_apply', array('l_status'=>1),array('l_id'=>$l_id));
                echo json_encode(array('code'=>1,'msg'=>'成功'));exit();
            }else{
                echo json_encode(array('code'=>0,'msg'=>'已审核,请勿重复审核'));exit();
            }
        }else{
            echo json_encode(array('code'=>0,'msg'=>'失败'));exit();
        }
    }

    public function apply_del(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $l_id		= intval($_POST['l_id']);
        $this->db->query('delete from w_apply where l_id='.$l_id,0);
        echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
    }

    //订单管理
    public function order_list(){
        $user	= $this->checkadmin();
        $this->display('order.index',array('user'=>$user));
    }

    //订单数据
    public function order_data(){
        $page           =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit          =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condition       ="`order_addtime` <> '0'";
        if(isset($_GET['o_data']) && $_GET['o_data']!='') {
            $o_data = urldecode($_GET['o_data']);
            $condition .= " and (p_id =".$o_data." or u_id=".$o_data." or o_id= ".$o_data.")";
        }
        if(isset($_GET['o_name']) && $_GET['o_name']!='') {
            $o_name = urldecode($_GET['o_name']);
            $condition .= " and (o_name like '%".$o_name."%' or o_tel like '%".$o_name."%')";
        }
        if (isset($_GET['o_regt']) && $_GET['o_regt'] != '') {
            $o_regt = urldecode($_GET['o_regt']);
            $o_times = explode(' - ', $o_regt);
            $o_btime = strtotime(trim($o_times[0]));
            $o_etime = strtotime(trim($o_times[1]));
            $condition .= " and order_addtime>=" . $o_btime . " and order_addtime<=" . $o_etime;
        }
        $sql  	            = "select * from w_order where ".$condition." order by order_addtime desc limit ".$limit*($page-1).",".$limit;
        $query  	        = "select count(o_id) as total from `w_order` where ".$condition;
        $order 		        = $this->db->query($sql,3);
        $order_count 		= $this->db->query($query, 2);
        foreach($order as &$row){
            $row['p_title'] = $this->getProduct($row['p_id'],'p_title');
            $row['p_cover'] = '<a target="_blank" href="'.$this->getProduct($row['p_id'],'p_cover').'"><img src="'.$this->getProduct($row['p_id'],'p_cover').'" height="60"></a>';
            $row['m_name'] = $this->getUser($row['u_id']);
            $row['order_addtime'] = date('Y-m-d H:i',$row['order_addtime']);
            $row['o_express_time'] = $row['o_express_time']  ==  false ? '暂无':date('Y-m-d H:i',$row['o_express_time']);
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$order_count['total'],'data'=>$order));
        exit();
    }

    //导出
    public function export_list(){
        $user = $this->checkadmin();
        $condition       ="`order_addtime` <> '0'";
        if(isset($_GET['o_data']) && $_GET['o_data']!='') {
            $o_data = urldecode($_GET['o_data']);
            $condition .= " and (p_id =".$o_data." or u_id=".$o_data." or o_id= ".$o_data.")";
        }
        if(isset($_GET['o_name']) && $_GET['o_name']!='') {
            $o_name = urldecode($_GET['o_name']);
            $condition .= " and (o_name like '%".$o_name."%' or o_tel like '%".$o_name."%')";
        }
        if (isset($_GET['o_regt']) && $_GET['o_regt'] != '') {
            $o_regt = urldecode($_GET['o_regt']);
            $o_times = explode(' - ', $o_regt);
            $o_btime = strtotime(trim($o_times[0]));
            $o_etime = strtotime(trim($o_times[1]));
            $condition .= " and order_addtime>=" . $o_btime . " and order_addtime<=" . $o_etime;
        }
        $sql  	            = "select * from w_order where ".$condition." order by order_addtime desc ";
        $order 		        = $this->db->query($sql,3);
        $title_arr = explode(',', 'ID,订单号,昵称,产品标题,产品单价,购买数量,订单总价,收货人,联系方式,收货地址,订单状态(0待发货1待收货2已完成3售后),快递公司,运单号,创建时间,发货时间,收货时间,售后时间');
        $datas_arr = array();
        foreach ($order as &$row) {
            $data_arr = array(
                $row['o_id'] = $row['o_id'],
                $row['o_num'] = $row['o_num'],
                $row['u_id'] = $this->getMember($row['u_id'],'m_name'),
                $row['p_id'] = $this->getProduct($row['p_id'],'p_title'),
                $row['p_price'] = $row['p_price'],
                $row['p_num'] = $row['p_num'],
                $row['order_sum_price'] = $row['order_sum_price'],
                $row['o_name'] = $row['o_name'],
                $row['o_tel'] = $row['o_tel'],
                $row['o_city'] = $row['o_city'],
                $row['o_status'] =  $row['o_status'],
                $row['o_express_name'] =  $row['o_express_name'],
                $row['o_express_num'] =  $row['o_express_num'],
                $row['order_addtime'] = date('Y-m-d H:i:s',$row['order_addtime']),
                $row['o_express_time'] = date('Y-m-d H:i:s',$row['o_express_time']),
                $row['o_shou_time'] = date('Y-m-d H:i:s',$row['o_shou_time']),
                $row['o_shouhou_time'] = date('Y-m-d H:i:s',$row['o_shouhou_time']),
            );
            array_push($datas_arr, $data_arr);
        }
        $file_name = '订单数据'.date('Y-m-d H:i:s',time()). '.xls';
        $this->exportToExcel($file_name, $title_arr, $datas_arr);
    }

    //订单发货
    public function order_delivery(){
        $user	= $this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $o_id = $_GET['o_id'];
        if($this->post){
            header('Content-type:text/json');
            $fields 	= $_POST;
            $order		= $this->db->query("select * from `w_order` where `o_id` = '$o_id'", 2);
            if(empty($order)){
                echo json_encode(array('code'=>0,'msg'=>'该订单不存在'));exit();
            }
            if($order['o_status'] != 0){
                echo json_encode(array('code'=>0,'msg'=>'订单状态有误'));exit();
            }
            $this->db->update('w_order', array('o_express_name'=>$fields['o_express_name'],'o_express_num'=>$fields['o_express_num'],'o_status'=>'1','o_express_time'=>time()),array('o_id'=>$o_id));
            echo json_encode(array('code'=>1,'msg'=>'发货成功'));exit();
        }
        $this->display('order.delivery',array('user'=>$user));
    }


    public function agent_level(){
        $user	= $this->checkadmin();
        $this->display('agent.level',array('user'=>$user));
    }

    //代理数据
    public function agent_level_data(){
        $sql  	            = "select * from w_agent order by a_level ASC ";
        $agent 		        = $this->db->query($sql,3);
        echo json_encode(array('code'=>0,'msg'=>'','data'=>$agent));
        exit();
    }

    public function agent_add_level(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if ($this->post){
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['a_name']==''){echo json_encode(array('status'=>0,'msg'=>'代理名称不能为空'));exit();}
            if($fields['a_level']==''){echo json_encode(array('status'=>0,'msg'=>'代理级别不能为空'));exit();}
            if($fields['a_benefit']==''){echo json_encode(array('status'=>0,'msg'=>'优惠比率不能为空'));exit();}
            $agent  = $this->db->query("select * from w_agent WHERE a_level = ".$fields['a_level'],2);
            if(!empty($agent)){
                echo json_encode(array('status'=>0,'msg'=>'当前级别已存在,请重新设置'));exit();
            }
            $agent	=array(
                'a_name'			=>$fields['a_name'],
                'a_level'			=>$fields['a_level'],
                'a_benefit'			=>$fields['a_benefit'],
            );
            $p_id = $this->db->insert('w_agent', $agent);
            if($p_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
            }
        }else{
            $this->display('agent.addlevel',array('user'=>$user,'a_id'=>0));
        }
    }

    public function agent_edit_level(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $a_id       = $_GET['a_id'];
        $agent  = $this->db->query("select * from w_agent WHERE a_id = ".$a_id,2);
        if ($this->post){
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['a_name']==''){echo json_encode(array('status'=>0,'msg'=>'代理名称不能为空'));exit();}
            if($fields['a_level']==''){echo json_encode(array('status'=>0,'msg'=>'代理级别不能为空'));exit();}
            if($fields['a_benefit']==''){echo json_encode(array('status'=>0,'msg'=>'优惠比率不能为空'));exit();}
            $agent  = $this->db->query("select * from w_agent WHERE a_id <> $a_id AND a_level = ".$fields['a_level'],2);
            if(!empty($agent)){
                echo json_encode(array('status'=>0,'msg'=>'当前级别已存在,请重新设置'));exit();
            }
            $agent	=array(
                'a_name'			=>$fields['a_name'],
                'a_level'			=>$fields['a_level'],
                'a_benefit'			=>$fields['a_benefit'],
            );
            $p_id = $this->db->update('w_agent', $agent,array('a_id'=>$a_id));
            if($p_id){
                echo json_encode(array('status'=>1,'msg'=>'编辑成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
            }
        }else{
            $this->display('agent.addlevel',array('user'=>$user,'a_id'=>$a_id,'agent'=>$agent));
        }
    }



    public function getcate($id){
        $query  	="select * from `w_cates` where id=".$id;
        $cates	 	=$this->db->query($query, 2);
        if(!empty($cates)){
            return $cates['c_name'];
        }else{
            return '无分类';
        }
    }

    public function GetAgent($level){
        $query  	="select * from `w_agent` where a_level=".$level;
        $agent	 	=$this->db->query($query, 2);
        if(!empty($agent)){
            return $agent['a_name'];
        }else{
            return '无分类';
        }
    }



}