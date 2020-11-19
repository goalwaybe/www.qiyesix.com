<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/4
 * Time: 16:24
 */

namespace app\admin\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id')|| !session('name') ){
            $this->error('您尚未登录系统!',url('login/index'));
        }
        //利用Auth类进行权限判断
        $auth = new Auth();
        $request = Request::instance();
        $con = $request->controller();
        $action = $request->action();
        $name = $con.'/' .$action;
        //不需要验证的控/方法
        $notCheck = array('Index/index','Admin/lst','Admin/logout','Login/index');
        //管理员不需要验证
        if(session('id')!=17){
            if(!in_array($name,$notCheck)){
                if(!$auth->check($name,session('id'))){
                    $this->error('没有权限',url('index/index'));
                }
            }
        }

    }




}