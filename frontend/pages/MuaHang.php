<?php
session_start();
require __DIR__ . '../../../db/connect.php';
include_once __DIR__ . '../../../frontend/pages/Function.php';

$now = date('Y-m-d H:i:s');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if (isset($_POST['Buy'])) {
    $pttt = $_POST['pttt'];
    $dsitem = explode(',', $_POST['cartid']);

    $total = 0;


    foreach ($dsitem as $item) {
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem[0] == $item) {
                $total += $cartItem[2] * $cartItem[3];
            }
        }

        // if (!is_null($rows['itemprice']) && !is_null($rows['quantity'])) {
        //     $total += $rows['itemprice'] * $rows['quantity'];
        // } else {
        //     die("Lỗi: Giá hoặc số lượng của sản phẩm không hợp lệ.");
        // }
    }
}
if (isset($_SESSION['user_id'])) {
    if ($total == 0) {
        die("Lỗi: Tổng số tiền không được bằng 0 hoặc null.");
    }
    $sql = "INSERT INTO orders (userid, orderdate, totalmount, payment_status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt == false) {
        die("Lỗi khi chuẩn bị truy vấn SQL: " . $conn->error);
    }
    $stmt->bind_param("isds", $_SESSION['user_id'], $now, $total, $pttt);
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
                    unset($_SESSION['cart'][$key]);
                }
            }
        }
        // $row = $iteminfo->fetch_assoc();

        // foreach ($_SESSION['cart'] as $key => $cartItem) {
        //     if ($cartItem[0] == $row['proID']) {
        //         unset($_SESSION['cart'][$key]);
        //         break;
        //     }
        // }

        // $itemStmt->bind_param("iiid", $orderID, $row['proID'], $row['quantity'], $row['itemprice']);
        // $itemStmt->execute();

        // $deleteStmt->bind_param("i", $item);
        // $deleteStmt->execute();
        echo '<script>alert("Đặt hàng thành công");</script>';
        header('Location: ../../index.php?act=GioHang');
        exit();
    } else {
        echo '<script>alert("Đặt hàng thất bại");</script>';
        header('Location: ../../index.php');
        exit();
    }
}
