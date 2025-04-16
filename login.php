<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/form.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>

</head>
<body>
    <?php
        include_once 'db.php';
        // รับ get member ถ้าไม่มี ให้เป็นค่าว่าง
        $member = ($_GET['member'] ?? '');

        // เช็ค ถ้าประเภท member ไม่ถูกจะให้เริ่มต้นเป็น user
        if(!in_array($member, ['admin', 'user', 'rider', 'restaurant'])){
            header('location: ?member=user');
        }
    ?>  

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 card shadow p-0">
                <!-- แถบด้านบนของกล่อง Login  -->
                <ul class="nav nav-tabs bg-light">
                    <li class="nav-item">
                        <!-- ใน class เช็คถ้าค่า get ที่รับมาเป็น admin จะแสดงคลาส active ของ bootstrap เพื่อแสดงว่าเลือก login admin อยู่ -->
                        <a href="login.php?member=admin" class="nav-link <?php echo ($member == 'admin' ? 'active' : '') ?>" >Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php?member=user" class="nav-link <?php echo ($member == 'user' ? 'active' : '') ?>" >User</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php?member=restaurant" class="nav-link <?php echo ($member == 'restaurant' ? 'active' : '') ?>" >Restaurant</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php?member=rider" class="nav-link <?php echo ($member == 'rider' ? 'active' : '') ?>" >Rider</a>
                    </li>
                </ul>

                <!-- Login form -->
                <form action="system/login_db.php" class="p-3" method="post" enctype="multipart/form-data">
                    <!-- นำชื่อประเภท member ที่รับมา มาแสดง และให้ตัวแรกเป็นตัวพิมพ์ใหญ์ -->
                    <h1 class="text-center mb-4"><?php echo ucfirst($member) ?> Login</h1>
                    <!-- ส่งประเภท member ไปแบบ hidden -->
                    <input type="hidden" name="member" value="<?php echo $member ?>">

                    <!-- เรียกใช้ function form เพื่อแสดงไฮไลท์สีแดงในกรณีที่ช่องนี้กรอกข้อมูลไม่ถูกต้อง -->
                    <div class="form-floating mb-4 <?php form('username') ?>">
                        <input type="text" class="form-control" name="username" id="" placeholder="" value="" required>
                        <label for="">ชื่อผู้ใช้</label>
                    </div>

                    <!-- เรียกใช้ function form เพื่อแสดงไฮไลท์สีแดงในกรณีที่ช่องนี้กรอกข้อมูลไม่ถูกต้อง -->
                    <div class="form-floating mb-4 <?php form('password') ?>">
                        <input type="password" class="form-control" name="password" id="pass" placeholder="" required>
                        <label for="">รหัสผ่าน</label>
                    </div>

                    <div class="mb-4">
                        <input type="checkbox" class="form-check-input" id="show" onclick="showpass();">
                        <label for="show">แสดงรหัสผ่าน</label>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="index.php" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                        <input type="submit" class="btn btn-success w-100" name="submit" value="ยืนยัน">
                    </div>

                    <!-- ถ้าเป็น admin จะไม่ให้สมัคร -->
                    <?php if($member != 'admin'){ ?>
                        <p class="text-center my-3">ยังไม่มีบัญชี?<a href="register.php?member=<?php echo $member ?>">สมัครเลย!</a></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <script src="function.js"></script>
</body>
</html>