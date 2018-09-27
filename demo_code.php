<?php
$curl = curl_init();
$svname = $_SERVER['SERVER_NAME'];
//curl_setopt($curl, CURLOPT_URL, 'http://192.168.103.3/smdb/api/encrypt.php');  校园网
curl_setopt($curl, CURLOPT_URL, 'http://wlfw.ynudcc.cn/topstu/toplab/h/catdb/api/encrypt.php');  //公网
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_ENCODING ,'utf-8');
curl_setopt($curl, CURLOPT_POST, 1);
$post_data = array(
    "method" => "encode",
    "auth" => "5v2m4jxi",
    "message" => "message_test",
    "key" => "*studb_2471"
);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
$message = json_decode(curl_exec($curl),true)[data];
echo "密文:".$message."<br>";

$post_data = array(
    "method" => "decode",
    "auth" => "5v2m4jxi",
    "message" => $message,
    "key" => "*studb_2471"
);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
$message = json_decode(curl_exec($curl),true)[data];
echo "明文:".$message."<br>";
curl_close($curl);