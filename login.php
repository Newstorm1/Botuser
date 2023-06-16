<?php
date_default_timezone_set("Asia/Baghdad");
if (!file_exists('madeline.php')) {
 copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
define('MADELINE_BRANCH', 'deprecated');
include 'madeline.php';  
$settings['app_info']['api_id'] = 22545177;  
$settings['app_info']['api_hash'] = '4b501c6d1939cd05bdeea2d1b756c5a8';  
$name = file_get_contents("name");
$MadelineProto = new \danog\MadelineProto\API(''.$name.'.madeline', $settings);  
require("conf.php"); 
$TT = file_get_contents("token");
$tg = new Telegram("$TT");
$lastupdid = 1; 
while(true){ 
 $upd = $tg->vtcor("getUpdates", ["offset" => $lastupdid]); 
 if(isset($upd['result'][0])){ 
  $text = $upd['result'][0]['message']['text']; 
  $chat_id = $upd['result'][0]['message']['chat']['id']; 
$from_id = $upd['result'][0]['message']['from']['id']; 
$n = file_get_contents("name");
if($from_id == $from_id){
try{
if(file_get_contents("step") == "2"){
if($text !== $n){
$MadelineProto->phoneLogin($text);
$tg->vtcor('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"كود : مثال : 55665",
]);
file_put_contents("step","3");
}
}elseif(file_get_contents("step") == "3"){
if($text){
$authorization = $MadelineProto->completePhoneLogin($text);
if ($authorization['_'] === 'account.password') {
$tg->vtcor('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"ارسل تحقق",
]);
file_put_contents("step","4");
}else{
$tg->vtcor('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"تم تسجيل بنجاح",
]);
file_put_contents("step","");
exit;
}
}
}elseif(file_get_contents("step") == "4"){
if($text){
$authorization = $MadelineProto->complete2falogin($text);
$tg->vtcor('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"تم تسجيل بنجاح",
]);
file_put_contents("step","");
exit;
}
}
}catch(Exception $e) {
  $tg->vtcor('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"خطا",
]);
exit;
}}
$lastupdid = $upd['result'][0]['update_id'] + 1;
}
}