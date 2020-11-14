<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/14
 * Time: 17:16
 */

namespace app\admin\validate;
use think\Validate;

class Conf extends Validate
{
    protected $rule=[
        'cnname'=>'unique:conf|require|max:60',
        'enname'=>'unique:conf|require|max:60',
        'type'=>'require',
    ];
    protected $message=[
        'cnname.require'=>'中文名称不得为空!',
        'cnname.unique'=>'中文名称不得重复',
        'cnname.max'=>'中文名称不得大于60个字符!',
        'enname.unique'=>'英文名称不得重复',
        'enname.require'=>'英文名称不得为空',
        'enname.max'=>'英文名称不得大于60给字符',
        'type.require'=>'配置类型不得为空!'
    ];
}