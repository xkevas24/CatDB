<?php
echo "<div align='center'><h1>TOP-CatDB1.0</h1></div><br>";

echo "<h3>CatDB是一个自主研发的文件型的NoSQL（只处理key-value键值对），以加密文件的形式存储在硬盘上。因此该数据库可以方便地进行转移。如果对其读写速度有要求，可以将其转移至内存盘上。CatDB依赖于PHP，采用PHP编写的语法解释器和指令方法。</h3>";

?>
<h2>第一步、连接数据库</h2>
<code>
    require("cat_bin/cat_base.php");<br>
    $cat_core=cat_core_load($api);<br>
    $cat_core_crt=cat_core_crt("加密密钥","数据库密码");<br>
    $cat_base_core=cat_base_core($cat_core_crt,$cat_core);<br>
</code>
    <br>
<p>先引入cat_base.php头文件，然后使用cat_core_load()，cat_core_crt()，cat_base_core()三个方法来创建连接。</p>

    <h2>第二步、编写并执行语句</h2>
    <code>
        $order="insert key=".time().",value=余梓豪;";<br>
        order_wake($cat_base_core,"连接的数据表",$order);<br>
    </code>
    <br>
    <p>执行语句很简单，先编写语句，然后使用order_wake()命令，连接相关的表格并执行。</p>

    <h2>第三步、关闭数据库连接</h2>
    <code>
        cat_core_close($cat_core);<br>
    </code>
    <br>
    <p>使用cat_core_close()命令关闭数据库文件句柄。关闭后需要再次连接数据库方能正常读取数据。</p>

<h3>示例代码</h3>
<?php
require("cat_bin/cat_base.php");
$bg_time=msectime();
$api="http://192.168.103.3/toplab/h/catdb/api/encrypt.php";
$cat_core=cat_core_load($api);
$cat_core_crt=cat_core_crt("5v2m4jxi","*studb_2471");
$cat_base_core=cat_base_core($cat_core_crt,$cat_core);

echo "1、insert 命令<br>";
echo "通过<code>insert key=".time().",value=余梓豪;</code>来测试向数据库catdb插入数据。返回false为操作失败，返回true为操作成功。";
$bg_time=msectime();
echo "<br>";
$order="insert key=".time().",value=余梓豪;";
echo "语法：".$order."<br>";
$do=order_work($order);
echo "解释器：";
print_r($do);
echo "<br>";
$do=order_wake($cat_base_core,"cat.cdb",$order);
$ed_time=msectime();
//cat_core_close($cat_core);
$tm=$ed_time-$bg_time;
echo "共写入1条数据，用时：".$tm."毫秒";
echo "<br><br><br>";

echo "2、select 命令<br>";
echo "通过<code>select;</code>命令来取出catdb的所有数据，并以json格式输出";
$bg_time=msectime();
$order="select;";
order_wake($cat_base_core,"cat.cdb",$order);
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "<br>共用时：".$tm."毫秒";

echo "<br><br><br>";

echo "2、select key=?命令<br>";
echo "通过<code>select key=1568771207;</code>命令来取出catdb的所有数据，并以json格式输出";
$bg_time=msectime();
$order="select key=1568771207;";
order_wake($cat_base_core,"cat.cdb",$order);
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "<br>共用时：".$tm."毫秒";

echo "<br><br>3、delete 命令<br>";
echo "通过<code>delete key=1568771207;</code>命令来删除catdb的部分或全部数据。返回false为操作失败，返回true为操作成功。此命令已注释掉了。";
$bg_time=msectime();
$order="delete key=1568771207;";
order_wake($cat_base_core,"cat.cdb",$order);
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "<br>共用时：".$tm."毫秒";

echo "<br><br>4、delete *;命令<br>";
echo "通过<code> *;</code>命令来删除catdb的全部数据。返回false为操作失败，返回true为操作成功。此命令已注释掉了。";
/*
 * $bg_time=msectime();
 * $order="delete *;";
order_wake($cat_base_core,"cat.cdb",$order);
$ed_time=msectime();
$tm=$ed_time-$bg_time;
echo "<br>共用时：".$tm."毫秒";
*/
cat_core_close($cat_core);
?>