<?php
/*---simsimi.php [ 智能聊天（simsimi） ]
+--------------------------------------------------
|   Author: LimYoonPer
+------------------------------------------------*/

function simsimi ($keyword)
{
  $keyword = urlencode($keyword);
  //----------- 获取COOKIE ----------//
  $url = "http://www.simsimi.com/";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $content = curl_exec($ch);
  list($header, $body) = explode("\r\n\r\n", $content);
  preg_match_all("/set\-cookie:([^\r\n]*);/iU", $header, $matches);
  $cookie = implode(';', $matches[1]).";simsimi_uid=1;";
  curl_close($ch);
  //----------- 抓 取 回 复 ----------//
  $url = "http://www.simsimi.com/func/reqN?lc=ch&ft=0.0&req=$keyword&fl=http%3A%2F%2Fwww.simsimi.com%2Ftalk.htm";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
  $content = json_decode(curl_exec($ch), 1);
  curl_close($ch);
  if ( $content['result'] == '200' ) {
    return $content['sentence_resp'];
  } else {
    return '我还不会回答这个问题...';
  }
}
?>