<?php
//上次登录时间
$visit_time =date('Y-m-d H:i:s',time());
if (!isset($_COOKIE['last_time'])) {
  echo "first visit ".$visit_time;
}else{
  echo "last visit time".$_COOKIE['last_time'];
}

setcookie('last_time',$visit_time,time()+3600);

//保存用户登录信息


 ?>
