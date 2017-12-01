<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/30
 * Time: 16:16
 */

namespace app\home\model;


use think\Model;

class Fuwu extends Model
{
    protected $autoWriteTimestamp=false;
    protected $auto=['name','uid','room','tel','relation','card','status'];
    //属性修改器
    protected function setTitleAttr($value,$data)
    {
        return htmlspecialchars($value);
    }
}