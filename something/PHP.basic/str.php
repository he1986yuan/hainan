<?php
/**
 * substr 用于截取字符串
 */
$a="learn php";
echo substr($a,4,3)  //其中参数“4”表示的是起始位置，参数“3”表示的是要输出的字符串的总长度

//输出结果将是：   n p

/**
 * trim 用于删除字符串两段的空白字符，和指定的字符trim($a,'')
 */

$a="learn php";
echo trim($a,"le")//其中“le"是要删除的字符
//输出结果将是：  arn php

/**
 * explode将字符串炸开的函数返回的是一个数组
 */

$pizza  = "piece1 piece2 piece3";
$pieces = explode(" ", $pizza);
echo $pieces[0]; // piece1
echo $pieces[1]; // piece2

/**
 * md5用于的字符串进行md5加密的函数，只需将需要加密的字符串作为参数即可
 */

$a="learn php";
echo md5($a);  //对$a进行md5加密

//输出结果将是：b49f68e15dea91e231f276476e409a7d

/**
 * str_replace($search,$repalce,$subject)
 * $search 寻找的目标
 * $replace用于替换的替换项
 * $subject
 * return string or array
 */
 // 赋值: <body text='black'>
$bodytag = str_replace("%body%", "black", "<body text='%body%'>");

// 赋值: Hll Wrld f PHP
$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
$onlyconsonants = str_replace($vowels, "", "Hello World of PHP");

// 赋值: You should eat pizza, beer, and ice cream every day
$phrase  = "You should eat fruits, vegetables, and fiber every day.";
$healthy = array("fruits", "vegetables", "fiber");//
$yummy   = array("pizza", "beer", "ice cream");

$newphrase = str_replace($healthy, $yummy, $phrase);//将查找道德healthy 替换为yummy

// 赋值: 2
$str = str_replace("ll", "", "good golly miss molly!", $count);
echo $count;


//返回字符串的长度
strlen();
/**
 * 将字符串中所有的元素转换成大写
 */
$str ="Mary has a little lamb and she loved shes lamb verymuch"
$str =strtoupper($str);
