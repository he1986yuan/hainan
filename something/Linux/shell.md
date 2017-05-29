 ##Linux 下建立压缩包，解压缩包的命令
--Gz:
打包: tar czf file.tar.gz file.txt
解压: tar xzf file.tar.gz
Bz2:
打包: tar zxvf file.tar.bz2 file.txt
解压: tar zcvf file.tar.bz2
--Gzip:
打包: gzip file1.txt
解压: gunzip file1.txt.gz
--Zip:
打包: zip file1.zip file1.txt
解压: unzip file1.zip

--查看进程信息
ps –e
--查看进程负载
ps -aux
--管道筛选
ps -e | grep sshd
