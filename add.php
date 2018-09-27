<?php
echo "数据写入测试";
echo "<br>";
require("cat_bin/cat_base.php");
$api='http://wlfw.ynudcc.cn/topstu/toplab/h/catdb/api/encrypt.php';
$cat_core=cat_core_load($api);
$cat_crt=cat_core_crt("5v2m4jxi","*studb_2471");
$cat_base_core=cat_base_core($cat_crt,$cat_core);
$order="insert key=15,value=TOP,;";
echo $order;
$do=order_wake($cat_base_core,"table1.txt",$order);
cat_core_close($cat_core);
?>