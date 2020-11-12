<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/11
 * Time: 16:01
 */

namespace app\admin\validate;
use \think\Validate;

class Article extends Validate
{
    protected $rule=[
        'title'=>'unique:article|require|max:25',
        'cateid'=>'require',
        'des'=>'require',
        'content'=>'require',
    ];
    protected $message=[
        'title.unique'=>'文章标题不得重复!',
        'title.require'=>'文章标题不得为空',
        'title.max'=>'文章标题不得超过25个字符',
        'cateid.require'=>'文章所属栏目不得为空!',
        'des.require'=>'文章描述不得为空!',
        'content.require'=>'文章内容不得为空!',
    ];
    protected $scene=[
        'add'=>['title','url','des','content'],
        'edit'=>['title','url'],
    ];
}