<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/14
 * Time: 17:39
 */

namespace app\index\model;
use think\Model;

class Conf extends Model
{
    public function getAllConf()
    {
        $confres = $this::select();
        return $confres;
    }

}