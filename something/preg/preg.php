<?php
//写出匹配URL的正则表达式.
$reg =/^[a-zA-z]+:\/\/(\w+(-\w+)*)(\.(\w+(-\w+)*))*(\?\S*)?/ ;

//请用正则表达式（Regular Expression）写一个函数验证电子邮件的格式是否正确。
if(isset($_POST['action']) && $_POST['action']=='submitted'){
	$email=$_POST['email'];
	if(!preg_match("/^(?:w+.?)*w+@(?:w+.?)*w+$/",$email)){
		echo "电子邮件检测失败";
	}else{
		echo "电子邮件检测成功";
	}
}





 ?>
