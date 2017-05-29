<?php
if ($_GET['name']==1&&$_GET['id']==1) {
  $response=[
    'error'=>0,//错误代码和错误信息
    'errorInfo'=>"no error"
  ];
}else{
  $response=[
    'error'=>1,
    'errorInfo'=>"error"
  ];
}
echo json_encode($response);//将PHP的数组转码未json类型的数据返回给ajax，注意用的是echo




 ?>
