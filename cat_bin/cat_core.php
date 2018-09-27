<?php
function cat_core_load($api){
    $cat_core = curl_init();
    //curl_setopt($cat_core, CURLOPT_URL, 'http://192.168.103.3/smdb/api/encrypt.php');  校园网
    curl_setopt($cat_core, CURLOPT_URL, $api);  //公网
    curl_setopt($cat_core, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cat_core,CURLOPT_ENCODING ,'utf-8');
    curl_setopt($cat_core, CURLOPT_POST, 1);
    return $cat_core;
}

function cat_core_close($cat_core){
    curl_close($cat_core);
}

function cat_core_crt($auth,$key){
    $cat_core_crt=array("auth"=>$auth,"key"=>$key);
    return $cat_core_crt;
}

function cat_core_qwer($message,$method,$cat_core_crt,$cat_core){
    switch ($method){
        case "read":
            $method="decode";
            break;
        case "write":
            $method="encode";
            break;
    }

    $auth=$cat_core_crt["auth"];
    $key=$cat_core_crt["key"];
    $post_data = array(
        "method" => $method,
        "auth" => $auth,
        "message" => $message,
        "key" => $key
    );
    curl_setopt($cat_core, CURLOPT_POSTFIELDS, $post_data);
    $result = json_decode(curl_exec($cat_core),true)["data"];
    return $result;
}

/*function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}*/

function order_work($order){
    str_replace(";"," ;",$order);
    $order=explode(";",$order)[0];
    $array=explode(" ",$order);
    $operation_type=$array[0];
    $target=$array[1];
    $qualification_info=$array[2];
    $qualification=$array[3];
    switch($operation_type){
        case "insert":
            $operation_type="insert";
            break;
        case "delete":
            $operation_type="delete";
            break;
        case "update":
            $operation_type="update";
            break;
    }

    switch($qualification_info){
        case "where":
            $qualification_info=1;
            break;
        default:
            $qualification_info=0;
            break;
    }
    $result=array(
      "ot"=> $operation_type,
      "tg"=>$target,
        "iq"=>$qualification_info,
        "q"=>$qualification
    );
    return $result;
}
