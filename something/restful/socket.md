Node构建webApp
Node 做的是服务器 适合处理大量即时的request linkedin 手机app后台有node cloud9 的后台都是node 做的。 所谓思路 可以设计成分散式的多服务器互相沟通最大限度利用node 的优点 实现快速的云处理解决方案

===========

多服务器并不是一定的。小项目的话一个服务器绝对够了 处理大规模request的速度绝对比php ruby django 快。但毕竟还是有上限的，那个速度，因为暂时还只能够single thread。暂时来说 我自己的解决方案是显示网页的一个server，RestApi一个 server，Socket一个server。通过Api进行authentication。webapp 通过ajax 向api server发送request得到数据。
