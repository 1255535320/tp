<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"E:\www\twothink\public/../application/home/view/default/article\article\detail.html";i:1511955869;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/static/static/tp/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/static/tp/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main {
            margin-bottom: 60px;
        }

        .indexLabel {
            padding: 10px 0;
            margin: 10px 0 0;
            color: #fff;
        }
    </style>
</head>


<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid">
        <div class="blank"></div>
        <h3 class="noticeDetailTitle"><strong><?php echo $info['title']; ?></strong></h3>
        <div class="noticeDetailInfo">通知人:<?php echo get_username($info['uid']); ?></div>
        <input type="hidden" id="active_id" value="<?php echo $info['id']; ?>">
        <div class="noticeDetailInfo">发布时间：<?php echo date('Y-m-d H:i',$info['create_time']); ?></div>
        <?php if($info['category_id']==44): ?>
        <div class="noticeDetailInfo"><a href="javascript:;" class="btn btn-warning">我要报名</a></div>
        <?php endif; ?>
        <div class="noticeDetailContent">
            <?php echo $info['content']; ?>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/static/tp/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/static/tp/bootstrap/js/bootstrap.min.js"></script>
<script>
    $('.btn').click(function () {
        var id = $('#active_id').val();
        $.getJSON('/home/apply/add', {'id': id}, function (data) {
//        console.debug(data)
                if (data == 1) {
                    alert('报名成功')
                } else if (data == 0) {
                    alert('请登陆后操作')
                    window.location.href = '/user/login/index';
                } else {
                    alert('请不要重复报名')
                }
            }
        );

    })
</script>
</body>
</html>

