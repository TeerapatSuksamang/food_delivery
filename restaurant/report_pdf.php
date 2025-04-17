<?php

    include_once 'nav.php';
    require_once __DIR__ . '/vendor/autoload.php';

    // สร้าง PDF โดยใช้ฟอนต์ THSarabunNew และกำหนดขนาดตัวอักษรเริ่มต้น
    $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => '18',
        'default_font' => 'THSarabunNew'
    ]);

    echo "<h1 class='text-center mt-5'>ใบเสร็จ</h1>";

    // เริ่มส่วนที่แสดงใน pdf
    ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จ</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>

</head>
<body>
    <?php
        // เช็คค่า get order_id ถ้าไม่มีให้เป็น ''
        $order_id = ($_GET['order_id'] ?? '');

        // เลือกออร์เดอร์จากไอดีที่รับมา และอยู่ในร้านที่กำลังล็อคอินใช้งานอยู่ตอนนี้
        $select_order = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `order_id` = '$order_id' AND `res_id` = '$res_id' ");
        if($select_order -> num_rows <= 0){
            alert('ไม่พบออร์เดอร์ที่คุณค้นหา');
        }
        $row_order = mysqli_fetch_array($select_order);
    ?>

    <!-- แสดงข้อมูลบนใบเสร็จ -->
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="card shadow p-3">
                    <!-- ข้อมูลออร์เดอร์นี้ -->
                    <div class="text-center">
                        <h2 style="font-weight: bold; font-size: 1.5rem;">ร้านอาหาร : <?php echo $row['res_name'] ?></h2>
                        <h6><?php echo $row['address'] ?></h6>
                        <h6><?php echo $row_order['date'] ?> | <?php echo $row_order['time'] ?></h6>
                    </div>
                    <hr>

                    <!-- รายการเมนูอาหารในออร์เดอร์ -->
                    <div class="table-responsive">
                        <table class="table-sm w-100">
                            <thead>
                                <?php
                                    // ดึงเมนูอาหารในออร์เดอร์นี้
                                    $select_food = mysqli_query($conn, "SELECT * FROM `food_order` WHERE `order_id` = '$order_id' ");
                                    while($row_food = mysqli_fetch_array($select_food)){
                                ?>
                                    <tr>
                                        <td>
                                            <!-- ชื่อเมนู -->
                                            <?php echo $row_food['food_name'] ?> x 
                                            <!-- จำนวน -->
                                            <?php echo $row_food['qty'] ?>
                                            (
                                                <!-- ราคาต่อชิ้น แสดงในวงเล็บ และเช็คส่วนลด ถ้ามีส่วนลดก็จะแสดงทั้งก่อนและหลังลดด้วย -->
                                                <?php if($row_food['discount'] != 0){ ?>
                                                    <s>฿<?php echo $row_food['price'] ?></s>
                                                    <span>฿<?php echo discount($row_food['price'], $row_food['discount']) ?></span>
                                                <?php } else { echo '฿'.$row_food['price']; } ?>
                                            )
                                        </td>
                                        <!-- ราคารวม ให้อยู่ฝั่งขวา -->
                                        <td align="right">฿<?php echo $row_food['total_price'] ?></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td style="font-weight: bold;">ค่าอาหาร</td>
                                    <td style="font-weight: bold;" align="right">฿<?php echo $row_order['all_price'] ?></td>
                                </tr>

                                <!-- ถ้ามีการเพิ่มส่วนลดเข้ามา -->
                                <?php if($row_order['cpn_discount']){ ?>
                                    <tr>
                                        <td style="font-weight: bold;">ส่วนลด</td>
                                        <td style="font-weight: bold;" align="right">- <?php echo $row_order['cpn_discount'] ?>%</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">ทั้งหมด</td>
                                        <td style="font-weight: bold;" align="right">฿<?php echo $row_order['sum_price'] ?></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td style="font-weight: bold;">การชำระเงิน</td>
                                    <td style="font-weight: bold;" align="right"><?php echo ($row_order['slip'] == NUll ? 'เงินสด' : 'โอนจ่าย') ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <hr>

                    <h5 style="font-weight: bold;">ข้อมูลผู้สั่ง</h5>
                    <h6>ชื่อผู้สั่ง : <?php echo $row_order['full_name'] ?></h6>
                    <h6>ที่อยู่ : <?php echo $row_order['address'] ?></h6>
                    <h6>เบอร์โทร : <?php echo $row_order['phone'] ?></h6>

                    <p class="text-center">ขอบคุณที่ใช้บริการ</p>
                </div>
            </div>
        </div>
    </div>

    <?php
    
        $html = ob_get_contents();
        $mpdf->WriteHTML($html);
        $mpdf->OutPut('Receipt.pdf');

        // สิ้นสุดส่วนที่แสดง pdf
        ob_end_flush();
    
    ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-4">
                <div class="d-flex gap-3">
                    <a href="report.php" class="btn btn-outline-secondary w-100">ย้อนกลับ</a>
                    <a href="Receipt.pdf" class="btn btn-primary w-100">พิมพ์</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
