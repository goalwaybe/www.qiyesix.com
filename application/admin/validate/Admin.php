<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/11
 * Time: 16:20
 */

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'name'=>'unique:admin|require|max:25',
        'password'=>'require|min:6'
    ];
    protected $message=[
        'name.unique'=>'管理员名称不得重复!',
        'name.require'=>'管理员名称不得为空',
        'name.max'=>'管理员名称不得大于25个字符',
        'password.require'=>'密码不得为空!',
        'password.min'=>'密码不得少于6位!',
    ];
    protected $scene=[
        'add'=>['name','password'],
        'edit'=>['name'],
    ];
}