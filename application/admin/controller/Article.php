<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/6
 * Time: 15:32
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
class Article extends Common
{
    public function lst()
    {
        return view('list');
    }
    public function add()
    {
        $cateM = new CateModel();
        $artM = new ArticleModel();
        if(request()->isPost()){
            $data = input('post.');
            if($_FILES['thumb']['tmp_name']){
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public\static' .DS. 'uploads');
                if($info){
                    $thumb = 'http://www.qiyesix.com/' . 'static' . DS . 'uploads'. '/' . $info->getSaveName();
                    $data['thumb'] = $thumb;
                }
            }

            if($artM->save($data)){
                $this->success('添加文章成功!',url('lst'));
            }else{
                $this->error('添加文章失败!');
            }
            return;
        }
        $cateres =  $cateM->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }
    public function edit()
    {
        $cateM = new CateModel();
        $cateres =  $cateM->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }

    public function del(){}
}