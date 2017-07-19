<?php
header( 'Content-Type:text/html;charset=utf-8 ');
//1.用函数打印出后天的日期，输出格式为(Y-M-D);
echo  date('Y-m-d',strtotime('+2 days'));
 echo '<hr/>';
//2.$f=2.1,用函数格式华为保留两位小数2.10；$d=10000000,用函数输出格式化整数，10,000,000
$f=2.1;
$d=10000000;
 echo number_format($f,2);
  echo '<br/>';
 echo number_format($d);
 //echo number_format($d,2,'.',',');保留小数点后两位，小数点已'.',千位分隔符已','
  echo '<hr/>';
  
  //3.语句include和require的区别是什么？为了避免多次包含同一文件，应该如何处理？可用什么函数代替他们！

// 答：  	include有条件包含，如果文件不存在会给出一个warning,但脚本会继续执行；require无条件包含，如果文件不存在会报致命错误，脚本停止执行。可用require_once或者include_once。可以检测文件是否重复包含。

//4.简单描述echo,print,print_r()之间的区别
	//答：echo 不是函数，是一个语言结构。print输入字符串，print_r 可以打印变量值本身。给出的是 array，将会按照一定格式显示键和元素。object 与数组类似。 
//5.用PHP写出显示客户端IP和服务器IP?
echo $_SERVER['REMOTE_ADDR']."<BR/>";
echo getenv('REMOTE_ADDR')."<HR/>";			//：：1说明你的电脑开启了ipv6支持,这是ipv6下的本地回环地址的表示。因为你访问的时候用的是localhost访问的，是正常情况。使用ip地址访问或者关闭ipv6支持都可以不显示这个。

//6.用函数获取http://www.baidu.com/网页内容标签<title></title>

//$content=file_get_contents("http://www.qilong.com/");

//$postb=strpos($content,'<title>')+7;
//$poste=strpos($content,'</title>');
//$length=$poste-$postb;
//echo substr($content,$postb,$length);


$c = curl_init();
$url = 'http://www.baidu.com/';
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($c);
curl_close($c);
$pos = strpos($data,'utf-8');
if($pos===false){$data = iconv("gbk","utf-8",$data);}
preg_match("/<title>(.*)<\/title>/i",$data, $title);
echo $title[1]."<hr/>";
//7.你用什么工具来进行版本控制的。请写出的用过、熟悉的PHP开源系统有哪些？模板？框架
	//答：svn,git; phpcms,ddcms,ecshop; smarty,template; ci,tp,yii,yaf
//8.写一个正则表达式，过滤网页上所有的JS脚本（即把script标记及其内容都去掉）
 preg_match("/<script.*?>.*?<\/script>/ig");
$script="以下内容不显示：";
echo preg_replace("/].*?>.*?/si", "替换内容", $script);
