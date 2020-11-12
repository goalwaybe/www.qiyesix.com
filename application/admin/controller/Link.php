<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/9
 * Time: 16:41
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Link as LinkModel;
class Link extends Common
{
    public function lst()
    {
        if(request()->isPost()){
            $sorts = input('post.');
            foreach ($sorts as $k=>$v){
                db('link')->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('排序成功!',url('lst'));
            return;
        }
        $linkRes = LinkModel::order('sort ASC')->paginate(4);
        $this->assign('linkRes',$linkRes);
        return view('list');
    }
    public function add()
    {
        $linkM = new LinkModel();
        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $add = $linkM->insert($data);
            if($add){
                $this->success('添加友情链接成功',url('lst'));
            }else{
                $this->error('添加友情链接失败!');
            }
            return;
        }
        return view();
    }
    public function edit($id)
    {
        $linkM = new LinkModel();
        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $edit = $linkM->update($data);
            if($edit !== false){
                $this->success('编辑链接成功!',url('lst'));
            }else{
                $this->error('编辑链接失败');
            }
            return;
        }
        $links = $linkM->find($id);
        $this->assign('links',$links);
        return view();
    }
    public function del($id)
    {
        $del = LinkModel::destroy($id);
        if($del){
            $this->success('删除链接成功!',url('lst'));
        }else{
            $this->error('删除链接失败!');
        }
    }

}