<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 17:57
 */

namespace app\home\controller;


use think\Controller;
use think\Db;
use think\Validate;

class Fix extends Home
{
   //添加
    public function add(){
//        if (!isset($_SESSION['uid'])){
//            header("Loaction:user/login");
//        }
        if (request()->isPost()){
//            var_dump(111);exit;
            $Fix = model('Fix');
            $post_data = request()->post();
            //验证
//            $validate =new Validate();
            $validate =validate('Fix');
            if (!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
//            $post_data['create_at']=date('Y-m-d H:i:s');
            $data=$Fix->create($post_data);
//            var_dump($data);exit;
            if ($data){
                session(' admin_fix_add',null);
                //记录行为
                action_log('update_fix','Fix',$data->id,UID);
                $this->success('新增成功','index',Cookie('__forward__'));
            }else{
                $this->error($Fix->getError());
            }
        }else{

            $this->assign('info',array('id'=>input('id'),'name'=>input('name'),'tel'=>input('tel'),
                'address'=>input('address'),'content'=>input('content'),));
            $fix=Db::name('Fix')->field(true)->select();
            $fix=model('Common/Tree')->toFormatTree($fix);
            $this->assign('Fix',$fix);
            $this->assign('fix_add','新增保修');
//            var_dump(222);exit;
            return $this->fetch('add');
        }
    }
}