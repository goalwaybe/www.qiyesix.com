<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/15
 * Time: 15:27
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\AuthGroup as AuthGroupModel;

class AuthGroup extends Common
{
    public function lst()
    {
        $authGroupRes = AuthGroupModel::paginate(2);
        $this->assign('authGroupRes',$authGroupRes);
        return view('list');
    }
    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            if($data['rules']){
                $data['rules'] = implode(',',$data['rules']);
            }
            $data;

            //处理status
            $_data =array();
            foreach ($data as $k=>$v){
                $_data[] = $k;
            }
            if(!in_array('status',$_data)){
                $data['status'] = 0;
            }

            $add = db('auth_group')->insert($data);
            if($add){
                $this->success('添加用户组成功!',url('lst'));
            }else{
                $this->error('添加用户组失败!');
            }
            return;
        }
        $authRuleM = new \app\admin\model\AuthRule();
        $authRuleRes = $authRuleM->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view();
    }
    public function edit($id)
    {
        if(request()->isPost()){
            $data = input('post.');
            if($data['rules']){
                $data['rules'] = implode(',',$data['rules']);
            }

            //处理复选框没有选中的时候status字段
            $_data=array();
            foreach($data as $k=>$v){
                $_data[] = $k;
            }
            if(!in_array('status',$_data)){
                $data['status']=0;
            }
            $edit = db('auth_group')->update($data);
            if($edit!==false){
                $this->success('修改用户组成功!',url('lst'));
            }else{
                $this->error('修改用户组失败!');
            }
            return;
        }
        $authRuleM = new \app\admin\model\AuthRule();
        $authRuleTree = $authRuleM->authRuleTree();
        $authgroups = db('auth_group')->find($id);
        $this->assign(array(
            'authRuleTree' => $authRuleTree,
            'authgroups' => $authgroups
        ));
        return view();
    }
    public function del($id)
    {
        $del = db('auth_group')->delete($id);
        if($del){
            $this->success('删除用户组成功!',url('lst'));
        }else{
            $this->error('删除用户组成功');
        }
    }

}