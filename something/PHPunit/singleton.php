<?php
/**
 * getSingleton
 */
class Preferences //extends AnotherClass
{
  private $props =[];
  private static $instance;
  private function __construct(){}

    public function getInstance()
    {
      if (empty(self::$instance)) {
      self::$instance =new Preferences;
      }
      return self::$instance;
    }
    public function setProperty($key,$val)
    {
      $this->props[$key] =$val;
    }
    public function getProperty($key)
    {
      $this->propd[$key];
    }

}





public static function getInstance()
{
  private static $_intance=null;
  if (!(self::$_instance instanceof self)) {
    self::$_instance;//如果不存在这个实例就创建
  }
  return self::$_instance;//不存在创建后直接返回，存在直接返回
}

public static function getInstance()
{
  private static $_instance=null;
  if (!(self::$_instance instanceof self)) {
    # code...
    self::$_instance;
  }
  return self::$_instance;
}


 ?>
