
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
        // เก็บไอดีร้านไว้ใน session 
        if(isset($_GET['see_res'])){
            $_SESSION['rider_see_res'] = $_GET['see_res'];
        }
        $rider_see_res = $_SESSION['rider_see_res'];

        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$rider_see_res' ");
        // เช็คว่ามีไอดีร้านที่รับมาไหม ถ้าไม่มีก็จะเด้งกลับไปหน้าหลัก
        if($select_res -> num_rows <= 0){
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา', 'index.php');
        }
        $row_res = mysqli_fetch_array($select_res);

    ?>
    <!-- แสดงรูปร้าน -->
    <div class="banner position-relative">
        <div class="dark-overlay"></div>
        <img src="../upload/<?php echo $row_res['img'] ?>" class="img">
    </div>

    <!-- ข้อมูลร้าน -->
    <div class="container my-3">
        <div class="mx-2">
            <h3>ร้านอาหาร : <?php echo $row_res['res_name'] ?>
            </h3>
            <h5>ที่อยู่ : <?php echo $row_res['address'] ?> | ติดต่อ : <?php echo $row_res['phone'] ?></h5>
            <p><?php star($row_res['star'], $row_res['qty_sale']) ?></p>
        </div>
    </div>
    <hr>

    <!-- ออร์เดอร์ที่กำลังรอไรเดอร์รับ -->
    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <h1 class="text-center mb-3">รับออร์เดอร์</h1>
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `res_id` = '$rider_see_res' AND `status` = 2");
                if($select -> num_rows > 0){
                    include '../template/status.php';
                }else{
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีออร์เดอร์</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>