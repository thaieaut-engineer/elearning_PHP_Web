<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

$data = [
    'title' => 'Danh sách khoá học',
];

layout('header', $data);

$filter = filterData();
$chuoiWhere = '';
$cate ='0';
$keyword ='';
$page = 1;
if(isGet()){
  if(isset($filter['keyword'])){
    $keyword = $filter['keyword'];
  }
  if(isset($filter['cate'])){
    $cate = $filter['cate'];
  }

  if(!empty($keyword)){
    if(strpos($chuoiWhere, 'WHERE') === false){
      $chuoiWhere .= ' WHERE ';
    }else{
      $chuoiWhere .= ' AND ';
    }
    $chuoiWhere .= " (a.name LIKE '%$keyword%' OR a.description LIKE '%$keyword%') ";
  }

  if(!empty($cate)){
    if(strpos($chuoiWhere, 'WHERE') == false){
      $chuoiWhere .= ' WHERE ';
    }else{
      $chuoiWhere .= ' AND ';
    }
    $chuoiWhere .= " a.category_id = $cate ";
  }
}

//xử lý phân trang
$maxData = getRow("SELECT id FROM course"); //tổng dữ liệu
$perPage = 6; //số dữ liệu trên 1 trang
$maxPage = ceil($maxData / $perPage); //tính tổng số trang
$offset = 0; //vị trí bắt đầu lấy dữ liệu

//lấy trang hiện tại
if(isset($filter['page'])){
  $page = $filter['page'];
  if($page < 1){
    $page = 1;
  }
  if($page > $maxPage){
    $page = $maxPage;
  }
}

$offset = ($page - 1) * $perPage; //vị trí bắt đầu lấy dữ liệu

$getDatailUser = getAll("SELECT a.id, a.name, a.thumbnail, a.price, b.name AS category_name FROM course a INNER JOIN course_category b ON a.category_id = b.id $chuoiWhere ORDER BY a.created_at DESC LIMIT $offset, $perPage");

if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page, '', $queryString);
}

$msg = getSessionFlash('msg');
$msgType = getSessionFlash('msg_type');

?>
<div class="container mt-4 mb-4">
  <h2 class="text-center mb-4">Danh sách khoá học</h2>
  <a href="?module=course&action=add" class="btn btn-success mb-3"><i class="fa-solid fa-plus"></i> Thêm khoá học mới</a>
  <?php 
        if(!empty($msg) && !empty($msgType)){
        getMsg($msg, $msgType);
        } ?>
  <form class="mb-3" action="" method="get">
    <input type="hidden" name="module" value="course">
    <input type="hidden" name="action" value="list">
    <div class="row">
    <div class="col-3">
        <select name="group" id="" class="form-select form-control">
            <option value="">-- Lĩnh vực --</option>

            <?php
            $getCate = getAll("SELECT * FROM course_category");
            foreach($getCate as $item): ?>
            <option value="<?= $item['id'] ?>" <?= $cate == ($item['id']) ? 'selected' : '' ?>><?= $item['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-6 d-flex">
      <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm khoá học..." value="<?= (!empty($keyword)) ? $keyword : '' ?>">
    </div>
    <div class="col-3 d-flex"><button class="btn btn-primary" type="submit">Tìm kiếm</button></div>

    </div>
  </form>

<table class="table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Tên khoá học</th>
      <th scope="col">Thumbnail</th>
      <th scope="col">Giá</th>
      <th scope="col">Lĩnh vực</th>
      <th scope="col">Sửa</th>
      <th scope="col">Xóa</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($getDatailUser as $key => $item): 
    ?>
    <tr>
      <th scope="row"><?= $key + 1 ?></th>
      <td><?= $item['name'] ?></td>
      <td><img src="<?= $item['thumbnail'] ?>" alt="<?= $item['name'] ?>" class="img-fluid" width="100"></td>
      <td><?= $item['price'] ?></td>
      <td><?= $item['category_name'] ?></td>
      <td><a href="?module=course&action=edit&id=<?= $item['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></td>
      <td><a href="?module=course&action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php if(isset($page) && $page > 1): ?>
    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $page - 1 ?>">Trước</a></li>
    <?php endif; ?>

    <?php 
    $start = $page - 1;
    if($start < 1){
      $start = 1;
    }
    ?>
    <?php if($start > 1): ?>
      <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $start ?>">...</a></li>
    <?php endif;
    $end = $page + 1;
    if($end > $maxPage){
      $end = $maxPage;
    }
    ?>
    <?php for($i = $start; $i <= $end; $i++): ?>
    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link" href="?<?= $queryString ?>&page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor; ?>

    <?php if($end < $maxPage): ?>
    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $maxPage ?>">...</a></li>
    <?php endif; ?>

    <?php if(isset($page) && $page < $maxPage): ?>
    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>&page=<?= $page + 1 ?>">Sau</a></li>
    <?php endif; ?>
  </ul>
</nav>
</div>

<?php
layout('footer', $data);