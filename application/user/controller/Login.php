<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络 <http://www.twothink.cn>
// +----------------------------------------------------------------------

namespace app\user\controller;

use app\common\controller\UcApi;
use EasyWeChat\Factory;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Session;

/**
 * 用户登入
 * 包括用户登录及注册
 */
class Login extends Controller
{
    public function __construct()
    {
        /* 读取站点配置 */
        $config = api('Config/lists');
        config($config); //添加配置
        parent::__construct();
    }

    private function config()
    {
        $config = [
            'app_id' => 'wxa53276e774825d41',
            'secret' => '9fa417cbaf73599863eaf0a88c37ceb2',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'file' => '/www/wwwroot/tp5/runtime/log/wechat.log',
            ],
            'oauth' => [
                'scopes' => ['snsapi_base'],
                'callback' => url('user/login/callback', '', true, true)],
        ];
        return $config;
    }

    /* 登录页面 */
    public function index($username = '', $password = '', $verify = '', $type = 1)
    {

        if (!Session::has('openid')) {
            //发送请求之前,先把当前url地址保存在session中,获取到openid后还要跳转回来
            Session::set('ret_url', url());
            $app = Factory::officialAccount(self::config());
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect()
                ->send();
        }
        $openid = Session::get('openid');
        //查看当前账号是否已经绑定openid
        $data = Db::table('ucenter_member')
            ->where('openid', $openid)
            ->find();
        if ($data['openid'] === null) {
            if ($this->request->isPost()) { //登录验证
                //先获取到当前用户的openid
                //看下session里面是否给openid赋值  使用has

                /* 检测验证码 */
                if (!captcha_check($verify)) {
                    $this->error('验证码输入错误！');
                }
                /* 调用UC登录接口登录 */
                $user = new UcApi;
                $uid = $user->login($username, $password, $type);
                if (0 < $uid) { //UC登录成功
                    /* 登录用户 */
                    $Member = model('Member');
                    if ($Member->login($uid)) { //登录用户
                        //TODO:跳转到登录前页面
                        if (!$cookie_url = Cookie::get('__forward__')) {
                            $cookie_url = url('Home/Index/index');
                        }
                        //绑定openid
                        Db::table('ucenter_member')
                            ->where('id', $uid)
                            ->update(['openid' => $openid]);
                        $this->success('登录成功！', $cookie_url);
                    } else {
                        $this->error($Member->getError());
                    }

                } else { //登录失败
                    switch ($uid) {
                        case -1:
                            $error = '用户不存在或被禁用！';
                            break; //系统级别禁用
                        case -2:
                            $error = '密码错误！';
                            break;
                        default:
                            $error = '未知错误！';
                            break; // 0-接口参数错误（调试阶段使用）
                    }
                    $this->error($error);
                }
            } else { //显示登录表单
                return $this->fetch();
            }
        } else {
            /* 登录用户 */
            $Member = model('Member');
            $uid=$data['id'];
            if ($Member->login($uid)) { //登录用户
                //TODO:跳转到登录前页面
                if (!$cookie_url = Cookie::get('__forward__')) {
                    $cookie_url = url('Home/Index/index');
                }
                $this->success('', $cookie_url);
            }
        }
    }

    /* 注册页面 */
    public function register($username = '', $password = '', $repassword = '', $email = '', $verify = '')
    {
        if (!config('user_allow_register')) {
            $this->error('注册已关闭');
        }
        if ($this->request->isPost()) { //注册用户
            /* 检测验证码 */
            if (!captcha_check($verify)) {
                $this->error('验证码输入错误！');
            }

            /* 检测密码 */
            if ($password != $repassword) {
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User = new UcApi;
            $uid = $User->register($username, $password, $email);
            if (0 < $uid) { //注册成功
                $app = Factory::officialAccount(self::config());
                $app->template_message->send([
                    'touser' => 'o83gR1RE79deDvsRp-2wwaZyb4ts',
                    'template_id' => 'pRM8aVi3-4jlrgq7LdtHcj99oAhgcG8ZjcNVaEHUf6k',
                    'url' => 'https://baidu.com',
                    'data' => [
                        'name' => $username,
                        'info' => $password
                    ],
                ]);

                //TODO: 发送验证邮件
                $this->success('注册成功！', url('login/index'));
            } else { //注册失败，显示错误信息
                $this->error($uid);
            }

        }else{ //显示注册表单
            return $this->fetch();
        }
    }

    /* 退出登录 */
    public function logout()
    {
        if (is_login()) {
            model('Member')->logout();
            $this->success('退出成功！', url('User/login'));
        } else {
            $this->redirect('User/login');
        }
    }

    public function reg()
    {
        return $this->fetch();
    }

    //获取用户openid
    public function callback()
    {
        //获取到$code=$_GET['code'];去请求一个url获取到openId

        $app = Factory::officialAccount(self::config());
        $user = $app->oauth->user();
        $openid = $user->getId();
        //把openid保存在session中
        Session::set('openid', $openid);
        //跳转回去
        $this->redirect(Session::get('ret_url'));
    }
}
