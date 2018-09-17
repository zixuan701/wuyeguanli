<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/12
 * Time: 9:38
 */

namespace app\admin\controller;


use think\console\output\Descriptor;
use think\Db;

class Zushou extends Admin
{
    //租售列表
    public function index()
    {
        $list=Db::table('zushou')->paginate(3);
//        halt($list);die;
        $this->assign('list',$list);
        $this->assign('meta_title','小区租售');
        return $this->fetch('index');
    }
    //添加租售信息
    public function add()
    {
       if ($this->request->isPost()){
           halt($_POST);
           halt($_FILES);

       }else{

           return $this->fetch('edit');
       }

    }

    public function test()
    {
        //http://www.tp5.com/home/article/detail/id/139.html
        $documents=\think\Db::table('document')->where('category_id',42)->select();
        $news=[];
       foreach ($documents as $val){
           $news[]=[
               'Title'=>$val['title'],
               'Description'=>$val['description'],
                'PicUrl'=>'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=1037812572,1556550496&fm=15&gp=0.jpg',
               'Url'=>"http://www.tp5.com/home/article/detail/id/{$val['id']}.html"
           ];
       }
    }

}