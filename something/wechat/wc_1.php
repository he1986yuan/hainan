<?php
// AppID(应用ID)wxd6ef1026c5dd2f13
// AppSecret(应用密钥)da04165e1906fc31aa541bbcdafff81a
require './wechat.class.php';
define('APPID','wxd1fb3b4932bcaff2');
define('APPSECRET','c7743bc0f2f9ee52c3c7d44628eb6845');
define('TOKEN','heyuan');
$wechat =new WeChat(APPID,APPSECRET,TOKEN);
//$token =$wechat->getAccessToken(); //weixin提供的appid和密钥获得access头肯，这是PHP请求微信平台的关键唯一全局token
//var_dump($token);
// var_dump($wechat->getQRCode(1234,'./1234.jpeg'));//获得自己的二维码：永久的
//$wechat->firstValid();//微信平台向我们PHP请求，用来验证开发者给微信的URL和TOKEN
$wechat ->responseMsg();
