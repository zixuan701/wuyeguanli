<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpStudy\WWW\tp5\public/../application/home/view/default/article\article\detail.html";i:1533809716;}*/ ?>
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
        <h3 class="noticeDetailTitle"><strong><?php echo $info['title']; ?></strong></h3>
        <div class="noticeDetailInfo">发布者:<?php echo get_username($info['uid']); ?></div>
        <div class="noticeDetailInfo">发布时间：<?php echo date('Y-m-d H:i',$info['create_time']); ?></div>
        <div class="noticeDetailContent">
            <?php echo $info['content']; ?>
        </div>
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