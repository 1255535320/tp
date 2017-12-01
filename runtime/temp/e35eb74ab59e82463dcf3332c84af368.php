<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\www\twothink\public/../application/home/view/default/index\index.html";i:1512083005;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!--<load href='__PUBLIC__/public/static/static/tp/bootstrap/css/bootstrap.min.css' />-->
    <link href="/static/static/tp/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/static/tp/css/style.css" rel="stylesheet">

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
    <?php $__CATE__ = model('Category')->getChildrenId(1);$__WHERE__ = model('Document')->listMap($__CATE__);$__LIST__ = \think\Db::name('Document')->where($__WHERE__)->field($field)->order('`level` DESC,`id` DESC')->paginate(10);if($__LIST__){ $__LIST__=$__LIST__->toArray(); $__LIST__=$__LIST__['data'];} if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$article): $mod = ($i % 2 );++$i;?>

    <nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid text-center">
        <div class="col-xs-3">
            <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
        </div>
        <div class="col-xs-3">
            <p class="fuwu navbar-text"><a href="javascript:;" id="uid" class="navbar-link">服务</a></p>
        </div>
        <div class="col-xs-3">
            <p class="navbar-text"><a href="<?php echo url('Article/index?category=shop'); ?>" class="navbar-link">发现</a></p>
        </div>
        <div class="col-xs-3">
            <p class="navbar-text"><a href="my.html" class="navbar-link">我的</a></p>
        </div>
    </div>
</nav>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <!--导航结束-->

<div class="container-fluid">
    <div class="indexImg row">
        <img src="/static/static/tp/image/index.png" width="100%" />
    </div>
    <div class="serviceList text-center">
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <a href="<?php echo url('Article/lists?category=default_blog'); ?>">
                    <div class="indexLabel label-danger">
                    <span class="glyphicon glyphicon-bullhorn"></span><br/>
                    小区通知
                    </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <!--<a href="<?php echo url('Article/index?category=policy'); ?>">-->
                    <a href="<?php echo url('Article/lists?category=policy'); ?>">
                    <div class="indexLabel label-warning">
                    <span class="glyphicon glyphicon-ok-circle"></span><br/>
                    便民服务
                    </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo url('Fix/add?id='.$fix['id']); ?>">
                    <div class="indexLabel label-info">
                    <span class="glyphicon glyphicon-heart-empty"></span><br/>
                    在线报修
                    </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo url('Article/lists?category=shop'); ?>">
                    <div class="indexLabel label-success">
                    <span class="glyphicon glyphicon-briefcase"></span><br/>
                    商家活动
                    </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo url('Article/index?category=rent'); ?>">
                    <div class="indexLabel label-primary">
                    <span class="glyphicon glyphicon-usd"></span><br/>
                    小区租售
                    </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo url('Article/lists?category=plot'); ?>">
                    <div class="indexLabel label-default">
                        <span class="glyphicon glyphicon-apple"></span><br/>
                        小区活动
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/static/tp/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/static/tp/bootstrap/js/bootstrap.min.js"></script>
<script>
    $('.fuwu').click(function () {
        //验证是否登录
        $.getJSON('/home/fuwu/index',function(data){
            if(data==1){
                window.location.href='/user/login/index';
            } else{
              window.location.href='/home/fuwu/lists';
//                window.location.href='../application/home/view/default/fuwu/index'
            }
        })
    })
</script>
</body>
</html>