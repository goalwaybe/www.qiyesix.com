<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/4
 * Time: 17:07
 */

namespace app\admin\model;
use think\Model;

class Cate extends Model
{
    public function catetree()
    {
        $cateres = $this->order('sort ASC')->select();
        return $this->sort($cateres);
    }

    public function sort($data,$pid=0,$level=0)
    {
        static $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level'] = $level;
                $arr[] = $v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }

    //找出当前栏目的子栏目
    public function getChildrenIds($cateid)
    {
        $cateres = $this->select();
        return $this->_getChildrenIds($cateres,$cateid);
    }

    public function _getChildrenIds($cateres,$cateid)
    {
        static $arr = array();
        foreach($cateres as $k=>$v){
            if($v['pid']==$cateid){
                $arr[] = $v['id'];
                $this->_getChildrenIds($cateres,$v['id']);
            }
        }
        return $arr;
    }





}