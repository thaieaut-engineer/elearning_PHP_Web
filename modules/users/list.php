<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Danh sách người dùng',
];

layout('header', $data);

?>
<div class="container mt-4 mb-4">
  <h2 class="text-center mb-4">Danh sách người dùng</h2>
  <a href="?module=users&action=add" class="btn btn-success mb-3"><i class="fa-solid fa-plus"></i> Thêm người dùng mới</a>
  <form class="mb-3" action="" method="get">
    <div class="row">
    <div class="col-3">
        <select name="" id="" class="form-select form-control">
            <option value="">-- Chọn nhóm người dùng --</option>
            <option value="admin">Quản trị viên</option>
            <option value="editor">Biên tập viên</option>
            <option value="user">Người dùng</option>
        </select>
    </div>
    <div class="col-6 d-flex">
      <input type="text" class="form-control" name="search" placeholder="Tìm kiếm người dùng..." value="">
    </div>
    <div class="col-3 d-flex"><button class="btn btn-primary" type="submit">Tìm kiếm</button></div>

    </div>
  </form>

<table class="table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Họ tên</th>
      <th scope="col">Email</th>
      <th scope="col">Ngày đăng ký</th>
      <th scope="col">Nhóm</th>
      <th scope="col">Phân quyền</th>
      <th scope="col">Sửa</th>
      <th scope="col">Xóa</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td><a href="#" class="btn btn-primary">Phân quyền</a></td>
      <td><a href="#" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>
      <td><a href="#" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a></td>
    </tr>
  </tbody>
</table>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
</div>

<?php
layout('footer', $data);