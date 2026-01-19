<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Set the page title and include the header layout
$data = [
    'title' => 'Đăng nhập hệ thống'
];
layout('header-auth', $data);

if(isPost()){
  $filter = filterData();
  $errors = [];

  // Validate email
  if(empty(trim($filter['email']))){
    $errors['email']['required'] = 'Vui lòng nhập địa chỉ email.';
}else{
    if(!validateEmail(trim($filter['email']))){
      $errors['email']['invalid'] = 'Địa chỉ email không hợp lệ.';
    }
  }

  // Validate password
  if(empty(trim($filter['password']))){
    $errors['password']['required'] = 'Vui lòng nhập mật khẩu.';
  }else{
    if(strlen(trim($filter['password'])) < 6){
      $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }
  }
  // If there are validation errors, store them in session and redirect back to the login page
  if(empty($errors)){
    setSessionFlash('msg', 'Đăng nhập thành công.');
    setSessionFlash('msg_type', 'success');
}else{
    setSessionFlash('msg', 'Đăng nhập thất bại. Vui lòng kiểm tra lại email và mật khẩu.');
    setSessionFlash('msg_type', 'danger');
    setSessionFlash('old_data', $filter);
    setSessionFlash('errors', $errors);
}

$msg = getSessionFlash('msg');
$msgType = getSessionFlash('msg_type');
// lấy lại dữ liệu cũ và lỗi
$oldData = getSessionFlash('old_data');
$errorsArr = getSessionFlash('errors');
}
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
            <h2 class="fw-normal mb-5 me-3">Đăng nhập hệ thống</h2>
          </div>

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" name="email" id="form3Example3" value="<?php 
            if (!empty($oldData))
            echo oldData($oldData, 'email'); ?>" class="form-control form-control-lg"
              placeholder="Địa chỉ email" />
              <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'email'); ?>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Nhập mật khẩu" />
              <?php 
              if (!empty($errorsArr))
              echo formError($errorsArr, 'password'); ?>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?= HOST_URL; ?>?module=auth&action=forgot" class="text-body">Quên mật khẩu?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Chưa có tài khoản? <a href="<?= HOST_URL; ?>?module=auth&action=register"
                class="link-danger">Đăng ký</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<?php
layout('footer');