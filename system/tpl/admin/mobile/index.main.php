<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo WEBNAME;?> - <?php echo WEBDESC;?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="/static/css/layui.css">
<link rel="stylesheet" href="/static/css/main.css">
<link rel="stylesheet" href="/static/css/admin.css">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">会员概况</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=index" class="layadmin-backlog-body">
                          <h3>今日新增</h3>
                          <p><cite><?php echo $num_1;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=index" class="layadmin-backlog-body">
                          <h3>昨日新增</h3>
                          <p><cite><?php echo $num_2;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=index" class="layadmin-backlog-body">
                          <h3>一星及以上</h3>
                          <p><cite><?php echo $num_3;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=index" class="layadmin-backlog-body">
                          <h3>会员总数</h3>
                          <p><cite><?php echo $num_4;?></cite></p>
                        </a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">订单概况</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=uplevel" class="layadmin-backlog-body">
                          <h3>今日新增</h3>
                          <p><cite><?php echo $num_5;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=uplevel" class="layadmin-backlog-body">
                          <h3>昨日新增</h3>
                          <p><cite><?php echo $num_6;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=uplevel" class="layadmin-backlog-body">
                          <h3>等待审核</h3>
                          <p><cite style="color: #FF5722;"><?php echo $num_7;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=uplevel" class="layadmin-backlog-body">
                          <h3>累计订单</h3>
                          <p><cite><?php echo $num_8;?></cite></p>
                        </a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
           <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">商盟概况</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="?m=shop&c=apply&type=0" class="layadmin-backlog-body">
                          <h3>入驻申请</h3>
                          <p><cite style="color: #FF5722;"><?php echo $num_9;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=shop&c=apply&type=1" class="layadmin-backlog-body">
                          <h3>7日内到期</h3>
                          <p><cite style="color: #FF5722;"><?php echo $num_10;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=shop&c=apply&type=1" class="layadmin-backlog-body">
                          <h3>推荐中店铺</h3>
                          <p><cite><?php echo $num_11;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=shop&c=apply&type=1" class="layadmin-backlog-body">
                          <h3>显示中店铺</h3>
                          <p><cite><?php echo $num_12;?></cite></p>
                        </a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">待办事项</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=mlogs" class="layadmin-backlog-body">
                          <h3>投诉待处理</h3>
                          <p><cite style="color: #FF5722;"><?php echo $num_13;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=mlogs" class="layadmin-backlog-body">
                          <h3>已处理</h3>
                          <p><cite><?php echo $num_14;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=wlogs" class="layadmin-backlog-body">
                          <h3>资料待审核</h3>
                          <p><cite style="color: #FF5722;"><?php echo $num_15;?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a href="?m=user&c=wlogs" class="layadmin-backlog-body">
                          <h3>已审核</h3>
                          <p><cite><?php echo $num_16;?></cite></p>
                        </a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
         <!--<div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">版本信息</div>
              <div class="layui-card-body layui-text">
                <table class="layui-table">
                  <colgroup>
                    <col width="100">
                    <col>
                  </colgroup>
                  <tbody>
                    <tr>
                      <td>当前版本</td>
                      <td>创客新零售 6.0</td>
                    </tr>
                    <tr>
                      <td>你的公司</td>
                      <td>你的公司</td>
                    </tr>
                    <tr>
                      <td>官方网址</td>
                      <td>你的网址</td>
                    </tr>
                    <tr>
                      <td>售后客服</td>
                      <td>你的联系方式</td>
                    </tr>
                    <tr>
                      <td>联系我们</td>
                      <td style="padding-bottom: 0;">
                        <div class="layui-btn-container">
                          <a href="你的网址" target="_blank" class="layui-btn layui-btn-danger">访问网站</a>
                          <a href="这里是在线客服链接" target="_blank" class="layui-btn">在线客服</a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>-->
        </div>
      </div>
    </div>
  </div>

<script src="/static/layui.js"></script> 
</body>
</html>