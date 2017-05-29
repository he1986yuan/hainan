<?php
#1
wechat:id gh_108857d2cfc8
appid:wxd1fb3b4932bcaff2
appsecret:c7743bc0f2f9ee52c3c7d44628eb6845


http请求方式: GET
url:'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';
参数说明

参数	是否必须	说明
grant_type	是	获取access_token填写client_credential
appid	是	第三方用户唯一凭证
secret	是	第三方用户唯一凭证密钥，即appsecret
返回说明

正常情况下，微信会返回下述JSON数据包给公众号：

【tolken】{"access_token":"ACCESS_TOKEN","expires_in":7200}
参数	说明
access_token	获取到的凭证
expires_in	  凭证有效时间，单位：秒

错误时微信会返回错误码等信息，JSON数据包示例如下（该示例为AppID无效错误）:

{"errcode":40013,"errmsg":"invalid appid"}
调用access_token接口频率限制说明

全局返回码说明

使用网页调试工具调试该接口

#2QRcode
获取ticket
利用ticket获取二维码图片的内容
创建二维码ticket

每次创建二维码ticket需要提供一个开发者自行设定的参数（scene_id），分别介绍临时二维码和永久二维码的创建二维码ticket过程。

临时二维码请求说明

http请求方式: POST
URL: https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=TOKEN
POST数据格式：json
POST数据例子：{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
永久二维码请求说明

http请求方式: POST
URL: https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=TOKEN
POST数据格式：json
POST数据例子：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
或者也可以使用以下POST数据创建字符串形式的二维码参数：
{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "123"}}}
参数说明

参数	说明
expire_seconds	该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
action_name	二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
action_info	二维码详细信息
scene_id	场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
scene_str	场景值ID（字符串形式的ID），字符串类型，长度限制为1到64，仅永久二维码支持此字段
返回说明

正确的Json返回结果:

{"ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==","expire_seconds":60,"url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"}
参数	说明
ticket	获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码。
expire_seconds	该二维码有效时间，以秒为单位。 最大不超过2592000（即30天）。
url	二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
错误的Json返回示例:

{"errcode":40013,"errmsg":"invalid appid"}
全局返回码说明

使用网页调试工具调试该接口

通过ticket换取二维码

获取二维码ticket后，开发者可用ticket换取二维码图片。请注意，本接口无须登录态即可调用。

请求说明

HTTP GET请求（请使用https协议）
https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET
提醒：TICKET记得进行UrlEncode
返回说明

ticket正确情况下，http 返回码是200，是一张图片，可以直接展示或者下载。

HTTP头（示例）如下：
Accept-Ranges:bytes
Cache-control:max-age=604800
Connection:keep-alive
Content-Length:28026
Content-Type:image/jpg
Date:Wed, 16 Oct 2013 06:37:10 GMT
Expires:Wed, 23 Oct 2013 14:37:10 +0800
Server:nginx/1.4.1
错误情况下（如ticket非法）返回HTTP错误码404。

使用网页调试工具调试该接口：

#配置合法的URL接口，在PHP端被公众平台所请求
URL： 一个被外网访问的url用于公众平台访问PHP
TOKEN：区别于acess_token (a_t是公共平台的生成的，用于php请求公共平台)，token是开发者自定义，用于公众平台请求php服务



 ?>
