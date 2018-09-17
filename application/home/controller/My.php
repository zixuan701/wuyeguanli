<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/12
 * Time: 15:03
 */

namespace app\home\controller;


use think\Db;

class My extends Home
{
    public function pub()
    {
        //判断有没有认证
        session_start();
        $uid = $_SESSION['twothink_home']['user_auth']['uid'];
        $status=Db::table('renzheng')->where('uid',$uid)->find()['status'];
        if ($status===''){
            return $this->error('请先提交业主认证信息,审核通过即可查看','home/fuwu/renzheng');
        }
        if ($status==0){
            return $this->error('您的信息正在审核中,通过即可查看详细信息','home/my/index');
        }
    }

    public function index()
    {
        //判断登录
            if(!is_login()){
                return $this->error('您未登录,请先登录','user/login/index');
            }
        session_start();
        $uid=$_SESSION['twothink_home']['user_auth']['uid'];
        $cen=Db::table('ucenter_member')->where('id',$uid)->find();
        $me=Db::table('member')->where('uid',$uid)->find();
        $list=['username'=>$cen['username'],'score'=>$me['score']];
        $this->assign('list',$list);
        return $this->fetch('my');
    }
    //我的报修
    public function baoxiu()
    {
        //判断有没有认证
        self::pub();
        session_start();
        $uid = $_SESSION['twothink_home']['user_auth']['uid'];
        $list=Db::table('repair')->where('uid',$uid)->select();

        $this->assign('list',$list);
        return $this->fetch('baoxiu');
    }

    //我报名的活动
    public function activity()
    {
        //判断有没有认证
        self::pub();
        session_start();
        $uid = $_SESSION['twothink_home']['user_auth']['uid'];
        $lists=Db::table('activity')->where('user_id',$uid)->select();
        $list=[];
        foreach ($lists as $val){
            $acts=Db::table('document')->where('id',$val['activity_id'])->select();
            foreach ($acts as $v){
                $list[]=['title'=>$v['title'],'deadline'=>$v['deadline']];
            }
        }
        $this->assign('list',$list);
        return $this->fetch('activity');
    }

    //账单
    public function zhangdan()
    {
        //判断有没有认证
        self::pub();
        return $this->fetch('zhangdan');
    }

    //物业通知
    public function wuye()
    {
        //判断有没有认证
        self::pub();
        return $this->fetch('wuye');
    }
    //水电气
    public function shuidian()
    {
        //判断有没有认证
        self::pub();
        return $this->fetch('shuidian');
    }




}