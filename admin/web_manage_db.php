<?php

    include_once 'nav.php';
    include_once '../template/load.html';

    // แก้ไขข้อมูลเว็บ
    if(isset($_POST['web_edit'])){
        $web_name = $_POST['web_name'];
        include '../upload.php';

        if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
            $sql = mysqli_query($conn, "UPDATE `admin` SET `web_name` = '$web_name', `logo` = '$img' ");
        } else {
            $sql = mysqli_query($conn, "UPDATE `admin` SET `web_name` = '$web_name' ");
        }
        ($sql ? alert('แก้ไขข้อมูลเว็บไซต์สำเร็จ') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // เพิ่มโค้ดส่วนลด
    if(isset($_POST['add_cpn'])){
        $cpn_code = $_POST['cpn_code'];
        $cpn_discount = $_POST['cpn_discount'];

        // เช็คชื่อคูปองซ้ำ
        $select = mysqli_query($conn, "SELECT * FROM `coupon` WHERE `cpn_code` = '$cpn_code' ");
        if($select -> num_rows > 0){
            alert('ชื่อคูปองซ้ำ กรุณาเปลี่ยนใหม่');
        } else {
            $sql = mysqli_query($conn, "INSERT INTO `coupon`(`cpn_code`, `cpn_discount`) VALUES('$cpn_code', '$cpn_discount') ");
            ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        }
    }

    // ลบคูปอง
    if(isset($_GET['del_cpn'])){
        $sql = mysqli_query($conn, "DELETE FROM `coupon` WHERE `cpn_id` = '".$_GET['del_cpn']."' ");
        ($sql ? back() : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));

    }

?>