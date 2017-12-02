<?php
define("TOKEN", "weixin");
$wechatObj = new wechat();
if (isset($_GET['echostr'])) {
  $wechatObj->valid();
}else{
  $wechatObj->responseMsg();
}
class wechat
{
  public function valid()
  {
    $echoStr = $_GET["echostr"];
    if($this->checkSignature()){
      header('content-type:text');
      echo $echoStr;
      exit;
    }
  }
  private function checkSignature()
  {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    if( $tmpStr == $signature ){
      return true;
    }else{
      return false;
    }
  }
  public function responseMsg()
  {
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    if (!empty($postStr)){
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); //获取数据
      $fromUsername = $postObj->FromUserName;
      $toUsername = $postObj->ToUserName;
      $keyword = trim($postObj->Content);
      $time = time();
      $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
            </xml>";
      if($keyword) { //获取用户信息
        $msgType = "text";
        $contentStr = $this->getResponseMsg($keyword); // 回复的内容
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
      }
    }else{
      echo "";
      exit;
    }
  }

  private function getResponseMsg($keyword)
  {
    $rand = mt_rand(1, 19);
    $array = array(
      1=>'人之初?性本善?玩心眼?都滚蛋。',
      2=>'今后的路?我希望你能自己好好走下去?而我 坐车',
      3=>'笑话是什么?就是我现在对你说的话。',
      4=>'人人都说我丑?其实我只是美得不明显。',
      5=>'A;猪是怎么死的?B;你还没死我怎么知道',
      6=>'奥巴马已经干掉和他同姓的两个人?奥特曼你要小心了。 ',
      7=>'有的人活着?他已经死了?有的人活着?他早该死了。',
      8=>'"妹妹你坐船头?哥哥我岸上走"据说很傻逼的人看到都是唱出来的。',
      9=>'我这辈子只有两件事不会?这也不会?那也不会。',
      10=>'过了这个村?没了这个店?那是因为有分店。',
      11=>'我以为你只是个球?没想到?你真是个球。',
      12=>'你终于来啦，我找你N年了，去火星干什么了？我现在去冥王星，回头跟你说个事，别走开啊',
      13=>'你有权保持沉默，你所说的一切都将被作为存盘记录。你可以请代理服务器，如果请不起网络会为你分配一个。',
      14=>'本人正在被国际刑警组织全球范围内通缉，如果您有此人的消息，请拨打当地报警电话',
      15=>'洗澡中~谢绝旁观！！^_^0',
      16=>'嘀，这里是移动秘书， 美眉请再发一次，我就与你联系；姐姐请再发两次，我就与你联系；哥哥、弟弟就不要再发了，因为发了也不和你联系！',
      17=>'其实我在~就是不回你拿我怎么着？',
      18=>'你刚才说什么，我没看清楚，请再说一遍！',
      19=>'乖，不急。。。'
    );
    return $array[$rand];
  }
}
?>