
HTTP 80 HTTPS 443
1、常用的HTTP方法有哪些？

GET： 用于请求访问已经被URI（统一资源标识符）识别的资源，可以通过URL传参给服务器
POST：用于传输信息给服务器，主要功能与GET方法类似，但一般推荐使用POST方式。
PUT： 传输文件，报文主体中包含文件内容，保存到对应URI位置。
HEAD： 获得报文首部，与GET方法类似，只是不返回报文主体，一般用于验证URI是否有效。
DELETE：删除文件，与PUT方法相反，删除对应URI位置的文件。
OPTIONS：查询相应URI支持的HTTP方法。
URL与URI首先，URI，是uniform resource identifier，统一资源标识符，用来唯一的标识一个资源。而URL是uniform resource locator，统一资源定位器，它是一种具体的URI，即URL可以用来标识一个资源，而且还指明了如何locate这个资源。而URN，uniform resource name，统一资源命名，是通过名字来标识资源，比如mailto:java-net@java.sun.com。也就是说，URI是以一种抽象的，高层次概念定义统一资源标识，而URL和URN则是具体的资源标识的方式。URL和URN都是一种URI。


2、GET方法与POST方法的区别
区别一：
get重点在从服务器上获取资源，post重点在向服务器发送数据；
区别二：
get传输数据是通过URL请求，以field（字段）= value的形式，置于URL后，并用"?"连接，多个请求数据间用"&"连接，如http://127.0.0.1/Test/login.action?name=admin&password=admin，这个过程用户是可见的；
post传输数据通过Http的post机制，将字段与对应值封存在请求实体中发送给服务器，这个过程对用户是不可见的；
区别三：
Get传输的数据量小，因为受URL长度限制，但效率较高；
Post可以传输大量数据，所以上传文件时只能用Post方式；
区别四：
get是不安全的，因为URL是可见的，可能会泄露私密信息，如密码等；
post较get安全性较高；
区别五：
get方式只能支持ASCII字符，向服务器传的中文字符可能会乱码。
post支持标准字符集，可以正确传递中文字符。


3、HTTP请求报文与响应报文格式
请求报文包含三部分：
a、请求行：General包含请求方法、URI、HTTP版本信息
b、请求首部字段 header
c、请求内容实体 content
响应报文包含三部分：
a、状态行：包含HTTP版本、状态码、状态码的原因短语（304 not Modified）
b、响应首部字段 header
c、响应内容实体 content
<!-- --Request URL:http://recdm.csdn.net/getRecommendList.html?jsonp=jQuery191022132950592116796_1479216136483&userId=fake_userId&size=10&his=2%3A51336564&client=blog_cf_enhance&query=HTTP%E5%BF%85%E7%9F%A5%E5%BF%85%E4%BC%9A%E2%80%94%E2%80%94%E5%B8%B8%E8%A7%81%E9%9D%A2%E8%AF%95%E9%A2%98%E6%80%BB%E7%BB%93%2Curl%2Ccolor%2C%E9%9D%A2%E8%AF%95%E9%A2%98%2C%E6%9C%8D%E5%8A%A1%E5%99%A8%2Cpre%2Curi&cid=4835473493095236035_20160908&_=1479216136484
Request Method:GET
Status Code:200 OK
Remote Address:101.201.173.208:80
Response Headers
view source
Connection:keep-alive
Content-Type:application/json; charset=UTF-8
Date:Tue, 15 Nov 2016 13:22:22 GMT
Keep-Alive:timeout=20
Server:openresty
Transfer-Encoding:chunked
Request Headers
view source
Accept:*/*
Accept-Encoding:gzip, deflate, sdch
Accept-Language:zh-CN,zh;q=0.8
Cache-Control:max-age=0
Connection:keep-alive
Cookie:uuid_tt_dd=4835473493095236035_20160908; UN=sinat_26953817; UE=""; BT=1478614873670; __message_district_code=000000; __utma=17226283.1651750025.1479047859.1479047859.1479047859.1; __utmc=17226283; __utmz=17226283.1479047859.1.1.utmcsr=baidu|utmccn=(organic)|utmcmd=organic; __message_sys_msg_id=0; __message_gu_msg_id=0; __message_cnel_msg_id=0; __message_in_school=0; Hm_lvt_6bcd52f51e9b3dce32bec4a3997715ac=1479190859,1479195949,1479215599,1479216137; Hm_lpvt_6bcd52f51e9b3dce32bec4a3997715ac=1479216137; dc_tos=ogoqh6; dc_session_id=1479216138467
Host:recdm.csdn.net
Referer:http://m.blog.csdn.net/article/details?id=51336564
User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.22 Safari/537.36 SE 2.X MetaSr 1.0 -->


4、常见的HTTP相应状态码
200：【请求被正常处理】
204：请求被受理但没有资源可以返回
206：客户端只是请求资源的一部分，服务器只对请求的部分资源执行GET方法，相应报文中通过Content-Range指定范围的资源。
301：永久性重定向
302：【临时重定向】
303：与302状态码有相似功能，只是它希望客户端在请求一个URI的时候，能通过GET方法重定向到另一个URI上
304：发送附带条件的请求时，条件不满足时返回，与重定向无关
307：临时重定向，与302类似，只是强制要求使用POST方法
400：请求报文语法有误，服务器无法识别
401：【请求需要认证】
403：【请求的对应资源禁止被访问】
404：【服务器无法找到对应资源】
500：【服务器内部错误】
503：【服务器正忙】


5、HTTP1.1版本新特性
a、默认持久连接节省通信量，只要客户端服务端任意一端没有明确提出断开TCP连接，就一直保持连接，可以发送多次HTTP请求
b、管线化，客户端可以同时发出多个HTTP请求，而不用一个个等待响应
c、断点续传原理


6、常见HTTP首部字段
a、通用首部字段（请求报文与响应报文都会使用的首部字段）
【Date：创建报文时间】
【Connection：连接的管理】
【Cache-Control：缓存的控制】
Transfer-Encoding：报文主体的传输编码方式
b、请求首部字段（请求报文会使用的首部字段）
Host：请求资源所在服务器
Accept：可处理的媒体类型
Accept-Charset：可接收的字符集
Accept-Encoding：可接受的内容编码
Accept-Language：可接受的自然语言
c、响应首部字段（响应报文会使用的首部字段）
【Accept-Ranges：可接受的字节范围】
【Location：令客户端重新定向到的URI】
Server：HTTP服务器的安装信息
d、实体首部字段（请求报文与响应报文的的实体部分使用的首部字段）
Allow：资源可支持的HTTP方法
【Content-Type：实体主类的类型】
Content-Encoding：实体主体适用的编码方式
Content-Language：实体主体的自然语言
Content-Length：实体主体的的字节数
Content-Range：实体主体的位置范围，一般用于发出部分请求时使用


7、HTTP的缺点与HTTPS
a、通信使用明文不加密，内容可能被窃听
b、不验证通信方身份，可能遭到伪装
c、无法验证报文完整性，可能被篡改
HTTPS就是HTTP加上加密处理（一般是SSL安全通信线路）+认证+完整性保
