<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/11
 * Time: 16:35
 */

namespace app\admin\controller;
use app\admin\model\Conf as ConfModel;
use app\admin\controller\Common;

class Conf extends Common
{
    public function lst()
    {
        if(request()->isPost()){
            $sorts = input('post.');
            foreach ($sorts as $k=>$v){
                ConfModel::update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功!',url('lst'));
            return;
        }
        $confres = ConfModel::order('sort ASC')->paginate(2);
        $this->assign('confres',$confres);
        return view('list');
    }
    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            if($data['values']){
                $data['values'] = str_replace('，',',',$data['values']);
            }
            $confM = new ConfModel();
            if($confM->save($data)){
                $this->success('添加配置成功!',url('lst'));
            }else{
                $this->error('添加配置失败!');
            }
            return;
        }
        return view();
    }
    public function edit($id)
    {
        if(request()->isPost()){
            $data = input('post.');
            if($data['values']){
                $data['values'] = str_replace('，',',',$data['values']);
            }
            $edit = ConfModel::update($data);
            if($edit !== false){
                $this->success('修改成功！',url('lst'));
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $confs = ConfModel::find($id);
        $this->assign('confs',$confs);
        return view();
    }

    public function conf()
    {
        $confres = ConfModel::order('sort ASC')->select();
        $this->assign('confres',$confres);
    }

    public function del($id)
    {
        $del = ConfModel::destroy($id);
        if($del){
            $this->success('删除配置成功!',url('lst'));
        }else{
            $this->error('删除配置失败!');
        }
    }

}