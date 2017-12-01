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
use think\Validate;

class Fix extends Admin
{
    public function add(){
        if (request()->isPost()){
//            var_dump(111);exit;
            $Fix = model('Fix');
            $post_data = request()->post();
            $validate =validate('Fix');
            if (!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
//            $post_data['create_time']=date('Y-m-d H:i:s');
            $data=$Fix->create($post_data);
//            var_dump($data);exit;
            if ($data){
                session(' admin_fix_add',null);
                //记录行为
                action_log('update_fix','Fix',$data->id,UID);
                $this->success('新增成功','fix/index',Cookie('__forward__'));
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

            return $this->fetch('edit');
        }

    }
    //列表
    public function index(){
//        var_dump(1111);
        $id = input('id',0);
//        var_dump($id);exit;
        if ($id){
         $data= Db::name('Fix')->where("id={$id}")->field(true)->find();
         var_dump($data);
         $this->assign('data',$data);
        }
        $title =trim(input('title'));
        $name =trim(input('name'));
        $tel =trim(input('tel'));
        $address =trim(input('address'));
        $content =trim(input('content'));
        $type = config('config_group_list');
        $all_fix =Db::name('Fix')->column('id,title');
//        $map['id'] =   $id;
//        var_dump($id);exit;
        if($title)
            $map['title'] = array('like',"%{$title}%");
        $list = Db::name('Fix')->where($map)->field(true)->order('id asc')->paginate(6);
        if ($list){
            foreach ($list as &$key){
                if ($key['id']){
                    $key['up_title']=$all_fix[$key['id']];
                }
            }
            $this->assign('list',$list);
        }
//        var_dump($list);exit;
        Cookie('_fix_',$_SERVER['REQUEST_URI']);
        $this->assign('meta_title','保修列表');
        return $this->fetch();
    }
    //修改
    public function edit($id=0){
        if (request()->isPost()){
//            var_dump(request()->post());exit;
            $Fix = model('Fix');
            $post_data =$this->request->post();
            $validate=validate('Fix');
            if (!$validate->check($post_data)){
                return $this->error($validate->getError());
            }
//            var_dump($post_data);exit;
            $data = $Fix->update($post_data);
//            var_dump(1111);exit;

//            var_dump($data);exit;
            if ($data){
                session('admin_fix_list',null);
                //记录行为
                action_log('update_fix','Fix',$data->id,UID);
                $this->success('更新成功','fix/index',Cookie('__forward__'));
            }else{
                $this->error($Fix->getError());
            }
        }else{
            $info = array();
            $info = Db::name('Fix')->field(true)->find($id);
            $fix=Db::name('Fix')->field(true)->select();
            $fix=model('Common/Tree')->toFormatTree($fix);
            $fix=array_merge(array(0=>array('id'=>0)),$fix);
//            var_dump($fix);exit;
            $this->assign('Fix',$fix);
            if (false===$info){
                $this->error('获取后台菜单信息错误');
            }
            $this->assign('info',$info);
            $this->assign('meta_title','修改报修');
            return $this->fetch();
        }
    }
    //删除
    public function del(){
       $id=array_unique((array)input('id/a',0));
//       var_dump($id);exit;
       if (empty($id)){
           $this->error('请选择需要操作的数据!');
       }
        $map = array('id'=>array('in',$id));
//           var_dump($map);exit;
           if (Db::name('Fix')->where($map)->delete()){
               session('admin_fix_list',null);
               //记录行为
               action_log('update_fix','Fix',$id);
               $this->success('删除成功');
           }else{
               $this->error('删除失败');
           }
    }


}