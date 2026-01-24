<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Quên mật khẩu'
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

  if(empty($errors)){
    // Kiểm tra email có tồn tại trong hệ thống không
    if(!empty(trim($filter['email']))){
      $email = trim($filter['email']);
      $checkEmail = getOnce("SELECT * FROM users WHERE email = '$email'");
      if(!empty($checkEmail)){
        // update forget_token vào bảng users
        $forget_token = sha1(uniqid().time());
        $data = [
          'forget_token' => $forget_token
        ];
        $conndition = "id = ".$checkEmail['id'];
        $update = update('users', $data, $conndition);
        if($update){
          // Gửi email chứa liên kết đặt lại mật khẩu
          $resetLink = HOST_URL.'?module=auth&action=reset&token='.$forget_token;
          $subject = 'Yêu cầu đặt lại mật khẩu';
          $message = "Chào bạn,<br><br> Vui lòng nhấp vào liên kết sau để đặt lại mật khẩu của bạn: <a href='$resetLink'>$resetLink</a><br><br>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.<br><br>Trân trọng,<br>Đội ngũ hỗ trợ.";
          sendMail($email, $subject, $message);

          setSessionFlash('msg', 'Chúng tôi đã gửi một liên kết đặt lại mật khẩu đến email của bạn.');
          setSessionFlash('msg_type', 'success');
        }else{
          setSessionFlash('msg', 'Đã xảy ra lỗi khi xử lý yêu cầu của bạn. Vui lòng thử lại sau.');
          setSessionFlash('msg_type', 'danger');
        }
      }
    }
  }else{
    setSessionFlash('msg', 'Vui lòng kiểm tra lại thông tin bạn đã nhập.');
    setSessionFlash('msg_type', 'danger');
    setSessionFlash('old_data', $filter);
    setSessionFlash('errors', $errors);
  }
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
            <h2 class="fw-normal mb-5 me-3">Quên mật khẩu</h2>
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

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Gửi yêu cầu</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<?php
layout('footer');