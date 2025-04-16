<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประเภทร้านอาหาร</title>
</head>
<body>
    <?php

        include_once 'nav.php';
        // เก็บไอดีประเภทร้านที่ได้กดเข้ามาดู ถ้าไม่มีจะเก็บค่าเป็น '' 
        $res_type_id = ($_GET['res_type_id'] ?? '');

        // ดึงชื่อประเภทนี้
        $select_type = mysqli_query($conn, "SELECT `res_type` FROM `restaurant_type` WHERE `res_type_id` = '$res_type_id' ");
        $row_type = mysqli_fetch_array($select_type);

    ?>
    <div class="container">
        <div class="row my-5">
            <h3>
                <!-- &#11148; เป็น html unicode แสดงไอคอน ย้อนกลับ ⮌ -->
                <a href="index.php?page=home" class="btn p-0"><h3>&#11148;</h3></a>
                <?php echo ($row_type['res_type'] ?? 'ไม่พบข้อมูล') ?>
            </h3>

            <?php
                // ดึงข้อมูลร้านในหมวดหมู่นี้
                $select = mysqli_query($conn, "SELECT `restaurant`.* , `restaurant_type`.`res_type`
                            FROM `restaurant`
                            LEFT JOIN `restaurant_type`
                            ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id`
                            WHERE `restaurant`.`status` = 1 AND `restaurant`.`res_type_id` = '$res_type_id' "); 

                // เช็คว่ามีร้านในหมวดหมู่นี้ไหม
                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1">
                    <h3 class="position-absolute m-2" style="z-index: 999;">
                        <?php
                            // เก็บไอดีร้านลงตัวแปลนี้ แล้วดึงปุ่มกดใจจากไฟล์ fav_btn เพราะไฟล์นั้นใช้ตัวแปรนี้
                            $see_res = $row['res_id'];
                            include 'fav_btn.php';
                        ?>
                    </h3>

                    <!-- แสดงข้อมูลร้าน และลิงค์ไปหน้าร้าน -->
                    <a href="see_res.php?see_res=<?php echo $row['res_id'] ?>" class="text-dark">
                        <div class="card hover-img shadow mb-3">
                            <div class="card-img-top hover-img" style="height: 200px;">
                                <img src="../upload/<?php echo $row['img'] ?>" class="img">
                            </div>

                            <div class="card-body">
                                <h4 class="card-title"><?php echo $row['res_name'] ?></h4>
                                <h6><?php echo $row['res_type'] ?> | ⭐<?php echo ($row['star'] > 0 ? $row['star'].'คะแนน' : 'ยังไม่มีคะแนน') ?></h6>
                                <p class="text-truncate"><?php echo $row['address'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }} else { ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีร้านอาหารในประเภทนี้</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>