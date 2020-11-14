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
        $this->assign('confres',$confres);
    }


}