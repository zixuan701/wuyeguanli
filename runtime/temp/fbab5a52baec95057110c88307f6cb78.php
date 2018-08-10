<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpStudy\WWW\tp5\public/../application/home/view/default/article\lists.html";i:1533873776;}*/ ?>
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

<section id="contents">
    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
    <div class="row noticeList">
        <div class="col-xs-2">
            <a href="<?php echo url('Article/detail?id='.$data['id']); ?>"><img class="img-thumbnail" src="__ROOT__<?php echo get_cover_path($data['cover_id']); ?>" /></a>
        </div>
        <div class="col-xs-10">
            <h3 class="ellipsis"><a href="<?php echo url('Article/detail?id='.$data['id']); ?>"><?php echo $data['title']; ?></a></h3>
            <p class="lead"><?php echo $data['description']; ?></p>
            <span><a href="<?php echo url('Article/detail?id='.$data['id']); ?>">查看全文</a></span>
            <span class="pull-right">
											<span class="author"><?php echo get_username($data['uid']); ?></span>&nbsp;&nbsp;
											<span>发表于 <?php echo $data['create_time']; ?></span>
											<span>阅读(<?php echo $data['view']; ?>)</span>&nbsp;&nbsp;
										</span>
        </div>
        <hr/>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <!--<div class="twothink pagination pagination-right pagination-large">-->
        <!--<?php $__PAGE__ = \think\Db::name('Document')->paginate($category['list_row'],get_list_count($category['id']));echo $__PAGE__->render(); ?>-->
    <!--</div>-->
</section>
<div id="apd"></div>
<div style="text-align: center" id="getlist">获取更多通知...</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static2/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(function () {

        var page=1;
        $("#getlist").click(function () {
            $.get( "/home/article/getList?page="+page+"&category=42",function (date) {
               $("#apd").append(date);
            });
            page++;
        });




    })
</script>
</body>
</html>