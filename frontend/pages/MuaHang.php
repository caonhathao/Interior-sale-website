<?php
session_start();
require __DIR__ . '../../../db/connect.php';
include_once __DIR__ . '../../../frontend/pages/Function.php';
if (isset($_POST['cartid'])) {
    $pttt = $_POST['pttt'];
    $dsitem = explode(',', $_POST['cartid']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date('Y-m-d H:i:s');
    $total_cost = 0;

    foreach ($dsitem as $item) {
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem[0] == $item) {
                $total_cost += floatval($cartItem[2]) * floatval($cartItem[3]);
                echo $total_cost;
            }
        }
    }
    if (isset($_SESSION['user_id'])) {
        // if ($total_cost <= 0) {
        //     die("Lỗi: Tổng số tiền phải lớn hơn 0.");
        // }
        $sql = "INSERT INTO orders (userid, orderdate, totalmount, payment_status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt == false) {
            die("Lỗi khi chuẩn bị truy vấn SQL: " . $conn->error);
        }
        $stmt->bind_param("isds", $_SESSION['user_id'], $now, $total_cost, $pttt);

        if ($stmt->execute()) {
            $orderID = $stmt->insert_id;
            $itemStmt = $conn->prepare("INSERT INTO `order-detail` (orderid, proid, quanitity, price) VALUES (?, ?, ?, ?)");
            $deleteStmt = $conn->prepare("DELETE FROM `cart-item` WHERE proID = ? AND userID = ?");

            foreach ($dsitem as $item) {
                foreach ($_SESSION['cart'] as $key => $cartItem) {
                    if ($cartItem[0] == $item) {
                        if (!$itemStmt->bind_param("iiid", $orderID, $cartItem[0], $cartItem[2], $cartItem[3])) {
                            die("Lỗi khi gán tham số vào order-detail: " . $itemStmt->error);
                        }
                        if (!$itemStmt->execute()) {
                            die("Lỗi khi thêm dữ liệu vào bảng order-detail: " . $itemStmt->error);
                        }
                        if (!$deleteStmt->bind_param("ii", $cartItem[0], $_SESSION['user_id'])) {
                            die("Lỗi khi gán tham số vào cart-item: " . $deleteStmt->error);
                        }
                        if (!$deleteStmt->execute()) {
                            die("Lỗi khi xóa dữ liệu vào bảng cart-item: " . $deleteStmt->error);
                        }

                        $Updatequantity = $conn->prepare("UPDATE product SET prostock = prostock - ? WHERE proid = ?");
                        $Updatequantity->bind_param("ii", $cartItem[2], $cartItem[0]);
                        $Updatequantity->execute();
                        $Updatequantity->close();

                        $checkprostock = $conn->prepare("SELECT prostock FROM product WHERE proid = ?");
                        $checkprostock->bind_param("i", $cartItem[0]);
                        $checkprostock->execute();
                        $result = $checkprostock->get_result();
                        $stockrow = $result->fetch_assoc();
                        if ($stockrow['prostock'] == 0) {
                            $disableProduct = $conn->prepare("UPDATE product SET is_active = '0' WHERE proid = ?");
                            $disableProduct->bind_param("i", $cartItem[0]);
                            $disableProduct->execute();
                            $disableProduct->close();
                        }
                        $checkprostock->close();
                        unset($_SESSION['cart'][$key]);
                    }
                }
            }
            echo '<script>alert("Đặt hàng thành công");</script>';
            header('Location: ../../index.php?act=GioHang');
            exit();
        } else {
            echo '<script>alert("Đặt hàng thất bại");</script>';
            header('Location: ../../index.php');
            exit();
        }
    }
    exit();
}
