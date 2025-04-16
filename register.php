<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        if(!in_array($member, ['user', 'rider', 'restaurant'])){
            header('location: ?member=user');
        }
    ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 card shadow p-0">
                <!-- แถบด้านบนของกล่อง Register  -->
                <ul class="nav nav-tabs bg-light">
                    <li class="nav-item">
                        <!-- ใน class เช็คถ้าค่า get ที่รับมาเป็น admin จะแสดงคลาส active ของ bootstrap เพื่อแสดงว่าเลือก login admin อยู่ -->
                        <a href="register.php?member=user" class="nav-link <?php echo ($member == 'user' ? 'active' : '') ?>" >User</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php?member=restaurant" class="nav-link <?php echo ($member == 'restaurant' ? 'active' : '') ?>" >Restaurant</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php?member=rider" class="nav-link <?php echo ($member == 'rider' ? 'active' : '') ?>" >Rider</a>
                    </li>
                </ul>

                <!-- Register form -->
                <form action="system/register_db.php" class="p-3" method="post" enctype="multipart/form-data">
                    <h1 class="text-center mb-4"><?php echo ucfirst($member) ?> Register</h1>
                    <input type="hidden" name="member" value="<?php echo $member ?>">

                    <center>
                        <div class="rounded-circle hover-img border mb-2" style="width: 7rem; height: 7rem;">
                            <!-- 
                                ถ้าสมัครเป็นร้าน จะแสดงรูปเริ่มต้นของร้าน แต่ถ้าไม่ใช่จะแสดงรูปเริ่มต้นของ user 
                                และถ้าอัพโหลดรูป จะแสดงถาพเป็นตัวอย่าง
                            -->
                            <img src="upload/<?php echo ($member == 'restaurant' ? 'res_df.png' : 'df.png') ?>" class="img" id="preview">
                        </div>
                        <!-- ซ่อนปุ่มเพิ่มไฟล์ -->
                        <input type="file" name="img" id="img_upload" hidden>
                        <!-- ใช้ label เป็นปุ่มอัพโหลดไฟล์แทน -->
                        <label for="img_upload" class="btn btn-outline-primary mb-4">เพิ่มรูปโปรไฟล์</label>
                    </center>

                    <!-- ถ้าเป็นร้าน จะแสดง input นี้ให้ใส่ชื่อร้าน -->
                    <?php if($member == 'restaurant'){ ?>
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" name="res_name" id="" placeholder="" required>
                            <label for="">ชื่อร้านอาหาร</label>
                        </div>
                    <?php } ?>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="full_name" id="" placeholder="" required>
                        <label for="">ชื่อ - นามสกุล</label>
                    </div>

                    <!-- เรียกใช้ function form เพื่อแสดงไฮไลท์สีแดงในกรณีที่ช่องนี้กรอกข้อมูลไม่ถูกต้อง -->
                    <div class="form-floating mb-4 <?php form('username') ?>">
                        <input type="text" class="form-control" name="username" id="" placeholder="" required>
                        <label for="">ชื่อผู้ใช้</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" name="password" id="" placeholder="" required>
                        <label for="">รหัสผ่าน</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="address" id="" placeholder="" required>
                        <label for="">ที่อยู่</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="tel" class="form-control" name="phone" id="" placeholder="" required minlength="10" maxlength="10" pattern="[0-9]{10}">
                        <label for="">เบอร์โทรศัพท์</label>
                    </div>

                    <!-- ถ้าเป็นร้าน จะแสดง input นี้ให้ใส่ประเภทร้าน -->
                    <?php if($member == 'restaurant'){ ?>
                        <label for="">ประเภทร้านอาหาร</label>
                        <select name="res_type" class="form-select mb-4">
                            <?php   
                                $select = mysqli_query($conn, "SELECT * FROM `restaurant_type` ");
                                while($row = mysqli_fetch_array($select)){
                            ?>
                                <option value="<?php echo $row['res_type_id'] ?>"><?php echo $row['res_type'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>

                    <div class="d-flex gap-3">
                        <a href="index.php" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                        <input type="submit" class="btn btn-success w-100" name="submit" value="ยืนยัน">
                    </div>

                    <?php if($member != 'admin'){ ?>
                        <p class="text-center my-3">มีบัญชีแล้ว?<a href="login.php?member=<?php echo $member ?>">เข้าสู่ระบบ!</a></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <script src="function.js"></script>
</body>
</html>