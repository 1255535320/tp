<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26
 * Time: 14:43
 */

namespace app\admin\controller;


use think\Cookie;
use think\Db;

class Fix extends Admin
{
    public function add(){
        if (request()->ispost){
            var_dump(111);exit;
            $Fix = model('Fix');
            $post_data = request()->post();
            $validate = validate('Fix');
            if (!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
            $data=$Fix->create($post_data);
            if ($data){
                session(' admin_fix_add',null);
                //记录行为
                action_log('新增成功',Cookie('_fix'));
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
    //列表
    public function index(){
        $id = input('id',0);
        if ($id){
         $data= Db::name('Fix')->where("id={$id}")->field(true)->find();
         $this->assign('data',$data);
        }
        $title =trim(input('title'));
        $name =trim(input('name'));
        $tel =trim(input('tel'));
        $address =trim(input('address'));
        $content =trim(input('content'));
    }

}