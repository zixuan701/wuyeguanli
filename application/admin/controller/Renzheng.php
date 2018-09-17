<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/12
 * Time: 13:41
 */

namespace app\admin\controller;


use think\Db;

class Renzheng extends Admin
{

    public function index()
    {
       $list= Db::table('renzheng')->paginate(2);
       $this->assign('list',$list);
       return $this->fetch('index');
    }

    public function shenhe()
    {
        $id=input('id');
        Db::table('renzheng')->where('id',$id)->update(['status'=>1]);
        return $this->success('已审核','admin/renzheng/index');
    }
}