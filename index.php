<?php include_once 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $web['web_name'] ?></title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.js"></script>

    <!-- แสดงรูปโลโก้บน browser tab -->
    <link rel="icon" type="image/png" href="upload/<?php echo $web['logo'] ?>" class="img">
    <!-- แสดงรูปเวลาแชร์ลิงค์ -->
    <meta property="og:image" content="img/banner.png" />

    <style>

        /* กรอบพื้นหลังสีดำใหญ่เต็มจอ ที่ใส่ข้อความให้อยู่ตรงกลาง และแสดงทับทุกอย่าง */
        .intro-container{
            background-color: #000;
            position: fixed;
            width: 100%;
            height: 100svh;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fade-out .5s 2.3s forwards;
            z-index: 9999;
        }
        /* รอดีเลย์ค่อยหาย */
        @keyframes fade-out {
            to{
                opacity: 0;
                display: none;
            }
        }

        /* กรอบที่ใส่ข้อความทั้งหมด */
        .text{
            overflow: hidden;
            color: #fff;
            animation: fade-scale 3s forwards;
            font-size: 2rem;
        }
        @keyframes fade-scale {
            0%{
                opacity: 0;
                transform: scale(1.1);
            }
            70%{
                opacity: 1;
                transform: scale(0.8);
            }
            100%{
                opacity: 0;
                transform: scale(0.7);
            }
        }

        /* ข้อความในกรอบ เริ่มต้นให้ซ่อน และอยู๋ด้านล้างนอกกรอบข้อความ */
        .text span{
            display: inline-block;
            opacity: 0;
            transform: translateY(100%);
            animation: fade-up .7s forwards;
        }
        @keyframes fade-up {
            to{
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* วนลูปนับจำนวนตัวอักษรในข้อความ เพื่อปรับดีเลย์ให้เหมาะสมกับอนิเมชั่น */
        <?php
            $child = 0;
            $sec = 0;
            for ($i = 0; $i < strlen($web['web_name']); $i++){
                $sec += 0.10;
        ?>
            .text span:nth-child(<?php echo ++$child ?>){
                animation-delay: <?php echo $sec ?>s;
            }
        <?php } ?>

        /* เส้นที่วิ่งด้านล่าง ที่ปรับ delay ให้เหมาะสมกับอนิเมชั่นข้อความแล้ว */
        .text::before{
            content: '';
            position: absolute;
            bottom: 0;
            left: -100%;
            width: 100%;
            height: 1.5px;
            background-color: #fff;
            box-shadow: 0 0 5px #a200ff, 0 0 10px #e606ff, 0 0 20px #fff;
            animation: under-line .7s <?php echo ($sec + 0.3) ?>s;
        }
        @keyframes under-line {
            to{
                left: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- intro ตอนเปิดหน้าเว็บ -->
    <div class="intro-container">
        <div class="text">
            <!-- นำชื่อเว็บมาวนลูปแสดงทีละตัวอักษรให้อยู่ใน span เพื่อให้เล่นอนิเมชั่นทีละตัว -->
            <?php for ($i = 0; $i < strlen($web['web_name']); $i++) { ?>
               <span><?php echo $web['web_name'][$i] ?></span>
            <?php } ?>
        </div>
    </div>

    <!-- Navbar พื้นหลังสีขาวขุ่นโปร่งใส และเบลอ -->
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top" style="background: #252525a1; backdrop-filter: blur(5px);">
        <div class="container-fluid">
            <a href="index.php" class="pro-brand">
                <img src="upload/<?php echo $web['logo'] ?>" class="img">
            </a>
            <a href="index.php" class="navbar-brand"><?php echo $web['web_name'] ?></a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#hamburger">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="hamburger">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <hr class="text-light">

                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a href="user/index.php" class="nav-link">สั่งอาหาร</a>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a href="" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                            พาร์ทเนอร์
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="register.php?member=restaurant" class="dropdown-item">เปิดร้านอาหาร</a></li>
                            <li><a href="register.php?member=rider" class="dropdown-item">สมัครเป็นผู้ส่งอาหาร</a></li>
                        </ul>
                    </li>

                    <hr class="text-light">
                    <a href="login.php?member=user" class="btn btn-success">ลงชื่อเข้าใช้</a>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel image slider -->
    <div class="carousel slide" id="slider" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <button data-bs-target="#slider" data-bs-slide-to="0" class="active"></button>
            <button data-bs-target="#slider" data-bs-slide-to="1"></button>
            <button data-bs-target="#slider" data-bs-slide-to="2"></button>
        </ol>

        <!-- พื้นที่แสดงรูป banner -->
        <div class="carousel-inner">
            <!-- bg-img-1 : รูป banner เป็นพื้นหลัง -->
            <div class="carousel-item bg-img-1 active">
                <!-- dark-overlay : พื้นหลังโทนมืดไล่ไปสว่าง จากซ้ายไปขวา -->
                <div class="dark-overlay">
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-md-8 text-light">
                                <h3 class="display-4">Order Food</h3>
                                <h1 class="display-1">สั่งอาหารออนไลน์</h1>
                                <h3>
                                    พบกับหลากเมนูจากหลายร้านอาหารที่พร้อมส่งถึงมือคุณ
                                    พร้อมส่วนลดมื้อสุขสุดคุ้มอีกมากมาย
                                </h3>
                                
                                <a href="user/index.php" class="btn btn-outline-light px-5 py-3">สั่งเลย!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item bg-img-2">
                <div class="dark-overlay">
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-md-8 text-light">
                                <h3 class="display-4">Restaurant</h3>
                                <h1 class="display-1">เปิดร้านอาหารกับเรา</h1>
                                <h3>เข้าถึงลูกค้าได้มากกว่า เพื่อเพิ่มยอดขายให้ธุรกิจร้านอาหารของคุณ</h3>
                                
                                <a href="register.php?member=restaurant" class="btn btn-outline-light px-5 py-3">เปิดร้านกับเรา!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item bg-img-3">
                <div class="dark-overlay">
                    <div class="container h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-md-8 text-light">
                                <h3 class="display-4">Delivery Man</h3>
                                <h1 class="display-1">สมัครเป็นผู้ส่งอาหาร</h1>
                                <h3>งานส่งอาหาร ที่เลือกวันและเวลาทำงานได้อย่างอิสระ สามารถทำเป็นงานเสริมหรืองานประจำก็ได้ สมัครง่ายไม่มีค่าใช้จ่าย</h3>
                                
                                <a href="register.php?member=rider" class="btn btn-outline-light px-5 py-3">สมัครเลย!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ปุ่มเลื่อนซ้าย ขวา -->
            <button class="carousel-control-prev" data-bs-target="#slider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" data-bs-target="#slider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</body>
</html>