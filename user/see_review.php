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
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา');
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
    <ul class="nav nav-tabs ps-5 mb-5" id="review">
        <li class="nav-item ms-5">
            <a href="see_res.php#food" class="nav-link">เมนูอาหาร</a>
        </li>
        <li class="nav-item">
            <a href="see_review.php#review" class="nav-link active">รีวิวร้าน</a>
        </li>
        <li class="nav-item">
            <a href="fav_food.php#fav" class="nav-link">เมนูโปรด</a>
        </li>
    </ul>

    <div class="container">
        <div class="row my-5">
            <h1 class="text-center mb-3">รีวิวร้านอาหาร</h1>

            <?php
                // ดึงข้อมูลออร์เดอร์ที่สำเร็จแล้ว กับรูปภาพโปรไฟล์ของลูกค้าคนที่สั่ง
                $select = mysqli_query($conn, "SELECT `order_detail`.* , `user`.`img`
                                FROM `order_detail`
                                LEFT JOIN `user`
                                ON `order_detail`.`user_id` = `user`.`user_id`
                                WHERE `order_detail`.`res_id` = '$see_res' AND `order_detail`.`status` = 7 ");

                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
            ?>
                <div class="card p-0 mb-3 shadow">
                    <div class="card-header p-3">
                        <div class="d-flex gap-2 align-items-center ">
                            <div class="rounded-circle hover-img border" style="width: 3.8rem; height: 3.8rem;">
                                <img src="../upload/<?php echo $row['img'] ?>" class="img">
                            </div>

                            <h4 class="align-items-center ">
                                <?php echo $row['full_name'] ?>
                                <br>
                                <?php star2($row['star']) ?>
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <span class="text-secondary"><?php echo $row['date'] ?> | <?php echo $row['time'] ?></span>
                        <h4><?php echo $row['review'] ?></h4>

                        <span class="text-secondary">รายการอาหารที่สั่ง : 
                            <?php
                                // เลือกเมนูทั้งหมดของออร์เดอร์นี้
                                $select_food = mysqli_query($conn, "SELECT * FROM `food_order` WHERE `order_id` = '".$row['order_id']."' ");
                                while($row_food = mysqli_fetch_array($select_food)){
                                    echo $row_food['food_name'].', ';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            <?php }} else { ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีรีวิวร้านอาหาร</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>