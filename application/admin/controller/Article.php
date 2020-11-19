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
        $artRes = db('article')
            ->alias('a')
            ->field('a.*,b.catename')
            ->join('bk_cate b','a.cateid=b.id')
            ->paginate(2);
        $this->assign('artRes',$artRes);
        return view('list');
    }
    public function add()
    {
        $cateM = new CateModel();
        $artM = new ArticleModel();
        if(request()->isPost()){
            $data = input('post.');
            $data['time'] = time();
            $validate =  \think\Loader::validate('Article');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            //使用钩子函数before_insert 到模型层处理图片
            /*if($_FILES['thumb']['tmp_name']){
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public\static' .DS. 'uploads');
                if($info){
                    $thumb = 'http://www.qiyesix.com/' . 'static' . DS . 'uploads'. '/' . $info->getSaveName();
                    $data['thumb'] = $thumb;
                }
            }*/

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
    public function edit($id)
    {
        $cateM = new CateModel();
        $artM = new ArticleModel();
        if(request()->isPost()){
            $data = input('post.');
            $validate = \think\Loader::validate('Article');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $save = $artM->update($data);
            if($save !== false){
                $this->success('修改文章成功!',url('lst'));
            }else{
                $this->error('修改文章失败!');
            }
            return;
        }

        $cateres =  $cateM->catetree();
        $arts = db('article')->find($id);
        $this->assign(array(
            'arts'=>$arts,
            'cateres'=>$cateres
        ));
        return view();
    }

    public function del($id)
    {
        if(ArticleModel::destroy($id)){
            $this->success('删除文章成功!',url('lst'));
        }else{
            $this->error('删除文章失败!');
        }
        dump($id);
    }
}