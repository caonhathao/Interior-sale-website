<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        var nf = new Intl.NumberFormat();
    </script>
    <title>Thông tin sản phẩm</title>
</head>

<body>
    <?php
    $id = isset($_GET['prodID']) ? ($_GET['prodID']) : 27;

    $sql = "SELECT * FROM product where proid=$id";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); { ?>
        <div class="container">
            <div class="product-info">
                <div class="product-image">
                    <img class="image" src="../../../<?php echo htmlspecialchars($row['image_path']); ?>">
                </div>
                <div class="product-intro">
                    <div class="show-info">
                        <div class="product-name">
                            <?php echo $row['proname']; ?>
                        </div>
                        <div class="product-price"><?php if ($row['sales'] == null) { ?>
                                Giá: <script>
                                    var price = <?php echo $row['proprice'] ?>;
                                    document.write(nf.format(price));
                                </script>đ
                            <?php } else { ?>
                                <div class="old-price" style="color:gray; text-decoration:line-through;font-size:14px;">
                                    Giá cũ: <script>
                                        var price = <?php echo $row['proprice'] ?>;
                                        document.write(nf.format(price));
                                    </script>đ
                                </div>
                                <div class="new-price" style="color:red;font-size:20px;">
                                    Giá mới: <script>
                                        var price = <?php echo $row['proprice'] * (1 - $row['sales'] / 100) ?>;
                                        document.write(nf.format(price));
                                    </script>đ
                                </div>
                            <?php } ?>
                        </div>

                        <div class="product-description"><?php
                                                            $lines = explode("\n", $row['prodescription']);
                                                            foreach ($lines as $line) {
                                                                echo "<p>" . $line . "</p>";
                                                            }
                                                            ?></div>
                    </div>
                    <div class="act">
                        <div class="btn">
                            <form action="../../../../index.php?act=GioHang" method="post">
                                <input type="hidden" name="idSP" value="<?php echo $id ?> ">
                                <input type="hidden" name="nameSP" value=" <?php echo $row['proname']; ?>">
                                <input type="hidden" name="priceSP" value="<?php
                                                                            if ($row['sales'] == null) {
                                                                                echo $row['proprice'];
                                                                            } else {
                                                                                echo $row['proprice'] - ($row['proprice'] * ($row['sales'] / 100));
                                                                            } ?>;">
                                <input type="hidden" name="imgSP" value="<?php echo htmlspecialchars($row['image_path']); ?>">
                                <input type="hidden" name="mua" value="1">
                                <input type="submit" class="pre-order-btn" name="addcart" value="Mua ngay" <?php
                                                                                                            if ($row['prostock'] == 0) {
                                                                                                                echo "disabled";
                                                                                                            }
                                                                                                            ?>>
                            </form>
                            <form id="add-to-cart-form">
                                <input type="hidden" name="idSP" value="<?php echo $id ?>">
                                <input type="hidden" name="nameSP" value="<?php echo $row['proname']; ?>">
                                <input type="hidden" name="priceSP" value="<?php
                                                                            if ($row['sales'] == null) {
                                                                                echo $row['proprice'];
                                                                            } else {
                                                                                echo $row['proprice'] - ($row['proprice'] * ($row['sales'] / 100));
                                                                            } ?>;">
                                <input type="hidden" name="imgSP" value="<?php echo htmlspecialchars($row['image_path']); ?>">
                                <input type="hidden" name="mua" value="0">
                                <input type="submit" class="pre-order-btn" name="addcart" value="Thêm vào giỏ"
                                    <?php if ($row['prostock'] == 0) {
                                        echo "disabled";
                                    } ?>>
                            </form>
                        </div>
                        <div class="services-info">
                            Miễn phí giao hàng & lắp đặt tại tất cả quận huyện thuộc TP.HCM, Hà Nội, Khu đô thị Ecopark, Biên Hòa và một số quận thuộc Bình Dương (*)
                            <br />
                            Miễn phí 1 đổi 1 - Bảo hành 2 năm - Bảo trì trọn đời (**)
                            <br />
                            <br />
                            (*) Không áp dụng cho danh mục Đồ Trang Trí
                            <br />
                            (**) Không áp dụng cho các sản phẩm Clearance. Chỉ bảo hành 01 năm cho khung ghế, mâm và cần đối với Ghế Văn Phòng
                        </div>
                        <div class="hotline">Gọi ngay để được tư vấn:<br /> 01234567890</div>
                    </div>
                </div>
            </div>
            <div class="decription"></div>
        </div>
    <?php
    }
    ?>
    <script>
        document.getElementById('add-to-cart-form').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('assets/frontend/pages/Cart/add-to-cart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    if (text === 'OK') {
                        alert('Sản phẩm đã được thêm vào giỏ hàng!');
                    } else {
                        console.error('There was an error.');
                        alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                    }
                })
                .catch(error => {
                    console.error('There was an error:', error);
                });
        });
    </script>
</body>

</html>