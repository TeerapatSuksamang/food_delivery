<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ</title>
</head>
<body>
    <?php

        include_once 'nav.php';

        // ประเภทออร์เดอร์
        $cate = ($_GET['cate'] ?? '');
        // เช็คถ้าค่าประเภทออร์เดอร์ไม่ถูกต้อง ให้เป็นหน้าเริ่มต้น
        if(!in_array($cate, ['cancel', 'success', ''])){
            header('location: history.php');
        }

        // เช็คและกำหนดคลาสสีของปุ่มให้รู้ว่าตอนนี้เลือกประเภทไหนอยู่
        $all = ($cate == '' ? 'primary' : 'outline-primary');
        $cancel = ($cate == 'cancel' ? 'warning' : 'outline-warning');
        $success = ($cate == 'success' ? 'success' : 'outline-success');

        // จัดเรียงออร์เดอร์
        $arrange = ($_GET['arrange'] ?? '');
    ?>

    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <h1 class="text-center mb-3">ประวัติการสั่งซื้อ</h1>
            <div class="col-md-10 mb-3 pb-1" style="border-bottom: .8px solid #333;">
                <!-- ปุ่มเลือกประเภทออร์เดอร์ และแสดงค่าตัวแปลที่เช็คไว้ก่อนหน้านี้ มาต่อจาก btn- เพื่อรวมกันเป็นชื่อคลาสปุ่ม -->
                <a href="history.php?arrange=<?php echo $arrange ?>" class="btn btn-<?php echo $all ?>">ทั้งหมด</a>
                <a href="history.php?cate=cancel&arrange=<?php echo $arrange ?>" class="btn btn-<?php echo $cancel ?> text-dark">ถูกยกเลิก</a>
                <a href="history.php?cate=success&arrange=<?php echo $arrange ?>" class="btn btn-<?php echo $success ?>">สำเร็จ</a>

                <span class="float-end ">
                    <form action="history.php" method="get" class="d-flex gap-2">
                        <input type="hidden" name="cate" value="<?php echo $cate ?>">
                        <select name="arrange" class="form-select" onchange="submitForm(this);">
                            <option value="1" <?php echo ($arrange == 1 ? 'selected' : '') ?>>เก่าที่สุด</option>
                            <option value="2" <?php echo ($arrange == 2 ? 'selected' : '') ?>>ใหม่ที่สุด</option>
                            <option value="3" <?php echo ($arrange == 3 ? 'selected' : '') ?>>คะแนนมากที่สุด</option>
                        </select>
                    </form>
                </span>
            </div>
            
            <?php
                // เช็คการจัดเรียงออร์เดอร์
                if($arrange == 1){
                    $arr = 'ORDER BY `date` ASC, `time` ASC  ';
                } else if($arrange == 2){
                    $arr = 'ORDER BY `date` DESC, `time` DESC  ';
                } else if($arrange == 3){
                    $arr = 'ORDER BY `star` DESC ';
                } else {
                    $arr = 'ORDER BY `date` ASC ';
                }

                // เช็คประเภทออร์เดอร์ แล้วดึงออร์เดอร์ตามเงื่อนไข
                if($cate == ''){
                    $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `user_id` = '$user_id' AND (`status` = 7 OR `status` = -1) $arr");
                } else if($cate == 'cancel'){
                    $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `user_id` = '$user_id' AND `status` = -1 $arr");
                } else if($cate == 'success'){
                    $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `user_id` = '$user_id' AND `status` = 7 $arr");
                }

                // เช็คว่ามีออร์เดอร์หรือยัง
                if($select -> num_rows > 0){
                    // แล้วดึงส่วนสำหรับแสดงรายละเอียดออร์เดอร์จาก template
                    include '../template/status.php';
                }else{
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีประวัติการสั่งซื้อ</p>
            <?php } ?>
        </div>
    </div>

    <script>
        // ถ้ามีการเลือก option ใน select จะกด submit อัตโนมัติ
        function submitForm(select) { 
            select.form.submit();
        }
    </script>
</body>
</html>