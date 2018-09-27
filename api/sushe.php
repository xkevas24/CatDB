<?php
$bg_time=msectime();
function msectime() {
   list($msec, $sec) = explode(' ', microtime());
   $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	return $msectime;
}
function get_array_row($column,$array){
    $arrayiter = new RecursiveArrayIterator($array);
    $iteriter = new RecursiveIteratorIterator($arrayiter);
    $i=0;
    foreach ($iteriter as $key => $val){
        $i++;
    }
    $row=$i/$column;
    return $row;
}
//初始化
$curl = curl_init();
$handle=fopen("../table1.txt","a+");
//设置抓取的url
$stuno=$_POST["stuno"];
$svname = $_SERVER['SERVER_NAME'];
curl_setopt($curl, CURLOPT_URL, 'http://wlfw.ynudcc.cn/topstu/lab/api/qiandao_cxapi.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
$today=date("Y-m-d");
$xiaoqu=$_GET["xq"];
$dong=$_GET["d"];
$post_data = array(
    "date" => $today,
    "xiaoqu" => $xiaoqu,
    "loudong" => $dong
);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
//执行命令
$result = curl_exec($curl);
//关闭URL请求
curl_close($curl);
//显示获得的数据
//print_r($data);

$array=json_decode($result,true);

$row=get_array_row(12,$array);
$list="";
for($i=0;$i<$row;$i++){
    $data=$array[$today];
    $data=$data[$i];
    if($data["bz"]==""){
        $list=$list.$data["stuno"]."`"."1`;";
    }elseif($data["bz"]=="晚归"){
        $list=$list.$data["stuno"]."`"."2`;";
    }else{
        $list=$list.$data["stuno"]."`"."0`;";
    }

}
//$find = '20162153001';
//$start=strpos($list,$find);
//$key=substr($list,$start,15);
//echo $key;


$str=fwrite($handle,$list);
fclose($handle);

$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "0转存".$xiaoqu."校区，".$dong."数据，用时：".$tm."毫秒";


?>