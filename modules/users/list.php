<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Danh sách người dùng',
];

layout('header', $data);

$filter = filterData();
$chuoiWhere = '';
$group ='0';
$keyword ='';
if(isGet()){
  if(isset($filter['keyword'])){
    $keyword = $filter['keyword'];
  }
  if(isset($filter['group'])){
    $group = $filter['group'];
  }

  if(!empty($keyword)){
    if(strpos($chuoiWhere, 'WHERE') == false){
      $chuoiWhere .= ' WHERE ';
    }else{
      $chuoiWhere .= ' AND ';
    }
    $chuoiWhere .= " (a.fullname LIKE '%$keyword%' OR a.email LIKE '%$keyword%') ";
  }

  if(!empty($group)){
    if(strpos($chuoiWhere, 'WHERE') == false){
      $chuoiWhere .= ' WHERE ';
    }else{
      $chuoiWhere .= ' AND ';
    }
    $chuoiWhere .= " a.group_id = $group ";
  }
}

$getDatailUser = getAll("SELECT a.id, a.fullname, a.email, a.created_at, b.name FROM users a INNER JOIN groups b ON a.group_id = b.id $chuoiWhere ORDER BY a.created_at DESC");

$getGroup = getAll("SELECT * FROM groups");

?>
<div class="container mt-4 mb-4">
  <h2 class="text-center mb-4">Danh sách người dùng</h2>
  <a href="?module=users&action=add" class="btn btn-success mb-3"><i class="fa-solid fa-plus"></i> Thêm người dùng mới</a>
  <form class="mb-3" action="" method="get">
    <input type="hidden" name="module" value="users">
    <input type="hidden" name="action" value="list">
    <div class="row">
    <div class="col-3">
        <select name="group" id="" class="form-select form-control">
            <option value="">-- Chọn nhóm người dùng --</option>
            <?php foreach($getGroup as $item): ?>
            <option value="<?= $item['id'] ?>" <?= ($item['id'] == $group) ? 'selected' : '' ?>><?= $item['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-6 d-flex">
      <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm người dùng..." value="<?= (!empty($keyword)) ? $keyword : '' ?>">
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
    <?php foreach($getDatailUser as $key => $item): 
    ?>
    <tr>
      <th scope="row"><?= $key + 1 ?></th>
      <td><?= $item['fullname'] ?></td>
      <td><?= $item['email'] ?></td>
      <td><?= date('d/m/Y', strtotime($item['created_at'])) ?></td>
      <td><?= $item['name'] ?></td>
      <td><a href="?module=users&action=permission&id=<?= $item['id'] ?>" class="btn btn-primary">Phân quyền</a></td>
      <td><a href="?module=users&action=edit&id=<?= $item['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>
      <td><a href="?module=users&action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a></td>
    </tr>
    <?php endforeach; ?>
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