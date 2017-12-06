<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/4
 * Time: 14:37
 */

namespace app\home\controller;

use EasyWeChat\Foundation\Application;

use EasyWeChat\Message\News;
use function GuzzleHttp\Psr7\str;
use think\Config;
use think\Controller;
use think\Response;

class Weixin extends Controller
{
    public function index()
    {
        $app = new Application(Config::get('wechat'));
// 从项目实例中得到服务端应用实例。
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            $redis=new \Redis();
            $redis->connect('127.0.0.1');
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
//            return "您好！欢迎关注我!";
//            return $message->Content;原样输出接收到的内容
            switch ($message->MsgType) {
                case 'event':
                    if ($message->Event=='CLICK'){
//                        $message->EventKey; 获取菜单key
                        switch ($message->EventKey){
                            case 'V1001_TODAY_ACTIVE':
                                return "感谢您的支持";
                                break;
                        }
                    }
                    return '收到事件消息';
                    break;
                //获取用户发的位置,搜索附近商家
                //1.用户发位置---获取用户的位置(百度地图接口)
                //2.用户发送关键字---回复附近商家内容(图文形式)

                case 'text':
                    //用户发送关键字,调用百度地图接口查询商家信息
                    $message->Content;//用户发送的关键字
                    //用户坐标信息
                    $location=$redis->hGetAll('location_'.$message->FromUserName);
                    if ($location){
                    //调用百度接口关键字查询附近商家
                        $ak='YZTOZYEQOvgCz3msag3sXCiXRIGYBtGC';
                        $query=urlencode($message->Content);//url请求参数编码,避免特殊符号
                        $url="http://api.map.baidu.com/place/v2/search?query={$query}".
                            "&location={$location['x']},{$location['y']}&radius=2000&output=xml&ak=$ak";
                        $xml=simplexml_load_file($url);
                        $news=[];//存储遍历图文信息
                        $pics=[
                            'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2538750809,2877294847&fm=27&gp=0.jpg',
                            'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=1159642459,957462517&fm=27&gp=0.jpg',
                            'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=2543422105,3201565147&fm=27&gp=0.jpg',
                            ];
                        //遍历每一条查询结果
                        foreach ($xml->results->result as $result){
                            $news[] = new News([
                                'title'       =>(string)$result->name,
                                'image'       => $pics[rand(0,3)],
                                //地图详情url
                                'url'         => "http://map.baidu.com/detail?qt=ninf&uid=".(string)$result->uid."&detail=life",
                                ]);
                            //微信限制图文信息最高8条
                            if (count($news)==8){
                                break;
                            }
                        }
                        return $news;

                    }else{
                        return '请先发送位置,我们将帮您搜索附近商家';
                    }
//                    if($message->Content=='烤鱼'){
////                        return '收到文字消息';
//                        $news1 = new News([
//                            'title'       => '烤鱼',
//                            'description' => '...',
//                            'url'         => 'www.baidu.com',
//                            'image'       => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1512448526114&di=2d89177b826cb48d17ecd178341ef512&imgtype=0&src=http%3A%2F%2Fpic60.nipic.com%2Ffile%2F20150228%2F9422660_164004654000_2.jpg',
//                        ]);
//                        $news2 = new News([
//                            'title'       => '烤鱼2',
//                            'description' => '...',
//                            'url'         => 'www.baidu.com',
//                            'image'       => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1512448526114&di=2d89177b826cb48d17ecd178341ef512&imgtype=0&src=http%3A%2F%2Fpic60.nipic.com%2Ffile%2F20150228%2F9422660_164004654000_2.jpg',
//                        ]);
//                        $news3 = new News([
//                            'title'       => '烤鱼3',
//                            'description' => '...',
//                            'url'         => 'www.baidu.com',
//                            'image'       => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1512448526114&di=2d89177b826cb48d17ecd178341ef512&imgtype=0&src=http%3A%2F%2Fpic60.nipic.com%2Ffile%2F20150228%2F9422660_164004654000_2.jpg',
//                        ]);
//
//                        return [$news1,$news2,$news3];
//                    }
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    //以hash类型保存坐标信息到redis
                   $redis->hSet('location_'.$message->FromUserName,'x',$message->Location_X);
                   $redis->hSet('location_'.$message->FromUserName,'y',$message->Location_Y);
                    //设置过期时间
                    $redis->expire('location_'.$message->FromUserName,24*300);
                    return '已收到,请继续发送关键字搜索附近商家';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

        });
        $response = $server->serve();
        $response->send(); // Laravel 里请使用：return $response;
    }
    //菜单功能
    public function setMenu(){
        $app = new Application(Config::get('wechat'));
        $menu = $app->menu;
        $buttons = [
            //点击事件菜单
            [
                "type" => "click",
                "name" => "最新活动",
                "key"  => "V1001_TODAY_ACTIVE"
            ],
            [
                "type" => "click",
                "name" => "个人中心",
                "key"  => "V1001_TODAY_USER"
            ],
//            [
//                "name"       => "菜单",
//                //点击跳转菜单
//                "sub_button" => [
//                    [
//                        "type" => "view",
//                        "name" => "搜索",
//                        "url"  => "http://www.soso.com/"
//                    ],
//                    [
//                        "type" => "view",
//                        "name" => "视频",
//                        "url"  => "http://v.qq.com/"
//                    ],
//                    [
//                        "type" => "click",
//                        "name" => "赞一下我们",
//                        "key" => "V1001_GOOD"
//                    ],
//                ],
//            ],
            [
                "name"       => "导航",
                //点击跳转菜单
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "小区通知",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "便民服务",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "商家活动",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "小区租售",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "小区活动",
                        "url"  => "http://v.qq.com/"
                    ],

                ],
            ],
        ];
        $menu->add($buttons);
        echo "菜单生成";
    }
    //检查菜单
    public function getMenu(){
        $app = new Application(Config::get('wechat'));
        $menu = $app->menu;
        $menus=$menu->all();
        var_dump($menus);exit;
    }

}