<?php

//微信请求的数据格式
/*
<xml>
<ToUserName>< ![CDATA[toUser] ]></ToUserName>
<FromUserName>< ![CDATA[fromUser] ]></FromUserName>
<CreateTime>1348831860</CreateTime>
<MsgType>< ![CDATA[text] ]></MsgType>
<Content>< ![CDATA[this is a test] ]></Content>
<MsgId>1234567890123456</MsgId>
</xml>
*/
//获取微信通过post发送的xml数据
$data=file_get_contents('php://input');
$strs=simplexml_load_string($data);
$data=[];
foreach ($strs as $key=>$value){
    $data[$key]=(string)$value;
}
extract($data);

if($Content=='小区通知'||$Content=='通知'){

    $document=\think\Db::table('document')->select();

    $news=[
        [
            'title'=>'这个是测试标题',
            'Description'=>'这个是描述',
            'PicUrl'=>'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=1037812572,1556550496&fm=15&gp=0.jpg',
            'Url'=>'http://www.baidu.com'
        ]
    ];
    require 'news.xml';

}else{
    $data=file_get_contents('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
    $sichuans=simplexml_load_string($data);
    $data=[];
    foreach ($sichuans->city as $citys){
        if((string)$citys['cityname']==$Content){
            $data['cityname']=(string)$citys['cityname'];
            $data['tem1']=(string)$citys['tem1'];
            $data['tem2']=(string)$citys['tem2'];
            $data['stateDetailed']=(string)$citys['stateDetailed'];
            $data['windState']=(string)$citys['windState'];
            $str=$data['cityname'].'的天气信息如下:'.$data['stateDetailed'].'---'.$data['windState'].'---'.'最高气温'.$data['tem2'].'°C'.'---'.'最低气温'.$data['tem1'].'°C';
            break;
        }else{
            $str='请输入正确的四川城市名';
        }
    }
    echo "<xml>
    <ToUserName><![CDATA[{$FromUserName}]]></ToUserName>
    <FromUserName><![CDATA[{$ToUserName}]]></FromUserName>
    <CreateTime>12345678</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[{$str}]]></Content>
</xml>";
}
