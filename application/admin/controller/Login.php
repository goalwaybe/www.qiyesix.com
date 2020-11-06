<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/4
 * Time: 15:15
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
            $data = input('post.');
            $adminM = new AdminModel();
            $num = $adminM->login($data);
            if($num==1){
                $this->error('用户不存在!');
            }
            if($num==2){
                $this->error('登录成功!',url('index/index'));
            }
            if($num==3){
                $this->error('密码错误!');
            }
            return;
        }
        return view('login');
    }

}