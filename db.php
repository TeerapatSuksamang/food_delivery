<?php

    session_start();

    // ไม่แสดง error 
    // ini_set('display_erros', 0);
    // error_reporting(0);

    // * เปลี่ยนระหว่าง localhost กับบน server อัตโนมัติ 
    if($_SERVER["SERVER_NAME"] == 'localhost'){
        $conn = mysqli_connect('localhost', 'root', '', 'atc_deli') or die(mysqli_connect_error());
    } else {
        $conn = mysqli_connect('localhost', 'ietdevco_krujune', 'qwerty', 'ietdevco_krujune') or die(mysqli_connect_error());
    }
    
    // ดึงชื่อเว็บและรูปโลโก้จากตาราง admin คนแรกคนเดียว
    $web = mysqli_query($conn, "SELECT `web_name`,`logo` FROM `admin` ORDER BY `admin_id` ASC LIMIT 1 ");
    $web = mysqli_fetch_array($web);


    // --------------- Function ทั้งหมด ---------------
    
    // ถ้ามี session alert จะดึงไฟล์ alert.php เพื่อมาแจ้งเตือน
    if(isset($_SESSION['alert'])){
        include 'template/alert.php';
        unset($_SESSION['alert']);
    }

    function alert($msg, $lo = '', $name = '', $c = ''){
        // $msg = ข้อความแจ้งเตือน
        // $lo = หน้าที่จะให้ไปหลังจากโค้ดก่อนหน้าทำงานเสร็จ
        // $name = name จากช่อง input ที่ต้องการไฮไลท์
        // $c = class สี bootstrap ที่ต้องการใส่ในแจ้งเตือน
        
        // เก็บข้อความไว้ใน session 
        $_SESSION['alert'] = $msg;
        $_SESSION['form'] = $name;
        $_SESSION['c'] = $c;


        // ถ้ามีการใส่สีมาใน function จะเช็คว่าถูกตาม class ใน bootstrap ไหม
        if($c != ''){
            // ถ้า class สีที่ใส่มาไม่มีใน bootstrap จะใส่ primary เป็นค่าเริ่มต้น
            if(!in_array($c, ['primary', 'danger', 'warning', 'success', 'secondary', 'info'])){
                $_SESSION['c'] = 'primary';
            }
        } else {
            // เช็คประเภทการแจ้งเตือนจากข้อความใน $msg อัตโนมัติ แล้วใส่คลาสสีตามประเภทการแจ้งเตือน
            if (strpos($msg, 'สำเร็จ') !== false) {
                $_SESSION['c'] = 'success'; // เขียว
            } else if (preg_match('/ผิดพลาด|ไม่พบ/', $msg)) {
                $_SESSION['c'] = 'danger'; // แดง
            } else if (preg_match('/กรุณา|มี|นี้แล้ว|ไม่ได้|ไม่ถูกต้อง/', $msg)) {
                $_SESSION['c'] = 'warning'; // เหลือง
            } else {
                // ค่าเริ่มต้น สีน้ำเงิน
                $_SESSION['c'] = 'primary';
            } 
        }
            
        
        if($lo == ''){
            // ย้อนกลับไปหน้าก่อนหน้านี้
            echo "<script>window.location.replace(document.referrer);</script>";
            // echo "<script>window.history.back();</script>"; // * ถ้าใช้อันนี้จะย้อนกลับเหมือนกดย้อนกลับที่เบราเซอร์ แล้วหน้าเว็บจะดูเหมือนไม่ได้รีโหลด แต่เหมือนจะไม่เหมาะกับ chrome
        } else {
            // ไปยังหน้าที่ต้องการ
            echo "<script>window.location = '$lo';</script>";
        }
    }

    // สำหรับใส่ใน class="" ของ input บนหน้าเว็บที่ต้องการไฮไลท์เมื่อมีการแจ้งเตือนเช่นหน้า login, register
    function form($name){
        // ถ้ามี session นี้ถึงจะเช็คว่าตรงกับที่มีเรียกใช้ในหน้านั้นไหม ถ้ามีก้จะแสดงคลาสของ bootstrap เพื่อไฮไลท์ช่องที่ต้องการแจ้งเตือน
        if(isset($_SESSION['form'])){
            if($_SESSION['form'] == $name){
                echo 'alert alert-danger';
                unset($_SESSION['form']);
            }
        }
    }

    // ย้อนกลับไปหน้าก่อนหน้า
    function back(){
        // echo "<script>window.history.back();</script>";
        echo "<script>window.location.replace(document.referrer);</script>";
    }

    // function สำหรับขึ้นให้กดยืนยันกับยกเลิกบนหน้าเว็บ 
    // (* ตัวอย่างเช่นปุ่มลบโค้ดส่วนลด ที่ admin/web_manage.php )
    function confirm($action, $get = '', $id = '', $msg){
        // $action = ไฟล์ที่จะให้ไปเมื่อกดยืนยัน     (* web_manage_db.php )
        // $get = ชื่อ get method ว่าต้องการให้ทำอะไรในไฟล์นั้น     (* del_cpn )
        // $id = id ของสิ่งที่จะให้ถูกทำ     (* $row_cpn['cpn_id'] )
        // $msg = ข้อความทีต้องการให้แสดงบน modal

        // ดึง modal จาก confirm.php ใน template
        include 'template/confirm.php';

        // ส่งกลับค่าใน $get ที่ต่อกับ $id เพื่อเรียกใช้ modal ใด้ถูก     (* del_cpn5 )
        return '#id_'.$get.$id;
        // ค่าที่ส่งกลับก็จะเป็น #id_del_cpn5 ก็จะเรียกใช้ modal ที่ไอดีนี้
    }

    // คำนวณส่วนลดเป็นเปอร์เซ็นต์
    function discount($price, $discount){
        $new_discount = ($price * $discount) / 100;
        $new_price = ($price - $new_discount);
        return $new_price;
    }

    // แสดง ⭐ เฉลี่ย
    function star($star, $qty_sale){
        // star = คะแนนดาวเฉลี่ย
        // $qty_sale = จำนวนทั้งหมดที่ขายได้
        if($qty_sale > 0){
            for($i=1; $i<=$star; $i++){
                echo '⭐';
            }
            echo ' '.$star.'คะแนน ('.$qty_sale.' รีวิว)';
        } else {
            echo '⭐ยังไม่มีรีวิว';
        }
    }

    // แสดงดาวเฉลี่ยหลังรีวิว (★★★★☆)
    function star2($star){
        echo "<span class='text-warning'>";
            $x = 5 - $star; // เก็บผลลบกับคะแนนดาว เพื่อเอาไปลูปดาวโปร่ง ☆
            for($i=1; $i<=$star; $i++){
                // ดาวแบบเต็มดวง ★
                echo '&#9733';
            }
            for($i=1; $i<=$x; $i++){
                // ดาวแบบโปร่ง ☆
                echo '&#9734';
            }
            // ผลที่แสดงออกมาทั้งหมดจะเต็ม 5ดวง เช่น (★★★☆☆)
        echo "</span>";
    }

?>