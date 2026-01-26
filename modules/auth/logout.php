<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Set the page title and include the header layout
$data = [
    'title' => 'Đăng nhập hệ thống'
];

if(checkLogin()){
    $token = getSession('token_login');
    $remoToken = delete('token_login', "token = '$token'");
    
    if($remoToken){
        // Xóa session
        removeSession('token_login');
        
        // Chuyển hướng về trang đăng nhập
        redirect('?module=auth&action=login');
    }else{
        setSessionFlash('msg', 'Đăng xuất không thành công. Vui lòng thử lại.');
        setSessionFlash('msg_type', 'danger');
    }
}else{
    setSessionFlash('msg', 'Bạn chưa đăng nhập.');
    setSessionFlash('msg_type', 'danger');
}