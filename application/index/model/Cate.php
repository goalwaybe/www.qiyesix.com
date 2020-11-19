<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/19
 * Time: 17:46
 */

namespace app\index\model;
use think\Model;

class Cate extends Model
{
    //查找当前栏目下的子栏目
    public function getChildrenId($cateid)
    {
        $cateres = $this->select();
        $arr = $this->_getChildrenId($cateres, $cateid);
        $arr[] = (int)$cateid;
        $strId = implode(',',$arr);
        return $strId;
    }
    public function _getChildrenId($cateres, $cateid)
    {
        static $arr = array();
        foreach($cateres as $k=>$v){
            if($v['pid'] == $cateid){
                $arr[] = $v['id'];
                $this->_getChildrenId($cateres, $v['id']);
            }
        }
        return $arr;
    }

}