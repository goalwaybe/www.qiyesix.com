<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/4
 * Time: 16:37
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
class Cate extends Common
{
    protected $beforeActionList = [
        'delsoncate'=>['only'=>'del']
    ];

    public function lst()
    {
        $cate = new CateModel();
        if(request()->isPost()){
            $sorts = input('post.');
            foreach($sorts as $k => $v){
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功!',url('lst'));
            return;
        }
        $cateres = $cate->catetree();
        $this->assign('cateres',$cateres);
        return view('list');
    }
    public function add()
    {
        $cateM = new CateModel();
        if(request()->isPost()){
            $data = input('post.');

            $add = $cateM->save($data);
            if($add){
                $this->success('添加栏目成功!',url('lst'));
            }else{
                $this->error('添加栏目失败!');
            }
            return;
        }
        $cateres = $cateM->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }
    public function edit($id)
    {
        $cateM = new CateModel();
        if(request()->isPost()){
            $data = input('post.');
            $save = $cateM->save($data,['id'=>$id]);
            if($save !==false){
                $this->success('修改栏目成功!',url('lst'));
            }else{
                $this->error('修改栏目失败!');
            }
            return;
        }
        $cates = $cateM->find($id);
        $cateres =  $cateM->catetree();
        $this->assign(array(
            'cates'=>$cates,
            'cateres'=>$cateres
        ));
        return view();
    }

    public function del($id)
    {
        $del = db('cate')->delete($id);
        if($del){
            $this->success('删除栏目成功!',url('lst'));
        }else{
            $this->error('删除栏目失败!');
        }
    }

    public function delsoncate()
    {
        $cateid = (int)input('id');  //要删除当前栏目的id
        $cateM = new CateModel();
        $sonids = $cateM->getChildrenIds($cateid);
        $allCateId=$sonids;
        $allCateId[] = $cateid;
        //删除父级栏目,子级栏目,孙级栏目下文章也删除
        foreach ($allCateId as $k=>$v){
            $articleM = new ArticleModel();
            $articleM->where(array('cateid'=>$v))->delete();
        }

        if($sonids){
            db('cate')->delete($sonids);
        }
    }

}