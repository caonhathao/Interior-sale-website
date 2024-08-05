<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./about.css">
    <link rel="stylesheet" href="../../component/header/header.css">
    <link rel="stylesheet" href="../../component/footer/footer.css">
    <script src="./about.js"></script>
    <title>Về chúng tôi</title>
</head>

<body>
    <?php include "../../component/header/header.php"; ?>
    <div class="container">
        <div class="content">
            <div class="group-content-container">
                <div class="group-content-1 left">
                    <div class="content-1">
                        Chào mừng bạn đến với nội thất Nhật Hoàng.
                        <br />
                        Chúng tôi tự hào là thương hiệu kinh doanh nội thất số 10 Việt Nam.
                        <br />
                        Chúng tối sẽ chứng minh cho bạn thấy rằng, Nhật Hoàng là thương hiệu đáng để bạn lựa chọn!
                    </div>
                    <div class="content-2">
                        Được thành lập từ 2015, đến nay chúng tôi đã và đang trở thành đối tác tin cậy của hơn 20+ đối tác lớn ở trong và ngoài nước.
                        <br />
                        Chúng tôi luôn tìm kiếm những thiết kế sang trọng, hiện đại, đảm bảo chất lượng và giá cả tốt nhất.
                    </div>
                </div>
                <div class="group-content-2 right">
                    <div class="content-1">
                        <div class="slideshow">
                            <div class="slideshow-container">
                                <div class="slides fade">
                                    <img src="../../src/about/112131.png" alt="Image">
                                </div>
                                <div class="slides fade">
                                    <img src="../../src/about/537456.jpg" alt="Image">
                                </div>
                                <div class="slides fade">
                                    <img src="../../src/about/674709.jpg" alt="Image">
                                </div>
                                <div class="slides fade">
                                    <img src="../../src/about/cropped-1920-1080-174965.png" alt="Image">
                                </div>
                                <div class="slides fade">
                                    <img src="../../src/about/Ảnh-nền-hoạt-hình-cực-ngầu-scaled.jpg" alt="Image">
                                </div>
                                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            </div>
                            <br />
                            <div class="dots" style="text-align:center">
                                <span class="dot" onclick="currentSlide(1)"></span>
                                <span class="dot" onclick="currentSlide(2)"></span>
                                <span class="dot" onclick="currentSlide(3)"></span>
                                <span class="dot" onclick="currentSlide(4)"></span>
                                <span class="dot" onclick="currentSlide(5)"></span>
                            </div>
                        </div>
                        <script>
                            
                        </script>
                    </div>
                </div>
            </div>
            <div class="group-content-container">
                <div class="group-content-1 right">
                    <div class="content-1"></div>
                </div>
                <div class="group-content-2 left">
                    <div class="content-2"></div>
                </div>
            </div>
            <div class="group-content-container">
                <div class="group-content-1 left">
                    <div class="content-1"></div>
                </div>
                <div class="group-content-2 right">
                    <div class="content-1"></div>
                    <div class="content-1"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../../component/footer/footer.php"; ?>
</body>

</html>