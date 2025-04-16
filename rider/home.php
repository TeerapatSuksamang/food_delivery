<div class="container">
    <div class="row my-5">
        <div class="col-md-6">
            <h2>ร้านอาหาร</h2>
        </div>
        <div class="col-md-6">
            <form action="index.php" class="d-flex gap-2 float-end" method="get">
                <?php
                    // เช็คค่า get find ถ้าไม่มีให้เป็น ''
                    $find = ($_GET['find'] ?? '');

                    // ถ้าไม่ใช่ '' แสดงว่ามีการค้นหา ก็จะแสดงปุ่มรีเซ็ท
                    if($find != ''){
                ?>
                    <a href="index.php" class="btn btn-warning text-nowrap">รีเซ็ท</a>
                <?php } ?>
                <input type="text" class="form-control" name="find" placeholder="ร้านไหนดีสุดหล่อ" value="<?php echo $find ?>" required>
                <input type="submit" class="btn btn-primary" value="ค้นหา">
            </form>
        </div>

        <?php  
            // เช็คการค้นหา และดึงข้อมูลร้านตามคำค้นหา
            if($find != ''){
                $select = mysqli_query($conn, "SELECT `restaurant`.* , `restaurant_type`.`res_type`
                            FROM `restaurant`
                            LEFT JOIN `restaurant_type`
                            ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id`
                            WHERE `restaurant`.`status` = 1 AND `restaurant`.`res_name` LIKE '%$find%' "); 
            } else {
                $select = mysqli_query($conn, "SELECT `restaurant`.* , `restaurant_type`.`res_type`
                            FROM `restaurant`
                            LEFT JOIN `restaurant_type`
                            ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id`
                            WHERE `restaurant`.`status` = 1 "); 
            }

            // ถ้าพบร้าน
            if($select -> num_rows > 0){
                while($row = mysqli_fetch_array($select)){
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1">
                <a href="see_res.php?see_res=<?php echo $row['res_id'] ?>" class="text-dark">
                    <div class="card hover-img shadow mb-3">
                        <div class="card-img-top hover-img" style="height: 200px;">
                            <img src="../upload/<?php echo $row['img'] ?>" class="img">
                        </div>

                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row['res_name'] ?></h4>
                            <h6>
                                <?php echo $row['res_type'] ?> | ⭐
                                <!-- เช็คคะแนนดาว -->
                                <?php echo ($row['star'] > 0 ? $row['star'].'คะแนน' : 'ยังไม่มีคะแนน') ?></h6>
                            <p class="text-truncate"><?php echo $row['address'] ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php }} else { ?>
            <p class="text-center blockquote-footer my-3">ไม่พบร้านอาหารที่ค้นหา</p>
        <?php } ?>
    </div>
</div>