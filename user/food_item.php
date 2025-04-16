<!-- ไฟล์นี้สำหรับแสดงการ์ดของเมนู -->
<div class="col-lg-3 col-md-4 col-sm-6 col-6 p-0 position-relative">
    <!-- เช็คสถานะคงเหลือ -->
    <?php if($row['status'] == 0){ ?>
        <span class="out"><i>หมด</i></span>
    <?php } ?>

    <!-- ปุ่มกดเพิ่มเมนูโปรด -->
    <h3 class="position-absolute m-2" style="z-index: 999;">
        <?php
            // เช็คว่าเมนูในร้านที่กำลังแสดง ผู้ใช้ได้กดเพิ่มเป็นเมนูโปรดไหม ถ้าใช่จะแสดงปุ่มใจสีแดง
            $select_fav = mysqli_query($conn, "SELECT * FROM `fav_food` WHERE `res_id` = '$see_res' AND `user_id` = '$user_id' AND `food_id` = '".$row['food_id']."' ");
            if($select_fav -> num_rows > 0){
                $row_fav = mysqli_fetch_array($select_fav);
        ?>
            <a href="add_fav.php?un_food=<?php echo $row_fav['fav_id'] ?>" class="float-end fav">
                <span class="text-danger">❤</span>
            </a>
        <?php } else { ?>
            <a href="add_fav.php?fav_food=<?php echo $row['food_id'] ?>" class="float-end fav">
                <span>❤</span>
            </a>
        <?php } ?>
    </h3>

    <!-- ส่วนที่แสดงข้อมูลเมนู กดเพื่อเปิด modal ดูรายละเอียดเมนู -->
    <!-- 
        และเช็คใน data-bs-target 
        ถ้าเมนูอยู่ในสถานะคงเหลือจะแสดงไอดีของเมนู ซึ่งต่อกับ #see_food_ เพื่อเปิด modal ทีไอดีนี้เหมือนกัน (ทำงานร่วมกับไฟล์ food_modal.php)
        แต่ถ้าไม่ได้อยู่ในสถานะคงเหลือจะแสดง 0 ป้องกันไม่ให้สามารถกดได้
    -->
    <a href="" class="text-dark" data-bs-toggle="modal" data-bs-target="#see_food_<?php echo ($row['status'] == 1 ? $row['food_id'] : 0) ?>">
        <div class="card hover-img shadow">
            <div class="card-img-top hover-img" style="height: 200px;">
                <img src="../upload/<?php echo $row['img'] ?>" class="img">
            </div>

            <div class="card-body">
                <h5 class="card-title"><?php echo $row['food_name'] ?></h5>
                <h6>
                    <!-- เช็คส่วนลดเมนู -->
                    <?php if($row['discount'] != 0){ ?>
                        <s class="text-secondary">฿<?php echo $row['price'] ?></s>
                        <span class="text-success">฿<?php echo discount($row['price'], $row['discount']) ?></span>
                        <span class="text-danger">(ลด - <?php echo $row['discount'] ?>%)</span>
                    <?php } else { echo '฿'.$row['price']; } ?>
                </h6>
                <p><?php star($row['star'], $row['qty_sale']) ?></p>
            </div>
        </div>
    </a>
</div>