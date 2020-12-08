<?php

class mod_shop extends mod
{
    public function upload($name)
    {
        if ($_FILES[$name]["error"]) {
            echo json_encode(array('code' => 1, 'msg' => '发生错误'));
            exit();
        } else {
            if (($_FILES[$name]["type"] == "image/png" || $_FILES[$name]["type"] == "image/jpeg") && $_FILES[$name]["size"] < 1024000) {
                $filename = substr(strrchr($_FILES[$name]["name"], '.'), 1);
                $filename = "./static/upload/" . date('Ymd', time()) . $this->getMillisecond() . '.' . $filename;
                if (file_exists($filename)) {
                    return '';
                } else {
                    move_uploaded_file($_FILES[$name]["tmp_name"], $filename);
                    return $filename;
                }
            } else {
                return '';
            }
        }
    }

    public function myshop()
    {
        $user = $this->checkuser();
        $shop = $this->db->query("select * from `w_shops` where `s_uid`=" .$user['id'] ." order by id asc", 2);
        $goods = [];
        if(!empty($shop) and $shop['s_status'] > 0){
            $goods = $this->db->query("select * from `w_goods` where `g_shop`=".$shop['id'] ." order by g_addtime desc", 3);
        }
        $cates = $this->db->query("select * from `w_cates` where `id`=".$shop['s_type'], 3);
        $score = $this->CountScore($user['id']);
        if(!empty($shop)){ $shop['avatar'] = $this->getMember($shop['s_uid'], 'm_avatar');}
         
        $this->display('shop.myshop', array('user'=>$user, 'shop'=>$shop,'goods'=>$goods,'score'=>$score, 'cateslist' => $cates[0]));
    }


