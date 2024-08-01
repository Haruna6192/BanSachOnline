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
						<li><a href="contact.php">Profile</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
                    <!-- /* ------------------------------ PHP ----------------------------- */ -->
                    <?php
                    function getInforUser($email){ // lấy thông tin của người dùng
                        include './inc/myconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM loginuser WHERE email = ?");
                        $stmt->bind_param("s",$email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        return $result->fetch_assoc();
                    }
                    $user = getInforUser($_SESSION["email"]);
                    ?>
                    <!-- /* ------------------------------ PHP ----------------------------- */ -->
                    <!-- /* ------------------------------ THÔNG TIN NGƯỜI DÙNG ----------------------------- */ -->
					<div class="heading"><h1>Thông tin cá nhân</h1></div>
                    <form action="" class="form row" method="POST">
                        <div class="form-group col-lg-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" value="<?= $user['matkhau'] ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Họ tên</label>
                            <input type="text" class="form-control" name="fullname" value="<?= $user['HoTen'] ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Số điện thoại</label>
                            <input type="text" class="form-control" name="numberphone" value="<?= $user['DienThoai'] ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <button class="btn btn-success" name="update">Cập nhật</button>
                        </div>
                    </form>
                    <!-- /* --------------------------- CẬP NHẬT THÔNG TIN --------------------------- */ -->
                    <?php 
                    include './inc/myconnect.php';
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["update"])){
                            $where = $_SESSION["email"];
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                            $fullname = $_POST["fullname"];
                            $numberphone = $_POST["numberphone"];

                            if(!empty($email) && !empty($password) && !empty($fullname) && !empty($numberphone)){
                                $stmt = $conn->prepare("UPDATE loginuser SET email = ?, matkhau = ?, HoTen = ?, DienThoai = ? WHERE email = ?");
                                $stmt->bind_param("sssss", $email, $password, $fullname, $numberphone, $where);
                                if($stmt->execute()){
                                    header("Location: ./profile.php");
                                }
                            }else{
                                echo "Chưa nhập đầy đủ thông tin";
                            }
                        }
                    }
                    ?>
                    <!-- /* --------------------------- CẬP NHẬT THÔNG TIN --------------------------- */ -->
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
