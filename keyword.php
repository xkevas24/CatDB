<?php
$bg_time=msectime();
function msectime() {
   list($msec, $sec) = explode(' ', microtime());
   $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	return $msectime;
}




$dbfile = fopen("table1.txt", "r") or die("无法连接表格");
$mem=fread($dbfile,filesize("table1.txt"));
fclose($dbfile);

$find = $_GET["stuno"];
$start=strpos($mem,$find);
$key=substr($mem,$start,15);
	$stuno=substr($key,0,11);
if($stuno==$find){
$status=substr($key,12,1);
switch($status){
	case 0:
		echo "已请假";
		break;
	case 1:
		echo "已签到";
		break;
	case 2:
		echo "晚归";
		break;
}
}else{
	echo "未签到";
}
//echo "<br>"; 

//echo $key;
echo "<br>";
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "用时：".$tm."毫秒";


?>