<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Thiết lập giá trị cho một biến session
function setSession($key, $value){
    if(!empty(session_id())){
        $_SESSION[$key] = $value; // Lưu giá trị vào session
        return true; // Trả về true nếu thành công
    }
    return false; // Trả về false nếu session chưa được khởi động
}

// Lấy giá trị của một biến session
function getSession($key){
    if(!empty(session_id()) && isset($_SESSION[$key])){
        return $_SESSION[$key]; // Trả về giá trị của session nếu tồn tại
    }
    return null; // Trả về null nếu session chưa được khởi động hoặc không tồn tại
}

// Xoá một biến session
function unsetSession($key){
    if(!empty(session_id()) && isset($_SESSION[$key])){
        unset($_SESSION[$key]); // Xoá biến session
        return true; // Trả về true nếu thành công
    }
    return false; // Trả về false nếu session chưa được khởi động hoặc biến không tồn tại
}

// Thiết lập một biến session flash (tạm thời)
function setSessionFlash($key, $message){
    $key = $key . '_flash'; // Thêm hậu tố '_flash' vào tên biến session
    $result = setSession($key, $message); // Gọi hàm setSession để lưu giá trị
    return $result;
}

// Lấy và xoá một biến session flash
function getSessionFlash($key){
    $key = $key . '_flash'; // Thêm hậu tố '_flash' vào tên biến session
    $message = getSession($key); // Gọi hàm getSession để lấy giá trị
    unsetSession($key); // Xoá biến session sau khi lấy giá trị
    return $message; // Trả về giá trị của biến session flash
}