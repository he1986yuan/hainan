<?php
/*引入文件的区别：
相同点：include和require 都能把另外一个文件包含到当前文件中。
不同点：使用include时，当包含的文件不存在时，系统会报出警告级别的错误，程序会继续往下执行。
【require会终止执行】使用require包含文件时，当包含的文件不存在时，系统会先报出警告级别的错误，接着又报一个致命级别的错误。
程序将终止执行。   require能让php的程序得到更高的效率，在同一php文件中解释过一次后，不会再解释第二次。
而include却会重复的解释包含的文件。所以当php网页中使用循环或条件语句引入文件时，
"require"则不会做任何的改变，当出现这种情况，必须使用"include"命令来引入文件。*/


function tree($directory)
{
	$mydir = dir($directory);
	echo "<ul>\n";
  //var_dump($mydir->read());
	while($file = $mydir->read())
	{
		if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))//如果该目录不是文件或. ..
		{
			echo "<li><font color=\"#ff00cc\"><b>$file</b></font></li>\n";
			tree("$directory/$file");//递归的遍历其下边的所有文件
		}
		else
		{
      if ($file!="."AND $file!="..") {
        echo "<li>$file</li>\n";
      }
    }
	}
	echo "</ul>\n";
	$mydir->close();
}
tree('../');


function tree($directory)
{
  $mydir =dir($directory);
  echo "<ul>\n";
  while($file=$mydir->read())
  {
    if (is_dir($directory/$file)&& ($file!=".") AND ($file!="..")) {

      echo "<li><font color=\"#ff00cc\"><b>$file<b></font><li>\n";
      tree("$directory/$file");
    }else
    echo "<li>$file</li>\n";
  }
  echo "</ul>\n";
  $mydir->close();
}

 ?>
