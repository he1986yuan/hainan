<?php
/**
 *
 */
class ShopProduct //extends AnotherClass
{
//工厂和单例的设计模式通常是结合在一起使用的
//工厂使用单例模式保证不生成重复的对象实例
  public static function getInstance($id,PDO $dhh)
  {
    //传递一个PDO对象
    $query ="select * from product where id=?";
    $stmt =$dhh->prepare($query);
    if (! $stmt->execute(array($id))) {
      $error =$dhh->errorInfo();
      die("failed:".$error[1]);
    }
    $row =$stmt->fetch();
    if (empty($row)) {
      return null;
    }
    if ($row['type']=="book") {
      $product =new BookProduct;
    }else{
      $product =new CdProduct;
    }
    $product->setId($row['id']);
    $produnct->setDiscount($row['discount']);
    return $product;

  }
}

$cdproduct =new ShopProduct(6,$dhh);
//singleton
public class SingletonA {
     public static SingletonA instance = null;

     private SingletonA(){     }

     public static SingletonA getSingletonA(){
          if(instance == null){
               instance = new SingletonA();
          }
          return instance;
     }
}


 ?>
