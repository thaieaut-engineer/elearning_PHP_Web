<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

try {
	if(class_exists('PDO')){
		$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", //hỗ trợ về tiếng Việt
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //đẩy lỗi vào ngoại lệ
	);
    $dns = $driver . ':host='.$host."; dbname=".$db;
	$conn = new PDO ($dns , $user, $pass, $option);
    }
 } catch (Exception $ex) {
	echo 'Lỗi kết nối '. $ex->getMessage();
}