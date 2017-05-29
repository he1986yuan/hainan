<?php
//一个手写的单元测试
require 'test.php';
/**
 * validate
 */
class Validator //extends AnotherClass
{
  private $store;
  public function __construct(UserStore $store)
  {
    $this->store =$store;
  }
  public function ValidateUser($mail,$pass)
  {
    if (! is_array($user =$this->store->getUser($mail))) {
      return false;
    }
    if ($user['pass']==$pass) {
      return true;
    }
    $this->store->notifyPasswordFailure($mail);
    return false;
  }
}
//test
$store =new UserStore();
$store->addUser('mail1','name1','1111111');
print_r($store->getUser('mail1'));

$Validator =new Validator($store);
var_dump($Validator->ValidateUser('mail1','1111111'));


 ?>
