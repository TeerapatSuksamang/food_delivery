<?php

    session_start();
    unset($_SESSION['rider_id']);
    header('location: ../index.php');

?>