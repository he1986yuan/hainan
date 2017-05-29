<?php
function _doTrans()
{
  $keyfrom = "beidao2";    //申请APIKEY 时所填表的网站名称的内容
  $apikey = "227362714";  //从有道申请的APIKEY
  // $word =$request_xml->Content;
  $word ='word';


  //有道翻译-xml格式
  $url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=xml&version=1.1&q='.$word;

  $xmlStyle = simplexml_load_file($url_youdao);

  $errorCode = $xmlStyle->errorCode;
  var_dump( $errorCode);
  echo "<br>";

  $paras = $xmlStyle->translation->paragraph;//翻译的内容
  var_dump($paras);

  if($errorCode == 0){
    // $text ='<xml><ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> <CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[%s]]></Content> </xml>';
    //
    // $response =sprintf($text,$request_xml->FromUserName,$request_xml->ToUserName,time(),$paras);
    // //将字符串中的%替换掉并组成response
    // die($response);
    return $paras;
  }else{
      return "无法进行有效的翻译".$erroCode;
  }

}

_doTrans();




 ?>
