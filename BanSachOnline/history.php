<?php
ob_start();

 ?>
<?php
 require "login.php";
      if(!isset($_SESSION['txtus'])) // If session == null thi tra ve trang login
       {
           header("Location:account.php");  
       }

?>
<?php 
	include "head.php"
	?>
<?php
$title ="Shop huy";
$name ="Điện thoai";
?>
<?php 
	include "top.php"
    ?>
    <?php 
	include "Header.php"
	?>
	<?php 
	include "navigation.php"
	?>
	<!--//////////////////////////////////////////////////-->
	<!--///////////////////Contact Page///////////////////-->
	<!--//////////////////////////////////////////////////-->
	<div id="page-content" class="single-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="breadcrumb">
						<li><a href="index.php">Home</a></li>
						<li><a href="contact.php">History</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
                    <!-- /* ------------------------------ THÔNG TIN NGƯỜI DÙNG ----------------------------- */ -->
                    <style>
                        table, td, th{
                            border: 1.5px solid gray !important;
                        }
                        th{
                            background-color: gray;
                            color: white;
                        }
                    </style>
					<div class="heading"><h1>Lịch sử mua hàng</h1></div>
                                        <!-- /* --------------------------- ĐƠN HÀNG CHI TIẾT --------------------------- */ -->
                                        <?php 
                    include './inc/myconnect.php';
                    include './model.php';
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["details"])){
                            $sodh = $_POST["sodh"];
                            $dt = $conn->prepare("SELECT * FROM chitiethoadon WHERE sodh = ?");
                            $dt->bind_param("i", $sodh); // gán giá trị cho ?
                            $dt->execute();
                            $res = $dt->get_result();
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên sách</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Tổng tiền</th>
                                </tr>
                                <?php 
                                while($detail = $res->fetch_assoc()){
                                    ?>
                                    <tr>
                                    <td><?= $detail['sodh'] ?></td>
                                    <td><?= selectOne('sanpham', 'ID', $detail['masp'], 'array')['Ten'] ?></td>
                                    <td><?= $detail['soluong'] ?></td>
                                    <td><?= $detail['dongia'] ?></td>
                                    <td><?= $detail['thanhtien'] ?></td>
                                    </tr>
                                    <?php //HTML
                                } 
                                ?>
                            </table>
                            <?php //HTML
                        }
                    }
                    ?>
                    <!-- /* --------------------------- ĐƠN HÀNG CHI TIẾT --------------------------- */ -->
                    <!-- /* ----------------------------------- LỊCH SỬ ĐẶT HÀNG ---------------------------------- */ -->
                    <table class="table">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày giao hàng</th>
                            <th>Địa chỉ</th>
                            <th>Phương thức thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Tiến trình</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php 
                        include './inc/myconnect.php';
                        // lấy thông tin đơn hàng của người dùng
                        $email = $_SESSION["email"];
                        $stmt = $conn->prepare("SELECT * FROM hoadon WHERE emailkh = ? ");
                        $stmt->bind_param("s", $email); // gán giá trị cho ?
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($order = $result->fetch_assoc()){ // hiển thị
                            ?>
                            <tr>
                                <td><?= $order['sodh'] ?></td>
                                <td><?= $order['ngaygiao'] ?></td>
                                <td><?= $order['diachi'] ?></td>
                                <td><?= $order['hinhthucthanhtoan'] ?></td>
                                <td><?= $order['thanhtien'] ?></td>
                                <td><?= empty($order['trangthai']) ? "Chưa thanh toán" : $order['trangthai']; ?></td>
                                <td><?= empty($order['tientrinh']) ? "Đang xử lý" : $order['tientrinh']; ?></td>
                                <td>
                                    <form action="" method="POST"> 
                                        <input type="hidden" name="sodh" value="<?= $order['sodh'] ?>">
                                        <button class="btn btn-success" name='details'>Chi tiết</button>
                                    </form>
                                </td>
                            </tr>
                            <?php //HTML
                        }
                        ?>
                    </table>
                    <!-- /* ----------------------------------- LỊCH SỬ ĐẶT HÀNG ---------------------------------- */ -->
                    <!-- /* ------------------------------ THÔNG TIN NGƯỜI DÙNG ----------------------------- */ -->
				</div>
			</div>
		</div>
	</div>
	<?php 
	include "footer.php"
	?>
</body>
</html>
