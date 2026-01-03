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

// Truy vấn một bản ghi
function getOnce($sql){
    global $conn;
    $stm = $conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}
?>