<?php
// 毫秒级时间戳
function msectime() {
   list($msec, $sec) = explode(' ', microtime());
   $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	return $msectime;
}

echo msectime();
echo "<br>";
sleep(2);

echo msectime();
//调用
//$a=getMillisecond();
//$b=getMillisecond();
//echo $t1;
//echo "<br>";
//echo $t2;
?>