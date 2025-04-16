<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve</title>
</head>
<body>
    <?php
        // ดึง navbar มาแสดง
        include_once 'nav.php';

        // รับ get permis ถ้าไม่มีให้เป็นค่าว่าง
        $permis = ($_GET['permis'] ?? ''); // เก็บประเภทผู้ใช้ (user, rider, restaurant)

        // เช็คประเภทผู้ใช้จาก permis ถ้าไม่ถูกต้องหรือไม่มี จะให้เริ่มต้นเป็น user
        if(!in_array($permis, ['user', 'rider', 'restaurant'])){
            header('location: ?permis=user');
        }

        // นำชื่อแต่ละประเภทผู้ใช้มาต่อกับ _id เพราะในฐานข้อมูลของทุกอันจะเป็นชื่อประเภทผู้ใช้ที่ต่อกับ _id ( เช่น user_id , rider_id )
        $permis_id = $permis.'_id'; // เก็บชื่อ column id ของประเภทผู้ใช้ (user_id, rider_id, res_id)
    ?>
    <div class="container-fluid">
        <div class="row my-5">
            <?php
                if($permis == 'restaurant'){
                    // ของร้านจะเป็น res เพราะในฐานข้อมูลสร้างว่า res_id
                    $permis_id = 'res_id';
            ?>
                <h1 class="text-center mb-3">ประเภทร้านอาหาร</h1>

                <!-- แสดงประเภทร้านอาหารทั้งหมด -->
                <?php
                    $select_type = mysqli_query($conn, "SELECT * FROM `restaurant_type` ");
                    if($select_type -> num_rows > 0){
                        while($row_type = mysqli_fetch_array($select_type)){
                ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 p-1">
                        <div class="card hover-img shadow mb-3">
                            <div class="card-img-top hover-img border" style="height: 200px;">
                                <img src="../upload/<?php echo $row_type['img'] ?>" class="img ">
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $row_type['res_type'] ?></h4>
                                
                                <!-- ใช้ function confirm เพื่อแสดง modal ให้ยืนยัน -->
                                <?php   
                                    // เก็บค่าที่ได้จาก confirm เพื่อเอาไปแสดงใน data-bs-target ให้สามารถเรียกใช้ modal ได้ถูก
                                    $t = confirm('approve_db.php', 'del_type', $row_type['res_type_id'], 'ต้องการลบหมวดหมู่นี้หรือไม่')
                                ?>
                                <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="<?php echo $t ?>" >ลบ</a>
                            </div>
                        </div>
                    </div>
                <?php }} else { ?>
                    <p class="text-center blockquote-footer my-3">ยังไม่มีประเภทร้านอาหาร</p>
                <?php } ?>

                <div class="col-md-12 my-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_res_type">เพิ่มประเภทร้านอาหาร</button>
                </div>

                <!-- bootstrap modal เมื่อกด เพิ่มประเภทร้านอาหาร  -->
                <form action="approve_db.php" class="modal fade" id="add_res_type" method="post" enctype="multipart/form-data">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">เพิ่มประเภทร้านอาหาร</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label for="">ประเภทร้านอาหาร</label>
                                <input type="text" class="form-control mb-3" name="res_type" required>

                                <label for="">รูปภาพ</label>
                                <input type="file" class="form-control mb-3" name="img" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <input type="submit" class="btn btn-success" name="add_res_type" value="บันทึก">
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>

            <h2><?php echo ucfirst($permis); ?> Approve</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered text-center shadow">
                    <tr>
                        <th>ชื่อ - นามสกุล</th>
                        <th>รูปภาพ</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทรศัพท์</th>
                        <?php if($permis == 'restaurant'){ ?>
                            <th>ชื่อร้านอาหาร</th>
                            <th>ประเภทร้านอาหาร</th>
                        <?php } ?>
                        <th>จัดการ</th>
                    </tr>

                    <?php
                        if($permis == 'restaurant'){
                            // ถ้าเป็นร้าน จะรวมตารางร้านกับ ประเภทร้าน โดยให้ตารางร้านเป็นหลัก
                            $select = mysqli_query($conn, "SELECT `restaurant`.* , `restaurant_type`.`res_type`
                            FROM `restaurant`
                            LEFT JOIN `restaurant_type`
                            -- ใช้ไอดีของตาราง restaurant_type เป็นตัวเชื่อม (res_typ_id)
                            ON `restaurant`.`res_type_id` = `restaurant_type`.`res_type_id` "); 
                        } else {
                            // ถ้าไม่ใช่ร้าน จะนำค่าจากใน $permis มาเพื่อให้แสดงชื่อฐานข้อมูลเลย
                            $select = mysqli_query($conn, "SELECT * FROM `$permis` ");
                        }
                        
                        // ลูปแสดงข้อมูลผู้ใช้ที่ดึงมาก่อนหน้านี้
                        while($row = mysqli_fetch_array($select)){
                    ?>
                        <tr valign="middle">
                            <td><?php echo $row['full_name'] ?></td>
                            <td>
                                <center>
                                    <div class="rounded hover-img" style="width: 5rem; height: 5rem;">
                                        <img src="../upload/<?php echo $row['img'] ?>" class="img">
                                    </div>
                                </center>
                            </td>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <?php if($permis == 'restaurant'){ ?>
                                <td><?php echo $row['res_name'] ?></td>
                                <td><?php echo $row['res_type'] ?></td>
                            <?php } ?>
                            <td>
                                <?php if($row['status'] == 0){ ?>
                                    <!-- อยู่ในสถานะ ยกเลิก(0) กดปุ่มเพื่อเปลี่ยนเป็นสถานะ อนุมัติ(1) -->
                                    <a href="approve_db.php?status=1&permis=<?php echo $permis.'&permis_id='.$permis_id.'&id='.$row[$permis_id] ?>" class="btn btn-success">ยืนยัน</a>
                                    <!-- 
                                        ค่า get ที่ส่งไปจะมี
                                        status = 1 | สถานะ อนุมัติ
                                        permis = $permis | ประเภทผู้ใช้ นำไปใช้เป็นชื่อตาราง เพราะชื่อตรงกับตารางในฐานข้อมูล
                                        permis_id = $permis_id | ชื่อ column id (ชื่อประเภทผู้ใช้ที่ต่อกับ _id)
                                        id = $row[$permis_id] | ไอดีของผู้ใช้ตามประเภทผู้ใช้นั้นๆ
                                    -->
                                        
                                <?php 
                                        // เช็คว่ามีการเพิ่มหมายเหตุไหม
                                        if($row['note'] != null){
                                            echo "</br><i>หมายเหตุ: ". $row['note'] ."<i>";
                                        } else {
                                            echo "</br><i>ไม่ได้อนุมัติการใช้งาน<i>";
                                        }
                                    } else { 
                                ?>
                                    <!-- อยู่ในสถานะ อนุมัติ(1) กดปุ่มเพื่อเปลี่ยนเป็นสถานะ ยกเลิก(0) -->
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $row[$permis_id] ?>">ยกเลิก</button>
                                    
                                    <!-- modal สำหรับเพิ่มหมายเหตุ เมื่อกดปุ่มยกเลิก  -->
                                    <form action="approve_db.php" method="get" class="modal fade" id="modal_<?php echo $row[$permis_id] ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>เพิ่มหมายเหตุระงับการใช้งาน</h4>
                                                </div>
                                                <div class="modal-body ">
                                                    <input type="text" name="note" class="form-control mb-3" placeholder="เพิ่มหมายเหตุระงับการใช้งาน (ไม่จำเป็น)">

                                                    <!-- ค่าที่ส่งไป เหมือนกับปุ่มกดยืนยันก่อนหน้านี้  -->
                                                    <input type="hidden" name="permis" value="<?php echo $permis ?>">
                                                    <input type="hidden" name="permis_id" value="<?php echo $permis_id ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row[$permis_id] ?>">
                                                    <input type="hidden" name="status" value="0">

                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">ยกเลิก</button>
                                                        <input type="submit" class="btn btn-success  w-100" name="" value="ยืนยัน">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>