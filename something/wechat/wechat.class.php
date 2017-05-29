<?php
/**
 * wechat  controller class
 */
class Wechat //extends AnotherClass
{

  private $_appid;
  private $_appsecret;
  private $_token;//公众平台请求开发者时候的参数
  //Qrcode的类型
  const QRCODE_TYPE_TEMP=1;
  const QRCODE_TYPE_LIMIT =2;
  const QRCODE_TYPE_LIMIT_STR =3;
  public function __construct($id,$secret,$token)
  {
    //get appid and appsecret
    $this->_appid =$id;
    $this->_appsecret=$secret;
    $this->_token =$token;
  }
  /**
   * 在wei平台请求PHP时验证signature的合法性
   * 获取签名的目的是为PHP给微信平台提供自己接口URL和开发者提供的token
   */
  public function firstValid()
  {
    //如果签名合法返回随机字符串
    if ($this->_checkSignature()) {
      echo $_GET['echostr'];
    }
  }
  /**
   * @return bool [description]
   */
   private function _checkSignature()
   {
     $signature =$_GET['signature'];//微信传来的签名（来自我们在品台上事先填好的token运算而成）
     $timestamp =$_GET['timestamp'];//传来的时间戳
     $nonce =$_GET['nonce'];
     $tmp_arr =array($this->_token,$timestamp,$nonce);
     sort($tmp_arr,SORT_STRING);//字典的顺序
     $tmp_str =implode($tmp_arr);//把数组项链接成字符串
     $tmp_str =sha1($tmp_str);//sha1签名算法
     if ($signature ==$tmp_str) {//如果本地保留的token计算而来的签名等于传递而来的签名
       return true;
     }else{
       return false;
     }
   }



  //获取微信的acessToken
  //ccSbJPK5QtPgrPs3pcCMlq1Em_ogc6RlQMfYklHpl1m8tgpdLVasty1hyzx-fPbLxhx2MgY1ecamaByx8pd6QjdoQMcPOAKGDGu8pbMBTJO69L2gEvnDN2EpIGCIkRtEUODcABAZTI
  public function getAccessToken($token_file ='./access_token')
  {
    $life_time=7200;
    //如果时间没有过期则直接返回文件中的access_token否则重新获取access_token
    // if (file_exists($token_file) && time()-filetime($token_file)<$life_time) {
    //    return file_get_contents($token_file);
    // }

    $url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appid}&secret={$this->_appsecret}";
    //send request GET
    //var_dump($url);
    $result =$this->_requestGet($url,$ssl=true);
    if (!$result) {
      return false;
    }
    $obj =json_decode($result);//如果填写第二个参数就是数组，否则返回的就是对象//{"access_token":"ACCESS_TOKEN","expires_in":7200}
    //写入文件
    //file_put_contents($token_file,$obj->access_token);
    return $obj->access_token;


  }
  public  function _getQRCodeTicket($content,$type=2)//这里写死了我们用固定的action类型2：-。-
  {
    $access_token =$this->getAccessToken();
    $url ="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
    //echo "$url</br>";
    //qrcode 的类型
    $type_list =[
      self::QRCODE_TYPE_TEMP=>'QR_SCENE',
      self::QRCODE_TYPE_LIMIT=>'QR_LIMIT_SCENE',
      self::QRCODE_TYPE_LIMIT_STR=>'QR_LIMIT_STR_SCENE',
    ];
    $action_name =$type_list[$type];
    $data ='{"action_name": "'.$action_name.'", "action_info": {"scene": {"scene_id": "'.$content.'"}}}';
    //echo "$data</br>";
    // die;
    $result =$this->_requestPost($url,$data);
    if (!$result) {
      return false;
    }
    $result_obj =json_decode($result);
    // var_dump($access_token);
    // var_dump($result_obj);
    return $ticket =$result_obj->ticket;
  }
  /**
   * request POST
   *@param [type] string [$url]
   *@param [type] string [$data]
   *@param [type] bool [$ssl]
   *@return[type] string
   */

  public function _requestPost($url,$data,$ssl=true)
  {

      $curl =curl_init();
      //设置CURL选项
      curl_setopt($curl,CURLOPT_URL,$url);
      $user_agent =isset($_SERVER['HTTP_SERVER_USER_AGENT']) ? $_SERVER['HTTP_SERVER_USER_AGENT']:"User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.22 Safari/537.36 SE 2.X MetaSr 1.0";
      curl_setopt($curl,CURLOPT_USERAGENT,$user_agent);
      //请求来源
      curl_setopt($curl,CURLOPT_AUTOREFERER,true);
      //不验证ssl证书
      if ($ssl) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //https请求 不验证证书 其实只用这个就可以了
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //https请求 不验证HOST
      }
      //处理响应
      curl_setopt($curl,CURLOPT_POST,true); //请求的url
      curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
      curl_setopt($curl,CURLOPT_HEADER,false);//不处理请求头
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);//返回响应结果
      //send request
      $response =curl_exec($curl);
      if (false==$response) {
        echo curl_error($curl);
        return false;
      }
      return $response;

  }
  //获取二维码
  public function getQRCode($content,$file=null)
  {
    $ticket =$this->_getQRCodeTicket($content);
    //var_dump($ticket);
    $url ="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
    $result =$this->_requestGet($url);//获取的是图像资源
    if ($file) {
      file_put_contents($file,$result);
    }else{
      header('Content-type:image/jpeg');
      echo $result;
    }
  }

  /**
   * request GET
   *@param [type] string [$url]
   *@param [type] bool [$ssl]
   *@return[type] stringl
   */
  public function _requestGet($url,$ssl=true)
  {
    $curl =curl_init();
    //设置CURL选项
    curl_setopt($curl,CURLOPT_URL,$url);
    $user_agent =isset($_SERVER['HTTP_SERVER_USER_AGENT']) ? $_SERVER['HTTP_SERVER_USER_AGENT']:"User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.22 Safari/537.36 SE 2.X MetaSr 1.0";
    curl_setopt($curl,CURLOPT_USERAGENT,$user_agent);
    //请求来源
    curl_setopt($curl,CURLOPT_AUTOREFERER,true);
    //不验证ssl证书
    if ($ssl) {
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //https请求 不验证证书 其实只用这个就可以了
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //https请求 不验证HOST
    }
    //处理响应
    curl_setopt($curl,CURLOPT_URL,$url); //请求的UR
    curl_setopt($curl,CURLOPT_HEADER,false);//不处理请求头
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);//返回响应结果
    //send requere
    $response =curl_exec($curl);
    if (false==$response) {
      echo curl_error($curl);
      return false;
    }
    return $response;

  }


