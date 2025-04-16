<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขหมวดหมู่อาหาร</title>
</head>
<body>
    <?php
    
        include_once 'nav.php';

        // เช็คว่ามีค่า get food_type_id มาไหม ถ้าไม่มีให้เป็น '' ค่าว่าง
        $food_type_id = ($_GET['food_type_id'] ?? '');

        // เช็คค่าที่รับมาว่า มีอยู่ในร้านหรือไม่
        $select = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `food_type_id` = '$food_type_id' AND `res_id` = '$res_id' ");
        if($select -> num_rows > 0){
            $row = mysqli_fetch_array($select);
    ?>
        <div class="container">
            <div class="row justify-content-center my-5">
                <div class="col-md-6">
                    <form action="food_manage.php" class="card shadow p-3" method="post" enctype="multipart/form-data">
                        <h1 class="text-center mb-3">แก้ไขหมวดหมู่อาหาร</h1>
                        <input type="hidden" name="food_type_id" value="<?php echo $food_type_id ?>">

                        <label for="">หมวดหมู่อาหาร</label>
                        <input type="text" class="form-control mb-3" name="food_type" value="<?php echo $row['food_type'] ?>" required>

                        <label for="">รูปภาพ</label>
                        <center>
                            <img src="../upload/<?php echo $row['img'] ?>" class="border mb-2 rounded" style="width:  10rem;" id="preview">
                        </center>
                        <input type="file" class="form-control mb-3" name="img" id="img_upload">

                        <div class="d-flex gap-3">
                            <a href="index.php" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                            <input type="submit" class="btn btn-success w-100" name="type_edit" value="ยืนยัน">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-center blockquote-footer my-5">ไม่พบหมวดหมู่ที่ต้องการแก้ไข</p>
    <?php } ?> 

    <script src="../function.js"></script>
</body>
</html>