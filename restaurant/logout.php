<?php

    // ลบ session การล็อคอินของร้าน แล้วกลับไปหน้าหลักของเว็บ
    session_start();
    unset($_SESSION['res_id']);
    header('location: ../index.php');

?>