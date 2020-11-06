<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/3
 * Time: 16:43
 */

namespace app\admin\model;
use think\Model;

class Admin extends Model
{
    public function addadmin($data)
    {
        if(empty($data)|| !is_array($data)){
            return false;
        }
        if($data['password']){
            $data['password']=md5($data['password']);
        }
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

   public function getadmin()
   {
       //引用自定义分页类
       return $this::paginate(5,false,[
           'type'=>'MyBootstrap',
           'var_page'=>'page',
       ]);
       // return $this::paginate(5);
   }

   public function saveadmin($data,$admins)
   {
       if(!$data['name']){
           return 2;  //管理员名称为空
       }
       if(!$data['password']){
           $data['password'] = $admins['password'];
       }else{
           $data['password'] = md5($data['password']);
       }
       return $this::update(['name'=>$data['name'],''=>$data['password']],['id'=>$data['id']]);
   }



}