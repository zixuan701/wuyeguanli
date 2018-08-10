<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2018/8/9
 * Time: 14:10
 */

namespace app\home\controller;


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

        //调用validate里面的模型验证
//        $vaildate=validate('repair');

        if ($this->request->isPost()){
            $datas=$this->request->post();
            $datas['time']=time();
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
            $this->assign('meta_title', '添加报修');
            return $this->fetch('add');
        }
    }


//    public function test()
//    {
//            $a=new \app\admin\Controller\Repair();
//            $a->add();
//    }
}