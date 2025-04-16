<!-- ไฟล์นี้ถูกใช้ในหน้าที่ต้องแสดงออร์เดอร์ -->
<?php
    // ตัวแปร $select จะมาจากไฟล์ status ของแต่ละประเภทผู้ใช้ที่ดึงไฟล์นี้ไปทำงาน เช่น (restaurant/status.php , user/status.php)
    while($row = mysqli_fetch_array($select)){
        // ดึงข้อมูลร้านตามออร์เดอร์
        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '".$row['res_id']."' ");
        $row_res = mysqli_fetch_array($select_res);

        // ถ้ายังไม่กดเพิ่มดาวให้ออร์เดอร์นี้ ให้ตั้งดาวเริ่มต้นของออร์เดอร์นี้ให้เป็น 1
        if(!isset($_SESSION['star'][$row['order_id']])){
            $_SESSION['star'][$row['order_id']] = 1;
        }
?>
    <span class="position-absolute pb-5" id="<?php echo $row['order_id'] ?>"></span>
    <div class="col-md-10 border rounded shadow p-3 mb-5">
        <div class="row">
            <div class="col-md-6">
                <h3>คำสั่งซื้อร้าน : <?php echo $row_res['res_name'] ?></h3>
                <h5><?php echo $row_res['address'] ?> | <?php echo $row_res['phone'] ?></h5>
            </div>
            <div class="col-md-6">
                <!-- ถ้าไฟล์นี้ทำงานในส่วนของลูกค้า และสถานะ <= 0 จะแสดงว่าออร์เดอร์ถูกยกเลิก -->
                <?php if($member == 'user' && $row['status'] <= 0){ ?>
                    <div class="form-control p-2">
                        <span class="float-end"><?php echo $row['date'] ?> | <?php echo $row['time'] ?></span>
                        <h4 class="text-danger">ออร์เดอร์ของคุณถูกยกเลิก </h4>
                        <!-- ถ้าสถานะเท่ากับ 0 จะขึ้นปุ่มให้กดรับทราบว่าออร์เดอร์ถูกยกเลิกแล้ว และส่งค่าสถานะของออร์เดอร์นี้เป็น -1 -->
                        <?php if($row['status'] == 0){ ?>
                            <a href="../system/update_status.php?status=-1&order_id=<?php echo $row['order_id'] ?>" 
                                class="btn btn-outline-primary w-100">
                                รับทราบ
                            </a>
                        <?php } ?>
                    </div>

                <!-- ถ้าทำงานอยู่ในส่วนของร้าน และสถานะเป็น 1 -->
                <?php } else if($member == 'restaurant' && $row['status'] == 1) { ?>
                    <!-- ปุ่มให้กดเปิด modal เพื่อเช็คสลิปที่ลูกค้าอัพโหลดมา -->
                    <div class="border rounded d-flex gap-2 p-2" data-bs-toggle="modal" data-bs-target="#open_slip" style="cursor: pointer;">
                        <div class="rounded hover-img" style="aspect-ratio: 1/1;">
                            <div style="width: 7rem; height: 7rem;">
                                <img src="../upload/<?php echo $row['slip'] ?>" class="img">
                            </div>
                        </div>
                        <h5 class="text-danger align-items-center d-flex">ตรวจสอบสลิป และยืนยันสลิปถูกต้อง👆</h5>
                    </div>

                    <!-- modal แสดงสลิปและกดยืนยันกับยกเลิกออร์เดอร์ -->
                    <div class="modal fade" id="open_slip">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">เช็คสลิป</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- รูปสลิป -->
                                <img src="../upload/<?php echo $row['slip'] ?>" class="img" style="max-height: 20rem;">

                                <!-- ปุ่มจัดการออร์เดอร์ ถ้ายกเลิก สถานะของออร์เดอร์นี้จะเป็น 0 แต่ถ้ายืนยันสถานะจะเป็น 2  -->
                                <div class="modal-footer">
                                    <a href="../system/update_status.php?status=0&order_id=<?php echo $row['order_id'] ?>" class="btn btn-danger">ยกเลิกออร์เดอร์</a>
                                    <a href="../system/update_status.php?status=2&order_id=<?php echo $row['order_id'] ?>" class="btn btn-success">ยืนยันสลิปถูกต้อง</a>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- ถ้าทำงานอยู๋ในส่วนของผู้ส่งอาหาร และสถานะเป็น 2   -->
                <?php } else if($member == 'rider' && $row['status'] == 2) { ?>
                    <!-- ให้ผู้ส่งกดรับ เพื่ออัพเดทสถานะออร์เดอร์นี้เป็น 3 -->
                    <a href="../system/update_status.php?status=3&order_id=<?php echo $row['order_id'] ?>" class="btn btn-outline-primary float-end">รับออร์เดอร์!</a>
                <?php } else if($member == 'restaurant' && $row['status'] == 3) { ?>
                    <a href="../system/update_status.php?status=4&order_id=<?php echo $row['order_id'] ?>" class="btn btn-outline-primary float-end">ยืนยันการทำอาหารเสร็จสิ้น</a>
                <?php } else if($member == 'rider' && $row['status'] == 4) { ?>
                    <a href="../system/update_status.php?status=5&order_id=<?php echo $row['order_id'] ?>" class="btn btn-outline-success float-end">อาหารเสร็จแล้ว จัดส่งเลย!</a>
                <?php } else if($member == 'rider' && $row['status'] == 5) { ?>    
                    <a href="../system/update_status.php?status=6&order_id=<?php echo $row['order_id'] ?>" class="btn btn-outline-success float-end">ยืนยันการจัดส่งและชำระเงินเสร็จสิ้น</a>

                <!-- ถ้าทำงานอยู่ในส่วนของลูกค้า และสถานะเป็น 6 จะแสดงกล่องรีวิวให้ลูกค้าเพิ่มรีวิว -->
                <?php } else if($member == 'user' && $row['status'] == 6) { ?>    
                    <form action="order_review.php" class="form-control p-2" method="post">
                        <h6>รีวิวอาหาร</h6>
                        <div class="d-block">
                            <!-- (ในการแข่งไม่มีการให้ออกอินเทอร์เน็ต หรือเตรียมไอคอนไปเอง ผมจึงใช้วิธีนี้ในการทำ star rating review เพราะเป็นวิธีที่ไวที่สุด(ที่ผมคิดได้) (ระบบนี้ไม่มีในโจทย์)) -->
                            <!-- 
                                ปุ่มดาวทั้ง 5 ปุ่ม แต่ละปุ่มจะส่งค่า 1-5
                                และจะแสดง html unicode | &#9733; คือดาวเต็มดวง★ ส่วน &#9734; คือดาวแบบโปร่ง☆
                                โดยเช็คค่าดาวของออร์เดอร์นี้ที่เก็บไว้ใน session 
                            -->
                            <a href="order_review.php?star=1&order_id=<?php echo $row['order_id'] ?>" style="border: none;" class="btn text-warning star-btn"><h2>&#973<?php echo ($_SESSION['star'][$row['order_id']] > 0 ? 3 : 4) ?></h2></a>
                            <a href="order_review.php?star=2&order_id=<?php echo $row['order_id'] ?>" style="border: none;" class="btn text-warning star-btn"><h2>&#973<?php echo ($_SESSION['star'][$row['order_id']] > 1 ? 3 : 4) ?></h2></a>
                            <a href="order_review.php?star=3&order_id=<?php echo $row['order_id'] ?>" style="border: none;" class="btn text-warning star-btn"><h2>&#973<?php echo ($_SESSION['star'][$row['order_id']] > 2 ? 3 : 4) ?></h2></a>
                            <a href="order_review.php?star=4&order_id=<?php echo $row['order_id'] ?>" style="border: none;" class="btn text-warning star-btn"><h2>&#973<?php echo ($_SESSION['star'][$row['order_id']] > 3 ? 3 : 4) ?></h2></a>
                            <a href="order_review.php?star=5&order_id=<?php echo $row['order_id'] ?>" style="border: none;" class="btn text-warning star-btn"><h2>&#973<?php echo ($_SESSION['star'][$row['order_id']] > 4 ? 3 : 4) ?></h2></a>
                        </div>

                        <!-- ช่องเพิ่มข้อความรีวิว ส่งไอดีร้าน และไอดีออร์เดอร์นี้ -->
                        <div class="d-flex gap-2">
                            <input type="hidden" name="res_id" value="<?php echo $row['res_id'] ?>">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id'] ?>">
                            <input type="text" class="form-control" name="review" placeholder="อาหารมื้อนี้เป็นอย่างไรบ้าง" required>
                            <input type="submit" class="btn btn-primary" name="submit_review" value="ยืนยัน">
                        </div>
                    </form>

                <!-- ถ้าสถานะเป็น 7 ของทุกประเภทผู้ใช้ (สถานะนี้คือออร์เดอร์เสร็จสิ้นแล้ว แสดงเป็นประวัติ และข้อความรีวิว) -->
                <?php } else if($row['status'] == 7) { ?>    
                    <form action="order_review.php" class="form-control p-2" method="post">
                        <h6>คะแนนรีวิว
                            <span class="float-end"><?php echo $row['date'] ?> | <?php echo $row['time'] ?></span>
                        </h6>
                        <h3><?php star2($row['star']) ?></h3>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" name="review" value="<?php echo $row['review'] ?>" placeholder="อาหารมื้อนี้เป็นอย่างไรบ้าง" readonly>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
        <hr>

        <!-- แสดงรายละเอียดของออร์เดอร์ -->
        <div class="row">
            <div class="col-md-6">
                <!-- ตารางแสดงรายการอาหารของออร์เดอร์นี้ -->
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>รูปภาพ</th>
                                <th>เมนูอาหาร</th>
                                <th>จำนวน</th>
                                <th>ราคารวม</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                // ดึงรายการอาหารของออร์เดอร์นี้
                                $select_food = mysqli_query($conn, "SELECT * FROM `food_order` WHERE `order_id` = '".$row['order_id']."' ");
                                while($row_food = mysqli_fetch_array($select_food)){
                            ?>
                                <tr>
                                    <td>
                                        <div class="rounded hover-img" style="width: 5rem; height: 5rem;">
                                            <img src="../upload/<?php echo $row_food['img'] ?>" class="img">
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $row_food['food_name'] ?>
                                        <br>
                                        <!-- เช็คส่วนลด ถ้ามีส่วนลดจะแสดงราคาก่อนและหลังลด -->
                                        <?php if($row_food['discount'] != 0){ ?>
                                            <s class="text-secondary">฿<?php echo $row_food['price'] ?></s>
                                            <span class="text-success">฿<?php echo discount($row_food['price'], $row_food['discount']) ?></span>
                                        <?php } else { echo '฿'.$row_food['price']; } ?>
                                    </td>
                                    <td><?php echo $row_food['qty'] ?></td>
                                    <td>฿<?php echo $row_food['total_price'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ข้อมูลผู้สั่งและ สถานะ -->
            <div class="col-md-6">
                <div class="form-control p-2 mb-3">
                    <h3 class="text-center mb-3">ข้อมูลผู้สั่ง</h3>
                    <h5>ชื่อผู้สั่ง : <?php echo $row['full_name'] ?></h5>
                    <h5>ที่อยู่ : <?php echo $row['address'] ?></h5>
                    <h5>ติดต่อ : <?php echo $row['phone'] ?></h5>
                </div>

                <h6>สถานะออร์เดอร์</h6>
                <progress class="progress w-100 mb-2" value="<?php echo $row['status'] ?>" max="6"></progress>
                <h6>
                    <!-- เช็คสถานะเพื่อมาแสดงคำอธิบาย -->
                    <?php if($row['status'] <= 0){ ?>
                        คำสั่งซื้อถูกยกเลิก
                    <?php } else if($row['status'] == 1){ ?>
                        รอร้านค้ายืนยันสลิป
                    <?php } else if($row['status'] == 2){ ?>
                        กำลังค้นหาไรเดอร์
                    <?php } else if($row['status'] == 3){ ?>
                        เจอไรเดอร์แล้วร้านค้ากำลังทำอาหาร
                    <?php } else if($row['status'] == 4){ ?>
                        ร้านค้าทำอาหารเสร็จสิ้น
                    <?php } else if($row['status'] == 5){ ?>
                        รอสักครู่ ไรเดอร์กำลังจัดส่ง
                    <?php } else if($row['status'] == 6){ ?>
                        การจัดส่งและชำระเงินเสร็จสิ้น
                    <?php } else if($row['status'] == 7){ ?>
                        เสร็จสิ้น
                    <?php } ?>
                </h6>

                <h5>ค่าอาหาร<span class="float-end">฿<?php echo $row['all_price'] ?></span></h5>
                
                <!-- เช็คส่วนลด -->
                <?php if($row['cpn_discount'] != 0){ ?>
                    <h5 class="text-danger">ส่วนลด<span class="float-end">- <?php echo $row['cpn_discount'] ?>%</span></h5>
                    <h5 class="text-success">ทั้งหมด<span class="float-end">฿<?php echo $row['sum_price'] ?></span></h5>
                <?php } ?>
                <!-- เช็คประเภทการชำระเงิน -->
                <h5>การชำระเงิน<span class="float-end"><?php echo ($row['slip'] == NUll ? 'เงินสด' : 'โอนจ่าย') ?></span></h5>
            </div>
        </div>

        <!-- ร้านเท่านั้นจะแสดงปุ่มปริ้นท์ PDF -->
        <?php if($member == 'restaurant'){ ?>
            <a href="report_pdf.php?order_id=<?php echo $row['order_id'] ?>" class="btn btn-outline-primary w-100">ดูใบเสร็จ</a>
        <?php } ?>
    </div>
<?php } ?>