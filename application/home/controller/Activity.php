<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/11
 * Time: 14:55
 */

namespace app\home\controller;


use think\Db;

class Activity extends Home
{
    public function activity()
    {
        $activity_id=$_GET['activity_id'];
        session_start();
        $user_id=$_SESSION['twothink_home']['user_auth']['uid'];
//        halt($user_id);die;
        //判断用户是否已报名
        $count=Db::table('activity')
            ->where('user_id',$user_id)
            ->where('activity_id',$activity_id)
            ->count();
        if($count>=1){
            return $this->error('您已参加活动');
        }else{
            Db::table('activity')->insert([
                'activity_id'=>$activity_id,
                'user_id'=>$user_id
            ]);
            return $this->success('报名成功','/home/article/index');
        }
    }
}