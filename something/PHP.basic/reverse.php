<?php
//字符串反转
function rev($str)
{
  $arr =[];
  $newstr ='';
  $arr =str_split($str);
  for ($i=count($arr)-1; $i >=0 ; $i--) {
    $newstr .=$arr[$i];
  }
  echo $newstr;
}

rev('abcd');
echo "</br>";
//数组内的元素两两相乘
$array =[1,2,3,4];//234;68;12

for ($i=0; $i <count($array) ; $i++)
{
  for ($j=$i+1; $j <count($array) ; $j++) {
    echo $array[$i]*$array[$j].'<br>';
  }
}

 ?>
