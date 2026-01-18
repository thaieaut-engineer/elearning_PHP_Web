<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Kích hoạt tài khoản'
];
layout('header-auth', $data);

$filter = filterData('get');

// Kiểm tra token kích hoạt
if(!empty($filter['token'])):
    $token = $filter['token'];
    $checkToken = getOnce("SELECT * FROM users WHERE active_token = '$token'");
?>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="<?= HOST_URL_TEMPLATES; ?>/assets/image/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <?php 
      if(!empty($checkToken)):
        // Kích hoạt tài khoản
        $dataUpdate = [
            'status' => 1,
            'active_token' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id = ".$checkToken['id'];
        // Cập nhật trạng thái kích hoạt
        update('users', $dataUpdate, $condition);
        ?>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form>
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h2 class="fw-normal mb-5 me-3">Kích hoạt tài khoản thành công</h2>
          </div>
          <a href="<?= HOST_URL; ?>?module=auth&action=login"
                class="link-danger">Đăng nhập ngay</a>
        </form>

      </div>
      <?php
      else:
        // Token không hợp lệ
        ?>
         <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form>
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h2 class="fw-normal mb-5 me-3">Token kích hoạt đã hết hạn</h2>
          </div>
        </form>
      </div>

        <?php
      endif;
      ?>

    </div>
  </div>
</section>

<?php 
else:
    // Token không hợp lệ
    ?>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="<?= HOST_URL_TEMPLATES; ?>/assets/image/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form>
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h2 class="fw-normal mb-5 me-3">Token kích hoạt không hợp lệ</h2>
          </div>
          <a href="<?= HOST_URL; ?>?module=auth&action=login"
                class="link-danger">Quay lại đăng nhập</a>
        </form>
      </div>
    </div>
  </div>
</section>
    <?php
    
endif;

?>


<?php
layout('footer');