<link rel="stylesheet" href="../style/style.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../bootstrap/js/bootstrap.bundle.js"></script>
<?php
    include_once '../db.php';

    // ถ้ายังไม่มีค่า จะให้เป็น string เปล่า 
    $_GET['page'] = ($_GET['page'] ?? '');
    $user_id = ($_SESSION['user_id'] ?? '');

    // เช็คการล็อคอิน ถ้ามี user_id แสดงว่าล็อคอินแล้ว ก็จะดึงข้อมูลของ user คนนี้
    if(isset($_SESSION['user_id'])){
        $member = 'user';
        $member_id = 'user_id';

        $select = mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = '$user_id' ");
        $row = mysqli_fetch_array($select);
    }

    // เช็คถ้าไม่ใช่หน้าเหล่านี้ก็จะดึง session.php เพื่อม่าเช็คการล้อคอิน (3 หน้านี้อณุญาติให้ดูได้โดยไม่ต้องล็อคอิน)
    if(!in_array(basename($_SERVER['SCRIPT_NAME']), ['index.php', 'see_res_type.php', 'see_res.php', ''])){
        include_once 'session.php';
    }

?>

<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background: #252525;">
    <div class="container-fluid">
        <!-- ไปหน้า profile (ส่งค่า get เป็น ../template/profile หน้า index ก้จะดึงไฟล์นี้มาทำงาน) -->
        <a href="index.php?page=../template/profile" class="pro-brand">
            <img src="../upload/<?php echo (isset($_SESSION['user_id']) ? $row['img'] : 'df.png') ?>" class="img">
        </a>
        <a href="" class="navbar-brand"><?php echo $web['web_name'] ?></a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#hamburger">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="hamburger">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <hr class="text-light">
                <li class="nav-item">
                    <!-- ไปหน้า index และส่ง get page=home เพื่อดึงหน้านี้มาแสดง และ เช็คค่า get page ว่าเป็น home ไหม ถ้าใช่ก้จะแสดง active ใน class  -->
                    <a href="index.php?page=home" class="nav-link <?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>">หน้าหลัก</a>
                </li>

                <!-- ไปหน้าต่างๆ และเช็คว่าไฟล์ที่กำลังทำงานนั้น ตรงกับปุ่มลิงค์ของหน้านั้นไหม ถ้าตรงกันก็จะแสดง active ใน class  -->
                <li class="nav-item">
                    <a href="status.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'status.php' ? 'active' : '') ?>">สถานะการสั่งซื้อ</a>
                </li>
                <li class="nav-item">
                    <a href="history.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'history.php' ? 'active' : '') ?>">ประวัติการสั่งซื้อ</a>
                </li>
                <li class="nav-item">
                    <a href="fav_res.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'fav_res.php' ? 'active' : '') ?>">ร้านโปรด</a>
                </li>

                <!-- ถ้ายังไม่ล็อคอินจะแสดงปุ่มนี้ -->
                <?php if(!isset($_SESSION['user_id'])){ ?>
                    <a href="../login.php" class="btn btn-success">ลงชื่อเข้าใช้</a>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>