<?php
/**
 * Created by PhpStorm.
 * User: wangkxin@foxmail.com
 * Date: 2020/11/6
 * Time: 15:32
 */

namespace app\admin\model;
use think\Model;

class Article extends Model
{
    protected static function init(){
        //钩子函数插入新增前执行图片上传
        Article::event('before_insert',function($data){
            if($_FILES['thumb']['tmp_name']){
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public/static' . '/' . 'uploads');
                if($info){
                    $thumb = '/' . 'static' . '/' . 'uploads'. '/' .  str_replace('\\','/',$info->getSaveName()) ;
                    $data['thumb'] = $thumb;
                }
            }
        });

        //钩子函数编辑修改前执行图片上传
        Article::event('before_update',function($data){
            if($_FILES['thumb']['tmp_name']){
                //编辑一篇文章时候删除文章旧图片
                $arts = Article::find($data->id);
                $thumbpath = $_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
                if(file_exists($thumbpath)){
                    @unlink($thumbpath);
                }

                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public/static' . '/' . 'uploads');
                if($info){
                    //因为在小程序APP等中,反斜杠\ 无法识别需要替换成 /
                    // $getSaveName = str_replace("\\","/",$info->getSaveName());
                    $thumb = '/'.'static' . '/' . 'uploads' . '/' . str_replace("\\","/",$info->getSaveName());
                    $data['thumb'] = $thumb;
                }
            }
        });

        //删除文章的同时也要删除文章的图片
        Article::event('before_delete',function($data){
            $arts = Article::find($data->id);
            $thumbPath = $_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
            if(file_exists($thumbPath)){
                @unlink($thumbPath);
            }
        });


    }

}