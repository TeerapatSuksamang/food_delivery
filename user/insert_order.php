<?php

    include_once 'nav.php';
    // เมื่อกดซื้อ
    if(isset($_POST['buy_order'])){
        $see_res = $_SESSION['see_res']; // ไอดีร้านที่กดสั่ง

        $all_price = $_POST['all_price']; // ราคาเมนูทั้งหมด
        $cpn_discount = $_POST['cpn_discount']; // ส่วนลด
        $sum_price = $_POST['sum_price']; // ราคาหลังหักส่วนลด

        // ข้อมูลผู้สั่ง
        $full_name = $_POST['full_name']; 
        $address = $_POST['address']; 
        $phone = $_POST['phone']; 
        include '../upload.php';

        // ถ้าราคาหลังหักส่วนลดน้อยกว่า 0 จะไม่สามารถสั่งได้
        if($sum_price > 0){
            // เช็คการอัพโหลดรูป ถ้ามีการอัพโหลดแสดงว่าเพิ่มสลิปการชำระเงินเข้ามา และบันทึกข้อมูลการสั่งลงตาราง order_detail
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                $sql_order = mysqli_query($conn, "INSERT INTO `order_detail`(`res_id`, `all_price`, `cpn_discount`, `sum_price`, `user_id`, `full_name`, `address`, `phone`, `slip`, `status`)
                VALUES('$see_res', '$all_price', '$cpn_discount', '$sum_price', '$user_id', '$full_name', '$address', '$phone', '$img', 1) ");
            } else {
                $sql_order = mysqli_query($conn, "INSERT INTO `order_detail`(`res_id`, `all_price`, `cpn_discount`, `sum_price`, `user_id`, `full_name`, `address`, `phone` )
                VALUES('$see_res', '$all_price', '$cpn_discount', '$sum_price', '$user_id', '$full_name', '$address', '$phone' ) ");
            }

            // เช็คว่าบันทึกข้อมูลการสั่งสำเร็จไหม
            if($sql_order){
                // ดึงไอดีออร์เดอร์ที่พึ่งบันทึกเมื่อกี้
                $order_id = mysqli_insert_id($conn);

                // ลูปข้อมูลจาก session ตะกร้าในร้านที่กดสั่ง แล้วบันทึกลงตาราง food_order
                foreach($_SESSION['cart_arr'][$see_res] as $food_id => $qty){
                    // ดึงข้อมูลเมนูตามไอดีในตะกร้า
                    $select_food = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_id` = '$food_id' ");
                    $row = mysqli_fetch_array($select_food);

                    // เช็คส่วนลด 
                    if($row['discount'] != 0){
                        $price = discount($row['price'], $row['discount']);
                    } else {
                        $price = $row['price'];
                    }
                    // ราคารวมของเมนูหลังลดราคาแล้ว
                    $total = ($price * $qty);

                    // บันทึกเมนูในตะกร้า ลงในตาราง
                    $sql_food = mysqli_query($conn, "INSERT INTO `food_order`(`order_id`, `food_id`, `food_name`, `img`, `price`, `discount`, `qty`, `total_price`)
                    VALUES('$order_id', '$food_id', '".$row['food_name']."', '".$row['img']."', '".$row['price']."', '".$row['discount']."', '$qty', '$total') ");
                }

                // เช็คว่าบันทึกเมนูสำเร็จไหม ถ้าสำเร็จก็จะลบข้อมูลในตะกร้าของร้านนี้ออก แล้วไปหน้าสถานะ status.php
                if($sql_food){
                    unset($_SESSION['cart_arr'][$see_res]);
                    alert('สั่งซื้อสำเร็จ รอรับออร์เดอร์สักครู่', 'status.php');
                } else {
                    alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง (2)');
                }
            } else {
                alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง (1)');
            }
        } else {
            alert('ยังไม่มีเมนูในตะกร้า เลือกเมนูที่ต้องการได้เลย!', 'see_res.php');
        }
    }

?>