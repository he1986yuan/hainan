##Linux下安装PHP的过程
安装软件之前先安装编译工具gcc、gcc-c++
拷贝源码包，解包解压缩
cd /lamp/php进入php目录
./configure –prefix=/usr/local/php –with-config-file-path=/usr/local/php/etc指定安装目录和配置文件目录
make 编译
make install安装

##Linux下安装Mysql的过程
groupadd mysql 添加一个用户组mysql
useradd -g mysql mysql 添加一个mysql用户指定分组为mysql
cd /lamp/mysql 进入mysql目录
./configure –prefix=/usr/local/mysql/ –with-extra-charsets=all
make
make all

##Linux下安装apache的过程
cd /lamp/httpd 进去apache软件目录
./configure –prefix=/usr/local/apache2/ –sysconfdir=/etc/httpd/ –with-included-apr
make
make all
