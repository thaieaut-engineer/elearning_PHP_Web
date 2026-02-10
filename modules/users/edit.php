<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Sửa người dùng',
];

layout('header', $data);

$getData = filterData('get');
if(!empty($getData['id'])){
    $user_id = (int)$getData['id'];
    $detailUser = getOnce("SELECT * FROM users WHERE id = $user_id");
    if(empty($detailUser)){
        setSessionFlash('msg', 'Người dùng không tồn tại.');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=users&action=list');
    }
}else{
    setSessionFlash('msg', 'ID người dùng không hợp lệ.');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=users&action=list');
}

if(isPost()){
  $filter = filterData();
  $errors = [];

  // Validate name
  if(empty(trim($filter['fullname']))){
    $errors['fullname']['required'] = 'Vui lòng nhập họ tên.';
  }else{
    if(strlen(trim($filter['fullname'])) < 3){
      $errors['fullname']['min'] = 'Họ tên phải có ít nhất 3 ký tự.';
    }
    if(strlen(trim($filter['fullname'])) > 50){
      $errors['fullname']['max'] = 'Họ tên không được vượt quá 50 ký tự.';
    }
  }

if($filter['email'] != $detailUser['email']){
    // Validate email
  if(empty(trim($filter['email']))){
    $errors['email']['required'] = 'Vui lòng nhập địa chỉ email.';
}else{
    if(!validateEmail(trim($filter['email']))){
      $errors['email']['invalid'] = 'Địa chỉ email không hợp lệ.';
    }else{
      $email = trim($filter['email']);
      $checkEmail = getRow("SELECT * FROM users WHERE email = '$email'");
      if($checkEmail > 0){
        $errors['email']['exists'] = 'Địa chỉ email đã được sử dụng.';
      }
    }
  }
}

  // Validate phone
  if(empty(trim($filter['phone']))){
    $errors['phone']['required'] = 'Vui lòng nhập số điện thoại.';
  }else{
    if(!validatePhone(trim($filter['phone']))){
      $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ.';
  }
  }

  // Validate password
  if(!empty(trim($filter['password']))){
    if(strlen(trim($filter['password'])) < 6){
      $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }
  }

  if(empty($errors)){
    $data = [
        'fullname' => trim($filter['fullname']),
        'email' => trim($filter['email']),
        'phone' => trim($filter['phone']),
        
        'address' => (!empty(trim($filter['address'])) ? trim($filter['address']) : null),
        'group_id' => (int)$filter['group_id'],
        'status' => (int)$filter['status'],
        'updated_at' => date('Y-m-d H:i:s'),
    ];
    if(!empty(trim($filter['password']))){
        $data['password'] = password_hash(trim($filter['password']), PASSWORD_DEFAULT);
    }

    $update = update('users', $data, "id = $user_id");
    if($update){
        setSessionFlash('msg', 'Sửa tài khoản thành công.');
        setSessionFlash('msg_type', 'success');
        redirect('?module=users&action=list');
    }else{
        setSessionFlash('msg', 'Sửa tài khoản thất bại. Vui lòng thử lại.');
        setSessionFlash('msg_type', 'danger');
        setSessionFlash('old_data', $filter);
    }
  }else{
    setSessionFlash('msg', 'Sửa tài khoản thất bại. Vui lòng kiểm tra lại thông tin.');
    setSessionFlash('msg_type', 'danger');
    setSessionFlash('old_data', $filter);
    setSessionFlash('errors', $errors);
}

}

$msg = getSessionFlash('msg');
$msgType = getSessionFlash('msg_type');

// lấy lại dữ liệu cũ và lỗi
$oldData = getSessionFlash('old_data');
if(!empty($detailUser)){
    $oldData = $detailUser;
}
$errorsArr = getSessionFlash('errors');

?>

<div class="container">
    <h2 class="mb-4">Thêm người dùng</h2>
    <?php 
        if(!empty($msg) && !empty($msgType)){
        getMsg($msg, $msgType);
        } ?>
    <form action="" method="post">
        <div class="row">
        <div class="col-6 pb-3">
            <label for="fullname">Họ và tên</label>
            <input id="fullname" name="fullname" type="text" class="form-control" value="<?php 
            if (!empty($oldData))
            echo oldData($oldData, 'fullname'); ?>" placeholder="Họ tên">
            <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'fullname'); ?>
        </div>
        <div class="col-6 pb-3">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="<?php 
            if (!empty($oldData))
            echo oldData($oldData, 'email'); ?>" placeholder="Email">
            <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'email'); ?>
        </div>
        <div class="col-6 pb-3">
            <label for="phone">Số điện thoại</label>
            <input id="phone" name="phone" type="text" class="form-control" value="<?php 
            if (!empty($oldData))
            echo oldData($oldData, 'phone'); ?>" placeholder="Số điện thoại">
            <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'phone'); ?>
        </div>
        <div class="col-6 pb-3">
            <label for="password">Mật khẩu</label>
            <input id="password" name="password" type="password" class="form-control" value="" placeholder="Mật khẩu">
            <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'password'); ?>
        </div>
        <div class="col-6 pb-3">
            <label for="address">Địa chỉ</label>
            <input id="address" name="address" type="text" class="form-control" value="<?php 
            if (!empty($oldData))
            echo oldData($oldData, 'address'); ?>" placeholder="Địa chỉ">
        </div>
        <div class="col-3 pb-3">
            <label for="group">Nhóm</label>
            <select id="group" name="group_id" class="form-select form-control">
                <?php
                $getGroup = getAll("SELECT * FROM groups");
                foreach($getGroup as $item):
                ?>
                <option value="<?= $item['id']; ?>" <?php if(!empty($oldData) && $oldData['group_id'] == $item['id']) echo 'selected'; ?> ><?= $item['name']; ?></option>
                <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="col-3 pb-3">
            <label for="status">Trạng thái</label>
            <select id="status" name="status" class="form-select form-control">
                <option value="0" <?php if(!empty($oldData) && $oldData['status'] == 0) echo 'selected'; ?> >Chưa kích hoạt</option>
                <option value="1" <?php if(!empty($oldData) && $oldData['status'] == 1) echo 'selected'; ?> >Đã kích hoạt</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Xác nhận</button>
    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Quay lại</button>
    </form>
</div>

<?php
layout('footer', $data);