<!-- app/views/product/purchaseHistory.php -->
<?php include 'app/views/shares/header.php'; ?>
<div class="mt-4 p-5 text-white rounded-3 my-4 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(90deg, #6a5acd, #32cd32);">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-20" style="background: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
    <h1 class="text-center mb-4 text-white fw-bold position-relative" style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
        <i class="fas fa-history me-3"></i> Lịch sử mua hàng của bạn
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
                <th scope="col" class="text-center">Mã đơn hàng</th>
                <th scope="col" class="text-center">Tên sản phẩm</th>
                <th scope="col" class="text-center">Số lượng</th>
                <th scope="col" class="text-center">Giá</th>
                <th scope="col" class="text-center">Tổng giá</th>
                <th scope="col" class="text-center">Ngày đặt</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($purchaseHistory)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-exclamation-circle me-2"></i> Bạn chưa có lịch sử mua hàng.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($purchaseHistory as $order): ?>
                    <?php foreach ($order['products'] as $product_id => $item): ?>
                        <tr style="line-height: 1.5;">
                            <td class="text-center"><?= htmlspecialchars($order['order_id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-end"><?= number_format($item['price'], 2) ?> VNĐ</td>
                            <td class="text-end"><?= number_format($item['quantity'] * $item['price'], 2) ?> VNĐ</td>
                            <td class="text-center"><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'app/views/shares/footer.php'; ?>
