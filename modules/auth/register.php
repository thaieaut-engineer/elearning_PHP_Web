<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Đăng ký tài khoản'
];
layout('header-auth', $data);

$msg = '';
$msgType = '';
$errorsArr = [];

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

  // Validate phone
  if(empty(trim($filter['phone']))){
    $errors['phone']['required'] = 'Vui lòng nhập số điện thoại.';
  }else{
    if(!validatePhone(trim($filter['phone']))){
      $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ.';
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

  // Validate confirm password
  if(trim($filter['password']) !== $filter['confirm_password']){
    $errors['confirm_password']['mismatch'] = 'Mật khẩu xác nhận không khớp.';
  }

  if(empty($errors)){
    $msg = 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.';
    $msgType = 'success';
  }else{
    $msg = 'Đăng ký tài khoản thất bại. Vui lòng kiểm tra lại thông tin.';
    $msgType = 'danger';

    setSessionFlash('errors', $errors);
}
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
        <?php getMsg($msg, $msgType); ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h2 class="fw-normal mb-5 me-3">Đăng ký tài khoản</h2>
          </div>

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="fullname" type="text" id="form3Example3" class="form-control form-control-lg"
              placeholder="Họ tên" />
              <?php echo formError($errorsArr, 'fullname'); ?>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="email" type="text" id="form3Example3" class="form-control form-control-lg"
              placeholder="Địa chỉ email" />
              <?php echo formError($errorsArr, 'email'); ?>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="phone" type="text" id="form3Example3" class="form-control form-control-lg"
              placeholder="Số điện thoại" />
              <?php echo formError($errorsArr, 'phone'); ?>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
            <input name="password" type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Nhập mật khẩu" />
              <?php echo formError($errorsArr, 'password'); ?>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input name="confirm_password" type="password" id="form3Example3" class="form-control form-control-lg"
              placeholder="Nhập lại mật khẩu" />
              <?php echo formError($errorsArr, 'confirm_password'); ?>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng ký</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Đã có tài khoản? <a href="<?= HOST_URL; ?>?module=auth&action=login"
                class="link-danger">Đăng nhập ngay</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<?php
layout('footer');