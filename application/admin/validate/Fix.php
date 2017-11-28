<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/28
 * Time: 15:10
 */

namespace app\admin\validate;


use think\Validate;

class Fix extends Validate
{
    //验证规则
    protected $rule=[
        'title'=>'require',
        'name'=>'require',
        'tel'=>'number|max:11',
        'address','require',
        'content','require',
    ];
}