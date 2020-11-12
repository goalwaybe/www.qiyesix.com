<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/10/27
 * Time: 17:55
 */

namespace app\admin\controller;
// use think\View;
use app\admin\controller\Common;
use app\admin\model\Admin as AdminModel;
use think\Db;
class Admin extends Common
{
    public function lst()
    {
        // return view('list');
        // $view = new View([
        //     'view_suffix'=>'html'
        // ]);
        // return $this->fetch('list');
        // $res = db('admin')->select();
        // $res = db('admin')->where(array('id'=>6))->find();
        $adminM = new AdminModel();
        $res = $adminM->getadmin();
        $this->assign('res',$res);
        return view('list');
    }

    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            $validate= \think\Loader::validate('Admin');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            // $res = db('admin')->insert($data);
            // $res = Db::name('admin')->insert($data);
            // $res = Db::table('bk_admin')->insert($data);
            $adminM = new AdminModel();
            $res = $adminM->addadmin($data);
            if($res){
                $this->success('添加管理员成功!',url('lst'));
            }else{
                $this->error('添加管理员失败!');
            }
            return;
        }
        return view();
    }
    public function edit($id)
    {
        $admins = db('admin')->field('id,name,password')->find($id);

        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Admin');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            // if(!$data['name']){
            //     $this->error('管理员用户名不得为空!');
            // }
            // if(!$data['password']){
            //     $data['password']=$admins['password'];
            // }else{
            //     $data['password'] = md5($data['password']);
            // }

            // $res = db('admin')->update($data);
            // $res = AdminModel::update(['name'=>$data['name'],'password'=>$data['password']],['id'=>$data['id']]);
            $adminM = new AdminModel();
            $saveNum = $adminM->saveadmin($data,$admins);
            if($saveNum=='2'){
                $this->error('管理员用户名不得为空!');
            }

            if($saveNum !== false){
                $this->success('修改成功!',url('lst'));
            }else{
                $this->error('修改失败!');
            }
            return;
        }

        if(!$admins){
            $this->error('该管理员不存在');
        }
        $this->assign('admin',$admins);
        return view();
    }

    public function del($id)
    {
        $adminM = new AdminModel();
        $delnum = $adminM->deladmin($id);
        if($delnum == '1'){
            $this->success('删除管理员成功!',url('lst'));
        }else{
            $this->error('删除管理员失败!');
        }
    }

    public function logout()
    {
        session(null);
        $this->success('退出系统成功!',url('login/index'));
    }


}