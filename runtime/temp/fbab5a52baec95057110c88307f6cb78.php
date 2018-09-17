<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"D:\phpStudy\WWW\tp5\public/../application/home/view/default/article\lists.html";i:1534058577;s:8:"nav.html";i:1534058653;}*/ ?>
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
<body>
    <div class="container-fluid">

        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>

        <div class="article_list">
            <div class="row noticeList">
                <a href="<?php echo url('Article/detail?id='.$data['id']); ?>">
                    <div class="col-xs-2">
                        <img class="noticeImg" src="__ROOT__<?php echo get_cover_path($data['cover_id']); ?>" />
                    </div>
                    <div class="col-xs-10">
                        <p class="title" href="<?php echo url('Article/detail?id='.$data['id']); ?>"><?php echo $data['title']; ?></p>
                        <p class="intro"><?php echo get_username($data['uid']); ?></p>
                        <p class="info">浏览: <?php echo $data['view']; ?> <span class="pull-right"><?php echo $data['create_time']; ?></span> </p>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div id="apd">

            </div>
            <span id="getlist">
                <button class="btn btn-default btn-block get_more" id="btn">获取更多。。。</button>
            </span>
        </div>
    </div>
<!--</section>-->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static2/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(function () {
        var page=2;
        category=<?php echo $category['id']; ?>;
        $("#getlist").click(function () {
            $.get( "/home/article/lists?page="+page+"&category="+category,function (date) {
                if (date===''){
                    $("#apd").append('<div style="text-align: center">没有更多信息...</div>');
                    $("#getlist").remove();
                }else{
                    $("#apd").append(date);
                }
         });
            page++;
        });

    })
</script>
</body>
</html>