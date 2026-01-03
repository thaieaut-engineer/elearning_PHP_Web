<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
//echo "Current date and time: " . date('Y-m-d H:i:s');

//khởi động session
session_start();

//tránh trường hợp lỗi
ob_start(); //header, cookie

//kiểm tra truy cập có hợp lệ
require_once 'config.php'; //khai báo hằng _THAI