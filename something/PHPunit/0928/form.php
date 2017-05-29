<?php
	// echo json_encode($_POST);
	// echo 'POST';
	// print_r($_POST);

	// echo 'FILE';
	// print_r($_FILES);

	if($_FILES['userpic']['error']>0){
		echo '上传的文件有错误';
	}

	//把图片移动到服务器的目录里面
	$path = './uploads/';
	$path .= date('YmdHis').mt_rand(1000,9999).$_FILES['userpic']['name'];

	$path = iconv('UTF-8', 'GB2312', $path);

	if(move_uploaded_file($_FILES['userpic']['tmp_name'],$path)){
		echo '上传成功';
	}else{
		echo '上传失败';
	}
