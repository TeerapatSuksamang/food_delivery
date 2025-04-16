<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลเว็บไซต์</title>

</head>
<body>
    <?php
        include_once 'nav.php';
    ?>

    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <div class="col-md-10 rounded border shadow p-3 bg-light">
                <h1>ข้อมูลเว็บไซต์</h1>
                <hr>
                
                <div class="row p-2">
                    <div class="col-md-6 col-sm-12 pt-3 ">
                        <form action="web_manage_db.php" method="post" class="mb-4 form-control" enctype="multipart/form-data" onchange="form_change();">
                            <h5>ชื่อเว็บไซต์</h5>
                            <div class="d-flex gap-2 mb-3">
                                <input type="text" class="form-control" name="web_name" value="<?php echo $row['web_name'] ?>"> 
                            </div>

                            <h5>โลโก้</h5>
                            <center>
                                <div class="rounded-circle hover-img border mb-2" style="width: 7rem; height: 7rem;">
                                    <img src="../upload/<?php echo $row['logo'] ?>" class="img" id="preview">
                                </div>
                            </center> 
                            <div class="d-flex gap-2 mb-3">
                                <input type="file" name="img" id="img_upload" class="form-control"> 
                            </div>

                            <input type="submit" class="btn btn-primary w-100" name="web_edit" value="อัพเดท" disabled>
                        </form>


                        <hr>
                        <div class="form-control">
                            <form action="web_manage_db.php" method="post" class="mb-4">
                                <h5>เพิ่มโค้ดส่วนลด</h5>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control" name="cpn_code" placeholder="เพิ่มโค้ดส่วนลด" required>
                                    <input type="number" class="form-control" name="cpn_discount" placeholder="ส่วนลด(%)" required>
                                    <input type="submit" class="btn btn-primary" name="add_cpn" value="ตกลง">
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>โค้ดส่วนลด</th>
                                            <th>ส่วนลด(%)</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $select_cpn = mysqli_query($conn, "SELECT * FROM `coupon` ");
                                            while($row_cpn = mysqli_fetch_array($select_cpn)){
                                        ?>
                                                <tr valign="middle">
                                                    <td><?php echo $row_cpn['cpn_code'] ?></td>
                                                    <td><?php echo $row_cpn['cpn_discount'] ?>%</td>
                                                    <td>
                                                        <?php $target = confirm('web_manage_db.php', 'del_cpn', $row_cpn['cpn_id'], 'ต้องการลบคูปองนี้หรือไม่') ?>
                                                        <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="<?php echo $target ?>">ลบ</a>
                                                    </td>
                                                </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php
                        // จำนวนร้านทั้งหมด
                        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` ");
                        $qty_res = $select_res -> num_rows;

                        // จำนวนลูกค้าทั้งหมด
                        $select_user = mysqli_query($conn, "SELECT * FROM `user` ");
                        $qty_user = $select_user -> num_rows;

                        // จำนวนผุ้ส่งทั้งหมด
                        $select_rider = mysqli_query($conn, "SELECT * FROM `rider` ");
                        $qty_rider = $select_rider -> num_rows;

                        // จำนวนสมาชิกทั้งหมด
                        $all_member = $qty_res + $qty_user + $qty_rider;

                        // เปอร์เซ็นต์ของแต่ละประเภทผูใช้
                        $res_percent = ($qty_res == 0 ? 0 : ($qty_res * 100) / $all_member);
                        $user_percent = ($qty_user == 0 ? 0 : ($qty_user * 100) / $all_member);
                        $rider_percent = ($qty_res == 0 ? 0 : ($qty_rider * 100) / $all_member);

                        $res_percent = number_format($res_percent, 1);
                        $user_percent = number_format($user_percent, 1);
                        $rider_percent = number_format($rider_percent, 1);
                    ?>
                    <div class="col-md-6 col-sm-12 py-3 ">
                        <div class="form-control">
                            <h5>จำนวนสมาชิกทั้งหมด : <?php echo $all_member; ?> บัญชี</h5>
                            <div class="progress h-25 mb-4">
                                <div class="progress-bar bg-success p-3" style="width: <?php echo $res_percent ?>%;">
                                    ร้านอาหาร <?php echo $res_percent ?>%
                                </div>

                                <div class="progress-bar bg-secondary p-3" style="width: <?php echo $rider_percent ?>%;">
                                    ผู้ส่งอาหาร <?php echo $rider_percent ?>%
                                </div>
                                
                                <div class="progress-bar bg-primary p-3" style="width: <?php echo $user_percent ?>%;">
                                    ผู้ใช้งาน <?php echo $user_percent ?>%
                                </div>
                            </div>

                            <a href="approve.php?permis=restaurant" class="btn btn-outline-success w-100 mb-2">
                                <div class="row">
                                    <div class="col text-start">ร้านอาหาร</div>
                                    <div class="col text-end"><?php echo $qty_res ?></div>
                                </div>
                            </a>

                            <a href="approve.php?permis=rider" class="btn btn-outline-secondary w-100 mb-2">
                                <div class="row">
                                    <div class="col text-start">ผู้ส่งอาหาร</div>
                                    <div class="col text-end"><?php echo $qty_rider ?></div>
                                </div>
                            </a>
                            
                            <a href="approve.php?permis=user" class="btn btn-outline-primary w-100 mb-2">
                                <div class="row">
                                    <div class="col text-start">ผู้ใช้งาน</div>
                                    <div class="col text-end"><?php echo $qty_user ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../function.js"></script>
</body>
</html>