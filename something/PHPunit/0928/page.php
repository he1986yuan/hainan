<?php
	header("Content-Type:text/html;charset=utf-8");
	$link = mysql_connect("localhost","root","");
	mysql_select_db("ask",$link);
	mysql_query("set names utf8");

	//接收ajax传递的当前的页数
	$page = intval($_POST['page']);

	//计算总的记录数
	$result = mysql_query("SELECT count(*) AS num FROM ask_food");
	$arr = mysql_fetch_assoc($result);
	$total_rows = $arr['num'];

	// var_dump($arr);
	//计算每页显示的记录数
	$page_size = 4;

	//计算有多少页
	$total_pages = ceil($total_rows / $page_size);

	$page_start = ($page - 1)*$page_size;

	$sql = "SELECT * FROM ask_food LIMIT $page_start,$page_size";

	$result = mysql_query($sql);

	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		$arr[] = $row;
	}
	
	$data['total_rows'] = $total_rows;
	$data['total_pages'] = $total_pages;
	$data['cur_page'] = $page;
	$data['list'] = $arr;

	echo json_encode($data);

