<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/4
 * Time: 16:24
 */

namespace app\admin\controller;
use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id')|| !session('name') ){
            $this->error('您尚未登录系统!',url('login/index'));
        }
    }

}