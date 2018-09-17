<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/9
 * Time: 14:10
 */

namespace app\home\controller;


use think\Db;
use think\Validate;

class Repair extends Home
{



    public function add()
    {
        //验证数据
        $rule = [
            'title' => 'require|max:20',
            'name' => 'require|max:10',
            'tel' => 'require',
            'address' => 'require',
            'content' => 'require',
        ];

        $msg = [
            'title.require' => '标题必须填写',
            'title.max' => '标题最多不能超过20个字符',
            'name.require' => '姓名不能为空',
            'name.max' => '姓名最大为10个字符',
            'tel.require'=>'请填写手机号',
            'address.require' => '地址不能为空',
            'content.require' => '内容不能为空',
        ];
        $vaildate=new Validate($rule,$msg);

        if ($this->request->isPost()){
            $datas=$this->request->post();
            $datas['time']=time();
            $datas['status']=0;
            session_start();
            $uid = $_SESSION['twothink_home']['user_auth']['uid'];
            $datas['uid']=$uid;
            if(!$vaildate->check($datas)){
                return $this->error($vaildate->getError());
            }
            $repair=model('repair');
            $result=$repair->create($datas);
            if ($result){
                $this->success('添加成功','index');
            }else{
                $this->error($repair->getError());
            }
        }else{
            //判断登录
//            if(!is_login()){
//                return $this->error('您未登录,请先登录','user/login/index');
//            }
            //判断有没有认证
            session_start();
            $uid = $_SESSION['twothink_home']['user_auth']['uid'];
            $status=Db::table('renzheng')->where('uid',$uid)->find()['status'];
            if ($status===null||$status!=1){
                return $this->error('请先提交业主认证信息,审核通过即可在线报修','home/fuwu/renzheng');
            }
            $this->assign('meta_title', '添加报修');
            return $this->fetch('add');
        }
    }

}