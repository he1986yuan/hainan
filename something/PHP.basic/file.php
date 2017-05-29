<?php
//mydir::dir
$d = dir("/etc/php5");
echo "Handle: " . $d->handle . "\n";
echo "Path: " . $d->path . "\n";
while (false !== ($entry = $d->read())) {
   echo $entry."\n";
}
$d->close();

/**
 * 遍历文件
 */
function tree($directory)
{
	$mydir = dir($directory);
	echo "<ul>\n";
	while($file = $mydir->read())
	{
			if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
			{
				echo "<li><font color=\"#ff00cc\"><b>$file</b></font></li>\n";
				tree("$directory/$file");
			}
			else
			echo "<li>$file</li>\n";
	}
	echo "</ul>\n";
	$mydir->close();
}

tree("../");
/**
*file操作函数
*/
$file ='dir';
$fp =fopen($file,'r');
/**
 * fopen()的使用
 *r：文件以读的形式打开，文件指针在最前面
 *w：文件以写的形式打开，文件指针放在最前面如果文件不存在会创建
 *a：以追加的形式读取文件，文件的指针放在文件的最后边如果文件不存在则尝试创建她
 *
 */

//如何快速下载一个远程http服务器上的图片文件到本地?
$file="/imageA.jpg",
$fp=fopen($file,'rb');//读写r+返回fp资源句柄ftest
$img=fread($fp,10000);//filesize（file_full_path）=1000;返回读取的文件字符串
$dir="./";
$local=fopen($dir.'/'.basename($file),'w');//dir /之后的文件名字imageA
fwrite($local,$img);//把文件img的内容（string）写到写入本地的local句柄handle

//一个网页地址, 比如PHP开发资源网主页: http://www.phpres.com/index.html,如何得到它的内容?获取网页内容：
$url="http://www.phpres.com/index.html";
$str=file_get_contents($url);

 ?>
