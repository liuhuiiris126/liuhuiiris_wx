<?php
/**
 * 这个文件只是用来测试微信与服务器是否建立连接
 */
define("TOKEN", "weixin"); //TOKEN值
$wechatObj = new wechat();
$wechatObj->valid();
class wechat {
  public function valid() {
    $echoStr = $_GET["echostr"];
    if($this->checkSignature()){
      echo $echoStr;
      exit;
    }
  }
  private function checkSignature() {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    if( $tmpStr == $signature ) {
      return true;
    } else {
      return false;
    }
  }
}
?>