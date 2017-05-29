<?php
namespace mongodb;
$host ='127.0.0.1';
$port ='27017';
$server ='mongodb://'.$host.:':'.$port;
$mongo =new \MongoClient($server);
if (!@mongo->connected) {
  die('failed');
}
//创建数据库（库名：blog）->集合（类似于表名：post） -->待插入的记录（doc文档）
$post_collection =$mongo->blog->post;

var_dump($post_collection)

 ?>
