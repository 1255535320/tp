<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 14:01
 */

namespace app\home\controller;


use think\Controller;

class Wechat extends Controller
{   //获取用户id
    public function info(){
        $appID='wxdc8dbf0858ee97fe';
        $callback=url('home/wechat/callback','',true,true);
//        https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect 若提示“该链接无法访
    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appID}&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
    $this->redirect($url);
    }

    //授权成功回调页面
    public function callback(){
        echo '111';
    }
}