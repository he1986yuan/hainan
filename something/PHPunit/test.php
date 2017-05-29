<?php
/**
 * user class
 */
class UserStore //extends AnotherClass
{

  private $users =[];

  public function addUser($mail,$name,$pass)
  {
    if (isset($this->users[$mail])) {
      throw new Exception('user mail aready exists');
    }
    if (strlen($pass)<5) {
      throw new Exception('password must large than 5 number');
    }
    $this->users[$mail] =[
      'mail'=>$mail,
      'name'=>$name,
      'pass'=>$pass
    ];
    return true;
  }

  function notifyPasswordFailure($mail)
  {
    if (isset($this->users[$mail])) {
      $this->users[$mail]['failed'] =time();
    }

  }

  function getUser($mail){
    return($this->users[$mail]);
  }
}

/**
 * test ubit
 */



 ?>
