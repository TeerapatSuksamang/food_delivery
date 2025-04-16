<?php

    include_once 'nav.php';
    include_once '../template/load.html';

    // ---------- จัดการหมวดหมู่อาหาร ----------

    // เพิ่มหมวดหมู่อาหาร
    if(isset($_POST['add_food_type'])){
        $food_type = $_POST['food_type'];
        include '../upload.php';

        // เช็คว่าชื่อหมวดหมู่นี้ มีในร้านหรือยัง
        $select = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `food_type` = '$food_type' AND `res_id` = '$res_id' ");
        if($select -> num_rows > 0){
            alert('มีหมวดหมู่อาหารนี้ในร้านแล้ว');
        } else {
            // เช็คการอัพโหลดรูป
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                $sql = mysqli_query($conn, "INSERT INTO `food_type`(`food_type`, `img`, `res_id`) VALUES('$food_type', '$img' ,'$res_id') ");
                // เช็คว่าบันทึกข้อมูลได้ไหม ถ้าได้จะย้อนกลับไปหน้าก่อนหน้า
                ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
            } else {
                alert('เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ');
            }
        }
    }

    // ลบหมวดหมู่
    if(isset($_GET['del_type'])){
        $type_id = $_GET['del_type'];
        // ลบจากตารางหมวดหมู่
        $sql = mysqli_query($conn, "DELETE FROM `food_type` WHERE `food_type_id` = '$type_id' ");
        if($sql){
            // เปลี่ยนไอดีของเมนูที่อยู่ในหมวดหมู่นี้ให้เป็น 0 (หมวดหมู่อื่นๆ)
            $sql = mysqli_query($conn, "UPDATE `food` SET `food_type_id` = 0 WHERE `food_type_id` = '$type_id' ");
        }
        ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // แก้ไขหมวดหมู่อาหาร
    if(isset($_POST['type_edit'])){
        $food_type_id = $_POST['food_type_id'];
        $food_type = $_POST['food_type'];
        include '../upload.php';

        // เช็คว่าชื่อหมวดหมู่นี้ ซ้ำกับหมวดหมู่อื่นๆในร้านไหม
        $select = mysqli_query($conn, "SELECT * FROM `food_type` WHERE `food_type` = '$food_type' 
            AND `food_type_id` != '$food_type_id' -- ไม่เอาไอดีหมวดหมู่ที่กำลังแก้ไขอยู่ตอนนี้
            AND `res_id` = '$res_id' -- $res_id มาจากไฟล์ nav.php ที่ดึงมาทำงาน ");

        if($select -> num_rows > 0){
            alert('ชื่อหมวดหมู่ซ้ำกับในร้าน');
        } else {
            // เช็คการอัพโหลดรูป
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                // ถ้ามีการเพิ่มรูปมา จะแก้ไขในตารางด้วย
                $sql = mysqli_query($conn, "UPDATE `food_type` SET `food_type` = '$food_type', `img` = '$img' WHERE `food_type_id` = '$food_type_id' ");
            } else {
                $sql = mysqli_query($conn, "UPDATE `food_type` SET `food_type` = '$food_type' WHERE `food_type_id` = '$food_type_id' ");
            }
            ($sql ? alert('แก้ไขหมวดหมู่อาหารสำเร็จ', 'index.php') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        }
    }

    
    // ---------- จัดการเมนูอาหาร ----------

    // เพิ่มเมนูอาหาร
    if(isset($_POST['add_food'])){
        $food_name = $_POST['food_name'];
        $price = $_POST['price'];
        $food_type_id = $_POST['food_type'];
        include '../upload.php';

        // เช็คชื่อเมนูซ้ำในร้าน
        $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_name` = '$food_name' AND `res_id` = '$res_id' ");
        if($select -> num_rows > 0){
            alert('มีเมนูอาหารนี้ในร้านแล้ว');
        } else {
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                $sql = mysqli_query($conn, "INSERT INTO `food`(`food_name`, `img`, `price`, `food_type_id`, `res_id`) VALUES('$food_name', '$img', '$price', '$food_type_id', '$res_id') ");
                ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
            } else {
                alert('เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ');
            }
        }
    }

    // แก้ไขเมนูอาหาร
    if(isset($_POST['food_edit'])){
        $food_id = $_POST['food_id'];
        $food_name = $_POST['food_name'];
        $price = $_POST['price'];
        $food_type = $_POST['food_type'];
        include '../upload.php';

        // เช็คว่าชื่อเมนูนี้ ซ้ำกับเมนูอื่นๆในร้านไหม
        $select = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_name` = '$food_name' 
        AND `food_id` != '$food_id' 
        AND `res_id` = '$res_id' ");

        if($select -> num_rows > 0){
            alert('มีเมนูอาหารนี้ในร้านแล้ว');
        } else {
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                $sql = mysqli_query($conn, "UPDATE `food` SET
                `food_name` = '$food_name',
                `img` = '$img',
                `price` = '$price',
                `food_type_id` = '$food_type' WHERE `food_id` = '$food_id' ");

            } else {
                $sql = mysqli_query($conn, "UPDATE `food` SET
                `food_name` = '$food_name',
                `price` = '$price',
                `food_type_id` = '$food_type' WHERE `food_id` = '$food_id' ");
            }
            ($sql ? alert('แก้ไขเมนูอาหารสำเร็จ', 'index.php') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        }
    }

    // เพิ่มส่วนลด
    if(isset($_POST['discount'])){
        $food_id = $_POST['food_id'];
        $discount = $_POST['discount'];
        $sql = mysqli_query($conn, "UPDATE `food` SET `discount` = '$discount' WHERE `food_id` = '$food_id' ");
        ($sql ? alert('แก้ไขส่วนลดเมนูสำเร็จ', 'index.php') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // ลบเมนู
    if(isset($_GET['del_food'])){
        $food_id = $_GET['del_food'];
        $sql = mysqli_query($conn, "DELETE FROM `food` WHERE `food_id` = '$food_id' ");
        ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // ปรับสถานะคงเหลือของเมนู
    if(isset($_GET['st'])){
        $sql = mysqli_query($conn, "UPDATE `food` SET `status` = '".$_GET['st']."' WHERE `food_id` = '".$_GET['food_id']."' ");
        ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }


?>