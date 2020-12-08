<?php
class mod_agent extends mod
{
    //代理申请
    public function apply(){
        $is_agent = 0;
        $user = $this->checkuser();
        $query  	="select * from `w_agent` order by a_level asc";
        $agent	 	=$this->db->query($query, 3);
        $s_agent	=$this->db->query("select * from `w_apply` WHERE l_uid = ".$user['id'], 2);
        if(!empty($s_agent)){
            $is_agent = 1;
        }
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            if (!array_key_exists('l_name',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入您的姓名'));exit();}
            if (!array_key_exists('l_tel',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入您的电话'));exit();}
            if (!array_key_exists('l_weichat',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入您的LINE'));exit();}
            $apply = array(
                'l_uid'         =>$user['id'],
                'l_name'        =>$fields['l_name'],
                'l_tel'         =>$fields['l_tel'],
                'l_weichat'     =>$fields['l_weichat'],
                'l_level'       =>$fields['l_level'],
                'l_atime'       =>time(),
                'l_ctime'       =>0,
                'l_status'      =>0,
            );
            $this->db->insert('w_apply', $apply);
            echo json_encode(array('code' => 1, 'msg' => '申请已提交,请等待客服审核'));
            exit();
        }
        $this->display('agent.apply', array('user'=>$user,'agent'=>$agent,'is_agent'=>$is_agent));
    }

    //代理商城
    public function agent_shop(){
        $user = $this->checkuser();
        $cate = $this->db->query("select * from `w_cates` WHERE `c_type` = 2 order by c_index asc", 3);
        $product = $this->db->query("select * from `w_product` WHERE `p_tui` = 1 order by p_sort asc,p_addtime DESC", 3);
        $banner		= $this->db->query('select * from w_banner where b_pos=4 order by b_index asc',3);
        $this->display('agent.shop', array('user'=>$user,'cate'=>$cate,'product'=>$product,'banner'=>$banner));
    }

    //我的余额
    public function agent_alogs(){
        $user = $this->checkuser();
        $logs = $this->db->query("select * from `w_logs` WHERE `l_type` = 1 AND l_uid =".$user['id']."  order by l_time desc", 3);
        $this->display('agent.alogs', array('user'=>$user,'logs'=>$logs));
    }

    //我的订单
    public function agent_order(){
        $user = $this->checkuser();
        $condition = " and `order_addtime` <> '0'";
        if(array_key_exists('hot_search',$_GET) and $_GET['hot_search'] != ''){
            $hot_search = $_GET['hot_search'];
            $condition .= " and o_name like'%".$hot_search."%' or o_tel like'%".$hot_search."%'";
        }
        $order_1 =  $this->db->query("select * from `w_order` WHERE `u_id` = ".$user['id']." $condition order by order_addtime desc", 3);
        $order_2 =  $this->db->query("select * from `w_order` WHERE `o_status` = 0 AND `u_id` = ".$user['id']." $condition order by order_addtime desc", 3);
        $order_3 =  $this->db->query("select * from `w_order` WHERE `o_status` = 1 AND `u_id` = ".$user['id']." $condition order by order_addtime desc", 3);
        $order_4 =  $this->db->query("select * from `w_order` WHERE `o_status` > 1 AND `u_id` = ".$user['id']." $condition order by order_addtime desc", 3);
        $order_1 = $this->set_order($order_1);
        $order_2 = $this->set_order($order_2);
        $order_3 = $this->set_order($order_3);
        $order_4 = $this->set_order($order_4);
        $this->display('agent.order', array('user'=>$user,'order_1'=>$order_1,'order_2'=>$order_2,'order_3'=>$order_3,'order_4'=>$order_4));
    }

    public function set_order($order){
       if(!empty($order)){
            foreach ($order as &$row){
                $row['m_name'] = $this->getMember($row['u_id'],'m_name');
                $row['m_phone'] = $this->getMember($row['u_id'],'m_phone');
                $row['p_title'] = $this->getProduct($row['p_id'],'p_title');
                $row['p_cover'] = $this->getProduct($row['p_id'],'p_cover');
            }
       }
       return $order;
    }

    //订单确认页
    public function agent_ordercon(){
        $user = $this->checkuser();
        $o_id = $_GET['o_id'];
        $order  = $this->db->query("select * from `w_order` where `o_id` = '$o_id'", 2);
        $data = $this->GetProductFind($order['p_id']);
        $product = $data['product'];
        $this->display('agent.ordercon', array('user'=>$user,'order'=>$order,'product'=>$product));
    }

    //确认收货
    public function confirm_shop(){
        $user = $this->checkuser();
        if($this->post){
            header('Content-type:text/json');
            $o_id   = $_POST['o_id'];
            $order  = $this->db->query("select * from `w_order` where `o_id` = '$o_id'", 2);
            if(empty($order)){echo json_encode(array('code'=>0,'msg'=>'该订单不存在'));exit();}
            if($order['o_status'] != 1){echo json_encode(array('code'=>0,'msg'=>'订单状态有误'));exit();}
            $this->db->update('w_order', array('o_status'=>'2','o_shou_time'=>time()),array('o_id'=>$o_id));
            echo json_encode(array('code'=>1,'msg'=>'收货成功'));exit();
        }
    }


    //售后
    public function after_sale(){
        $user = $this->checkuser();
        if($this->post){
            header('Content-type:text/json');
            $o_id   = $_POST['o_id'];
            $order  = $this->db->query("select * from `w_order` where `o_id` = '$o_id'", 2);
            if(empty($order)){echo json_encode(array('code'=>0,'msg'=>'该订单不存在'));exit();}
            if($order['o_status'] != 2){echo json_encode(array('code'=>0,'msg'=>'订单状态有误'));exit();}
            $this->db->update('w_order', array('o_status'=>'3','o_shouhou_time'=>time()),array('o_id'=>$o_id));
            echo json_encode(array('code'=>1,'msg'=>'发起售后成功,等待客服与您联系'));exit();
        }
    }

    //删除订单
    public function del_order(){
        $user = $this->checkuser();
        if($this->post){
            header('Content-type:text/json');
            $o_id   = $_POST['o_id'];
            $order  = $this->db->query("select * from `w_order` where `o_id` = '$o_id'", 2);
            if(empty($order)){echo json_encode(array('code'=>0,'msg'=>'该订单不存在'));exit();}
            if($order['o_status'] < 2){echo json_encode(array('code'=>0,'msg'=>'订单状态有误'));exit();}
            $this->db->query('delete from w_order where o_id='.$o_id,0);
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
        }
    }

    //商品详情页
    public function agent_goodscon(){
        $user = $this->checkuser();
        $p_id = $_GET['p_id'];
        $data = $this->GetProductFind($p_id);
        $product = $data['product'];
        $p_a_price = $data['p_a_price'];
        $this->display('agent.goodscon', array('user'=>$user,'product'=>$product,'p_a_price'=>$p_a_price));
    }

    //确认页面
    public function agent_qrorder(){
        $user = $this->checkuser();
        $p_id = $_GET['p_id'];
        $data = $this->GetProductFind($p_id);
        $product = $data['product'];
        $p_a_price = $data['p_a_price'];
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            if (!array_key_exists('o_name',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入收货人姓名'));exit();}
            if (!array_key_exists('o_tel',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入收货人电话'));exit();}
            if (!array_key_exists('o_city2',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入详细地址'));exit();}
            if (!array_key_exists('p_num',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请输入您的LINE'));exit();}
            if (!array_key_exists('o_city1',$fields)) {echo json_encode(array('code' => 0, 'msg' => '请选择地址'));exit();}
            if (!array_key_exists('order_sum_price',$fields)) {echo json_encode(array('code' => 0, 'msg' => '商品总价不能为空'));exit();}
            if($user['m_money']< $fields['order_sum_price']){echo json_encode(array('code' => 0, 'msg' => '您的余额不足'));exit();}
            $order = array(
                'o_name'            =>$fields['o_name'],
                'o_tel'             =>$fields['o_tel'],
                'o_city'            =>$fields['o_city1'].$fields['o_city2'],
                'p_num'             =>$fields['p_num'],
                'p_price'           =>$p_a_price,
                'o_type'            =>$user['m_agent'],
                'order_addtime'     =>time(),
                'o_status'          =>0,
                'u_id'              =>$user['id'],
                'p_id'              =>$product['p_id'],
                'o_num'             =>$this->getNum(),
                'order_sum_price'   =>$fields['order_sum_price'],
            );
            $is_add = $this->db->insert('w_order', $order);
            if($is_add){
                $p_yishou = $product['p_yishou']+1;
                $this->db->update('w_product', array('p_yishou' => $p_yishou), array('p_id' => $product['p_id']));
                $this->do_logs($user['id'],1,-$fields['order_sum_price'],'下单购买代理产品');
                echo json_encode(array('code' => 1, 'msg' => '订单创建成功'));
                exit();
            }else{
                echo json_encode(array('code' => 0, 'msg' => '订单创建失败'));
                exit();
            }

        }
        $this->display('agent.qrorder', array('user'=>$user,'product'=>$product,'p_a_price'=>$p_a_price,'p_id'=>$p_id));
    }

    //产品列表
    public function pl(){
        $user = $this->checkuser();
        $p_type = $_GET['id'];
        $cate = $this->db->query("select * from `w_cates` WHERE `id` = $p_type", 2);
        $cate_name = $cate['c_name'];
        $product = $this->db->query("select * from `w_product` WHERE `p_type` = '$p_type' ORDER BY p_tui DESC,p_sort ASC,p_addtime DESC", 3);
        $this->display('agent.pl', array('user'=>$user,'product'=>$product,'cate_name'=>$cate_name));
    }


    //获取商品和价格
    public function GetProductFind($p_id){
        $user = $this->checkuser();
        $product = $this->db->query("select * from `w_product` WHERE p_id = $p_id", 2);
        $p_a_price = $product['p_price'];
        if($product['p_price_type'] == 1){
            $agent = $this->db->query("select * from `w_agent` WHERE a_level = ".$user['m_agent'], 2);
            $p_a_price = $p_a_price*($agent['a_benefit']/100);
        }elseif ($product['p_price_type'] == 2){
            $p_a_price  = json_decode($product['p_a_price'],true);
            foreach ($p_a_price as $k =>$v){
                if($k == $user['m_agent']){
                    $p_a_price = $v;
                }
            }
        }
        return array(
            'p_a_price' =>$p_a_price,
            'product' =>$product,

        );
    }

    public function infos(){
        $user		=$this->checkuser();
        if ($this->post) {
            $w_kefu = $this->config['w_kefu'];
            $w_tel = $this->config['w_tel'];
            $w_linecode = $this->config['w_linecode'];
            $ret_html='
			 <div class="jui_box_conbar">
				 <div class="jui_box_con">
					   <div class="jui_public_tit jui_flex_justify_center jui_fc_000 jui_font_weight jui_fs15">'.$w_kefu.' </div>
					   <div class="jui_h12"></div>
					   <div class="box_rm_ewm"><img src="'.$w_linecode.'"></div>
					   <div class="jui_h12"></div>
					   <div class="box_rm_text">
							<p>联系方式：'.$w_tel.'</p>
							<p>行业：代理商客服</p>
					   </div>
					   <div class="jui_h20"></div>
					   <div class="jui_box_close iconfont" id="close2" style="cursor:pointer;">&#xe61f;</div>
				 </div>
			 </div>';
            echo json_encode(array('code'=>1,'msg'=>$ret_html));exit();
        }
    }
}