<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\phpStudy\WWW\tp5\public/../application/user/view/default/login\index.html";i:1534056026;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>登录页面</title>

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
    <!--导航部分-->
    <!--<nav class="navbar navbar-default navbar-fixed-bottom">-->
        <!--<div class="container-fluid text-center">-->
            <!--<div class="col-xs-3">-->
                <!--<p class="navbar-text"><a href="index之前的.html" class="navbar-link">首页</a></p>-->
            <!--</div>-->
            <!--<div class="col-xs-3">-->
                <!--<p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>-->
            <!--</div>-->
            <!--<div class="col-xs-3">-->
                <!--<p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>-->
            <!--</div>-->
            <!--<div class="col-xs-3">-->
                <!--<p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>-->
            <!--</div>-->
        <!--</div>-->
    <!--</nav>-->
    <!--导航结束-->

    <div class="container-fluid">
        <form>

            <div class="form-group">
                <label>用户名:</label>
                <input type="text" id="inputEmail" class="form-control" placeholder="请输入用户名"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写1-16位用户名" nullmsg="请填写用户名" datatype="*1-16" value="" name="username">
            </div>

            <div class="form-group">
                <label>密码:</label>
                <input type="password" id="inputPassword"  class="form-control" placeholder="请输入密码"  errormsg="密码为6-20位" nullmsg="请填写密码" datatype="*6-20" name="password">
            </div>

<!--验证码开始-->
            <div class="form-group">
                <label for="inputPassword">验证码</label>
                <input type="text" id="inputPassword" class="form-control" placeholder="请输入验证码"  errormsg="请填写5位验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">
                <label class="control-label"></label>
                <div class="controls verifyimg">
                    <?php echo captcha_img(); ?>
                </div>
                <div class="controls Validform_checktip text-warning"></div>
            </div>
<!--验证码结束-->
            <!--自动登录-->
            <div class="form-group">
                <label>
                    <input type="checkbox" > 自动登陆
                </label>

            </div>
            <div class="form-group">
                <button class="btn btn-primary onlineBtn">立即登录</button>
            </div>

            <div class="form-group">
                <a href="" style="float: left">忘记密码</a>
                <a href="<?php echo url('login/register'); ?>" style="float: right">立即注册</a>
            </div>

        </form>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static2/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static2/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

    $(document)
        .ajaxStart(function(){
            $("button:submit").addClass("log-in").attr("disabled", true);
        })
        .ajaxStop(function(){
            $("button:submit").removeClass("log-in").attr("disabled", false);
        });


    $("form").submit(function(){
        var self = $(this);
        $.post(self.attr("action"), self.serialize(), success, "json");
        return false;

        function success(data){
            if(data.code){
                window.location.href = data.url;
            } else {
                self.find(".Validform_checktip").text(data.msg);
                //刷新验证码
                $(".verifyimg img").click();
            }
        }
    });

    $(function(){
        //刷新验证码
        var verifyimg = $(".verifyimg img").attr("src");
        $(".verifyimg img").click(function(){
            if( verifyimg.indexOf('?')>0){
                $(".verifyimg img").attr("src", verifyimg+'&random='+Math.random());
            }else{
                $(".verifyimg img").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
            }
        });
    });
</script>
</body>
</html>