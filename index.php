<?php
echo "数据读取+加密解密测试<br>";
function msectime() {
   list($msec, $sec) = explode(' ', microtime());
   $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	return $msectime;
}
require("cat_bin/cat_base.php");
$bg_time=msectime();
$api="http://wlfw.ynudcc.cn/topstu/toplab/h/catdb/api/encrypt.php";
$cat_core=cat_core_load($api);
$cat_core_crt=cat_core_crt("5v2m4jxi","*studb_2471");

$mem=cat_read_once("table1.txt",$cat_core,$cat_core_crt);
echo $mem;
echo "<br>";
/*$row=explode(";",$mem);
$row_count=count($row)-1;
for($i=0;$i<$row_count;$i++){
	$col=explode("`",$row[$i]);
	$col_count=count($col)-1;
	for($j=0;$j<$col_count;$j++){
		$cat_core_crt=cat_core_crt("5v2m4jxi","*studb_2471");
		$col[$j]=cat_core_qwer($col[$j],"read",$cat_core_crt,$cat_core);
		echo $col[$j]."|";
	}
	echo "<br>";
}*/
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "共用时：".$tm."毫秒";


cat_core_close($cat_core);

?>