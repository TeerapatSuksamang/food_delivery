<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาเมนูอาหาร</title>
</head>
<body>
    <?php
    
        include_once 'nav.php';
        
        // เช็คไอดีร้านที่กำลังดูแล้วเก็บไอดีลง session
        if(isset($_GET['see_res'])){
            $_SESSION['see_res'] = $_GET['see_res'];
        }
        // เก็บลงตัวแปรธรรมดาเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า ประหยัดเวลา
        $see_res = $_SESSION['see_res'];

        // ดึงข้อมูลของร้านที่กำลังดูอยู๋
        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$see_res' ");
        // เช็คว่ามีไอดีร้านที่รับมาไหม ถ้าไม่มีก็จะเด้งกลับไปหน้าหลัก
        if($select_res -> num_rows <= 0){
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา');
        }
        $row_res = mysqli_fetch_array($select_res);

        // เช็ค ถ้าไม่มีการเพิ่มเมนูของร้านนี้ลงตะกร้า จะสร้างเป็น array เปล่าไว้ก่อน
        if(!isset($_SESSION['cart_arr'][$see_res])){
            $_SESSION['cart_arr'][$see_res] = array();
        }

        // ถ้าไม่มีค่า get find ให้เก็บค่าเป็น '' สตริงเปล่า
        $find = ($_GET['find'] ?? '');

    ?>

    <div class="container">
        <div class="row my-5">
            <h3>
                <a href="see_res.php" class="btn p-0"><h3>&#11148;</h3></a>
                ค้นหาเมนูอาหาร
            </h3>

            <!-- ฟอร์มค้นหาเมนู -->
            <form action="search.php" class="form-control p-3 shadow mb-3 d-flex gap-2" method="get">
                <input type="text" class="form-control" name="find" placeholder="เมนูไหนดีสุดหล่อ" value="<?php echo $find ?>" required>
                <?php
                    // เช็คถ้ามีการค้นหาจะแสดงปุ่มรีเซ็ท
                    if($find != ''){
                ?>
                    <a href="search.php" class="btn btn-warning text-nowrap">รีเซ็ท</a>
                <?php } ?>
                <input type="submit" class="btn btn-primary" value="ค้นหา">
            </form>

            <?php
                // ถ้ามีการค้นหา จะดึงเมนูตามคำค้นหา
                if($find != ''){
                    $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `res_id` = '$see_res' AND `food_name` LIKE '%$find%' ");
                } else {
                    $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `res_id` = '$see_res' ");
                }

                // เช็คว่าดึงเมนูมาได้ไหม
                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
                        include 'food_item.php'; // การ์ดที่แสดงเมนู
                        include 'food_modal.php'; // modal เมื่อกดทีการ์ดเมนู
                    }
                } else {
            ?>
                <p class="text-center blockquote-footer my-3">ไม่พบเมนูที่ค้นหา</p>
            <?php } ?>
        </div>
    </div>

    <!-- ปุ่มตะกร้าชิดล่างขวาจอ -->
    <div class="position-fixed bottom-0 end-0 p-3">
        <a href="cart.php" class="position-relative btn btn-outline-primary">
            <h3>🛒</h3>
            <!-- เช็คจำนวนเมนูในตะกร้าของร้านนี้ ถ้ามากกว่า 0 จะแสดงจำนวนในจุดสีแดง -->
            <?php if(count($_SESSION['cart_arr'][$see_res]) > 0){ ?>
                <span class="position-absolute top-0 start-100 rounded-pill bg-danger translate-middle badge"><?php echo count($_SESSION['cart_arr'][$see_res]) ?></span>
            <?php } ?>
        </a>
    </div>
</body>
</html>