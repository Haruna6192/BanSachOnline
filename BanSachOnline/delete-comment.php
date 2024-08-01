<?php 
include './inc/myconnect.php';
$back = $_GET["back"] ?? ""; // id sản phẩm 
$id = $_GET["id"] ?? ""; // id comment
$stmt = $conn->prepare("DELETE FROM danhgia WHERE id = ?");
$stmt->bind_param("i", $id); // gắn giá trị cho ?
if($stmt->execute()){
    if($back > 0){ // trang người dùng
        header("Location: product.php?id=" . $back);
    }else{ // trang admin
        header("Location: Admin/quanlydanhgia.php");
    }
}

// DÙNG CHUNG CHỨC NĂNG XÓA CHO CẢ 2 TRANG