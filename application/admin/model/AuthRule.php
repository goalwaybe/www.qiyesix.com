<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/15
 * Time: 17:00
 */

namespace app\admin\model;
use think\Model;

class AuthRule extends Model
{
    //获取父级权限树
    public function authRuleTree()
    {
        $authRuleRes=$this
            ->order('sort ASC')
            ->select();
        return $this->sort($authRuleRes);
    }
    //递归查询
    /**
     * @param $data
     * @param int $pid
     * @return array
     */
    public function sort($data,$pid=0)
    {
        static $arr=array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['dataid']=$this->getParentId($v['id']);
                $arr[]=$v;
                $this->sort($data,$v['id']);
            }
        }
        // $arr;
        return $arr;
    }

   //删除父级的时候,删除所有子级
   public function getChildrenId($authRuleId)
   {
       $authRuleRes = $this->select();
       return $this->_getChildrenId($authRuleRes,$authRuleId);
   }
   public function _getChildrenId($authRuleRes,$authRuleId)
   {
       static $arr=array();
       foreach($authRuleRes as $k=>$v){
           if($v['pid'] == $authRuleId){
               $arr[]=$v['id'];
               $this->_getChildrenId($authRuleRes,$v['id']);
           }
       }
       return $arr;
   }

   //dataid-1-2-3, 找到父级id
   public function getParentId($authRuleId)
   {
       $authRuleRes = $this->select();
       return $this->_getParentId($authRuleRes,$authRuleId,True);
   }
   public function _getParentId($authRuleRes,$authRuleId, $clear=False)
   {
       static $arr=array();
       if($clear){
           $arr=array();
       }
       foreach ($authRuleRes as $k=>$v){
           if($v['id']==$authRuleId){
               $arr[]=$v['id'];
               $this->_getParentId($authRuleRes,$v['pid'], False);
           }
       }
       asort($arr);
       $arrStr = implode('-',$arr);
       // $arr;
       return $arrStr;
   }


}