    //发布商品
    public function ag(){
        $user = $this->checkuser();
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $shop = $this->db->query("select * from `w_shops` where `s_uid`=" . $user['id'] . " order by id asc", 2);
            if(empty($shop)){
                echo json_encode(array('code' => 0, 'msg' => '商铺不存在,无法上传产品'));
                exit();
            }
            if($shop['s_status'] == 0){
                echo json_encode(array('code' => 0, 'msg' => '商铺正在审核中,无法上传产品'));
                exit();
            }
            $g_pic = $this->upload('g_pic');
            if (!array_key_exists('g_title',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品标题'));
                exit();
            }
            if (!array_key_exists('g_price',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品价格'));
                exit();
            }
            if (!array_key_exists('g_content',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品内容'));
                exit();
            }
            $goods = array(
                'g_title'   => $fields['g_title'],
                'g_price'   => $fields['g_price'],
                'g_content' => $fields['g_content'],
                'g_pic'     => $g_pic,
                'g_addtime' => time(),
                'g_tui'     => 0,
                'g_shop'    => $shop['id']
            );
            $this->db->insert('w_goods', $goods);
            echo json_encode(array('code' => 1, 'msg' => '商品添加成功'));
            exit();
        }
        $this->display('shop.ag', array('user'=>$user));
    }

    //编辑商品
    public function eg(){
        $user = $this->checkuser();
        $g_id = $_GET['g_id'];
        $goods = $this->db->query("select * from `w_goods` where `g_id`='$g_id'", 2);
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $shop = $this->db->query("select * from `w_shops` where `s_uid`=" . $user['id'], 2);
            if(empty($shop)){
                echo json_encode(array('code' => 0, 'msg' => '商铺不存在,无法上传产品'));
                exit();
            }
            if($shop['s_status'] == 0){
                echo json_encode(array('code' => 0, 'msg' => '商铺正在审核中,无法上传产品'));
                exit();
            }
            if(!array_key_exists('g_pic',$fields)){
                $fields['g_pic'] = $this->upload('g_pic');
            }

            if (!array_key_exists('g_title',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品标题'));
                exit();
            }
            if (!array_key_exists('g_price',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品价格'));
                exit();
            }
            if (!array_key_exists('g_content',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请输入商品内容'));
                exit();
            }
            $goods = array(
                'g_title'   => $fields['g_title'],
                'g_price'   => $fields['g_price'],
                'g_content' => $fields['g_content'],
                'g_pic'     => $fields['g_pic'],
                'g_addtime' => time(),
                'g_tui'     => 0,
                'g_shop'    => $shop['id']
            );
            $this->db->update('w_goods', $goods,array('g_id'=>$g_id));
            echo json_encode(array('code' => 1, 'msg' => '商品编辑成功'));
            exit();
        }
        $this->display('shop.eg', array('user'=>$user,'goods'=>$goods));
    }

    //产品详情
    public function gc(){
        $user = $this->checkuser();
        $g_id = $_GET['g_id'];
        $goods = $this->db->query("select * from `w_goods` where `g_id`='$g_id'", 2);
        $shop = $this->db->query("select * from `w_shops` where `id`=" . $goods['g_shop'], 2);
        $shop_user = $this->db->query("select * from `w_users` where `id`=" . $shop['s_uid'], 2);
        $this->display('shop.gc', array('user'=>$user,'goods'=>$goods,'shop_user'=>$shop_user));
    }

    //商品列表
    public function gl(){
        $user = $this->checkuser();
        $goods =  $this->db->query("select * from w_goods where `g_tui` = '1' order by g_addtime desc", 3);
        $this->display('shop.gl', array('user'=>$user,'goods'=>$goods));
    }

    //删除商品
    public function gd(){
        $user = $this->checkuser();
        if($this->post){
            $fields = $_POST;
            $g_id = $fields['g_id'];
            $this->db->query('delete from w_goods where g_id='.$g_id,0);
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));
            exit();
        }
    }

    public function apply()
    {
        $user = $this->checkuser();
        $u_cates = $this->db->query("select * from `w_cates` WHERE `c_type` = '1' order by c_index asc", 3);
        if ($this->post) {
            $s_img = $this->upload('s_img');
            $s_zhizhao = $this->upload('s_zhizhao');
            $s_idfront = $this->upload('s_idfront');
            $s_idback = $this->upload('s_idback');
            $fields = $this->SafeFilter($_POST);
            if (!array_key_exists('s_name',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请填写商户名称'));
                exit();
            }
            if (!array_key_exists('s_info',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请填写商户简介'));
                exit();
            }
            if (!array_key_exists('s_address',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请填写详细地址'));
                exit();
            }
            if (!array_key_exists('s_region',$fields)) {
                echo json_encode(array('code' => 0, 'msg' => '请选择地区'));
                exit();
            }
            $shop = $this->db->query("select * from `w_shops` where `s_uid`=" . $user['id'] . " order by id asc", 2);
            if(!empty($shop)){
                echo json_encode(array('code' => 0, 'msg' => '商铺已存在!'));
                exit();
            }
            $shop = array(
                's_name' => $fields['s_name'],
                's_type' => $fields['s_type'],
                's_info' => strlen($fields['s_info']) > 180 ? substr($fields['s_info'], 0, 180) : $fields['s_info'],
                's_address' => $fields['s_address'],
                's_region' => $fields['s_region'],
                's_img' => $s_img,
                's_zhizhao' => $s_zhizhao,
                's_idfront' => $s_idfront,
                's_idback' => $s_idback,
                's_uid' => $user['id'],
                's_ctime' => time(),
                's_status' => 0
            );
            $this->db->insert('w_shops', $shop);
            echo json_encode(array('code' => 1, 'msg' => '申请已提交,请联系客服审核'));
            exit();
        }
        $this->display('shop.apply', array('user' => $user, 'u_cates' => $u_cates));
    }

    public function index()
    {
        $user = $this->checkuser();
        $cates = $this->db->query("select * from `w_cates` WHERE `c_type` = 1 order by c_index asc", 3);
        $banner = $this->db->query('select * from `w_banner` where b_pos=2 order by b_index asc', 3);
        $condition = "s_hot=1 and s_status=1 and s_dtime>" . time();
        $query = "select id,s_name,s_uid,s_img,s_read,s_info,s_hot from w_shops where " . $condition . " order by s_dtime desc limit 4";
        $shop = $this->db->query($query, 3);
        foreach ($shop as &$row) {
            $row['avatar'] = $this->getMember($row['s_uid'], 'm_avatar');
            $row['score'] = $this->CountScore($row['s_uid']);
        }
        $goods =  $this->db->query("select * from w_goods where `g_tui` = '1' order by g_addtime desc", 3);
        $this->display('shop.index', array('user' => $user, 'cates' => $cates, 'banner' => $banner,'shop'=>$shop,'goods'=>$goods));
    }

    public function fetch()
    {
        $user = $this->checkuser();
        $page = isset($_GET['page']) && $_GET['page'] != '' ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] != '' ? intval($_GET['limit']) : 20;
        //$condtion = "s_status=1 and s_dtime>" . time();//审核通过且未过期
        $condtion = "s_status=1";//审核通过且未过期
        $s_hot = isset($_GET['s_hot']) ? intval($_GET['s_hot']) : 0;
        $s_type = isset($_GET['s_type']) ? intval($_GET['s_type']) : 0;
        if ($s_hot) {
            $condtion .= " and s_hot=" . $s_hot;
        }
        if ($s_type) {
            $condtion .= " and s_type=" . $s_type;
        }
        $query = "select id,s_name,s_uid,s_img,s_read,s_info,s_hot from w_shops where " . $condtion . " order by s_dtime desc limit " . $limit * ($page - 1) . "," . $limit;
         
        $data = $this->db->query($query, 3);
        foreach ($data as &$row) {
            $row['avatar'] = $this->getMember($row['s_uid'], 'm_avatar');
        }
        echo json_encode($data);
    }



    public function shop(){
        $user = $this->checkuser();
        $shop_id = intval($_GET['id']);
        $shop = $this->db->query("select * from `w_shops` where id=" . $shop_id, 2);
        if (!empty($shop)) {
            if ($user['id'] != $shop['s_uid']) {
                $this->db->update('w_shops', array('s_read' => $shop['s_read'] + 1), array('id' => $shop_id));
            }
            $shop['score'] = $this->CountScore($shop['s_uid']);
            $shop['hang'] = $this->getHang($shop['s_type'], 'c_name');
            $goods = $this->db->query("select * from `w_goods` where `g_shop`=" .$shop_id ." order by g_addtime desc", 3);
            $shop_user = $this->db->query("select * from `w_users` where id=" . $shop['s_uid'], 2);

            $this->display('shop.shop', array('user' => $user, 'shopid' => $shop_id, 'shop' => $shop, 'shop_user' => $shop_user,'goods'=>$goods));
        }
    }


    public function lists(){
        $user = $this->checkuser();
        $typeid = intval($_GET['id']);
        $cate_name = $this->getHang($typeid, 'c_name');
        $this->display('shop.lists', array('user' => $user, 'cate_name' => $cate_name, 'typeid' => $typeid));
    }

    public function edit()
    {
        $user = $this->checkuser();
        $shopid = intval($_GET['id']);
        $shop = $this->db->query("select * from `w_shops` where id=" . $shopid, 2);
        if ($shop) {
            if ($user['id'] != $shop['s_uid']) {
                $this->blankmsg('提示', '没有权限', '?m=shop&c=myshop');
                exit();
            }
            if ($this->post) {
                $fields = $this->SafeFilter($_POST);
                $shop = array('s_content' => $fields['s_content']);
                $this->db->update('w_shops', $shop, array('id' => $shopid));
                echo json_encode(array('code' => 1, 'msg' => '修改成功'));
                exit();
            }
            $shop['hang'] = $this->getHang($shop['s_type'], 'c_name');
            $shop_user = $this->db->query("select * from `w_users` where id=" . $shop['s_uid'], 2);
            $this->display('shop.edit', array('user' => $user, 'shopid' => $shopid, 'shop' => $shop, 'shop_user' => $shop_user));
        }
    }


}

?>