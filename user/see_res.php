<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านอาหาร</title>
</head>
<body>
    <?php

        include_once 'nav.php';

        // เช็คไอดีร้านที่กำลังดูแล้วเก็บไอดีลง session
        if(isset($_GET['see_res'])){
            $_SESSION['see_res'] = $_GET['see_res'];
        }
        // เก็บลงตัวแปรธรรมดาเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า ประหยัดเวลา
        $see_res = $_SESSION['see_res'];

        // ดึงข้อมูลของร้านที่กำลังดูอยู่
        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$see_res' ");
        // เช็คว่ามีไอดีร้านที่รับมาไหม ถ้าไม่มีก็จะเด้งกลับไปหน้าหลัก
        if($select_res -> num_rows <= 0){
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา', 'index.php');
        }
        $row_res = mysqli_fetch_array($select_res);

        // เช็ค ถ้าไม่มีการเพิ่มเมนูของร้านนี้ลงตะกร้า จะสร้างเป็น array เปล่าไว้ก่อน
        if(!isset($_SESSION['cart_arr'][$see_res])){
            $_SESSION['cart_arr'][$see_res] = array();
        }
    
    ?>
    <!-- รูปร้าน -->
    <div class="banner position-relative">
        <div class="dark-overlay"></div>
        <img src="../upload/<?php echo $row_res['img'] ?>" class="img">
    </div>

    <!-- ข้อมูลร้าน -->
    <div class="container my-3">
        <div class="mx-2">
            <h3>ร้านอาหาร : <?php echo $row_res['res_name'] ?>
                <?php
                    include 'fav_btn.php';
                ?>
            </h3>
            <h5>ที่อยู่ : <?php echo $row_res['address'] ?> | ติดต่อ : <?php echo $row_res['phone'] ?></h5>
            <p><?php star($row_res['star'], $row_res['qty_sale']) ?></p>
        </div>
    </div>

    <!-- แถบเมนู -->
    <ul class="nav nav-tabs ps-5 mb-5" id="food">
        <li class="nav-item ms-5">
            <a href="see_res.php#food" class="nav-link active">เมนูอาหาร</a>
        </li>
        <li class="nav-item">
            <a href="see_review.php#review" class="nav-link">รีวิวร้าน</a>
        </li>
        <li class="nav-item">
            <a href="fav_food.php#fav" class="nav-link">เมนูโปรด</a>
        </li>
    </ul>

    <div class="container-fluid">
        <div class="row my-5">
            <h1 class="text-center mb-3">หมวดหมู่อาหาร</h1>
            <?php
                // ดึงหมวดหมู่อาหารในร้านมาแสดง แล้วเช็คว่ามีไหม
                $select_type = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `res_id` = '$see_res' ");
                if($select_type -> num_rows > 0){
                    while($row_type = mysqli_fetch_array($select_type)){
            ?>
                <div class="col-lg-2 col-md-3 col-sm 4 col-6 p-1">
                    <a href="#<?php echo $row_type['food_type'] ?>" class="text-dark">
                        <div class="card hover-img shadow mb-3">
                            <div class="card-img-top hover-img" style="height: 200px;">
                                <img src="../upload/<?php echo $row_type['img'] ?>" class="img">
                            </div>

                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $row_type['food_type'] ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }} else { ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีหมวดหมู่อาหาร</p>
            <?php } ?>
        </div>
    </div>

    <!-- แถบที่แสดงหมวดหมู่ในร้าน -->
    <nav class="navbar navbar-expand navbar-light bg-light sticky-top shadow">
        <a href="search.php" class="btn btn-outline-primary mx-2">🔎</a>

        <!-- คลาส scroll เมื่อเนื้อหาในนี้ยาวเกินจะให้เลื่อนได้ -->
        <div class="container-fluid scroll">
            <ul class="navbar-nav text-nowrap">
                <?php
                    // เช็คว่ามีเมนูไหนในร้านที่มีส่วนลดไหม
                    $pro = mysqli_query($conn, "SELECT * FROM `food` WHERE `discount` != 0 AND `res_id` = '$see_res' ");
                    if($pro -> num_rows > 0){
                ?>
                    <li class="nav-item">
                        <a href="#promotion" class="nav-link">โปรโมชั่น</a>
                    </li>
                <?php } ?>

                <?php
                    // ดึงหมวดหมู่ทั้งหมดในร้านมาแสดง
                    $select_type = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `res_id` = '$see_res' ");
                    while($row_type = mysqli_fetch_array($select_type)){
                ?>
                    <li class="nav-item">
                        <a href="#<?php echo $row_type['food_type'] ?>" class="nav-link"><?php echo $row_type['food_type'] ?></a>
                    </li>
                <?php } ?>

                <?php
                    // เช็คว่ามีเมนูไหนในร้านที่หมวดหมู่เป็นไอดี 0 ไหม ก็คือเป็นหมวดหมู่อื่นๆ
                    $more = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_type_id` = 0 AND `res_id` = '$see_res' ");
                    if($more -> num_rows > 0){
                ?>
                    <li class="nav-item">
                        <a href="#อื่นๆ" class="nav-link">อื่นๆ</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
            // นำตัวแปรที่ดึงเมนูที่มีส่วนลดมาเช็คตรงนี้อีกครั้ง ถ้ามีก็จะวนลูปแสดงเมนูที่มีส่วนลด
            if($pro -> num_rows > 0){
        ?>
            <div class="pt-5" id="promotion">
                <h1 class="mt-4">โปรโมชั่น</h1>
                <div class="row">
                    <?php
                        while($row = mysqli_fetch_array($pro)){
                            // ดึงไฟล์ที่แสดงการ์ดเมนู
                            include 'food_item.php';
                        }
                    ?>
                </div>
            </div>
            <hr>
        <?php } ?>

        <?php
            // ดึงหมวดหมู่ทั้งหมดในร้านมาแสดง
            $select_type = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `res_id` = '$see_res' ");
            while($row_type = mysqli_fetch_array($select_type)){
        ?>
            <div class="pt-5" id="<?php echo $row_type['food_type'] ?>">
                <h1 class="mt-4"><?php echo $row_type['food_type'] ?></h1>

                <div class="row">
                    <?php
                        // เมื่อวนลูปอยูในแต่ละหมวดหมู่ก็จะดึงเมนูที่อยู่ในหมวดหมู่นั้นๆทั้งหมดมาแสดง
                        $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `res_id` = '$see_res' AND `food_type_id` = '".$row_type['food_type_id']."' ");

                        // เช็คว่ามีเมนูอยู่ในหมวดหมู่ที่กำลังวนลูปอยู่ไหม
                        if($select -> num_rows > 0){
                            while($row = mysqli_fetch_array($select)){
                                // ดึงไฟล์ที่แสดงการ์ดเมนู
                                include 'food_item.php';
                            }
                        } else {
                            echo "<p class='text-center blockquote-footer'>ยังไม่มีเมนูอาหารในหมวดหมู่นี้</p>";
                        }
                    ?>
                </div>
            </div>
            <hr>
        <?php } ?>

        <?php
            // นำตัวแปรที่ดึงเมนูทีไอดีหมวดหมู่เป็น 0 มาเช็คอีกครั้งเพื่อแสดงหมวดหมู๋อื่นๆ
            if($more -> num_rows > 0){
        ?>
            <div class="pt-5" id="อื่นๆ">
                <h1 class="mt-4">อื่นๆ</h1>
                <div class="row">
                    <?php
                        while($row = mysqli_fetch_array($more)){
                            // ดึงไฟล์ที่แสดงการ์ดเมนู
                            include 'food_item.php';
                        }
                    ?>
                </div>
            </div>
            <hr>
        <?php } ?>
    </div>

    <?php
        // ดึงเมนูทั้งหมดในร้านมาวนลูปแสดง modal แต่ละเมนู เพื่อให้ food_item.php ที่ดึงมาทำงาน สามารถกดเพื่อเปิด modal ได้
        $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `res_id` = '$see_res' ");
        while($row = mysqli_fetch_array($select)){
            include 'food_modal.php';
        }
    ?>


    <!-- ปุ่มตะกร้าล่างขวาจอ -->
    <div class="position-fixed bottom-0 end-0 p-3">
        <a href="cart.php" class="position-relative btn btn-outline-primary">
            <h3>🛒</h3>
            <!-- เช็คจำนวนเมนูในตะกร้าของร้านนี้ ถ้ามากกว่า 0 จะแสดงจำนวนในจุดสีแดง -->
            <?php if(count($_SESSION['cart_arr'][$see_res]) > 0){ ?>
                <span class="position-absolute top-0 start-100 rounded-pill bg-danger translate-middle badge"><?php echo count($_SESSION['cart_arr'][$see_res]) ?></span>
            <?php } ?>
        </a>
    </div>
</body>
</html>