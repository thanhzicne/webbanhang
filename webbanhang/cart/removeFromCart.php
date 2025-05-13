<?php
session_start();

header('Content-Type: application/json');

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$productId = $_POST['id'];

// Kiểm tra xem sản phẩm có trong giỏ hàng không
if (!isset($_SESSION['cart'][$productId])) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
    exit;
}

// Xóa sản phẩm khỏi giỏ hàng
unset($_SESSION['cart'][$productId]);

// Tính lại tổng tiền
$totalCartPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['cart']));

echo json_encode([
    'success' => true,
    'totalCartPrice' => $totalCartPrice
]);
exit;