/**
 * 获得平台发送给PHP的信息事件的方法
 */

   public function responseMsg()
   {
     //获取的是POST请求：xml，并不是key value形式的
     $xml_str =$GLOBALS['HTTP_RAW_POST_DATA'];
     if (empty($xml_str)) {
      die('no reponse');
     }
  // 接受信息的格式
  //<xml>
  // <ToUserName><![CDATA[toUser]]></ToUserName>
  // <FromUserName><![CDATA[FromUser]]></FromUserName>
  // <CreateTime>123456789</CreateTime>
  // <MsgType><![CDATA[event]]></MsgType>
  // <Event><![CDATA[subscribe]]></Event>
  // </xml>
  //event是诸如读者请求关注平台->平台向PHP发送关注事件->处理xml
//设置该参数表示利用simpleXML解析返回的数据
     libxml_disable_entity_loader(true);//禁止实体载入防止XML注入
     $request_xml =simplexml_load_string($xml_str,'SimpleXMLElement',LIBXML_NOCDATA);
     //将XMLstring以一个simplexml方式解析返回的是一个xml来自微信公号的对象
     //通过msgtype获得消息的类型
     switch ($request_xml->MsgType) {
       case 'event':
         $event =$request_xml->Event;
         $key =$request_xml->EventKey;

         if ('subscribe'==$event) {//关注事件
           $this->_doSubscribe($request_xml);
         }
         if ('CLICK'==$event&&'V1001_TODAY_MUSIC'==$key){//点击translate事件
           $this->_dotTrans($request_xml);
         }
       case 'text':
           $this->_doText($request_xml);
       case 'image':
           $this->_doImage($request_xml);
       case 'voice':
           $this->_doVoice($request_xml);

       default:
         # code...
         break;
     }
   }

    /**
     * 用于处理关注事件的方法
     *@param [type] $request_xml
     *@param [return]
     */
    private function _doSubscribe($request_xml)
    {
      //php响应给->平台->到用户的信息
      $text ='<xml><ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> <CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[%s]]></Content> </xml>';
      $content ='我是何园，或许也是宋春亮，感谢关注，虽然这没啥卵用[抠鼻]';
      $response =sprintf($text,$request_xml->FromUserName,$request_xml->ToUserName,time(),$content);
      //将字符串中的%替换掉并组成response
      die($response);
    }

    /**
     * 用于处理PHP处理微信的文本内容回复的方法
     *@param [type] $request_xml
     *@param [return]
     */

    public function _doText($request_xml)
    {
      $receivecont =$request_xml->Content;
      $text ='<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName> <CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[%s]]></Content> </xml>';
      $content =[
        0=>'你说'.$receivecont.'，但是我见的太多了',
        1=>'你说'.$receivecont.'，我可以回答一句无可奉告',
        2=>'你识得唔识得嘞？',
        3=>'你说'.$receivecont.'，我也很替你捉急啊真的',
        4=>'naive!',
        5=>'你叫什么？',
        6=>'too young' ,
        7=>'你是男是女',
        8=>'蛤？',
        9=>'who are you?',
        10=>'吃了吗？',
        11=>'无可奉告',
        12=>'哼',
        13=>'忠党爱国一颗红心似烈火',
    ];
      $index = rand(0,count($content));
      $response =sprintf($text,$request_xml->FromUserName,$request_xml->ToUserName,time(),$content[$index]);
      //将字符串中的%替换掉并组成response
      die($response);

    }

    /**
     * public function translate
     * API key：197230029
     * keyfrom：beidaopoem
     * api ：URL；http://fanyi.youdao.com/openapi.do?keyfrom=beidaopoem&key=197230029&type=data&doctype=<doctype>&version=1.1&q=要翻译的文本
     */

     public function _doTrans($request_xml)
     {
       $keyfrom = "beidao2";    //申请APIKEY 时所填表的网站名称的内容
       $apikey = "227362714";  //从有道申请的APIKEY
       $word =$request_xml->Content;


       //有道翻译-xml格式
       $url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=xml&version=1.1&q='.$word;

       $xmlStyle = simplexml_load_file($url_youdao);

       $errorCode = $xmlStyle->errorCode;

       $paras = $xmlStyle->translation->paragraph;//翻译的内容

       if($errorCode == 0){
         $text ='<xml><ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> <CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[%s]]></Content> </xml>';

         $response =sprintf($text,$request_xml->FromUserName,$request_xml->ToUserName,time(),$paras);
         //将字符串中的%替换掉并组成response
         die($response);
       }else{
           return "无法进行有效的翻译";
       }

     }

  }



 ?>
