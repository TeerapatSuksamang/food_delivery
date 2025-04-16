<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มส่วนลด (%)</title>
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
                        <h1 class="text-center mb-3">เพิ่มส่วนลด (%)</h1>
                        <input type="hidden" name="food_id" value="<?php echo $food_id ?>">

                        <label for="">ชื่อเมนูอาหาร</label>
                        <input type="text" class="form-control mb-3" name="food_name" value="<?php echo $row['food_name'] ?>" readonly>

                        <label for="">รูปภาพ</label>
                        <center>
                            <img src="../upload/<?php echo $row['img'] ?>" class="border mb-2 rounded" style="width:  10rem;" id="preview">
                        </center>

                        <label for="">ราคา</label>
                        <input type="number" class="form-control mb-3" name="price" value="<?php echo $row['price'] ?>" readonly>

                        <label for="">เพิ่มส่วนลด (%)</label>
                        <input type="number" min="0" max="99" class="form-control mb-3" name="discount" value="<?php echo $row['discount'] ?>" required>

                        <div class="d-flex gap-3">
                            <a href="index.php" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                            <input type="submit" class="btn btn-success w-100" name="food_discount" value="ยืนยัน">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-center blockquote-footer my-3">ไม่พบเมนูที่ต้องการเพิ่มส่วนลด</p>
    <?php } ?>

    <script src="../function.js"></script>
</body>
</html>