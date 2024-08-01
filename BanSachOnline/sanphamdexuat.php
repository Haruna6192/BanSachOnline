<?php
$email = $_SESSION["email"];
if (!empty($email)) { // kiểm tra người dùng đã đăng nhập chưa
?>
<div class="row">
    <div class="col-lg-12">
        <div class="heading">
            <h2>Sản phẩm đề xuất</h2>
        </div>

        <div class="products">
            <?php
            require 'inc/myconnect.php'; // Lấy tất cả nhưng sản phẩm liên quan đến sản phẩm đã mua
            // Câu truy vấn SQL để lấy lịch sử mua hàng của người dùng dựa trên địa chỉ email
            $query = "SELECT chitiethoadon.*, sanpham.Ten AS TenSanPham, sanpham.ID AS ID, sanpham.Gia AS GiaSanPham, sanpham.HinhAnh AS HinhAnhSanPham, nhaxuatban.Ten AS TenNXB
            FROM chitiethoadon
            INNER JOIN sanpham ON chitiethoadon.masp = sanpham.ID
            INNER JOIN nhaxuatban ON sanpham.Manhasx = nhaxuatban.ID
            WHERE sodh IN (SELECT sodh FROM hoadon WHERE emailkh = ?)";

            $stmt = $conn->prepare($query); // Chuẩn bị câu truy vấn
            $stmt->bind_param("s", $email); // Gắn tham số vào câu truy vấn
            $stmt->execute(); // Thực thi câu truy vấn
            $rs = $stmt->get_result(); // Lấy kết quả từ câu truy vấn

            // Kiểm tra xem có sản phẩm nào được trả về không
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    // Hiển thị thông tin của sản phẩm
            ?>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="product">
                            <div class="image"><a href="product.php?id=<?php echo $row["ID"] ?>"><img src="images/<?php echo $row["HinhAnhSanPham"] ?>" style="width:300px;height:300px" /></a></div>
                            <div class="caption">
                                <div class="name">
                                    <h3><a href="product.php?id=<?php echo $row["ID"] ?>"><?php echo $row["TenSanPham"] ?></a></h3>
                                </div>
                                <div class="price"><?php echo $row["GiaSanPham"] ?>.000 VNĐ</div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }else{ // nếu ko có thì trả về sp nổi bật luôn
                require 'inc/truyvan.php';
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
    
                ?>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="product">
                                <div class="image"><a href="product.php?id=<?php echo $row["ID"] ?>"><img src="images/<?php echo $row["HinhAnh"] ?>" style="width:300px;height:300px" /></a></div>
                                <div class="caption">
                                    <div class="name">
                                        <h3><a href="product.php?id=<?php echo $row["ID"] ?>"><?php echo $row["Ten"] ?></a></h3>
                                    </div>
                                    <?php
                                    if ($row["KhuyenMai"] == true) {
                                    ?>
                                        <div class="price" style="color: red;"><?php echo $row["giakhuyenmai"] ?>,000₫<span style="font-size: 14px;"><?php echo $row["Gia"] ?>,000₫</span></div>
                                    <?php
                                    }
                                    ?>
                                    <div class="g-plusone" data-size="medium" data-annotation="none" data-href="/product.php?id=<?php echo $row["ID"] ?>"></div>
                                </div>
                            </div>
    
                        </div>
                <?php
                    }
                }
            }
            ?>
        </div>


    </div>
</div>
<?php //HTML
}
?>