<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/29
 * Time: 18:53
 */

namespace app\home\controller;


//活动报名
use think\Db;
use think\Loader;
use think\Validate;

class Apply extends Home
{
    public function add(){
        $uid=is_login();
        $Apply=model('Apply');
        $get_data=[];
        $get_data['active_id']=request()->get('id');
        $get_data['uid']=$uid;
        $validate = new Validate();
        if (!$validate->check($get_data)){
            return $this->error($validate->getError());
        }
//        var_dump($get_data);exit;
        if ($uid){
            //查询该id是否参加过此活动
            $info = Db::name('Apply')->where(['uid'=>$uid,'active_id'=>$get_data['active_id']])->select();
           if ($info){
               return json_encode(3);
           }else{
               //可以报名
               $data=$Apply->create($get_data);
               if ($data){
                   return json_encode(1);
               }
           }
        }else{
            //未登录
//            $this->redirect('/user/login', '页面跳转中...');
           return json_encode(0);
        }

    }
}