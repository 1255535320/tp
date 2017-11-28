<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 18:38
 */

namespace app\home\model;


use think\Model;

class Fix extends Model
{
//    protected $autoWriteTimestamp = false;
    protected $updateTime = false;//关闭自动更新时间
//    protected $createTime = 'create_at';//自动创建时间戳指向默认字段
    protected $auto = ['title','name','tel','address','content'];
    // 新增
//    protected $insert = ['status'=>1];
    //属性修改器
    protected function setTitleAttr($value, $data)
    {
        return htmlspecialchars($value);
    }
}