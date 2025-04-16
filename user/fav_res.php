<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านโปรด</title>
</head>
<body>
    <?php
        include_once 'nav.php';
    ?>

    <div class="container">
        <div class="row my-5">
            <h1 class="text-center mb-3">ร้านอาหารโปรด</h1>
            <?php  
                // ดึงร้านโปรดพร้อมประเภทร้าน ที่ผู้ใช้ได้เพิ่มเอาไว้
                $select = mysqli_query($conn, "SELECT `fav_res`.* , `restaurant`.* , `restaurant_type`.`res_type`
                                FROM `fav_res`
                                JOIN `restaurant` ON `fav_res`.`res_id` = `restaurant`.`res_id`
                                LEFT JOIN `restaurant_type` ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id`
                                WHERE `fav_res`.`user_id` = '$user_id' ");

                // เช็คว่ามีร้านโปรดไหม
                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1">
                    <!-- tag สำหรับแสดงปุ่มกดใจที่ดึงเข้ามา -->
                    <h3 class="position-absolute m-2" style="z-index: 999;">
                        <?php
                            // เก้บไอดีร้านลง $see_res เพราะไฟล์ fav_btn ต้องใช้ตัวแปรชื่อนี้
                            $see_res = $row['res_id'];
                            include 'fav_btn.php';
                        ?>
                    </h3>

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
                <p class="text-center blockquote-footer my-3">ยังไม่มีร้านโปรด<a href="index.php"> เลือกร้านอาหารที่ชอบเลย!</a></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>