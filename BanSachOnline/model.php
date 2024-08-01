<?php 
include './inc/myconnect.php';
function selectOne($table, $column, $value, $get){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param("s", $value); // gán giá trị cho ?
    $stmt->execute();
    $result = $stmt->get_result();
    if($get == 'array'){ // nếu lấy hàng
        return $result->fetch_assoc();
    }
    if($get == 'object'){ // nếu lấy tất cả
        return $result;
    }
}