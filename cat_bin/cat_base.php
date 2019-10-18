<?php
require "cat_core.php";
function cat_table($table){
    $table="cat_table/".$table;
    return $table;
}

function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}

function cat_base_core($cat_crt,$cat_core){
    $array=array("crt"=>$cat_crt,"core"=>$cat_core);
    return $array;
}

function cat_user_table($table){
    return $table;
}

function cat_user_table_connect($table){
    $dbfile = fopen($table, "r") or die("Connection failed!Unable to open table:".$table." with mode r,using function cat_user_table_connect.");
    return $dbfile;
}

//增
function cat_insert_once($key,$value,$table,$cat_base_core){
    $cat_crt=$cat_base_core["crt"];
    $cat_core=$cat_base_core["core"];
    $key=cat_core_qwer($key,"write",$cat_crt,$cat_core);
    $value=cat_core_qwer($value,"write",$cat_crt,$cat_core);
    $data=$key."`".$value."`;";
    $tb=fopen($table,"a+") or die("Connection failed!Unable to open table:".$table." with mode a+,using function cat_insert_once.");
    fwrite($tb,$data);
    cat_order_end($tb);
}

function cat_insert_start($table){
    $tb=fopen($table,"a+") or die("Connection failed!Unable to open table:".$table." with mode a+,using function cat_insert_start.");
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
    $dbfile = fopen($table, "r") or die("Connection failed!Unable to open table:".$table." with mode r,using function cat_read_once.");
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

function cat_trans_once($data,$cat_core,$cat_core_crt){
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

function cat_read_origin($table,$cat_core,$cat_core_crt){
    $dbfile = fopen($table, "r") or die("Connection failed!Unable to open table:".$table." with mode r,using function cat_read_once.");
    $data=fread($dbfile,filesize($table));
    fclose($dbfile);
    return $data;
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
    $cat_crt=$cat_base_core["crt"];
    $cat_core=$cat_base_core["core"];
    $wake=order_work($order);
    //$tmp=cat_read_once($table,$cat_core,$cat_crt);
    switch ($wake["ot"]){
        case "insert":
            switch ($wake["iq"]){
                case "1":
                    $qualification=$wake["q"];
                    switch ($qualification){
                        case "key_increase":
                            //键自增
                            //1.读取全表


                            break;
                        case "key_no_repeat":
                            //键不重复条件

                            break;
                        case "value_no_repeat":
                            //值不重复条件
                            break;
                        default:
                            //复合条件
                            break;
                    }
                    break;
                case "0":
                    $target=$wake["tg"];
                    $tg_array=explode(",",$target);
                    $key=$tg_array[0];
                    $value=$tg_array[1];
                    cat_insert_once($key,$value,$table,$cat_base_core);
                    break;
            }
            break;
        case "select":
            $tmp=cat_read_once($table,$cat_core,$cat_crt);
            switch ($wake["iq"]){
                case "1":
                    break;
                case "0":
                    if($wake["tg"]<>""){
                        $tmp_origin=cat_read_origin($table,$cat_core,$cat_crt);
                        $target=$wake["tg"];
                        $key=cat_core_qwer($target,"write",$cat_crt,$cat_core);
                        //通过正则表达式锁定key所在的行
                        $match=array();
                        if(preg_match('/('.$key.')`((\w+)|(\w+)[0-9])`;/', $tmp_origin, $match)){
                            $preg_line=$match[0];
                            //将密文转为明文
                            $memo=cat_trans_once($preg_line,$cat_core,$cat_crt);
                            $row=explode(";",$memo);
                            $row_count=count($row)-1;   //除去最后一行多余行
                            //提取第一行数据
                            $col=explode("`",$row[0]);
                            $col_count=count($col)-1;

                            //分离键值
                            $array_key=array();
                            for($c=0;$c<$col_count;$c++){
                                $key=explode("=",$col[$c])[0];
                                array_push($array_key,$key);
                            }
                            $array_table=array();
                            for($r=0;$r<$row_count;$r++){
                                unset($row_array);
                                $row_array=array();
                                $col=explode("`",$row[$r]);
                                unset($col_array);
                                for($c=0;$c<$col_count;$c++){

                                    $key=explode("=",$col[$c])[0];
                                    $value=explode("=",$col[$c])[1];

                                    //将列的键值输出到行
                                    $col_array[$key]=$value;
                                    //将行的数组插入至表

                                }
                                array_push($row_array,$col_array);
                                array_push($array_table,$row_array[0]);
                            }
                            echo json_encode($array_table);
                        }else{
                            echo "0";
                        }



                    }else{
                        $row=explode(";",$tmp);
                        $row_count=count($row)-1;   //除去最后一行多余行
                        //提取第一行数据
                        $col=explode("`",$row[0]);
                        $col_count=count($col)-1;

                        //分离键值
                        $array_key=array();
                        for($c=0;$c<$col_count;$c++){
                            $key=explode("=",$col[$c])[0];
                            array_push($array_key,$key);
                        }
                        $array_table=array();
                        for($r=0;$r<$row_count;$r++){
                            unset($row_array);
                            $row_array=array();
                            $col=explode("`",$row[$r]);
                            unset($col_array);
                            for($c=0;$c<$col_count;$c++){

                                $key=explode("=",$col[$c])[0];
                                $value=explode("=",$col[$c])[1];

                                //将列的键值输出到行
                                $col_array[$key]=$value;
                                //将行的数组插入至表

                            }
                            array_push($row_array,$col_array);
                            array_push($array_table,$row_array[0]);
                        }
                        echo json_encode($array_table);
                    }
                    break;
            }
            break;


        case "delete":
            if($wake["tg"]=="*"){
                $thedb = fopen($table, "w") or die("Unable to open file!");
                fwrite($thedb, "");
                fclose($thedb);
            }else{
                $tmp_origin=cat_read_origin($table,$cat_core,$cat_crt);
                $target=$wake["tg"];
                $key=cat_core_qwer($target,"write",$cat_crt,$cat_core);
                //通过正则表达式锁定key所在的行
                $flag = preg_replace('/('.$key.')`((\w+)|(\w+)[0-9])`;/', '', $tmp_origin);
                //覆盖文件
                $thedb = fopen($table, "w") or die("Unable to open file!");
                fwrite($thedb, $flag);
                fclose($thedb);
            }
            break;

    }
}