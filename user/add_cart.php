<?php
    // ไฟล์จัดการตะกร้า
    include_once 'nav.php';
    include_once '../template/load.html';

    // เก็บจำนวนของเมนูไว้ในตะกร้าของร้านนั้นๆ
    if(isset($_POST['add_cart'])){
        $_SESSION['cart_arr'][$_SESSION['see_res']][$_POST['food_id']]  = $_POST['qty'];
        // print_r($_SESSION['cart_arr']);
        alert('เพิ่มเมนูอาหารลงตะกร้าสำเร็จ');
    }

    // เพิ่ม ลด จำนวนเมนูในตะกร้า
    if(isset($_GET['update_food'])){
        // เช็คไม่ให้จำนวนต่ำกว่า 0
        if($_GET['qty'] > 0){
            $_SESSION['cart_arr'][$_SESSION['see_res']][$_GET['update_food']] = $_GET['qty'];
        } else {
            // ถ้าเกิดผิดพลาดแล้วต่ำกว่า 0 จะให้เป็น 1
            $_SESSION['cart_arr'][$_SESSION['see_res']][$_GET['update_food']] = 1;
        }
        back();
    }

    // ลบเมนูออกจากตะกร้า (del_cart เก็บไอดีของเมนู)
    if(isset($_GET['del_cart'])){
        unset($_SESSION['cart_arr'][$_SESSION['see_res']][$_GET['del_cart']]);
        back();
    }

    // สำหรับรีเซ็ทค่าใน session ตะกร้าช่วงทดสอบ
    if(isset($_GET['set'])){
        unset($_SESSION['cart_arr']);
    }

    // เพิ่มคูปอง
    if(isset($_POST['add_cpn'])){
        $cpn_code = $_POST['cpn_code'];
        // เช็คโค้ดคูปองว่ามีในระบบไหม
        $select = mysqli_query($conn, "SELECT * FROM `coupon` WHERE `cpn_code` = '$cpn_code' ");
        if($select -> num_rows > 0){
            // ถ้ามีจะเก็บส่วนลดไว้ใน session แล้วกลับไปหน้าตะกร้า
            $row = mysqli_fetch_array($select);
            $_SESSION['cpn_discount'] = $row['cpn_discount'];
            alert('เพิ่มคูปองสำเร็จ');
        } else {
            // ถ้าไม่มีจะลบ session ที่เก็บส่วนลดออก
            unset($_SESSION['cpn_discount']);
            alert('ไม่พบคูปอง');
        }
    }

    // ลบส่วนลด
    if(isset($_GET['del_cpn'])){
        unset($_SESSION['cpn_discount']);
        back();
    }

?>