<?php
    // ถ้าไม่มีค่า get find จะให้เป็น ''
    $find = ($_GET['find'] ?? '');

    // เช็คถ้าค่าเมื่อกี้เป็น '' แสดงว่ายังไม่มีการค้นหา ก็จะแสดงส่วนประเภทร้านอาหาร
    if($find == ''){
?>
    <div class="container-fluid">
        <div class="row my-5">
            <h1 class="text-center">ประเภทร้านอาหาร</h1>

            <!-- แถบเลื่อนซ้ายขวา เมื่อเนื้อหาในนี้ยาวเกิน -->
            <div class="scroll mb-3">
                <?php
                    // ดึงประเภทร้านทั้งหมด
                    $select_type = mysqli_query($conn, "SELECT * FROM `restaurant_type` ");
                    if($select_type -> num_rows > 0){
                        while($row_type = mysqli_fetch_array($select_type)){
                ?>
                    <div class="box text-center mx-2">
                        <a href="see_res_type.php?res_type_id=<?php echo $row_type['res_type_id']; ?>" class="link-img hover-img shadow border">
                            <img src="../upload/<?php echo $row_type['img'] ?>" class="img">
                        </a>
                        <br>

                        <a href="see_res_type.php?res_type_id=<?php echo $row_type['res_type_id']; ?>" class="text-dark"><?php echo $row_type['res_type'] ?></a>
                    </div>
                <?php }} else { ?>
                    <p class="text-center blockquote-footer my-3">ยังไม่มีประเภทร้านอาหาร</p>
                <?php } ?>
            </div>
            <hr>
        </div>
    </div>
<?php } ?>

<div class="container">
    <div class="row my-5">
        <div class="col-md-6">
            <h2>ร้านอาหาร</h2>
        </div>
        <div class="col-md-6">
            <form action="index.php" class="d-flex gap-2 float-end" method="get">
                <!-- เช็คถ้ามีการค้นหา จะแสดงปุ่มรีเซ็ท -->
                <?php if($find != ''){ ?>
                    <a href="index.php" class="btn btn-warning text-nowrap">รีเซ็ท</a>
                <?php } ?>
                <input type="text" class="form-control" name="find" placeholder="ร้านไหนดีสุดหล่อ" value="<?php echo $find ?>" required>
                <input type="submit" class="btn btn-primary" value="ค้นหา">
            </form>
        </div>

        <?php  
            // ถ้ามีการค้นหา ดึงข้อมูลร้านตามคำค้นหา
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

            // เช็คว่ามีร้านไหม
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
            <p class="text-center blockquote-footer my-3">ไม่พบร้านอาหารที่ค้นหา</p>
        <?php } ?>
    </div>
</div>