<link rel="stylesheet" href="../style/style.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../bootstrap/js/bootstrap.bundle.js"></script>
<?php
    include_once 'session.php'; // เช็คการเข้าสู่ระบบ

    $_GET['page'] = ($_GET['page'] ?? ''); // ชื่อหน้า ถ้าใน get page ยังไม่มีค่าจะให้เป็น string เปล่า

    // ตัวแปรบอกประเภทผู้ใช้ที่กำลังทำงานอยู่ตอนนี้ ถูกใช้ในไฟล์ที่ประมวลผล เช่น food_manage.php หรือ system/profile_edit_db.php เป็นต้น
    $member = 'restaurant';
    $member_id = 'res_id';
    $res_id = $_SESSION['res_id']; // ไอดีของร้าน ที่ได้ล็อคอินเข้ามาใช้งาน (เก็บลงตัวแปรเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า)

    // ดึงข้อมูลร้าน และชื่อประเภทของร้านนี้
    $select = mysqli_query($conn, "SELECT `restaurant`.* , `restaurant_type`.`res_type`
                            FROM `restaurant`
                            LEFT JOIN `restaurant_type`
                            ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id`
                            WHERE `restaurant`.`res_id` = '$res_id' "); 
                            
    $row = mysqli_fetch_array($select);
?>

<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background: #40513D;">
    <div class="container-fluid">
        <a href="index.php?page=../template/profile" class="pro-brand">
            <img src="../upload/<?php echo $row['img'] ?>" class="img">
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
                    <a href="payment.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'payment.php' ? 'active' : '') ?>">ตัวเลือกการชำระเงิน</a>
                </li>
                <li class="nav-item">
                    <a href="status.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'status.php' ? 'active' : '') ?>">ออร์เดอร์ขณะนี้</a>
                </li>
                <li class="nav-item">
                    <a href="report.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'report.php' ? 'active' : '') ?>">รายงานสรุปยอดขาย</a>
                </li>
            </ul>
        </div>
    </div>
</nav>