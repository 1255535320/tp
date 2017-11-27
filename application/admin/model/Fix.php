<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26
 * Time: 16:06
 */

namespace app\admin\model;


use think\Model;

class Fix extends Model
{
    protected $autoWriteTimestamp = false;
    protected $auto = ['title','name','tel','address','content'];
    // 新增
//    protected $insert = ['status'=>1];
    //属性修改器
    protected function setTitleAttr($value, $data)
    {
        return htmlspecialchars($value);
    }
}