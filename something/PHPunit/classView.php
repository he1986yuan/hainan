<?php
/**
 * 观察者模式的示例
 */
class Login //extends AnotherClass
{
  const LOGIN_USER_UNKNOWN＝1;
  const LOGIN_WRONG_PASS =2;
  const LOGIN_ACCESS =3;
  private $status =[];

  function handleLogin($user,$pass,$ip)
  {
    switch (rand(1,3)) {
      case 1:
        # code...
        break;

      case 2:
        # code...
        break;
      case 2:
          # code...
        break;
    }
  }
}



 ?>
