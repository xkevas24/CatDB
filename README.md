# CatDB
CatDB应是一款开源的、依赖于WEB应用的、以内存方式进行数据交互的关系型数据库。这将是一款独立的、可移植的产品，尽力使其满足MySQL的基本功能和Memcached的读写速度。CatDB将拥有独立的语法，风格上会尽力参照MySQL。
<br>
目录解释：<br>
/cat_bin  CatDB的核心组件<br>
/cat_table CatDB的数据库结构目录<br>
/api 扩展功能的接口目录<br>
<br>
<br>
开发日志：<br>
2018/9/27 结构确定<br>
<br>
CatDB是一个自主研发的文件型的NoSQL（只处理key-value键值对），以加密文件的形式存储在硬盘上。因此该数据库可以方便地进行转移。如果对其读写速度有要求，可以将其转移至内存盘上。CatDB依赖于PHP，采用PHP编写的语法解释器和指令方法。<br>
第一步、连接数据库<br>
<code>
require("cat_bin/cat_base.php");<br>
$cat_core=cat_core_load($api);<br>
$cat_core_crt=cat_core_crt("加密密钥","数据库密码");<br>
$cat_base_core=cat_base_core($cat_core_crt,$cat_core);<br>
</code>

先引入cat_base.php头文件，然后使用cat_core_load()，cat_core_crt()，cat_base_core()三个方法来创建连接。<br>

第二步、编写并执行语句<br>
<code>
$order="insert key=".time().",value=余梓豪;";<br>
order_wake($cat_base_core,"连接的数据表",$order);<br>
</code>
执行语句很简单，先编写语句，然后使用order_wake()命令，连接相关的表格并执行。<br>

第三步、关闭数据库连接<br>
<code>
cat_core_close($cat_core);<br>
</code>
使用<code>cat_core_close()</code>命令关闭数据库文件句柄。关闭后需要再次连接数据库方能正常读取数据。<br>

示例代码<br>
1、insert 命令<br>
通过<code>insert key=1571372926,value=余梓豪;</code>来测试向数据库catdb插入数据。返回false为操作失败，返回true为操作成功。
语法：<code>insert key=1571372926,value=余梓豪;</code>;
解释器：Array ( [ot] => insert [tg] => key=1571372926,value=余梓豪 [iq] => 0 [q] => )
共写入1条数据，用时：7毫秒


2、select 命令<br>
通过select;命令来取出catdb的所有数据，并以json格式输出
<code>
[{"key":"1568771204","value":"\u4f59\u6893\u8c6a"},{"key":"1568771205","value":"\u4f59\u6893\u8c6a"},{"key":"1568771205","value":"\u4f59\u6893\u8c6a"},{"key":"1568771205","value":"\u4f59\u6893\u8c6a"},{"key":"1568771206","value":"\u4f59\u6893\u8c6a"},{"key":"1568771206","value":"\u4f59\u6893\u8c6a"},{"key":"1568771206","value":"\u4f59\u6893\u8c6a"},{"key":"1568771206","value":"\u4f59\u6893\u8c6a"},{"key":"1568771295","value":"\u4f59\u6893\u8c6a"},{"key":"1568771298","value":"\u4f59\u6893\u8c6a"},{"key":"1568771299","value":"\u4f59\u6893\u8c6a"},{"key":"1568771305","value":"\u4f59\u6893\u8c6a"},{"key":"1568771439","value":"\u4f59\u6893\u8c6a"},{"key":"1568771529","value":"\u4f59\u6893\u8c6a"},{"key":"1568771770","value":"\u4f59\u6893\u8c6a"},{"key":"1568771790","value":"\u4f59\u6893\u8c6a"},{"key":"1568771852","value":"\u4f59\u6893\u8c6a"},{"key":"1568771882","value":"\u4f59\u6893\u8c6a"},{"key":"1568799997","value":"\u4f59\u6893\u8c6a"},{"key":"1571372926","value":"\u4f59\u6893\u8c6a"}]
</code>
共用时：40毫秒<br>


2、<code>select key=?</code>命令<br>
通过select key=1568771207;命令来取出catdb的所有数据，并以json格式输出0
共用时：31毫秒

3、<code>delete</code> 命令<br>
通过delete key=1568771207;命令来删除catdb的部分或全部数据。返回false为操作失败，返回true为操作成功。此命令已注释掉了。
共用时：1毫秒

4、<code>delete *</code>;命令<br>
通过 *;命令来删除catdb的全部数据。返回false为操作失败，返回true为操作成功。此命令已注释掉了。
