<?php
abstract class AppEncoder{
  abstact function encode();
}

/**
 *继承与工厂方法
 */
class BloggAppEncoder extends AppEncoder
{
  function encode()
  {return :"Appointment data encode inBlogg...."}
}

abstract class Commmanager{
  abstract function getHeaderText();
  abstract function getAppEncoder();
  abstract function getFooterText();
}

/**
 *
 */
class BloggCommsManager extends Commmanager
{
  function getHeaderText()
  {return "BloggCal header";}

  function getAppEncoder()
  {return new BloggApptEncoder();}//工厂实例化

  function getFooterText()
  {return "BloggCal footer";}
}



 ?>
