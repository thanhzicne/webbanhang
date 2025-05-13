<?php
session_start();

header('Content-Type: application/json');

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST['id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$productId = $_POST['id'];
$action = $_POST['action'];

// Kiểm tra xem sản phẩm có trong giỏ hàng không
if (!isset($_SESSION['cart'][$productId])) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
    exit;
}

// Cập nhật số lượng sản phẩm
if ($action == 'increase') {
    $_SESSION['cart'][$productId]['quantity']++;
} elseif ($action == 'decrease' && $_SESSION['cart'][$productId]['quantity'] > 1) {
    $_SESSION['cart'][$productId]['quantity']--;
} else {
    echo json_encode(['success' => false, 'message' => 'Số lượng sản phẩm không hợp lệ']);
    exit;
}

// Tính toán lại tổng tiền sản phẩm
$newQuantity = $_SESSION['cart'][$productId]['quantity'];
$totalPrice = $_SESSION['cart'][$productId]['price'] * $newQuantity;
$totalCartPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['cart']));

echo json_encode([
    'success' => true,
    'newQuantity' => $newQuantity,
    'totalPrice' => $totalPrice,
    'totalCartPrice' => $totalCartPrice
]);
exit;
