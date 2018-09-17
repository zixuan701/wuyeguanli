<?php

namespace app\home\controller;

use think\Controller;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use think\Db;
use think\Session;

class Wechat extends Controller
{

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
                'scopes'   => ['snsapi_base'],
                'callback' =>url('home/wechat/callback','',true,true)],
        ];
        return $config;
    }
    //消息处理
    public function index()
    {
        $app = Factory::officialAccount(self::config());
        //响应信息
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                    //文本消息
                case 'text':
                    if($message['Content']==="小区通知"){
                        //查询小区通知数据
                        $lists=Db::query("select p.path,d.title,d.description,d.id from picture as p JOIN document as d on p.id=d.cover_id where d.category_id=42 ORDER BY id desc");
                        $items=[];
                        foreach ($lists as $list){
                           $url="http://tp.itsta.cn/home/article/detail/id/".$list['id'].".html";
                           $image="http://tp.itsta.cn".$list['path'];
                           $new= new NewsItem([
                                'title'       => "{$list['title']}",
                                'description' => "{$list['description']}",
                                'url'         => "{$url}",
                                'image'       => "{$image}",
                             ]);
                            $items[]=$new;
                        }
                        $res=array_slice($items,0,5);
                        $news = new News($res);
                        return $news;
                    }
                    if ($message['Content']=='快递'){
                        $app = Factory::officialAccount(self::config());
                        $app->template_message->send([
                            'touser' => 'o83gR1RE79deDvsRp-2wwaZyb4ts',
                            'template_id' => 'pRM8aVi3-4jlrgq7LdtHcj99oAhgcG8ZjcNVaEHUf6k',
                            'url' => 'https://baidu.com',
                            'data' => [
                                'name' => '测试',
                                'info' => '123456789'
        ],
    ]);
                    }
                    if ($message['Content']==="解除绑定"){
                        $res= Db::table('ucenter_member')->where('openid',$message['FromUserName'])->find();

                        if (!$res){
                            return '您未绑定账号,无需解绑';
                        }else{
                            Db::table('ucenter_member')->where('openid',$message['FromUserName'])->update(['openid'=>'']);
                            return '解绑成功';
                        }

                    }
                    if($message['Content']==="帮助"){
                        $str="您可以回复以下指令获取对应的数据\n\n"."回复城市名称-->获取当地天气预报\n"."回复小区通知或通知-->获取小区最新通知\n";
                        return $str;
                    }else{
                        $data = file_get_contents('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
                        $sichuans = simplexml_load_string($data);
                        $data = [];
                        foreach ($sichuans->city as $citys) {
                            if ((string)$citys['cityname'] == $message['Content']) {
                                $data['cityname'] = (string)$citys['cityname'];
                                $data['tem1'] = (string)$citys['tem1'];
                                $data['tem2'] = (string)$citys['tem2'];
                                $data['stateDetailed'] = (string)$citys['stateDetailed'];
                                $data['windState'] = (string)$citys['windState'];
                                $str = $data['cityname'] . '的天气信息如下:' . $data['stateDetailed'] . '---' . $data['windState'] . '---' . '最高气温' . $data['tem2'] . '°C' . '---' . '最低气温' . $data['tem1'] . '°C';
                                break;
                            } else {
                                $str = '请输入正确的指令';
                            }
                        }
                        return $str;
                    }
                    break;
                    //图片消息
                case 'image':
                    $image = new Image($message['mediaId']);
                    return $image['PicUrl'];
                    break;
                    //事件处理
                case 'event':
                    switch ($message['EventKey']){
                        case 'huodong':
                            //查询小区通知数据
                            $lists=Db::query("select p.path,d.title,d.description,d.id from picture as p JOIN document as d on p.id=d.cover_id where d.category_id=42 ORDER by id desc ");
                            $items=[];
                            foreach ($lists as $list){
                                $url="http://tp.itsta.cn/home/article/detail/id/".$list['id'].".html";
                                $image="http://tp.itsta.cn".$list['path'];
                                $new= new NewsItem([
                                    'title'       => "{$list['title']}",
                                    'description' => "{$list['description']}",
                                    'url'         => "{$url}",
                                    'image'       => "{$image}",
                                ]);
                                $items[]=$new;
                            }
                            $res=array_slice($items,0,5);
                            $news = new News($res);

                            return $news;
                            break;

                        case 'spxz':
                            return '点击了视频下载';
                            break;

                        case 'hhhh':
                            return '点击了嚯嚯嚯嚯';
                            break;
                    }
                    break;
            }
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
    //菜单处理
    //添加设置菜单
    public function setMenu()
    {

        $buttons = [
            [
                "type" => "view",
                "name" => "系统首页",
                "url"  => "http://tp.itsta.cn/"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "首页",
                        "url"  => "http://tp.itsta.cn/home/index/index.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "服务",
                        "url"  => "http://tp.itsta.cn/home/fuwu/index.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "发现",
                        "url" => "http://tp.itsta.cn/home/fuwu/index.html"
                    ],
                    [
                        "type" => "click",
                        "name" => "活动",
                        "key" => "huodong"
                    ],
                ],
            ],
            [
                "type" => "view",
                "name" => "个人中心",
                "url"  => "http://tp.itsta.cn/home/my/index.html"
            ],
        ];
        $app = Factory::officialAccount(self::config());
        $app->menu->create($buttons);
        echo '菜单设置成功';
    }
    //获取菜单列表
    public function getMenu()
    {
        $app = Factory::officialAccount(self::config());
        $list = $app->menu->list();
        var_dump($list);
    }
    //删除菜单
    public function delete()
    {
        $app = Factory::officialAccount(self::config());
        $app->menu->delete(); // 全部
        echo '菜单设置成功';
    }

    public function openid()
    {
        //1,判断session中有没有openid
        if (!Session::has('openid')) {
            //发送请求之前,先把当前url地址保存在session中,获取到openid后还要跳转回来
            Session::set('ret_url',url());
            //用户授权通过后,请求一个url地址,并带上参数code
            $app = Factory::officialAccount(self::config());
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect()
                ->send();
        }
        $openid=Session::get('openid');
        echo $openid;
    }

    public function callback()
    {
        //获取到$code=$_GET['code'];去请求一个url获取到openId

            $app = Factory::officialAccount(self::config());
            $user = $app->oauth->user();
            $openid=$user->getId();
            //把openid保存在session中
            Session::set('openid',$openid);
            //跳转回去
            $this->redirect(Session::get('ret_url'));
    }
    //测试
    public function test()
    {

        echo url('home/wechat/callback','',true,true);

    }

}