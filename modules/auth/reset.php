<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Đặt lại mật khẩu'
];
layout('header-auth', $data);

// Lấy token từ URL
$filterGet = filterData('get');
$tokenReset = $filterGet['token'] ?? '';
if(!empty($tokenReset)){
  // Kiểm tra token có hợp lệ không
  $checkToken = getOnce("SELECT * FROM users WHERE forget_token = '$tokenReset'");
  if(!empty($checkToken)){
    // Token hợp lệ, cho phép người dùng đặt lại mật khẩu
    if(isPost()){
  $filter = filterData();
  $errors = [];

  // Validate password
  if(empty(trim($filter['password']))){
    $errors['password']['required'] = 'Vui lòng nhập mật khẩu mới.';
  }else{
    if(strlen(trim($filter['password'])) < 6){
      $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }
  }

  // Validate confirm password
  if(empty(trim($filter['confirm_password']))){
    $errors['confirm_password']['required'] = 'Vui lòng nhập lại mật khẩu mới.';
  }else{
    if(trim($filter['password']) !== trim($filter['confirm_password'])){
      $errors['confirm_password']['mismatch'] = 'Mật khẩu nhập lại không khớp.';
    }
  }

  // Xử lý đặt lại mật khẩu nếu không có lỗi
  if(empty($errors)){
    // Thêm logic đặt lại mật khẩu ở đây
    $password = password_hash(trim($filter['password']), PASSWORD_DEFAULT);
    $data = [
      'password' => $password,
      'forget_token' => null, // Xóa token sau khi đặt lại mật khẩu
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $conndition = "id = ".$checkToken['id'];
    $update = update('users', $data, $conndition);
    if($update){
      setSessionFlash('msg', 'Mật khẩu của bạn đã được đặt lại thành công. Vui lòng đăng nhập lại.');
      setSessionFlash('msg_type', 'success');
    }else{
      setSessionFlash('msg', 'Đã xảy ra lỗi khi đặt lại mật khẩu. Vui lòng thử lại sau.');
      setSessionFlash('msg_type', 'danger');
    }
  }else{
    setSessionFlash('msg', 'Vui lòng kiểm tra lại thông tin bạn đã nhập.');
    setSessionFlash('msg_type', 'danger');
    setSessionFlash('old_data', $filter);
    setSessionFlash('errors', $errors);
  }
}
  }else{
    setSessionFlash('msg', 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.');
    setSessionFlash('msg_type', 'danger');
  }
}else{
  setSessionFlash('msg', 'Liên kết đặt lại mật khẩu không hợp lệ.');
  setSessionFlash('msg_type', 'danger');
}

$msg = getSessionFlash('msg');
$msgType = getSessionFlash('msg_type');
// lấy lại dữ liệu cũ và lỗi
$oldData = getSessionFlash('old_data');
$errorsArr = getSessionFlash('errors');
?>

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="<?= HOST_URL_TEMPLATES; ?>/assets/image/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <?php 
        if(!empty($msg) && !empty($msgType)){
        getMsg($msg, $msgType);
        } ?>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h2 class="fw-normal mb-5 me-3">Đặt lại mật khẩu</h2>
          </div>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" name="password" class="form-control form-control-lg"
              placeholder="Mật khẩu mới" />
              <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'password'); ?>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" name="confirm_password" class="form-control form-control-lg"
              placeholder="Nhập lại mật khẩu mới" />
              <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'confirm_password'); ?>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Gửi yêu cầu</button>
              <br>
              <a href="?module=auth&action=login">Đăng nhập</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<?php
layout('footer');