<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/29
 * Time: 19:57
 */

namespace app\home\model;


use think\Model;

class Apply extends Model
{
    protected $autoWriteTimestamp = false;
    protected $auto = ['uid','active_id',];

}