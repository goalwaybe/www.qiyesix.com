<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/19
 * Time: 17:50
 */

namespace app\index\model;
use think\Model;
use app\index\model\Cate;
class Article extends Model
{
    public function getAllArticles($cateid)
    {
        $cateM = new Cate();
        $allCateId = $cateM->getChildrenId($cateid);
        $artRes = db('article')
            ->where("cateid IN($allCateId)")
            ->paginate(10);
        return $artRes;
    }
}