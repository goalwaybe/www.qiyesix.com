<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/11
 * Time: 15:41
 */

namespace app\admin\validate;
use think\Validate;

class Link extends Validate
{
    protected $rule=[
        'title'=>'require|max:25',
        'url'=>'unique:link|require|max:60',
        'des'=>'require',
    ];
    protected $message=[
        'title.require'=>'链接标题不得为空!',
        'title.max'=>'链接标题长度不得超过25个字符',
        'url.unique'=>'链接地址不得重复!',
        'url.require'=>'链接地址不得为空!',
        'url.max'=>'链接地址长度不得超过60个字符',
        'des.require'=>'链接描述不得为空!',
    ];

    protected $scene=[
        'add'=>['title'=>'require','url','des'],
        'edit'=>['title','url']
    ];

}