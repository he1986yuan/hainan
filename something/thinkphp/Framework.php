
<?php
框架和框架之间当然有区别和优势。

比如 Spring 的事务管理。比如 Rails 的快速原型。另外，“轻型框架 Quixote，Sinatra，node 的一些框架”，甚至“没有框架”，也是一种框架。

而选择框架，应该说不是技术人员考虑的问题（现代语言上的差异，有时候小到根本不值得一提）。架构师才需要考虑这些。

考虑 Scalability 下的成本，用 Spring 的服务器集群来管理事物，是否要比上 Oracla 集群便宜？
考虑快速原型，用 Rails 是否能在一个月内拿出个可用的东西给 VC 看？
考虑用户有邮件模版编辑和自动分发的需求，因为 PHP 有现成的产品，是否优先选择他？
考虑系统涉及大量个人数据，基于安全性的考虑是否选择 Java 的框架？

当需求更多样化的时候，还可能需要混合多个框架。
Spring 的 API ＋ Rails ？
如果有简单事物的大量并发，是否考虑加入 Node？
如果有大量数据的简单索引，是否考虑 NoSQL 数据库？
为了多种语言下的不同的库都很重要，是否考虑用 Python 做粘合剂？

各种框架的优劣：
1）laravel (restful) 他必须先定义路由，每一条请求都得手动定义路由。而thinkphp yii他们是默认网址格式。 我觉得laravel这样会非常耗费资源，每一条请求网址都必须手动在routes.php里面绑定好，你用了不觉得繁琐吗。一条条的写，想象一下，一次性全部加载解析，运行效率觉得非常慢。

2）composer这个其实没有什么要讲的，只是一个下载安装方式不同而已。

3）对比thinkphp和yii来说，laravel真的还太年轻，官网说的聚集所有框架的最好的优点，这一点确实很吸引人，但是也会导致laravel框架不断的变，包括模板的处理方法。如果追寻的一种稳定的长期的，最好不要用laravel。

4）关于laravel artisan，其实其他的框架比如yii2 thinkphp symfony2，除了thinkphp没有，其他的两个框架都有这样类似的功能的。而且symfony2的功能比laravel的强大很多倍。

5）关于CI，我觉得他即将没落。现在PHP有规范出来了，其中的一点就是驼峰命名。而CI框架他一开头就一个CI_，而且kohana很可能取代CI框架。

6）cakephp，cakephp其实一直在模仿symfony。不过2.x版本和1.x版本已经完全不同了。国内对cakephp的认识还是停留在cakephp 1.x版本上，而且用的越来越少了。以前有很多非常火爆的框架，后来都销声匿迹的。
