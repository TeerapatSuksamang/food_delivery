<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขเมนูอาหาร</title>
</head>
<body>
    <?php
        include_once 'nav.php';

        // เช็คว่ามีค่า get food_id มาไหม ถ้าไม่มีให้เป็น '' ค่าว่าง
        $food_id = ($_GET['food_id'] ?? '');

        // เช็คว่า food_id ที่รับมาว่า ถูกต้อง หรือว่า มีอยู่ในร้านหรือไม่
        $select = mysqli_query($conn, "SELECT `food`.* , `food_type`.`food_type`
                                    FROM `food`
                                    LEFT JOIN `food_type`
                                    ON `food`.`food_type_id` = `food_type`.`food_type_id`
                                    WHERE `food`.`res_id` = '$res_id' AND `food`.`food_id` = '$food_id' ");
        if($select -> num_rows > 0){
            $row = mysqli_fetch_array($select);
    ?>
        <div class="container">
            <div class="row justify-content-center my-5">
                <div class="col-md-6">
                    <form action="food_manage.php" class="card shadow p-3" method="post" enctype="multipart/form-data">
                        <h1 class="text-center mb-3">แก้ไขเมนูอาหาร</h1>
                        <input type="hidden" name="food_id" value="<?php echo $food_id ?>">

                        <label for="">ชื่อเมนูอาหาร</label>
                        <input type="text" class="form-control mb-3" name="food_name" value="<?php echo $row['food_name'] ?>" required>

                        <label for="">รูปภาพ</label>
                        <center>
                            <img src="../upload/<?php echo $row['img'] ?>" class="border mb-2 rounded" style="width:  10rem;" id="preview">
                        </center>
                        <input type="file" class="form-control mb-3" name="img" id="img_upload">

                        <label for="">ราคา</label>
                        <input type="number" class="form-control mb-3" name="price" value="<?php echo $row['price'] ?>" required>

                        <label for="">หมวดหมู่อาหาร</label>
                        <select name="food_type" class="form-select mb-3">
                            <!-- แสดงหมวดหมู่อาหารทั้งหมดของร้าน -->
                            <?php
                                $select_type = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `res_id` = '$res_id' ");
                                while($row_type = mysqli_fetch_array($select_type)){
                            ?>
                                <!-- เช็ค ถ้าไอดีหมวดหมู่ของเมนูนี้ ตรงกับ หมวดหมู่ไหนที่ดึงมา ก็จะแสดง selected เพื่อบอกว่าตอนนี้เป็นหมวดหมู่นั้นๆอยู่ -->
                                <option     
                                    value="<?php echo $row_type['food_type_id'] ?>" 
                                    <?php echo ($row['food_type_id'] == $row_type['food_type_id'] ? 'selected' : '' ) ?>
                                >
                                    <?php echo $row_type['food_type'] ?>
                                </option>
                            <?php } ?>

                            <!-- เช็ค ถ้าไอดีหมวดหมู่ของเมนูนี้เป็น 0 แสดงว่าเป็นหมวดหมู่อื่นๆ ก็จะแสดง selected ว่าตอนนี้เป็นหมวดหมู่อื่นๆ -->
                            <option value="0" <?php echo ($row['food_type_id'] == 0 ? 'selected' : '') ?> >อื่นๆ</option>
                        </select>

                        <div class="d-flex gap-3">
                            <a href="index.php" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                            <input type="submit" class="btn btn-success w-100" name="food_edit" value="ยืนยัน">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-center blockquote-footer my-5">ไม่พบเมนูที่ต้องการแก้ไข</p>
    <?php } ?>

    <script src="../function.js"></script>
</body>
</html>