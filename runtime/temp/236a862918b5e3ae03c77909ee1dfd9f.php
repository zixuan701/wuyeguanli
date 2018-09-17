<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpStudy\WWW\tp5\public/../application/home/view/default/article\about.html";i:1533963076;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

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

    <div class="container-fluid">
        <div class="blank"></div>
        <h3 class="noticeDetailTitle"><strong>成都洛克物业管理有限公司</strong></h3>
        <hr>
        <div class="noticeDetailContent">
         公司成立于2018年8月,现有公司员工50000人,致力于打造一个综合能力超强的服务于千亿人的精英团队,公司提供多项发展,为员工提供多个温室岗位,让你一上岗就再也不想离开.公司成立于2018年8月,现有公司员工50000人,致力于打造一个综合能力超强的服务于千亿人的精英团队,公司提供多项发展,为员工提供
        </div>
        <h5>
            公司地址:成都市成华区脑壳街雅雀路258号
        </h5>
        <h5>
            公司电话:028-61254568
        </h5>
        <?php $prev = model('Document')->prev($info); if(!(empty($prev) || (($prev instanceof \think\Collection || $prev instanceof \think\Paginator ) && $prev->isEmpty()))): ?>
        <a href="<?php echo url('',array('id'=>$prev['id'])); ?>">上一篇</a>
        <?php endif; $next = model('Document')->next($info); if(!(empty($next) || (($next instanceof \think\Collection || $next instanceof \think\Paginator ) && $next->isEmpty()))): ?>
        <a href="<?php echo url('?id='.$next['id']); ?>">下一篇</a>
        <?php endif; ?>
    </div>
<!--</div>-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static2/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>