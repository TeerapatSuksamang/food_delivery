<!-- ไฟล์แสดงปุ่มกดเพิ่มร้านโปรด ถูกใช้ในหลายหน้า -->
<!-- (ระบบนี้คิดได้ไม่ถึง 1อาทิตย์ก่อนแข่ง ออกมาไม่ดีติดปัญหาบ่อย ตอนเกิดปัญหาต้องไปแก้หลายหน้า ตอนแข่งเลยใช้วิธีนี้ ถ้าผิดจะได้แก้แค่ไฟล์เดียว) -->

<?php
    // เช็คว่าร้านที่กำลังแสดงนั้น ผู้ใช้ได้เพิ่มเป็นร้านโปรดไหม ถ้าใช่จะแสดงปุ่มใจสีแดง
    $select_fav = mysqli_query($conn, "SELECT * FROM `fav_res` WHERE `user_id` = '$user_id' AND `res_id` = '$see_res' ");
    if($select_fav -> num_rows > 0){
        $row_fav = mysqli_fetch_array($select_fav);
?>
    <!-- ปุ่มใจสีแดง บอกว่ากดใจร้านนี้อยู่ กดอีกครั้งเพื่อนำออก -->
    <a href="add_fav.php?dis_res=<?php echo $row_fav['fav_id'] ?>" class="float-end fav">
        <span class="text-danger">❤</span>
    </a>
<?php } else { ?>
    <a href="add_fav.php?fav_res=<?php echo $see_res ?>" class="float-end fav">
        <span>❤</span>
    </a>
<?php } ?>