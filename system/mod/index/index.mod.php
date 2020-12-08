<?php

class mod_index extends mod
{
    public function school()
    {
        $user = $this->checkuser();
        $query = "select * from `w_caten` order by c_index asc";
        $cates = $this->db->query($query, 3);
        $banner = $this->db->query('select * from w_banner where b_pos=3 order by b_index asc', 3);
        $news = $this->db->query('select * from w_class order by id desc', 3);
        $this->display('index.school', array('user' => $user, 'news' => $news, 'cates' => $cates, 'banner' => $banner));
    }

    public function notice_list()
    {
        $user = $this->checkuser();
        $page = isset($_GET['page']) && $_GET['page'] != '' ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] != '' ? intval($_GET['limit']) : 20;
        $condtion = "1";
        $query = "select id,n_title,n_img,n_time,n_read from w_notice where " . $condtion . " order by n_index,id desc limit " . $limit * ($page - 1) . "," . $limit;
        $data = $this->db->query($query, 3);
        foreach ($data as &$row) {
            $row['n_time'] = date('Y-m-d H:i:s', $row['n_time']);
        }
        echo json_encode($data);
    }

    public function fetch()
    {
        $user = $this->checkuser();
        $page = isset($_GET['page']) && $_GET['page'] != '' ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] != '' ? intval($_GET['limit']) : 20;
        $condtion = "1";//审核通过且未过期

        $n_cate = isset($_GET['n_cate']) ? intval($_GET['n_cate']) : 0;
        if ($n_cate) {
            $condtion .= " and n_cate=" . $n_cate;
        }
        $query = "select id,n_title,n_img,n_time,n_read from w_class where " . $condtion . " order by n_index,id desc limit " . $limit * ($page - 1) . "," . $limit;
        $data = $this->db->query($query, 3);
        foreach ($data as &$row) {
            $row['n_time'] = date('Y-m-d H:i:s', $row['n_time']);
        }
        echo json_encode($data);
    }


    public function lists()
    {
        $user = $this->checkuser();
        $id = intval($_GET['id']);
        $cate = $this->db->query('select * from w_caten where id=' . $id, 2);
        $cate_name = '';
        if ($cate) {
            $cate_name = $cate['c_name'];
        }
        $this->display('index.lists', array('user' => $user, 'cate_name' => $cate_name, 'id' => $id));
    }

    public function wens()
    {
        $user = $this->checkuser();
        $id = intval($_GET['id']);
        $news = $this->db->query('select * from w_class where id=' . $id, 2);
        if ($news) {
            $this->db->update('w_class', array('n_read' => $news['n_read'] + 1), array('id' => $id));
            $this->display('index.wens', array('user' => $user, 'news' => $news));
        } else {
            $this->blankmsg('提示', '不存在', '?m=index&c=index');
            exit();
        }
    }

    public function news()
    {
        $user = $this->checkuser();
        $id = intval($_GET['id']);
        $news = $this->db->query('select * from w_notice where id=' . $id, 2);
        if ($news) {
            $this->db->update('w_notice', array('n_read' => $news['n_read'] + 1), array('id' => $id));
            $this->display('index.news', array('user' => $user, 'news' => $news));
        } else {
            $this->blankmsg('提示', '不存在', '?m=index&c=index');
            exit();
        }
    }

    public function notice()
    {
        $user = $this->checkuser();
        $notice = $this->db->query('select * from w_notice order by id desc', 3);
        $this->display('index.notice', array('user' => $user, 'news' => $notice));
    }

    public function login()
    {
        $code_need = 0;
        if ($this->smsset['w_user_log']) {
            $code_need = 1;
        }
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            if (array_key_exists('u_access', $fields)) {
                $_SESSION['uid'] = $fields['u_access'];
                echo json_encode(array('code' => 1));
                exit();
            }
            if (empty($fields['val_1']) || empty($fields['val_2'])) {
                echo json_encode(array('code' => 0, 'msg' => '参数不能为空'));
                exit();
            }
            $val_1 = $fields['val_1'];
            $val_2 = $fields['val_2'];
            if ($code_need) {
                if ($_SESSION['verycode'] == $val_2) {
                    $sql = "select * from w_users where m_phone='$val_1' and m_del=0";
                } else {
                    echo json_encode(array('code' => 0, 'msg' => '验证码不正确'));
                    exit();
                }
            } else {
                $val_2 = md5($val_2);
                $sql = "select * from w_users where m_phone='$val_1' and m_pass='$val_2' and m_del=0";
            }
            $user = $this->db->query($sql, 2);
            if (!empty($user)){
                if ($user['m_lock'] == 1) {
                    echo json_encode(array('code' => 0, 'msg' => '账号已冻结,请联系客服处理'));
                    exit();
                }
                $_SESSION['uid'] = $user['id'];
                echo json_encode(array('code' => 1, 'msg' => '登录成功', 'u_access' => $user['id']));
                exit();
            } else {
                echo json_encode(array('code' => 0, 'msg' => '信息有误，请检查后重试'));
                exit();
            }
        } else {
            $this->display('index.login', array('needs' => $code_need));
        }
    }

    public function helpreg()
    {
        $user = $this->checkuser();
        $m_tid = $user['m_tid'];
        if ($m_tid == 0) {
            $config = $this->config;
            $m_tid = $config['w_user'];
        }
        $t_user = $this->db->query("select * from w_users WHERE `id`='$m_tid'", 2);
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $m_tid = $user['id'];
            if (empty($fields['val_2'])) {
                echo json_encode(array('code' => 0, 'msg' => '注册手机号不能为空'));
                exit();
            }
            $query = "select id,m_phone,m_del from w_users where m_phone='" . $fields['val_2'] . "' and m_del=0";
            $member = $this->db->query($query, 2);
            if ($member) {
                echo json_encode(array('code' => 0, 'msg' => '该手机号已经注册'));
                exit();
            }
            if (empty($fields['val_4'])) {
                echo json_encode(array('code' => 0, 'msg' => '真实姓名不能为空'));
                exit();
            }
            if (empty($fields['val_5'])) {
                echo json_encode(array('code' => 0, 'msg' => 'LINE号不能为空'));
                exit();
            }
            if (empty($fields['val_6'])) {
                echo json_encode(array('code' => 0, 'msg' => '登录密码不能为空'));
                exit();
            }
            if (empty($fields['val_7'])) {
                echo json_encode(array('code' => 0, 'msg' => '确认密码不能为空'));
                exit();
            }
            if ($fields['val_7'] != $fields['val_6']) {
                echo json_encode(array('code' => 0, 'msg' => '两次输入密码不一致'));
                exit();
            }

            $m_pid = $this->getPidbyTid($m_tid);
            $m_line = '0';
            if($m_pid){
                $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                $member = $this->db->query($query, 2);
                if (empty($member)) {
                    echo json_encode(array('code' => 0, 'msg' => '节点人不存在'));
                    exit();
                }
                $m_line = $member['m_line'];
            }

            $member = array(
                'm_tid' => $m_tid,
                'm_pid' => $m_pid,
                'm_name' => $fields['val_4'],
                'm_phone' => $fields['val_2'],
                'm_pass' => md5($fields['val_6']),
                'm_level' => 0,
                'm_weixin' => $fields['val_5'],
                'm_hang' => 0,
                'm_regtime' => time()
            );
            if ($this->config['w_xinyu']) {
                $member['m_score'] = $this->config['w_xinyu1'];
            }
            $memberid = $this->db->insert('w_users', $member);
            if ($m_pid) {//更新节点人的一层人数
                $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                $member = $this->db->query($query, 2);
                $m_num = $member['m_num'] + 1;
                $this->db->update('w_users', array('m_num' => $m_num), array('id' => $m_pid));
            }
            if ($memberid) {//更新会员节点序列及所在层次
                $this->db->update('w_users', array('m_line' => $m_line . ',' . $memberid, 'm_layer' => count(explode(',', $m_line))), array('id' => $memberid));
                echo json_encode(array('code' => 1, 'msg' => '注册成功'));
                exit();
            } else {
                echo json_encode(array('code' => 0, 'msg' => '发生未知错误，请联系在线客服处理'));
                exit();
            }
        }
        $this->display('index.helpreg', array('user' => $user, 't_user' => $t_user));
    }

    public function renzheng(){
        $user = $this->checkuser();
        if($this->post){
            $fields = $_POST;
            if (empty($fields['val_2'])) {
                echo json_encode(array('code' => 0, 'msg' => '真实姓名不能为空'));
                exit();
            }
            if (empty($fields['val_4'])) {
                echo json_encode(array('code' => 0, 'msg' => '身份证号不能为空'));
                exit();
            }
            $is_car = $this->db->query("select * from w_users where m_carid='" . $fields['val_4'] . "' and m_del=0", 2);
            if (!empty($is_car)) {
                echo json_encode(array('code' => 0, 'msg' => '身份证信息已存在'));
                exit();
            }
            $val_5 = $this->UploadImg($fields['val_5']);
            $val_6 = $this->UploadImg($fields['val_6']);
            $set_user = array(
                'm_zsxm'    =>  $fields['val_2'],
                'm_carid'   =>  $fields['val_4'],
                'm_carimg'  =>  $val_5.','.$val_6,
            );
            $is_set = $this->db->update('w_users', $set_user, array('id' => $user['id']));
            if ($is_set) {
                echo json_encode(array('code' => 1, 'msg' => '认证成功'));
                exit();
            } else {
                echo json_encode(array('code' => 0, 'msg' => '发生未知错误，请联系在线客服处理'));
                exit();
            }

        }
        $this->display('index.renzheng', array('user' => $user));
    }



    public function register()
    {
        $tui_id = 0;
        $tui_name = '';
        $t_user = array();
        if (isset($_GET['t']) && $_GET['t'] != '') {
            $id = intval($_GET['t']);
            $query = 'select * from w_users where m_del=0 and m_lock=0 and m_level>0 and id=' . $id;
            $t_user = $this->db->query($query, 2);
            if (empty($t_user)) {
                $this->blankmsg('提示', '当前会员等级不足无法进行注册', '/?m=index&c=login&logout_type=1');
                exit();
            }
            $tui_id = $id; //根据推荐人ID判断是否需要显示推荐人输入框
            $tui_name = $t_user['m_name'];
            $_SESSION['m_tid'] = $id;
        }
        if ($this->config['w_reg'] == 1 && $tui_id == 0) {
            if ($this->post) {
                echo json_encode(array('code' => 0, 'msg' => '当前系统关闭注册,请通过推荐人注册'));
                //$this->blankmsg('提示', '当前系统关闭注册,请通过推荐人注册', '/?m=index&c=login&logout_type=1');
                exit();
            }
        }
        $code_need = 0;
        if ($this->smsset['w_user_reg']) {
            $code_need = 1;
        }
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            if (array_key_exists('val_1', $fields)) {      //检查推荐人是否存在
                if (empty($fields['val_1'])) {
                    echo json_encode(array('code' => 0, 'msg' => '推荐人手机不能为空'));
                    exit();
                }
                $t_phone = $fields['val_1'];
                $query = "select id,m_phone,m_del,m_level from w_users where m_phone='$t_phone' and m_del=0";
                $user = $this->db->query($query, 2);
                if (empty($user)) {
                    echo json_encode(array('code' => 0, 'msg' => '推荐人不存在'));
                    exit();
                }
                if ($user['m_level'] == 0) {
                    echo json_encode(array('code' => 0, 'msg' => '推荐人等级不足'));
                    exit();
                }
                $m_tid = $user['id'];
            } else {
                if (isset($_SESSION['m_tid']) && !empty($_SESSION['m_tid'])) {
                    $m_tid = intval($_SESSION['m_tid']);
                } else {
                    $m_tid = $this->config['w_user'];       //注册到默认会员下面 否则无法升级
                }
            }
            if (empty($fields['val_2'])) {
                echo json_encode(array('code' => 0, 'msg' => '注册手机号不能为空'));
                exit();
            }
            $query = "select id,m_phone,m_del from w_users where m_phone='" . $fields['val_2'] . "' and m_del=0";
            $user = $this->db->query($query, 2);
            if ($user) {
                echo json_encode(array('code' => 0, 'msg' => '该手机号已经注册'));
                exit();
            }
            if ($code_need) {
                if (empty($fields['val_3'])) {
                    echo json_encode(array('code' => 0, 'msg' => '短信验证码不能为空'));
                    exit();
                }
                if ($_SESSION['verycode'] != $fields['val_3']) {
                    echo json_encode(array('code' => 0, 'msg' => '短信验证码不正确'));
                    exit();
                }
            }
            if (empty($fields['val_4'])) {
                echo json_encode(array('code' => 0, 'msg' => '真实姓名不能为空'));
                exit();
            }
            if (empty($fields['val_5'])) {
                echo json_encode(array('code' => 0, 'msg' => 'LINE号不能为空'));
                exit();
            }
            if (empty($fields['val_6'])) {
                echo json_encode(array('code' => 0, 'msg' => '登录密码不能为空'));
                exit();
            }
            if (empty($fields['val_7'])) {
                echo json_encode(array('code' => 0, 'msg' => '确认密码不能为空'));
                exit();
            }
            if ($fields['val_7'] != $fields['val_6']) {
                echo json_encode(array('code' => 0, 'msg' => '两次输入密码不一致'));
                exit();
            }

            $m_pid = $this->getPidbyTid($m_tid);
            $m_line = '0';
            if ($m_pid) {         //找出 m_line 信息
                $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                $member = $this->db->query($query, 2);
                if (empty($member)) {
                    echo json_encode(array('code' => 0, 'msg' => '节点人不存在'));
                    exit();
                }
                $m_line = $member['m_line'];
            }

            $member = array(
                'm_tid' => $m_tid,
                'm_pid' => $m_pid,
                'm_name' => $fields['val_4'],
                'm_phone' => $fields['val_2'],
                'm_pass' => md5($fields['val_6']),
                'm_level' => 0,
                'm_weixin' => $fields['val_5'],
                'm_hang' => 0,
                'm_regtime' => time(),
                'm_money' => 0,
            );
            if ($this->config['w_xinyu']) {
                $member['m_score'] = $this->config['w_xinyu1'];
            }
            $memberid = $this->db->insert('w_users', $member);
            if ($m_pid) {//更新节点人的一层人数
                $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                $member = $this->db->query($query, 2);
                $m_num = $member['m_num'] + 1;
                $this->db->update('w_users', array('m_num' => $m_num), array('id' => $m_pid));
            }
            if ($memberid) {//更新会员节点序列及所在层次
                $this->db->update('w_users', array('m_line' => $m_line . ',' . $memberid, 'm_layer' => count(explode(',', $m_line))), array('id' => $memberid));
                echo json_encode(array('code' => 1, 'msg' => '注册成功'));
                exit();
            } else {
                echo json_encode(array('code' => 0, 'msg' => '发生未知错误，请联系在线客服处理'));
                exit();
            }
        } else {
            $this->display('index.register', array('needs' => $code_need, 'tui_id' => $tui_id, 'tui_name' => $tui_name, 't_user' => $t_user));
        }
    }

    public function find()
    {
        $code_need = $this->smsset['w_user_rep'];
        if (!$code_need) {
            $this->blankmsg('提示', '找回密码请联系客服处理', '?m=index&c=login');
            exit();
        }
        if ($this->post) {
            $fields = $_POST;
            if (empty($fields['val_2'])) {
                echo json_encode(array('code' => 0, 'msg' => '手机号不能为空'));
                exit();
            }
            if ($fields['val_2'] != $_SESSION['v_phone']) {
                echo json_encode(array('code' => 0, 'msg' => '手机号不一致'));
                exit();
            }
            if (empty($fields['val_3'])) {
                echo json_encode(array('code' => 0, 'msg' => '短信验证码不能为空'));
                exit();
            }
            if ($_SESSION['verycode'] != $fields['val_3']) {
                echo json_encode(array('code' => 0, 'msg' => '短信验证码不正确'));
                exit();
            }
            if (empty($fields['val_6'])) {
                echo json_encode(array('code' => 0, 'msg' => '新密码不能为空'));
                exit();
            }
            if (empty($fields['val_7'])) {
                echo json_encode(array('code' => 0, 'msg' => '确认密码不能为空'));
                exit();
            }
            if ($fields['val_7'] != $fields['val_6']) {
                echo json_encode(array('code' => 0, 'msg' => '两次输入密码不一致'));
                exit();
            }
            $this->db->update('w_users', array('m_pass' => md5($fields['val_6'])), array('m_phone' => $fields['val_2']));
            echo json_encode(array('code' => 1, 'msg' => '密码重置成功'));
            exit();
        }
        $this->display('index.find', array('needs' => $code_need));
    }

    public function checkrep()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $v_code = intval($fields['code']);
            $v_phone = $fields['phone'];
            if ($_SESSION['captcha'] == $v_code) {
                $query = "select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0";
                $user = $this->db->query($query, 2);
                if ($user) {
                    $this->sendcode($v_phone, 'log');
                    $_SESSION['v_phone'] = $v_phone;
                    echo json_encode(array('code' => 1, 'msg' => '验证码已发送至您的手机'));
                } else {
                    echo json_encode(array('code' => 0, 'msg' => '您输入的手机号没有注册'));
                }
            } else {
                echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
            }
        } else {
            echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
        }
        exit();
    }

    public function checkreg()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $v_code = intval($fields['code']);
            $v_phone = $fields['phone'];
            if (array_key_exists('t_phone', $fields)) {
                $t_phone = $fields['t_phone'];
                $query = "select id,m_phone,m_del from w_users where m_phone='$t_phone' and m_del=0 and m_lock=0 and m_level>0";
                $user = $this->db->query($query, 2);
                if (empty($user)) {
                    echo json_encode(array('code' => 0, 'msg' => '推荐人不存在'));
                    exit();
                }
            }
            if ($_SESSION['captcha'] == $v_code) {
                $query = "select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0";
                $user = $this->db->query($query, 2);
                if ($user) {
                    echo json_encode(array('code' => 0, 'msg' => '您的手机号已经注册'));
                    exit();
                } else {
                    $this->sendcode($v_phone, 'reg');
                    echo json_encode(array('code' => 1, 'msg' => '验证码已发送至您的手机'));
                    exit();
                }
            } else {
                echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
            exit();
        }
        exit();
    }

    public function checkcode()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $v_code = intval($fields['code']);
            $v_phone = $fields['phone'];
            if ($_SESSION['captcha'] == $v_code) {
                $query = "select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0";
                $user = $this->db->query($query, 2);
                if ($user) {
                    $this->sendcode($v_phone, 'log');
                    echo json_encode(array('code' => 1, 'msg' => '验证码已发送至您的手机'));
                } else {
                    echo json_encode(array('code' => 0, 'msg' => '您输入的手机号没有注册'));
                }
            } else {
                echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
            }
        } else {
            echo json_encode(array('code' => 0, 'msg' => '验证码输入错误'));
        }
        exit();
    }

    public function index()
    {
        $user = $this->checkuser();
        $banner = $this->db->query('select * from w_banner where b_pos=1 order by b_index asc', 3);
        $config = $this->db->query('select * from w_config where `id`= 1', 2);
        $team2 = $this->db->query("select count(id) as t_num from w_users where m_line like '%," . $user['id'] . ",%' and m_del=0 and m_level>0", 2);
        $t_num = empty($team2['t_num']) ? 0 : intval($team2['t_num']);
        $styles = $this->db->query('select * from w_style where s_display=1 order by s_sort asc', 3);
        if ($styles) {
            foreach ($styles as &$st) {
                if ($this->config['w_temp'] == 4) {
                    $st['icon_img'] = str_replace('/icons/', '/iconss/', $st['s_icon']);
                } else {
                    $st['icon_img'] = $st['s_icon'];
                }
            }
        }
        $this->display('index.home', array('user' => $user, 'banner' => $banner, 'config' => $config, 't_num' => $t_num, 'styles' => $styles));
    }

    public function logout()
    {
        session_destroy();
        $url_index = '?m=index&c=login&logout_type=1';
        header('Location: ' . $url_index);
        exit();
    }

    //申请升级
    public function apply_up()
    {
        $user = $this->checkuser();
        $n_level = $user['m_level'];
        $u_level = $user['m_level'] + 1;
        $is_upgrade = 1;
        if ($u_level > $this->config['w_level']) {
            $is_upgrade = 0;
            $msg = '您当前已是最高级别';
        }
        $level = $this->db->query('select * from w_level where id=' . $u_level, 2);
        if (empty($level)) {
            $is_upgrade = 0;
            $msg = '未找到升级级别';
        }
        if ($level['l_tnum'] > 0) {
            $members = $this->db->query('select id,m_tid,m_del from w_users where m_del=0 and m_tid=' . $user['id'], 3);
            if (count($members) < $level['l_tnum']) {
                $is_upgrade = 0;
                $msg = '直推人数未达标';
            }
        }
        if ($level['l_znum'] > 0) {
            $members = $this->db->query("select id,m_line,m_del from w_users where m_del=0 and m_line like '%," . $user['id'] . ",%'", 3);
            if (count($members) < $level['l_znum']) {
                $is_upgrade = 0;
                $msg = '团队人数未达标';
            }
        }
        if ($this->post) {
            if ($is_upgrade == 0) {
                echo json_encode(array('code' => 0, 'msg' => $msg));
                exit();
            }
            $w_up_level = $this->db->query("select * from `w_uplevel` WHERE `uid` = '" . $user['id'] . "' AND `status` = '0'", 3);
            if (count($w_up_level) > 0) {
                echo json_encode(array('code' => 0, 'msg' => '升级审核中,请耐心等待'));
                exit();
            }
            $up_members = array_reverse(explode(',', $user['m_line']));
            $one_id = 0;
            $two_id = 0;
            if (array_key_exists($level['l_user1'], $up_members) && $level['l_user1'] > 0) {
                $one_id = $up_members[$level['l_user1']];
                $tmpuser = $this->db->query('select id,m_del from w_users where m_del=0 and id=' . $one_id, 2);
                if (empty($tmpuser)) {
                    $one_id = $this->config['w_user'];
                }
            }
            if (array_key_exists($level['l_user2'], $up_members) && $level['l_user2'] > 0) {
                $two_id = $up_members[$level['l_user2']];
                $tmpuser = $this->db->query('select id,m_del from w_users where m_del=0 and id=' . $two_id, 2);
                if (empty($tmpuser)) {
                    $two_id = $this->config['w_user'];
                }
            }
            if ($one_id == 0 && $level['l_user1'] > 0) {
                $one_id = $this->config['w_user'];
            }
            if ($two_id == 0 && $level['l_user2'] > 0) {
                $two_id = $this->config['w_user'];
            }
            if ($u_level == 1 && $user['m_pid'] != $user['m_tid']) { //升级一星会员给推荐人和节点人各一单
                $two_id = $user['m_tid'];
            }
            if ($one_id) {
                $uplevel = array(
                    'uid' => $user['id'],
                    'sid' => $one_id,
                    'level' => $u_level,
                    'status' => 0,
                    'c_time' => time(),
                    'd_time' => 0
                );
                $this->db->insert('w_uplevel', $uplevel);
                if ($this->smsset['w_user_dnt']) {
                    $v_phone = $this->getMember($one_id, 'm_phone');
                    $this->sendcode($v_phone, 'dnt');
                }
            }
            if ($two_id) {
                $uplevel = array(
                    'uid' => $user['id'],
                    'sid' => $two_id,
                    'level' => $u_level,
                    'status' => 0,
                    'c_time' => time(),
                    'd_time' => 0
                );
                $this->db->insert('w_uplevel', $uplevel);
                if ($this->smsset['w_user_dnt']) {
                    $v_phone = $this->getMember($two_id, 'm_phone');
                    $this->sendcode($v_phone, 'dnt');
                }
            }
            echo json_encode(array('code' => 1, 'msg' => '申请成功'));
            exit();
        }
        $w_up_level = $this->db->query("select * from `w_uplevel` WHERE `uid` = '" . $user['id'] . "' AND `status` = '0'", 3);
        if (empty($w_up_level)) {
            $is_status = 1;
        } else {
            $is_status = 2;
        }

        $this->display('apply_up', array('user' => $user, 'n_level' => $n_level, 'u_level' => $u_level, 'is_status' => $is_status));
    }

    //审核升级
    public function to_up()
    {
        $arr = array();
        $user = $this->checkuser();
        $w_level = $this->db->query("select * from `w_uplevel` WHERE `sid` = '" . $user['id'] . "' AND `status` = '0' ORDER BY `c_time` DESC", 3);
        if (!empty($w_level)) {
            foreach ($w_level as $k => $v) {
                $s_user = $this->db->query("select * from `w_users` where `id` = '" . $v['uid'] . "' AND `m_del` = '0' ", 2);
                if (!empty($s_user)) {
                    $v['user_id'] = $s_user['id'];
                    $v['m_name'] = $s_user['m_name'];
                    $v['l_name'] = $this->user_levels[$s_user['m_level']];
                    $v['m_weixin'] = $s_user['m_weixin'];
                    $v['m_phone'] = $s_user['m_phone'];
                    $arr[] = $v;
                }
            }
        }
        $this->display('to_up', array('user' => $user, 's_user' => $arr));
    }

    public function ck_lok()
    {
        $user = $this->checkuser();
        if ($this->post) {
            $logid = intval($_POST['id']);
            $u_log = $this->db->query('select * from w_uplevel where id=' . $logid, 2);
            if ($u_log && $u_log['sid'] == $user['id']) {
              /*  $s_user = $this->db->query('select * from w_users where id='.$u_log['uid'].' and m_pid='.$u_log['sid'], 2);
                $n_user = $this->db->query('select * from w_users where id='.$u_log['sid'], 2);
                if(!empty($s_user)){
                    if ($u_log['level'] == 1 and $n_user['m_level'] < 2) {
                        echo json_encode(array('code' => 0, 'msg' => '您的级别过低,请升级后重试'));
                        exit();
                    }
                }*/
                if ($u_log['level'] > $user['m_level']) {
                    echo json_encode(array('code' => 0, 'msg' => '您的级别过低,请升级后重试'));
                    exit();
                }
                if ($u_log['status']) {
                    echo json_encode(array('code' => 0, 'msg' => '已审核,请勿重复审核'));
                    exit();
                } else {
                    if ($this->upgrade_do($logid) > 0) {
                        echo json_encode(array('code' => 1, 'msg' => '审核成功'));
                        exit();
                    } else {
                        echo json_encode(array('code' => 0, 'msg' => '发生未知错误'));
                        exit();
                    }
                }
            } else {
                echo json_encode(array('code' => 0, 'msg' => '没有权限'));
                exit();
            }
        }
    }


    //商家信息
    public function shop_info()
    {
        $user = $this->checkuser();
        $w_up_level = $this->db->query('select * from `w_uplevel` WHERE `uid` = ' . $user['id'] . ' AND `status` =0', 3);
        if (!empty($w_up_level)) {
            foreach ($w_up_level as &$row) {
                $row['m_phone'] = $this->getMember($row['sid'], 'm_phone');
                $row['m_levels'] = $this->getMember($row['sid'], 'm_level');
                $row['m_id'] = $row['sid'];
                $row['m_weixin'] = $this->getMember($row['sid'], 'm_weixin');
                $row['m_name'] = $this->getMember($row['sid'], 'm_name');
                $row['m_level'] = $this->user_levels[$row['m_levels']];
                $row['u_levels'] = $this->user_levels[$row['level']];
            }
        } else {
            $w_up_level = [];
        }
        $this->display('shop_info', array('user' => $user, 'logs' => $w_up_level));
    }

    //设置中心
    public function setup()
    {
        $user = $this->checkuser();
        $this->display('setup', array('user' => $user));
    }

    //修改资料
    public function save_info()
    {
        $user = $this->checkuser();
        if ($this->post) {
            header('Content-type:text/json');
            $fields = $_POST;
            $uid = $user['id'];
            if (empty($fields['m_name'])) {
                echo json_encode(array('code' => 0, 'msg' => '姓名不能为空'));
                exit();
            }
            if (empty($fields['m_weixin'])) {
                echo json_encode(array('code' => 0, 'msg' => 'LINE不能为空'));
                exit();
            }
            $msg = "修改成功！";
            if ($fields['m_weixin'] != $user['m_weixin']) {
                $w_wlog = array(
                    'l_uid' => $user['id'],
                    'l_old' => $user['m_weixin'],
                    'l_new' => $fields['m_weixin'],
                    'l_time' => time(),
                    'l_status' => 0
                );
                $this->db->insert('w_wlog', $w_wlog);
                $msg = '您修改了LINE号,请联系客服审核！';
            }
            $member = array(
                'm_name' => $fields['m_name'],
            );
            $this->db->update('w_users', $member, array('id' => $uid));
            echo json_encode(array('code' => 1, 'msg' => $msg));
            exit();
        }
        $this->display('save_info', array('user' => $user));
    }

    //修改密码
    public function save_pwd()
    {
        $user = $this->checkuser();
        if ($this->post) {
            header('Content-type:text/json');
            $fields = $_POST;
            $uid = $user['id'];
            if (md5($fields['old_pwd']) != $user['m_pass']) {
                echo json_encode(array('code' => 0, 'msg' => '原密码有误！'));
                exit();
            }
            $arr = array(
                'm_pass' => md5($fields['news_pwd1'])
            );
            $is_save = $this->db->update('w_users', $arr, array('id' => $uid));
            if ($is_save) {
                echo json_encode(array('code' => 1, 'msg' => '编辑成功！'));
                exit();
            } else {
                echo json_encode(array('code' => 0, 'msg' => '编辑失败！'));
                exit();
            }
        }
        $this->display('save_pwd', array('user' => $user));
    }

    //历史审核记录
    public function history()
    {
        $arr = array();
        $user = $this->checkuser();
        $w_level = $this->db->query("select * from `w_uplevel` WHERE `sid` = '" . $user['id'] . "' AND `status` <> '0' ORDER BY `c_time` DESC", 3);
        if (!empty($w_level)) {
            foreach ($w_level as $k => $v) {
                $s_user = $this->db->query("select * from `w_users` where `id` = '" . $v['uid'] . "' AND `m_del` = '0' ", 2);
                if (!empty($s_user)) {
                    $v['user_id'] = $s_user['id'];
                    $v['m_name'] = $s_user['m_name'];
                    $v['l_name'] = $this->user_levels[$s_user['m_level']];;
                    $v['m_weixin'] = $s_user['m_weixin'];
                    $v['m_phone'] = $s_user['m_phone'];
                    $arr[] = $v;
                }
            }
        }
        $this->display('history', array('user' => $user, 'w_log' => $arr));
    }

    public function checkup()
    {
        header('Content-type:text/json');
        $phone = $_POST['phone'];
        $sql = "select * from w_users where m_phone='$phone' and m_del=0";
        $user = $this->db->query($sql, 2);
        if (!empty($user)) {
            echo json_encode(array('code' => 1, 'msg' => $user['id']));
            exit();
        } else {
            echo json_encode(array('code' => 0, 'msg' => ''));
            exit();
        }
    }

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

    //转存图片
    public function UploadImg($data){
        if (mb_strlen($data) > 50) {
            $img_arr = explode(',', $data);
            if(!array_key_exists('1',$img_arr)){
                echo json_encode(array('code' => 0, 'msg' => '图片格式有误'));
                exit();
            }
            $img = $img_arr['1'];
            $tmp = base64_decode($img);
            $path = "./static/upload/images/".date('Ymd');
            if (!is_dir($path)){
                mkdir($path, 0777, true);
            }
            $path_name = $path . '/' . time() . rand('100', '999') . '.jpg';
            if (file_exists($path)) {
                file_put_contents($path_name, $tmp);
            }
            $data = $_SERVER['HTTP_ORIGIN'] . substr($path_name, 1);
        }
        return $data;
    }

}

?>