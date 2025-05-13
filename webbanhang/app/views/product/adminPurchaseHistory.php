<?php include 'app/views/shares/header.php'; ?>
<!-- Giao diện dành cho Admin: Lịch sử mua hàng -->
<!-- Giao diện dành cho Admin: Lịch sử mua hàng -->
<div class="mt-4 p-5 text-white rounded-3 my-4 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(90deg, #6b48ff, #00ddeb);">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
    <h1 class="text-center mb-4 text-white fw-bold position-relative" style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
        <i class="fas fa-history me-3"></i> Lịch sử mua hàng của tất cả khách hàng
    </h1>
</div>

<!-- Nút quay lại -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="/webbanhang/Product" class="btn btn-outline-secondary shadow-sm px-4 py-2 fw-bold">
        <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách sản phẩm
    </a>
</div>

<div class="table-responsive rounded shadow-sm">
    <table class="table table-striped table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">ID Đơn hàng</th>
                <th scope="col" class="text-center">Tên khách hàng</th>
                <th scope="col" class="text-center">Số điện thoại</th>
                <th scope="col" class="text-center">Địa chỉ</th>
                <th scope="col" class="text-center">Ngày đặt hàng</th>
                <th scope="col" class="text-center">Tên sản phẩm</th>
                <th scope="col" class="text-center">Số lượng</th>
                <th scope="col" class="text-center">Giá đơn vị</th>
                <th scope="col" class="text-center">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($order['order_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($order['order_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name'] ?? 'Không có sản phẩm', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($order['quantity'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-end"><?php echo number_format($order['unit_price'] ?? 0, 0, ',', '.') . ' VND'; ?></td>
                        <td class="text-end"><?php echo number_format($order['total_price'] ?? 0, 0, ',', '.') . ' VND'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-exclamation-circle me-2"></i> Không có lịch sử mua hàng nào.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'app/views/shares/footer.php'; ?>