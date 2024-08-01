<?php
include '../inc/myconnect.php'; 
$sodh = $_GET["sodh"];
$col = $_GET["col"];
$value = $_GET["value"];
$stmt = $conn->prepare("UPDATE hoadon SET $col = ? WHERE sodh = ?");
$stmt->bind_param("si", $value, $sodh);
if($stmt->execute()){
    header("Location: quanlyhoadon.php");
}
?>