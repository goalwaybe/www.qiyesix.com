<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/14
 * Time: 17:25
 */

namespace app\index\controller;
use think\Controller;


class Common extends Controller
{
    public function _initialize()
    {
        $confM =  new \app\index\model\Conf();
        $_confres = $confM->getAllConf();
        $confarr=array();
        foreach($_confres as $k=>$v){
            $confres[$v['enname']] = $v['cnname'];
        }
        // dump($confres);
        $this->getNavCates();
        $this->assign('confres',$confres);
    }

    //查询所有的栏目,最多两级
    public function getNavCates()
    {
        $cateres = db('cate')->where(array('pid'=>0))->select();
        foreach($cateres as $k=>$v){
            $children = db('cate')->where(array('pid'=>$v['id']))->select();
            if($children){
                $cateres[$k]['children'] = $children;
            }else{
                $cateres[$k]['children'] = 0;
            }
        }
        $this->assign('cateres', $cateres);

    }


}