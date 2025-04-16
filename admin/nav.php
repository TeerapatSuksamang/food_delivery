<link rel="stylesheet" href="../style/style.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../bootstrap/js/bootstrap.bundle.js"></script>
<?php
    include_once 'session.php'; // เช็คการล็อคอิน
    // ถ้ายังไม่มีค่า จะให้เป็น string เปล่า 
    $_GET['permis'] = ($_GET['permis'] ?? ''); // ประเภทผู้ใช้
    $_GET['page'] = ($_GET['page'] ?? ''); // ชื่อหน้า

    // 3ตัวแปรนีั้ บอกว่าที่กำลังทำงานอยู่ตอนนี้เป็นของ admin ไว้ใช้กับไฟล์ที่ประมวลผล เช่น profile_edit_db.php และ password_edit_db.php ใน system
    $member = 'admin';
    $member_id = 'admin_id';
    $admin_id = $_SESSION['admin_id']; // ไอดีของ admin ที่ได้ล็อคอินเข้ามาใช้งาน (เก็บลงตัวแปรเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า)
    
    // ดึงข้อมูลของ admin ที่ล็อคอินใช้งานอยู่ตอนนี้
    $select = mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin_id` = '$admin_id' ");
    $row = mysqli_fetch_array($select);
?>

<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background: #27374D;">
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
                    <!-- ไปหน้า index และส่ง get page=web_manage เพื่อดึงหน้านี้มาแสดง และ เช็คค่า get page ว่าเป็น web_manage ไหม ถ้าใช่ก้จะแสดง active ใน class  -->
                    <a href="index.php?page=web_manage" class="nav-link <?php echo ($_GET['page'] == 'web_manage' ? 'active' : '') ?>">จัดการเว็บไซต์</a>
                </li>

                <!-- 3อันนี้ ไปหน้า approve และส่งค่า get เป็น permis = ประเภทผู้ใช้ต่างๆ ซึ่งชื่อพวกนี้จะตรงกับชื่อตารางในฐานข้อมูล -->
                <li class="nav-item">
                    <a href="approve.php?permis=restaurant" class="nav-link <?php echo ($_GET['permis'] == 'restaurant' ? 'active' : '') ?>">อนุมัติร้านอาหาร</a>
                </li>
                <li class="nav-item">
                    <a href="approve.php?permis=rider" class="nav-link <?php echo ($_GET['permis'] == 'rider' ? 'active' : '') ?>">อนุมัติผู้ส่งอาหาร</a>
                </li>
                <li class="nav-item">
                    <a href="approve.php?permis=user" class="nav-link <?php echo ($_GET['permis'] == 'user' ? 'active' : '') ?>">อนุมัติผู้ใช้งาน</a>
                </li>
            </ul>
        </div>
    </div>
</nav>