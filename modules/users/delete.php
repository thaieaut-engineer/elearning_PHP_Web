<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

//lấy id từ đường dẫn
$getData = filterData('get');
if(!empty($getData['id'])){
    $user_id = $getData['id'];
    $checkUser = getRow("SELECT id FROM users WHERE id=$user_id");
    if($checkUser > 0){
        //cho phép xóa
        $checkToken = getRow("SELECT * FROM token_login WHERE user_id = $user_id");
        if($checkToken > 0){
            //xóa token trước
            delete('token_login', "user_id = $user_id");
        }
        //xóa người dùng
        $checkDelete = delete('users', "id = $user_id");
        if($checkDelete){
            setSessionFlash('msg', 'Xóa người dùng thành công.');
            setSessionFlash('msg_type', 'success');
            redirect('?module=users&action=list');
        }else{
            setSessionFlash('msg', 'Xóa người dùng thất bại.');
            setSessionFlash('msg_type', 'error');
            redirect('?module=users&action=list');
        }
    }else{
        //không tìm thấy người dùng
        setSessionFlash('msg', 'Người dùng không tồn tại.');
        setSessionFlash('msg_type', 'error');
        redirect('?module=users&action=list');
    }
}

?>