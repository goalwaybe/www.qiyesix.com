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
            $validate = \think\Loader::validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
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
            $validate = \think\Loader::validate('Conf');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

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
        if(request()->isPost()){
            $data = input('post.');
            $formarr = array();
            foreach($data as $k=>$v){
                $formarr[]=$k;
            }

            $_confarr = db('conf')->field('enname')->select();
            $confarr=array();
            foreach ($_confarr as $k=>$v){
                    $confarr[] = $v['enname'];
            }

            //将从数据库查出来的enname和提交的enname做对比
            $checkboxarr =array();
            foreach ($confarr as $k=>$v){
                if(!in_array($v,$formarr)){
                    $checkboxarr[]=$v;
                }
            }
            // $checkboxarr;
            if($checkboxarr){
                foreach ($checkboxarr as $ke=>$v){
                    ConfModel::where('enname',$v)->update(['value'=>$v]);
                }
            }
            if($data){
                foreach($data as $k=>$v){
                    ConfModel::where('enname',$k)->update(['value'=>$v]);
                }
                $this->success('修改成功!');
            }


            return;
        }
        $confres = ConfModel::order('sort ASC')->select();
        $this->assign('confres',$confres);
        return view('conf');
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