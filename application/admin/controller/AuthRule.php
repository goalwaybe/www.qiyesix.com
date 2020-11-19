<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/15
 * Time: 16:59
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\AuthRule as AuthRuleModel;

class AuthRule extends Common
{
    public function lst()
    {
        $authRuleM = new AuthRuleModel();
        if(request()->isPost()){
            $sorts = input('post.');
            foreach ($sorts as $k=>$v){
                $authRuleM->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功!',url('lst'));
            return;
        }
        $authRuleRes = $authRuleM->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view('list');
    }
    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            //level的值, 顶级权限level 为0 , 一级为1,二级为2
            $plevel = db('auth_rule')
                ->field('level')
                ->where('id',$data['pid'])
                ->find();
            if($plevel){
                $data['level'] = $plevel['level']+1;
            }else{
                //如果没有$plevel 则顶级权限为0
                $data['level'] = 0;
            }
            $add = db('auth_rule')->insert($data);
            if($add){
                $this->success('添加权限成功!',url('lst'));
            }else{
                $this->error('添加权限失败!');
            }
            return;
        }
        $authRuleRes = (new AuthRuleModel())->authRuleTree();
        $this->assign('authRuleRes',$authRuleRes);
        return view();
    }
    public function edit($id)
    {
        $authRuleM = new AuthRuleModel();
        if(request()->isPost()){
            $data = input('post.');
            $plevel = db('auth_rule')
                ->where('id',$data['pid'])
                ->field('level')
                ->find();
            if($plevel){
                $data['level']= $plevel['level']+1;
            }else{
                $data['level']=0;
            }

            $edit = $authRuleM->update($data);
            if($edit !==false){
                $this->success('编辑成功呢!',url('lst'));
            }else{
                $this->error('编辑失败!');
            }
            return;
        }
        $authRules =  $authRuleM->find($id);
        $authRuleRes = $authRuleM->authRuleTree();
        $this->assign(array(
           'authRuleRes' =>$authRuleRes,
            'authRules' => $authRules
        ));
        return view();
    }
    public function del($id)
    {
        $authM = new AuthRuleModel();
        $authRuleIds = $authM->getChildrenId($id);
        $authRuleIds[]=(int)input('id');
        $del = AuthRuleModel::destroy($authRuleIds);
        if($del){
            $this->success('删除权限成功!',url('lst'));
        }else{
            $this->error('删除权限失败!');
        }
    }
}