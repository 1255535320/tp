<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 14:01
 */

namespace app\home\controller;


use think\Controller;
use think\Session;

class Wechat extends Controller
{   //获取用户id
    public function info(){
        //保存当前地址到session
        Session::set('return_url',url('home/wechat/info'));
        //如果session中没有openid
        if (!Session::has('openid')){
            $appID='wxdc8dbf0858ee97fe';
//        var_dump($appID);exit;
            $callback_url=url('home/wechat/callback','',true,true);
//        https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect 若提示“该链接无法访
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appID}&redirect_uri={$callback_url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            $this->redirect($url);
        }else{
            return $openid=Session::get('openid');
        }
//        var_dump($openid);
    }

    //授权成功回调页面
    public function callback(){
        //获取code
        $code =request()->get('code');
        $secret='d089f8fde7b4e5bb68a9dbd5e913db5c';
        //通过code获取token
        $appID='wxdc8dbf0858ee97fe';
//        https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
       $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appID}&secret={$secret}&code={$code}&grant_type=authorization_code";
        $str= file_get_contents($url);
        $json= json_decode($str);
//        var_dump($json);exit;
        //保存用户id
        Session::set('openid',$json->openid);
        //判断session中是否保存有地址
        if (Session::has(Session::get('return_url'))){
            $this->redirect(Session::get('return_url'));
        }

    }
}