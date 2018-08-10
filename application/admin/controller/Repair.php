<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Db;
use think\Validate;


/**
 * 后台频道控制器
 */
class Repair extends Admin
{

//报修列表
    public function index()
    {
        $list = \think\Db::table('repair')->paginate(5);
        $this->assign('list', $list);
        $this->assign('meta_title', '报修列表');
        return $this->fetch();
    }

//添加报修信息
    public function add()
    {
        if ($this->request->isPost()) {//post方式提交,就保存数据

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
            $validate = new Validate($rule, $msg);

            $repair = model('repair');
            $datas = $this->request->post();
            $datas['time'] = time();
            if (!$validate->check($datas)) {
                return $this->error($validate->getError());
            }
            $data = $repair->create($datas);
            if ($data) {
                $this->success('添加成功', url('index'));
            } else {
                $this->error($repair->getError());
            }
        } else {//get方式就加载添加的表单
            $this->assign('meta_title', '添加报修');
            $this->assign('info', null);
            return $this->fetch('add');
        }
    }

    //编辑
    public function edit($id = 0)
    {
        if ($this->request->isPost()) {
            $postdata = $this->request->post();
            $data = Db::table('repair')->where('id', $id)->update($postdata);
            if ($data !== false) {
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        } else {
            $info = array();
            $info = \think\Db::name('Repair')->find($id);
            if (false === $info) {
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑报修信息';
            return $this->fetch();
        }
    }

    //删除
    public function del()
    {
        $id = array_unique((array)input('id/a', 0));
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id));
        if (\think\Db::name('repair')->where($map)->delete()) {
            //记录行为
            action_log('update_channel', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }

    }

}