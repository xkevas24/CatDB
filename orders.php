<?php
echo "语法调试";
echo "<br>";
echo "<br>";
$str="update key=c,value=d where key=a;";
echo "源语句：".$str;
echo "<br>";
echo "<br>";
str_replace(";"," ;",$str);
$str=explode(";",$str)[0];
$array=explode(" ",$str);
$operation_type=$array[0];
$target=$array[1];
$qualification_info=$array[2];
$qualification=$array[3];
switch($operation_type){
	case "insert":
		$operation_type="新增数据";
		break;
	case "delete":
		$operation_type="删除数据";
		break;
	case "update":
		$operation_type="更新数据";
		break;
}

switch($qualification_info){
	case "where":
		$qualification_info="是";
		break;
	default:
		$qualification_info="否";
		break;
}

echo "解读如下：";
echo "<br>";
echo "<br>";
echo "操作类型:".$operation_type;
echo "<br>";
echo "靶目标:".$target;
echo "<br>";
echo "是否有限定条件:".$qualification_info;
echo "<br>";
echo "限定条件:".$qualification;
echo "<br>";

?>