<?php
date_default_timezone_set("Asia/Baghdad");
error_reporting(0);
require("conf.php"); 
if (!file_exists("token")) {
$token =  readline("Enter Token => ");
file_put_contents("token", $token);
}
if (!file_exists("ID")) {
$id = readline("Enter iD => ");
file_put_contents("ID", $id);
}
$sudo = file_get_contents('ID');
$token = file_get_contents('token');
$o = '1631148798';
define('API_KEY',$token);
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res,true);
}
}
$lastupdid = 1; 
while(true){ 
$upd = bot("getUpdates", ["offset" => $lastupdid]); 
if(isset($upd['result'][0])){ 
$text = $upd['result'][0]['message']['text']; 
$chat_id = $upd['result'][0]['message']['chat']['id']; 
$from_id = $upd['result'][0]['message']['from']['id']; 
$message = $upd['result'][0]['message']; 
if($text == '/start' and $chat_id != $sudo){ 
bot('sendmessage',[ 
'chat_id'=>$chat_id,  
'text'=>" Hi . This To Bot STORM 🇮🇶 
",'parse_mode' => "MarkDown", 'disable_web_page_preview' => true,
'reply_markup' => json_encode(['inline_keyboard' => [
[['text' => "STORM", 'url' => "https://t.me/R_N_G"]], 
]]) 
]);
}
if($from_id == $sudo){
if($text == '/start' or $text == '/Home' or $text == "Back"){
bot('sendvideo',['chat_id' => file_get_contents("ID"), 'video' => "https://t.me/isiraqi/24",
'caption'=>" 
The War is Begin 🧭
", 
'inline_keyboard'=>true,
'reply_markup'=>json_encode([
'keyboard'=>[

          [['text'=>'اضف يوزر']],
          [['text'=>'تسجيل حساب'],['text'=>'الارقام']],
          [['text'=>'======Good Luck======']],
          [['text'=>'حالة سليب'],['text'=>'اضف سليب']],
          [['text'=>'ايقاف'],['text'=>'تشغيل']],
          
      ] 
  ]),'resize_keyboard'=>true
]);
}
$ex = explode(':',$text);
if($ex[0] == "حالة سليب"){
	
$type = file_get_contents("type");
if($type == "sleep"){
file_put_contents('type','usleep');
}else{
file_put_contents('type','sleep');
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"حالة سليب  : ‹ ".file_get_contents("type")." › ✅
",
'inline_keyboard'=>true,
'reply_markup'=>json_encode([
'keyboard'=>[
          [['text'=>'اضف يوزر']],
          [['text'=>'تسجيل حساب'],['text'=>'الارقام']],
          [['text'=>'======Good Luck======']],
          [['text'=>'حالة سليب'],['text'=>'اضف سليب']],
          [['text'=>'ايقاف'],['text'=>'تشغيل']],
      ] 
  ]),'resize_keyboard'=>true
]);
}
$g = explode('/delete ',$text);
if($g[1] != null){ 
$data = str_replace($g[1], "", file_get_contents("accounts"));
file_put_contents("accounts", $data);
unlink("".$g[1].".madeline");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"Ok
",
]);
}
if($text == "الارقام"){
$accounts = explode("\n",file_get_contents("accounts"));
$count = count($accounts);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارقامك الحالية  : $count 
By : @R_N_G ⚡️
",
]);
}
if($text == "اضف يوزر"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل يوزر مع @
",
]);
file_put_contents('username','ok');
}
$Ex = str_replace("@","",$text);
if(file_get_contents("username") == "ok"){
if($text and $text !="اضف يوزر"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم إضافة يوزر 
",
]);
file_put_contents('username',$Ex);
}
}
if($text == "اضف سليب"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل سليب
",
]);
file_put_contents('time','ok');
}
if(file_get_contents("time") == "ok"){
if($text and $text !="ارسل سليب"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم اضافة سليب
",
]);
file_put_contents('time',$text);
}
}
if($text == "تسجيل حساب"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل اسم لرقم : ركز مثل 1
",
]);
file_put_contents('name','ok');
}
if(file_get_contents("name") == "ok"){
if($text and $text !="تسجيل حساب"){
if (file_exists("accounts")) {
file_put_contents("accounts", trim("\n$text",""),FILE_APPEND);
}
}
}
if(file_get_contents("name") == "ok"){
if($text and $text !="تسجيل حساب"){
if (!file_exists("accounts")) {
file_put_contents("accounts",$text);
}
}
}
if(file_get_contents("name") == "ok"){
if($text and $text !="تسجيل حساب"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل الرقم مثل : +55119306159
",
]);
file_put_contents("name",$text);
file_put_contents("step","2");
system('php login.php');
}
}
if($text == "تشغيل"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم تشغيل
",
]);
shell_exec("pm2 stop flood.php");
shell_exec("pm2 start flood.php");
file_put_contents('clicks',0);
}
if($text == "ايقاف"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم ايقاف 
",
]);
shell_exec("pm2 stop flood.php");
}


}
$lastupdid = $upd['result'][0]['update_id'] + 1; 
}
}
