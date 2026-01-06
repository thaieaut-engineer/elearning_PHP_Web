<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Truy vấn nhiều bản ghi
function getAll($sql){
    global $conn;
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Đếm số bản ghi
function getRow($sql){
    global $conn;// Sử dụng biến toàn cục $conn
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->rowCount();
    return $result;
}

// Truy vấn một bản ghi
function getOnce($sql){
    global $conn;// Sử dụng biến toàn cục $conn
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Insert dữ liệu
function insert($table, $data){
    global $conn;
    $columns = implode(", ", array_keys($data));// Lấy tên cột
    $placeholders = ":" . implode(", :", array_keys($data));// Tạo placeholders
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";// Câu lệnh SQL
    $stm = $conn->prepare($sql);// Chuẩn bị câu lệnh
    // Gán giá trị cho placeholders
    foreach ($data as $key => $value) {
        $stm->bindValue(":$key", $value);// Gán giá trị
    }
    return $stm->execute();// Thực thi và trả về kết quả
}

// Cập nhật dữ liệu
function update($table, $data, $where){
    global $conn;
    $setClause = "";
    foreach ($data as $key => $value) {
        $setClause .= "$key = :$key, ";// Tạo câu lệnh SET
    }
    $setClause = rtrim($setClause, ", ");// Loại bỏ dấu phẩy cuối cùng
    $sql = "UPDATE $table SET $setClause WHERE $where";// Câu lệnh SQL
    $stm = $conn->prepare($sql);// Chuẩn bị câu lệnh
    // Gán giá trị cho placeholders
    foreach ($data as $key => $value) {
        $stm->bindValue(":$key", $value);// Gán giá trị
    }
    return $stm->execute();// Thực thi và trả về kết quả
}

// Xóa dữ liệu
function delete($table, $where){
    global $conn;
    $sql = "DELETE FROM $table WHERE $where";// Câu lệnh SQL
    $stm = $conn->prepare($sql);// Chuẩn bị câu lệnh
    return $stm->execute();// Thực thi và trả về kết quả
}

// Lấy ID của bản ghi mới nhất
function lastID(){
    global $conn;
    return $conn->lastInsertId();// Trả về ID của bản ghi mới nhất
}
?>