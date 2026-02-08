<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Thêm người dùng',
];

layout('header', $data);
?>

<div class="container">
    <h2 class="mb-4">Thêm người dùng</h2>
    <form action="" method="post">
        <div class="row">
        <div class="col-6 pb-3">
            <label for="fullname">Họ và tên</label>
            <input id="fullname" type="text" class="form-control" placeholder="Họ tên">
        </div>
        <div class="col-6 pb-3">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" placeholder="Email">
        </div>
        <div class="col-6 pb-3">
            <label for="phone">Số điện thoại</label>
            <input id="phone" type="text" class="form-control" placeholder="Số điện thoại">
        </div>
        <div class="col-6 pb-3">
            <label for="password">Mật khẩu</label>
            <input id="password" type="password" class="form-control" placeholder="Mật khẩu">
        </div>
        <div class="col-6 pb-3">
            <label for="address">Địa chỉ</label>
            <input id="address" type="text" class="form-control" placeholder="Địa chỉ">
        </div>
        <div class="col-3 pb-3">
            <label for="group">Nhóm</label>
            <select id="group" name="group" class="form-select form-control">
                <?php
                $getGroup = getAll("SELECT * FROM groups");
                foreach($getGroup as $item):
                ?>
                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="col-3 pb-3">
            <label for="status">Trạng thái</label>
            <select id="status" name="status" class="form-select form-control">
                <option value="0">Chưa kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Xác nhận</button>
    </form>
</div>

<?php
layout('footer', $data);