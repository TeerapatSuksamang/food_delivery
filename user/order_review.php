<?php

    include_once 'nav.php';

    // กดเพิ่มดาว
    if(isset($_GET['star'])){
        $_SESSION['star'][$_GET['order_id']] = $_GET['star'];
        back();
        // print_r($_SESSION['star'][$_GET['order_id']]);
    }

    // สำหรับรีเซ็ทค่าดาวช่วงที่เช็คการทำงาน
    if(isset($_GET['set'])){
        unset($_SESSION['star']);
    }

    // เมื่อกดรีวิว
    if(isset($_POST['submit_review'])){
        $order_id = $_POST['order_id'];
        $res_id = $_POST['res_id'];
        $review = $_POST['review'];
        $star = $_SESSION['star'][$order_id];

        // บันทึกคะแนนและข้อความรีวิวลง order_detail และอัพเดทสถานะเป็น 7
        $sql_order = mysqli_query($conn, "UPDATE `order_detail` SET `status` = 7, `star` = '$star', `review` = '$review' WHERE `order_id` = '$order_id' ");

        // เช็คว่าบันทึกสำเร็จไหม
        if($sql_order){
            // ดึงข้อมูลร้านที่กำลังรีวิว
            $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$res_id' ");
            $row_res = mysqli_fetch_array($select_res);

            // มีวิธีดีกว่านี้คือใช้ count sql แต่ตอนแข่งจำไม่ได้และข้อมูลนี้ถูกใช้ในหลายหน้า กลัวทำไม่ทันเลยใช้วิธีนี้
            $res_qty = $row_res['qty_sale'] + 1; // นำจำนวนการขายในร้านมาเพิ่มอีก 1
            $res_rating = $row_res['rating'] + $star; // นำคะแนนทั้งหมดของร้านมาบวกกับคะแนนดาวที่พึ่งกดรีวิว
            $res_star = ($res_rating / $res_qty); // คะแนนทั้งหมด หาร จำนวนการขายทั้งหมด จะได้เป็นคะแนนดาวเฉลี่ย
            $res_star = number_format($res_star, 2); // ปรับทศนิยมเป็น 2ตำแหน่ง

            // อัพเดท คะแนนดาว จำนวนการสั่ง และคะแนนทั้งหมด ที่คำนวนเมื่อกี้
            $sql_res = mysqli_query($conn, "UPDATE `restaurant` SET `star` = '$res_star', `rating` = '$res_rating', `qty_sale` = '$res_qty' WHERE `res_id` = '$res_id' ");

            // เช็คว่าอัพเดทสำเร็จไหม
            if($sql_res){
                // ดึงไอดีของเมนูทีสั่งไปในออร์เดอร์นี้ทั้งหมด
                $select_food_order = mysqli_query($conn, "SELECT `food_id` FROM `food_order` WHERE `order_id` = '$order_id' ");
                while($row_food_order = mysqli_fetch_array($select_food_order)){
                    $food_id = $row_food_order['food_id'];

                    // ดึงข้อมูลเมนูจากไอดีที่สั่งไปในออร์เดอรืนี้
                    $select_food = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_id` = '$food_id' ");
                    $row_food = mysqli_fetch_array($select_food);
        
                    $food_qty = $row_food['qty_sale'] + 1; // นำจำนวนการขายของเมนูนี้มาเพิ่มอีก 1
                    $food_rating = $row_food['rating'] + $star; // นำคะแนนทั้งหมดมาบวกกับคะแนนดาวที่พึ่งกดรีวิว
                    $food_star = ($food_rating / $food_qty); // คะแนนทั้งหมด หารจำนวนการขายทั้งหมด ได้เป็นคะแนนดาวเฉลี่ย
                    $food_star = number_format($food_star, 2); // ปรับทศนิยมเป็น 2ตำแหน่ง
        
                    // อัพข้อมูลเมื่อกี้ลงให้แต่ละเมนู ในตาราง food
                    $sql_food = mysqli_query($conn, "UPDATE `food` SET `star` = '$food_star', `rating` = '$food_rating', `qty_sale` = '$food_qty' WHERE `food_id` = '$food_id' ");        
                }

                // เช็คว่าอัพเดทสำเร็จไหม
                if($sql_food){
                    alert('รีวิวสำเร็จ ขอบคุณที่ใช้บริการ', 'history.php');
                } else {
                    alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง (3)');
                }
            } else {
                alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง (2)');
            }
        } else {
            alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง (1)');
        }
    }

?>