<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\www\twothink\public/../application/user/view/default/login\index.html";i:1511666217;}*/ ?>
<?php echo hook('pageHeader'); ?>
</head>
<body>
<!-- 头部 -->
<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="<?php echo url('index/index'); ?>">TwoThink</a>
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <?php $__NAV__ = \think\Db::name('Channel')->field(true)->where("status=1")->order("sort")->select();if(is_array($__NAV__) || $__NAV__ instanceof \think\Collection || $__NAV__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;if($nav['pid'] == '0'): ?>
          <li>
            <a href="<?php echo get_nav_url($nav['url']); ?>" target="<?php if($nav['target'] == '1'): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo $nav['title']; ?></a>
          </li>
          <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      <div class="nav-collapse collapse pull-right">
        <?php if(is_login()): ?>
        <ul class="nav" style="margin-right:0">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username(); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo url('user/user/profile'); ?>">修改密码</a></li>
              <li><a href="<?php echo url('user/login/logout'); ?>">退出</a></li>
            </ul>
          </li>
        </ul>
        <?php else: ?>
        <ul class="nav" style="margin-right:0">
          <li>
            <a href="<?php echo url('user/login/index'); ?>">登录</a>
          </li>
          <li>
            <a href="<?php echo url('user/user/register'); ?>" style="padding-left:0;padding-right:0">注册</a>
          </li>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


<section>
  <div class="span12">
    <form class="login-form" action="" method="post">
      <div class="control-group">
        <label class="control-label" for="inputEmail">用户名</label>
        <div class="controls">
          <input type="text" id="inputEmail" class="span3" placeholder="请输入用户名"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写1-16位用户名" nullmsg="请填写用户名" datatype="*1-16" value="" name="username">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">密码</label>
        <div class="controls">
          <input type="password" id="inputPassword"  class="span3" placeholder="请输入密码"  errormsg="密码为6-20位" nullmsg="请填写密码" datatype="*6-20" name="password">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">验证码</label>
        <div class="controls">
          <input type="text" id="inputPassword" class="span3" placeholder="请输入验证码"  errormsg="请填写5位验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"></label>
        <div class="controls verifyimg">
          <?php echo captcha_img(); ?>
        </div>
        <div class="controls Validform_checktip text-warning"></div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input type="checkbox"> 自动登陆
          </label>
          <button type="submit" class="btn">登 陆</button>
        </div>
      </div>
    </form>
  </div>
</section>


 

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

