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

        // เช็คว่ามีไอดีร้านที่รับมาไหม
        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$see_res' ");
        if($select_res -> num_rows <= 0){
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา');
        }
        $row_res = mysqli_fetch_array($select_res);

        // เช็ค ถ้าไม่มีการเพิ่มเมนูของร้านนี้ลงตะกร้า จะสร้างเป็น array เปล่าไว้ก่อน
        if(!isset($_SESSION['cart_arr'][$see_res])){
            $_SESSION['cart_arr'][$see_res] = array();
        }
    ?>
    <!-- แสดงรูปร้านเป็น banner -->
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

    <!-- menu bar -->
    <ul class="nav nav-tabs ps-5 mb-5" id="fav">
        <li class="nav-item ms-5">
            <a href="see_res.php#food" class="nav-link">เมนูอาหาร</a>
        </li>
        <li class="nav-item">
            <a href="see_review.php#review" class="nav-link">รีวิวร้าน</a>
        </li>
        <li class="nav-item">
            <a href="fav_food.php#fav" class="nav-link active">เมนูโปรด</a>
        </li>
    </ul>

    <div class="container">
        <div class="row my-5">
            <h1 class="text-center mb-3">เมนูโปรด</h1>

            <?php
                // ดึงเมนูโปรดในร้านทีผู้ใช้เพิ่มเอาไว้
                $select = mysqli_query($conn, "SELECT `fav_food`.* , `food`.*
                                FROM `fav_food`
                                JOIN `food`
                                ON `fav_food`.`food_id` = `food`.`food_id`
                                WHERE `fav_food`.`res_id` = '$see_res' AND `fav_food`.`user_id` = '$user_id' ");
                
                // เช็คว่ามีเมนูโปรดไหม
                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
                        include 'food_item.php';
                        include 'food_modal.php';
                    }
                } else {
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีเมนูโปรด<a href="see_res.php#food"> เลือกเมนูที่ชอบเลย!</a></p>
            <?php } ?>
        </div>
    </div>

    <!-- ปุ่มตะกร้า -->
    <div class="position-fixed bottom-0 end-0 p-3">
        <a href="cart.php" class="position-relative btn btn-outline-primary">
            <h3>🛒</h3>
            <!-- เช็คจำนวนเมนูในตะกร้าของร้านนี้ ถ้ามากกว่า 0 จะแสดงจำนวนในจุดสีแดง -->
            <?php if(count($_SESSION['cart_arr'][$see_res]) > 0){ ?>
                <span class="position-absolute top-0 start-100 rounded-pill bg-danger translate-middle badge">
                    <?php echo count($_SESSION['cart_arr'][$see_res]) ?>
                </span>
            <?php } ?>
        </a>
    </div>
</body>
</html>