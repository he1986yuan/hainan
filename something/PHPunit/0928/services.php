<?php
$arr = array('a' =>1 , 'b'=>2,'c'=>3);
$res =json_encode($arr);
//var_dump($res);
$callback =$_GET['callback'];
echo $callback."($res)";
 ?>
