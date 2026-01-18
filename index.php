<?php
error_reporting(0);// tắt báo lỗi
ini_set('display_errors', 0);// không hiển thị lỗi
date_default_timezone_set('Asia/Ho_Chi_Minh');
//echo "Current date and time: " . date('Y-m-d H:i:s');

//khởi động session
session_start();

//tránh trường hợp lỗi
ob_start(); //header, cookie

require_once 'config.php'; //khai báo hằng _THAI
require_once './includes/connect.php'; //kết nối database
require_once './includes/database.php'; //hàm thao tác database

require './includes/mailer/Exception.php';
require './includes/mailer/PHPMailer.php';
require './includes/mailer/SMTP.php';

require_once './includes/functionsc.php'; //hàm chung nâng cao
require_once './includes/functions.php'; //hàm chung
require_once './includes/session.php'; //hàm session

$module = _MODULES; // module mặc định
$action = _ACTION; // action mặc định

if(!empty($_GET['module'])){
    $module = $_GET['module'];
}
if(!empty($_GET['action'])){
    $action = $_GET['action'];
}

//nạp file điều khiển tương ứng
$path = 'modules/' . $module . '/' . $action . '.php';
if(!empty($path)){
    if(file_exists($path)){
        require_once $path;
    } else {
        require_once 'modules/errors/404.php';
    }
}else {
    require_once 'modules/errors/500.php';
}