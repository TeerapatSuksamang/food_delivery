<?php

    include_once '../db.php';
    include_once '../template/load.html';
    
    // เพิ่มประเภทร้านอาหาร
    if(isset($_POST['add_res_type'])){
        $res_type = $_POST['res_type'];
        // ดึงไฟล์ upload รูปมาใช้
        include '../upload.php';

        // เลือกประเภทร้านที่ตรงกับที่รับมาเพื่อเช็คชื่อซ้ำ
        $select = mysqli_query($conn, "SELECT * FROM `restaurant_type` WHERE `res_type` = '$res_type' ");
        if($select -> num_rows > 0){
            alert('มีประเภทร้านอาหารนี้แล้ว');
        } else {
            // ถ้าอัพโหลดรูปได้
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                $sql = mysqli_query($conn, "INSERT INTO `restaurant_type`(`res_type`, `img`) VALUES('$res_type', '$img') ");

                // ถ้าบันทึกข้อมูลสำเร็จจะย้อนกลับไปหน้าก่อนหน้า แต่ถ้าบันทึกไม่ได้จะแจ้งเตือน
                ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
            } else {
                alert('เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ');
            }
        }
    }

    // อนุมัติ / ยกเลิก การใช้งาน
    if(isset($_GET['permis'])){
        $permis = $_GET['permis']; // เก็บประเภทของ user (เอามาใช้แทนชื่อตารางของประเภท user นั้นๆ)
        $permis_id = $_GET['permis_id']; // ชื่อ column id ของประเภท user นั้น (เช่น user_id , admin_id)
        $id = $_GET['id']; // ไอดีของ user
        $status = $_GET['status']; // สถานะ
        $note = ($_GET['note'] ?? ''); // หมายเหตุการยกเลิกการใช้งาน

        if(isset($note)){
            $sql = mysqli_query($conn, "UPDATE `$permis` SET `status` = '$status', `note` = '$note' WHERE `$permis_id` = '$id' ");
        } else {
            $sql = mysqli_query($conn, "UPDATE `$permis` SET `status` = '$status', `note` = NULL WHERE `$permis_id` = '$id' ");
        }
        ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // ลบหมวดหมู่อาหาร
    if(isset($_GET['del_type'])){
        $sql = mysqli_query($conn, "DELETE FROM `restaurant_type` WHERE `res_type_id` = '".$_GET['del_type']."' ");
        ($sql ? back() : alert('เกิดข้อผิดพลาด'));
    }

?>