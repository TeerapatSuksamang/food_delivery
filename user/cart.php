<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้า</title>
</head>
<body>
    <?php

        include_once 'nav.php';

        // เช็คไอดีร้านที่กำลังดูแล้วเก็บไอดีลง session
        if(isset($_GET['see_res'])){
            $_SESSION['see_res'] = $_GET['see_res'];
        }
        // เก็บลงตัวแปรธรรมดาเพราะสั้นกว่า เอาไปเขียนต่อได้ไวกว่า ประหยัดเวลา
        $see_res = $_SESSION['see_res'];

        // เช็คว่ามีไอดีร้านที่รับมาไหม
        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '$see_res' ");
        if($select_res -> num_rows <= 0){
            alert('ขออภัย ไม่พบร้านอาหารที่คุณค้นหา');
        }
        $row_res = mysqli_fetch_array($select_res);

        // เช็ค ถ้าไม่มีการเพิ่มเมนูของร้านนี้ลงตะกร้า จะสร้างเป็น array เปล่าไว้ก่อน
        if(!isset($_SESSION['cart_arr'][$see_res])){
            $_SESSION['cart_arr'][$see_res] = array();
        }
    ?>
    <div class="container mb-5">
        <!-- ตารางแสดงเมนูในตะกร้า -->
        <div class="row mt-5">
            <h2>ตะกร้า ร้าน<?php echo $row_res['res_name'] ?>
                <!-- <button class="btn btn-primary float-end" onclick="window.history.back();">เลือกเมนูเพิ่ม</button> -->
                <a href="see_res.php" class="btn btn-primary float-end">เลือกเมนูเพิ่ม</a>
            </h2>
            <div class="table-responsive mb-3">
                <table class="table table-striped table-hover table-bordered text-center shadow">
                    <tr>
                        <th>เมนูอาหาร</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>จำนวน</th>
                        <th>ราคารวม</th>
                        <th>จัดการ</th>
                    </tr>

                    <?php
                        $food_price = 0; // เก็บราคาอาหารที่คูณกับจำนวน
                        $all_food_price = 0; // ราคาอาหารทั้งหมดในตะกร้า
                        $cpn_discount = ($_SESSION['cpn_discount'] ?? 0); // เช็คคูปองส่วนลด ถ้ายังไม่มีให้เป็น 0
                        $sum_price = 0; // ราคาทั้งหมดหลังหักส่วนลด

                        // แสดงเมนูอาหารและจำนวนที่เพิ่มลงตะกร้าของร้านนี้
                        foreach($_SESSION['cart_arr'][$see_res] as $food_id => $qty){
                            $select_food = mysqli_query($conn, "SELECT * FROM `food` WHERE `food_id` = '$food_id' ");
                            $row_food = mysqli_fetch_array($select_food);
                    ?>
                        <tr valign="middle">
                            <td>
                                <center>
                                    <div class="rounded hover-img" style="width: 5rem; height: 5rem;">
                                        <img src="../upload/<?php echo $row_food['img'] ?>" class="img">
                                    </div>
                                    <span><?php echo $row_food['food_name'] ?></span>
                                </center>
                            </td>
                            <td>
                                <?php
                                    // เช็คส่วนลด แล้วเก็บราคาลง $price เพื่อเอาไปคำนวนต่อ
                                    if($row_food['discount'] != 0){
                                        $price = discount($row_food['price'], $row_food['discount']);
                                ?>
                                    <s class="text-secondary">฿<?php echo $row_food['price'] ?></s>
                                    <span class="text-success">฿<?php echo $price ?></span>
                                    <span class="text-danger">(ลด - <?php echo $row_food['discount'] ?>%)</span>
                                <?php } else {
                                        $price = $row_food['price'];
                                        echo '฿'.$price;
                                    }
                                ?>
                            </td>
                            <td>
                                <!-- เพิ่ม ลด จำนวนเมนูอาหารนั้นๆ -->
                                <a href="add_cart.php?update_food=<?php echo $food_id.'&qty='.($qty-1) ?>" class="btn btn-warning">-</a>
                                <?php echo $qty ?>
                                <a href="add_cart.php?update_food=<?php echo $food_id.'&qty='.($qty+1) ?>" class="btn btn-primary">+</a>
                            </td>
                            <td>฿<?php
                                    $food_price = ($price * $qty); // ราคารวมของเมนูนั้นๆ
                                    echo $food_price; //แสดงราคาของเมนูนั้นๆ

                                    // ราคารวมของทุกเมนูในตะกร้า
                                    $all_food_price += $food_price; 
                                    $sum_price = $all_food_price;
                                ?>
                            </td>
                            <td>
                                <?php
                                    // เก็บค่าที่ได้จาก function confirm เพื่อนำไปใช้เปิด modal
                                    $t = confirm('add_cart.php', 'del_cart', $food_id, 'ต้องการนำเมนูนี้ออกจากตะกร้าหรือไม่?');
                                ?>
                                <a href="" data-bs-toggle="modal" data-bs-target="<?php echo $t ?>" class="btn btn-warning">ลบ</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <hr>
        </div>

        <!-- การชำระเงิน -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- ฟอร์มกรอกคูปอง -->
                <form action="add_cart.php" class="d-flex gap-2 mb-3" method="post" enctype="multipart/form-data">
                    <input type="text" class="form-control" name="cpn_code" placeholder="กรอกคูปองส่วนลด" required>

                    <!-- เช็คถ้ามีคูปองจะแสดงปุ่มลบ -->
                    <?php if($cpn_discount != 0){ ?>
                        <a href="add_cart.php?del_cpn" class="btn btn-warning">ลบ</a>
                    <?php } ?>
                    <input type="submit" class="btn btn-primary" name="add_cpn" value="ยืนยัน">
                </form>
                <h5>ค่าอาหาร<span class="float-end">฿<?php echo $all_food_price ?></span></h5>

                <?php 
                    // ถ้ามีคูปองจะแสดงส่วนลด และราคาหลังลด
                    if($cpn_discount != 0){
                        $sum_price = discount($all_food_price, $cpn_discount);
                ?>
                    <h5 class="text-danger">ส่วนลด<span class="float-end">- <?php echo $cpn_discount ?>%</span></h5>
                    <h5 class="text-success mb-4">ทั้งหมด<span class="float-end">฿<?php echo $sum_price ?></span></h5>
                <?php } ?>

                <form action="insert_order.php" method="post" enctype="multipart/form-data">
                    <h6>การชำระเงิน</h6>
                    <!-- ตัวเลือกชำระเงิน เงินสดปลายทาง -->
                    <label for="cash" class="form-check-label rounded w-100 mb-3 p-3 border" onclick="close_qr();">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment" id="cash" checked required>
                            <strong>เงินสด</strong>
                            <br>
                            ชำระเงินปลายทาง
                        </div>
                    </label>

                    <!-- ตัวเลือกชำระเงิน โอนจ่าย -->
                    <?php
                        // เช็คถ้าร้านเพิ่มบัญชีธนาคาร จะแสดงตัวเลือกชำระเงินนี้
                        if($row_res['bank'] != NULL){
                    ?>
                        <div class="accordion card">
                            <label for="tranfer" class="form-check-label rounded w-100 accordion-button" data-bs-toggle="collapse"
                            data-bs-target="#qr_code" onclick="open_qr();">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="payment" id="tranfer" required>
                                    <strong>ชำระทันที</strong>
                                    <br>
                                    โอนจ่าย
                                </div>
                            </label>

                            <!-- collapse แสดงข้อมูลธนาคาร -->
                            <div class="collapse accordion-collapse" id="qr_code">
                                <div class="accordion-body">
                                    <div class="d-flex gap-2 mb-2">
                                        <!-- ปุ่มรูป qr_code เพื่อกดซูม (เปิด modal ) -->
                                        <a href="" data-bs-toggle="modal" data-bs-target="#qr_zoom">
                                            <div class="hover-img border" style="aspect-ratio: 1/1;">
                                                <div class="" style="cursor: pointer; width: 7rem; height: 7rem;">
                                                    <img src="../upload/<?php echo $row_res['qr_code'] ?>" class="img">
                                                </div>
                                            </div>
                                        </a>

                                        <h6>
                                            <p>ธนาคาร : <?php echo $row_res['bank'] ?></p>
                                            <p>เลขบัญชี : <?php echo $row_res['ac_num'] ?></p>
                                            <p>ชื่อบัญชี : <?php echo $row_res['ac_name'] ?></p>
                                        </h6>
                                    </div>
                                    <input type="file" name="img" id="slip_upload">
                                </div>
                            </div>
                        </div>

                        <!-- modal แสดง qr_code แบบเต็มจอ -->
                        <div class="modal fade" id="qr_zoom">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">แสกน QR Code</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <img src="../upload/<?php echo $row_res['qr_code'] ?>" class="img">
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <hr class="my-5">

                    <!-- ยืนยันออร์เดอร์ -->
                    <div class="card shadow p-3">
                        <h1 class="text-center mb-3">ยืนยันข้อมูลผู้ส่ง</h1>
                        <input type="hidden" name="all_price" value="<?php echo $all_food_price ?>">
                        <input type="hidden" name="cpn_discount" value="<?php echo $cpn_discount ?>">
                        <input type="hidden" name="sum_price" value="<?php echo $sum_price ?>">

                        <label for="">ชื่อผู้สั่ง</label>
                        <input type="text" class="form-control mb-3" name="full_name" value="<?php echo $row['full_name'] ?>" required>

                        <label for="">ที่อยู่</label>
                        <input type="text" class="form-control mb-3" name="address" value="<?php echo $row['address'] ?>" required>

                        <label for="">เบอร์โทร</label>
                        <input type="tel" class="form-control mb-3" name="phone" value="<?php echo $row['phone'] ?>" required minlength="10" maxlength="10" pattern="[0-9]{10}">

                        <input type="submit" class="btn btn-success w-100" name="buy_order" value="สั่งเลย!">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../function.js"></script>
</body>
</html>