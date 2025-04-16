<link rel="stylesheet" href="../style/style.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../bootstrap/js/bootstrap.bundle.js"></script>
<?php
    include_once 'session.php';

    // ถ้ายังไม่มีค่า จะให้เป็น string เปล่า 
    $_GET['page'] = ($_GET['page'] ?? '');

    // 3ตัวแปรนีั้ บอกว่าที่กำลังทำงานอยู่ตอนนี้เป็นของ rider ไว้ใช้กับไฟล์ที่ประมวลผล เช่น profile_edit_db.php และ password_edit_db.php ใน system
    $member = 'rider';
    $member_id = 'rider_id';
    $rider_id = $_SESSION['rider_id']; // ไอดีของ rider ที่ได้ล็อคอินเข้ามาใช้งาน (เก็บลงตัวแปรเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า)
    
    // ดึงข้อมูลของ rider ที่ล็อคอินใช้งานอยู่ตอนนี้
    $select = mysqli_query($conn, "SELECT * FROM `rider` WHERE `rider_id` = '$rider_id' ");
    $row = mysqli_fetch_array($select);
?>
<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background: #594545;">
    <div class="container-fluid">
        <!-- ไปหน้า profile (ส่งค่า get เป็น ../template/profile หน้า index ก้จะดึงไฟล์นี้มาทำงาน) -->
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
                    <a href="order.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'order.php' ? 'active' : '') ?>">รับออร์เดอร์</a>
                </li>
                <li class="nav-item">
                    <a href="status.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'status.php' ? 'active' : '') ?>">สถานะการจัดส่ง</a>
                </li>
                <li class="nav-item">
                    <a href="history.php" class="nav-link <?php echo (basename($_SERVER['SCRIPT_NAME']) == 'history.php' ? 'active' : '') ?>">ประวัติการจัดส่ง</a>
                </li>
            </ul>
        </div>
    </div>
</nav>