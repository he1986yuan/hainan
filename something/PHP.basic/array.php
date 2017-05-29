<?php
/**
 * function about array
 */
 array_combine();//两个数组结合成新数组
 array_merge();//两个数组的合并
 array_diff();//返回两个数组的差异集合
 array_key_exists();//判断数组是否存在某个键值
 array_splice()//数组中部分的替换
 array_reverse();//颠倒一个数组
 /**
  * file operate
  */



//打印出前一天的时间，打印格式是2007年5月10日22:21:21
echo date('Y-m-d H:i:s',strtotime('-1 day'));
//计算两个时间的差
$begin=strtotime("2007-2-5");
$end=strtotime("2007-3-6");
echo ($end-$begin)/(24*3600);

/**
 *
 */
 //bubble sort
 function Bubblesort($arr)
 {
	for($i=0; $i<count($arr); $i++)
  {
  		for($j=0; $j<count($arr)-1; $j++)
      {
  			if($arr[$j] > $arr[$j+1])
        {
  				$tmp=$arr[$j];
  				$arr[$j]=$arr[$j+1];
  				$arr[$j+1]=$tmp;
          }
      }
    }
	return $arr;
}
$arr=array(3,2,1);
print_r(Bubblesort($arr));
//element  outside  inside
//3        i=0      j=0  j<2 j->0-1   3>2change ;j+1 a[1]=3 2>1 comparechange for twice 3-1
//2        i=1      j=0  j<2 j->0-1   a[0]=2>1change ;j+1 a[1]=2!>3 comparechange for once 3-2
//1        i=2      j=0  none compare                3-o

/**********************
一个简单的目录递归函数
第一种实现办法：用dir返回对象
***********************/
function tree($directory)
{
	$mydir = dir($directory);
	echo "<ul>\n";
	while($file = $mydir->read())
	{
		if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))//如果该目录不是文件或. ..
		{
			echo "<li><font color=\"#ff00cc\"><b>$file</b></font></li>\n";
			tree("$directory/$file");//递归的遍历其下边的所有文件
		}
		else
		echo "<li>$file</li>\n";
	}
	echo "</ul>\n";
	$mydir->close();
}

//PHP运行shell
system() //输出并返回最后一行shell结果。
exec() //不输出结果，返回最后一行shell结果，所有结果可以保存到一个返回的数组里面。
passthru() //只调用命令，把命令的运行结果原样地直接输出到标准输出设备上。




 ?>
