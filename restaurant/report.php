<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุปยอดขาย</title>
</head>
<body>
    <?php
    
        include_once 'nav.php';
        // วันที่เริ่มต้น - สิ้นสุด ที่จะให้แสดงออร์เดอร์
        $date1 = ($_GET['date1'] ?? '');
        $date2 = ($_GET['date2'] ?? '');

        // ประเภทออร์เดอร์
        $cate = ($_GET['cate'] ?? '');
        // เช็ค ถ้าค่าประเภทออร์เดอร์ไม่ถูกต้อง ให้เป็นหน้าเริ่มต้น
        if(!in_array($cate, ['cancel', 'success', ''])){
            header('location: report.php');
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
            <h1 class="text-center mb-3">รายงานสรุปยอดขาย วัน/เดือน/ปี</h1>
            <div class="col-md-10">
                <!-- ฟอร์มค้นหาออร์เดอร์ วันเริ่มต้น - สิ้นสุด -->
                <form action="" class="d-flex gap-2" method="get">
                    <input type="date" class="form-control" name="date1" value="<?php echo $date1 ?>">
                    <input type="date" class="form-control" name="date2" value="<?php echo $date2 ?>">
                    <!-- เช็คถ้ามีการค้นหา ให้แสดงป่มล้าง -->
                    <?php if($date1 != '' && $date2 != ''){ ?>
                        <a href="report.php" class="btn btn-warning">ล้าง</a>
                    <?php } ?>
                    <input type="submit" class="btn btn-primary" name="submit" value="ค้นหา">
                    <input type="hidden" name="cate" value="<?php echo $cate ?>">
                    <input type="hidden" name="arrange" value="<?php echo $arrange ?>">
                </form>

                <?php
                    // เช็คการจัดเรียงออร์เดอร์
                    if($arrange == 1){
                        $ar = 'ORDER BY `date` ASC, `time` ASC ';
                    } else if($arrange == 2){
                        $ar = 'ORDER BY `date` DESC, `time` DESC ';
                    } else if($arrange == 3){
                        $ar = 'ORDER BY `star` DESC ';
                    } else {
                        $ar = 'ORDER BY `date` ASC ';
                    }

                    // เช็คประเภทออร์เดอร์
                    if($cate == ''){
                        $status = "AND (`status` = 7 OR `status` = -1)";
                    } else if($cate == 'cancel'){
                        $status = "AND `status` = -1";    
                    } else if($cate == 'success'){
                        $status = "AND `status` = 7";    
                    }

                    // เช็คการค้นหาวันที่แสดงออร์เดอร์
                    if($date1 != '' && $date2 != ''){
                        $between = "AND `date` BETWEEN '$date1' AND '$date2' ";
                    } else {
                        $between = '';
                    }

                    // ดึงข้อมูลออร์เดอร์ตามเงื่อนไข
                    $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `res_id` = '$res_id' $status $between  $ar");
                    $select_sum = mysqli_query($conn, "SELECT SUM(`sum_price`) AS total FROM `order_detail` WHERE `res_id` = '$res_id' AND `status` = 7 $status $between $ar");

                    $row_sum = mysqli_fetch_array($select_sum);
                ?>
                <p class="text-success">รายได้รวมทั้งสิ้น <?php echo ($row_sum['total'] ?? 0) ?> บาท</p>

            </div>

            <div class=" col-md-10 mb-3 pb-1" style="border-bottom: .8px solid #333;">
                <!-- ปุ่มเลือกประเภทออร์เดอร์ และเช็คประเภทที่เลือกเพื่อแสดงคลาส bootstrap ให้เหมือนว่าเลือกปุ่มนั้นอยู่ -->
                <a href="report.php?arrange=<?php echo $arrange.'&date1='.$date1.'&date2='.$date2 ?>" class="btn btn-<?php echo $all ?>">ทั้งหมด</a>
                <a href="report.php?cate=cancel&arrange=<?php echo $arrange.'&date1='.$date1.'&date2='.$date2 ?>" class="btn btn-<?php echo $cancel ?> text-dark">ถูกยกเลิก</a>
                <a href="report.php?cate=success&arrange=<?php echo $arrange.'&date1='.$date1.'&date2='.$date2 ?>" class="btn btn-<?php echo $success ?>">สำเร็จ</a>

                <!-- เลือกการจัดเรียงออร์เดอร์ -->
                <span class="float-end ">
                    <form action="report.php" method="get" class="d-flex gap-2">
                        <input type="hidden" name="cate" value="<?php echo $cate ?>">
                        <input type="hidden" name="date1" value="<?php echo $date1 ?>">
                        <input type="hidden" name="date2" value="<?php echo $date2 ?>">

                        <select name="arrange" class="form-select" onchange="submitForm(this);">
                            <option value="1" <?php echo ($arrange == 1 ? 'selected' : '') ?>>เก่าที่สุด</option>
                            <option value="2" <?php echo ($arrange == 2 ? 'selected' : '') ?>>ใหม่ที่สุด</option>
                            <option value="3" <?php echo ($arrange == 3 ? 'selected' : '') ?>>คะแนนมากที่สุด</option>
                        </select>
                    </form>
                </span>
            </div>

            <?php
                // เช็คว่ามีออร์เดอร์หรือยัง
                if($select -> num_rows > 0){
                    // แล้วดึงส่วนสำหรับแสดงรายละเอียดออร์เดอร์จาก template
                    include '../template/status.php';
                }else{
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีรายงาน</p>
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