<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"D:\phpStudy\WWW\tp5\public/../application/home/view/default/my\baoxiu.html";i:1534061134;s:8:"nav.html";i:1534058653;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线报修</title>

    <!-- Bootstrap -->
    <link href="/static2/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static2/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航加载-->
    <!--导航部分-->
<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid text-center">
        <div class="col-xs-3">
            <p class="navbar-text"><a href="<?php echo url('home/index/index'); ?>" class="navbar-link">首页</a></p>
        </div>
        <div class="col-xs-3">
            <p class="navbar-text"><a href="<?php echo url('home/fuwu/index'); ?>" class="navbar-link">服务</a></p>
        </div>
        <div class="col-xs-3">
            <p class="navbar-text"><a href="faxian.html" class="navbar-link">发现</a></p>
        </div>
        <div class="col-xs-3">
            <p class="navbar-text"><a href="<?php echo url('home/my/index'); ?>" class="navbar-link">我的</a></p>
        </div>
    </div>
</nav>
<!--导航结束-->

    <div class="container-fluid">
        <div class="blank"></div>
        <div class="container">
            <table class="table table-bordered">
                <tr>
                    <th>报修人</th>
                    <th>标题</th>
                    <th>内容</th>
                    <th>报修时间</th>
                    <th>处理状态</th>
                </tr>
                <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$baoxiu): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $baoxiu['name']; ?></td>
                    <td><?php echo $baoxiu['title']; ?></td>
                    <td><?php echo $baoxiu['content']; ?></td>
                    <td><?php echo $baoxiu['time']; ?></td>
                    <td><?php echo !empty($baoxiu['status']) && $baoxiu['status']!==1?'正在处理中':'已处理'; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </table>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static2/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>