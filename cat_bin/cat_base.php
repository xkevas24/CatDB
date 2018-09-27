<?php
require "cat_core.php";
function cat_table($table){
    $table="cat_table/".$table;
    return $table;
}

function cat_base_core($cat_crt,$cat_core){
    $array=array("crt"=>$cat_crt,"core"=>$cat_core);
    return $array;
}

function cat_user_table($table){
    return $table;
}

function cat_user_tanle_connect($table){
    $dbfile = fopen($table, "r") or die("Connection failed!");
    return $dbfile;
}

//增
function cat_insert_once($key,$value,$table,$cat_base_core){
    $cat_crt=$cat_base_core["crt"];
    $cat_core=$cat_base_core["core"];
    $key=cat_core_qwer($key,"write",$cat_crt,$cat_core);
    $value=cat_core_qwer($value,"write",$cat_crt,$cat_core);
    $data=$key."`".$value."`;";
    $tb=fopen($table,"a+") or die("Connection failed!");
    fwrite($tb,$data);
    cat_order_end($tb);
}

function cat_insert_start($table){
    $tb=fopen($table,"a+") or die("Connection failed!");
    return $tb;
}

function cat_insert_write($key,$value,$tb,$cat_base_core){
    $cat_crt=$cat_base_core["crt"];
    $cat_core=$cat_base_core["core"];
    $key=cat_core_qwer($key,"write",$cat_crt,$cat_core);
    $value=cat_core_qwer($value,"write",$cat_crt,$cat_core);
    $data=$key."`".$value."`;";
    fwrite($tb,$data);
}

//删

//改

//查
function cat_read_once($table,$cat_core,$cat_core_crt){
    $dbfile = fopen($table, "r") or die("Connection failed!");
    $data=fread($dbfile,filesize($table));
    fclose($dbfile);
    $row=explode(";",$data);
    $row_count=count($row)-1;
    $feed="";
    for($i=0;$i<$row_count;$i++){
        $col=explode("`",$row[$i]);
        $col_count=count($col)-1;
        for($j=0;$j<$col_count;$j++){
            $col[$j]=cat_core_qwer($col[$j],"read",$cat_core_crt,$cat_core);
            $feed=$feed.$col[$j]."`";
        }
        $feed=$feed.";";
    }
    return $feed;
}
function cat_read_where($table,$head,$val,$cat_core,$cat_core_crt){
    $dbfile = fopen($table, "r") or die("Connection failed!");
    $data=fread($dbfile,filesize($table));
    fclose($dbfile);

    $val=cat_core_qwer($val,"write",$cat_core_crt,$cat_core);

    $start=strpos($data,$val);
    return start;
}


function cat_order_end($table){
    fclose($table);
}

//指令执行
function order_wake($cat_base_core,$table,$order){
    $wake=order_work($order);
    switch ($wake["ot"]){
        case "insert";
            $target=$wake["tg"];
            $tg_array=explode(",",$target);
            $key=$tg_array[0];
            $value=$tg_array[1];
            cat_insert_once($key,$value,$table,$cat_base_core);
            break;
        case "read":


    }
}
