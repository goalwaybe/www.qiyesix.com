<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/10/27
 * Time: 22:32
 */

namespace app\index\controller;
use app\index\model\Article as ArticleModel;

class Artlist extends Common
{
    public function index()
    {
        $articleM = new ArticleModel();
        $artRes = $articleM->getAllArticles(input('cateid'));
        $this->assign('artRes',$artRes);
        return view('artlist');
    }

}