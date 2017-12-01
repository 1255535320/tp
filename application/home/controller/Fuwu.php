<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/30
 * Time: 11:02
 */

namespace app\home\controller;


use app\home\validate\Model;
use think\Db;
use think\Validate;

class Fuwu extends Home
{
    public function index(){
        $uid=is_login();
        if ($uid){
            return json_encode(0);
        }else{
            return json_encode(1);
        }
    }
    public function lists(){
            $Fuwu =new Fuwu();
            $this->assign('fuwu/index',$Fuwu);
           return $this->fetch('fuwu/index');
    }
    //业主认证
    public function add(){
        $Fuwu =model('Fuwu');
        if (request()->isPost()){
            $post_data = request()->post();
            //验证
            $validate = new Validate();
            if (!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $post_data['uid']=is_login();
            $data=$Fuwu->create($post_data);
            if ($data){
                session(' home_fuwu_add',null);
                //记录行为
                action_log('update_fix','Fuwu',$data->id,UID);
                $this->success('已提交认证','lists',Cookie('__forward__'));
            }else{
                $this->error($Fuwu->getError());
            }
        }else{
            $this->assign('fuwu/index',$Fuwu);
//            return $this->fetch('add');
            $this->assign('meta_title','新增用户') ;
            return $this->fetch('add');
        }
    }

}