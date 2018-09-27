<?php
//CATDB 加密解密中心
header("Content-type: application/json");
if(isset($_POST["method"]) && isset($_POST["auth"]) && isset($_POST["message"]) && isset($_POST["key"]) && isset($_POST["auth"])=="5v2m4jxi"){
	$key=$_POST["key"];
	function encrypt($data, $key){
    $key    =    md5($key);
    $x        =    0;
    $len    =    strlen($data);
    $l        =    strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l) 
        {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}
function decrypt($data, $key){
    $key = md5($key);
    $x = 0;
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l) 
        {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }
        else
        {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}
	$method=$_POST["method"];
	$message=$_POST["message"];
	switch($method){
		case "encode":
			$info=array( "method" => "encode",
                        "data" => encrypt($message,$key)
						);
			break;
		case "decode":
			$info=array( "method" => "decode",
                        "data" => decrypt($message,$key)
						);
			break;
		default:
			$info="error";
			break;
	}
}
echo json_encode($info);

?>