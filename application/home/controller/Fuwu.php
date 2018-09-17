<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/12
 * Time: 11:50
 */

namespace app\home\controller;


use think\Db;

class Fuwu extends Home
{
    //服务列表
    public function index()
    {
        return $this->fetch('fuwu');
    }

    //业主认证
    public function renzheng()
    {
        if ($this->request->isPost()) {
            session_start();
            $uid = $_SESSION['twothink_home']['user_auth']['uid'];
            $data = $_POST;
            $data['uid'] = $uid;
            $data['status'] = 0;
            Db::table('renzheng')->insert($data);
            return $this->success('认证信息提交成功,请等待审核', 'home/fuwu/index');
        } else {
//            if(!is_login()){
//                return $this->error('您未登录,请先登录','user/login/index');
//            }
            session_start();
            $uid = $_SESSION['twothink_home']['user_auth']['uid'];
            //判断业主有没有提交过认证的资料,如果提交过就不让他在进入资料提交页面
//            $res = Db::table('renzheng')->where('uid', $uid)->count();
            $status = Db::table('renzheng')->where('uid', $uid)->select()['0']['status'];
            if ($status == 0) {
                return $this->error('您的认证信息正在审核中,请耐心等待');
            }
            if ($status == 1) {
                return $this->error('您的认证信息已审核通过,无需重复认证');
            }
            return $this->fetch('yezhurenzheng');
        }
    }

    //在线缴费权限验证
    public function jiaofei()
    {
        //判断登录
//        if(!is_login()){
//            return $this->error('您未登录,请先登录','user/login/index');
//        }
        //判断有没有认证
        session_start();
        $uid = $_SESSION['twothink_home']['user_auth']['uid'];
        $status=Db::table('renzheng')->where('uid',$uid)->find()['status'];
//        halt($status);
        if ($status===''){
            return $this->error('请先提交业主认证信息,审核通过即可查看','home/fuwu/renzheng');
        }
        if ($status==0){
            return $this->error('您的信息正在审核中,请耐心等待','home/fuwu/index');
        }
        return $this->fetch('index');
    }


    //关于我们
    public function about()
    {
        $title=Db::table('document')->where('id',146)->find();
        $content=Db::table('document_article')->where('id',146)->find();
        $list=['title'=>$title['title'],'content'=>$content['content']];

        $this->assign('list',$list);
        return $this->fetch('about');
    }

    //生活贴士
    public function tieshi()
    {
       $article=new \app\home\controller\Article;
        return $article->lists();

    }



}