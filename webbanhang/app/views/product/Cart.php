<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg p-4 rounded-4 border-0">
                <h2 class="text-center text-primary fw-bold mb-4">Giỏ hàng của bạn</h2>

                <?php if (!empty($cart)): ?>
                    <ul class="list-group">
                        <?php foreach ($cart as $id => $item): ?>
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <?php if ($item['image']): ?>
                                        <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                        <p class="mb-1 text-danger fw-bold"><span id="price-<?php echo $id; ?>">
                                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                                        </span> VND</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-danger btn-sm me-2" onclick="updateQuantity(<?php echo $id; ?>, 'decrease')">-</button>
                                    <span class="fw-bold" id="quantity-<?php echo $id; ?>">
                                        <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                    <button class="btn btn-outline-success btn-sm ms-2" onclick="updateQuantity(<?php echo $id; ?>, 'increase')">+</button>
                                    <button class="btn btn-danger btn-sm ms-3" onclick="removeFromCart(<?php echo $id; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="mt-3 fw-bold">Tổng tiền: <span id="total-price"><?php echo number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 0, ',', '.'); ?> VND</span></p>

                    <a href="/webbanhang/Product/checkout" class="btn btn-primary w-100 py-2 mt-2">Thanh Toán</a>
                    <a href="/webbanhang/Product" class="btn btn-secondary w-100 py-2 mt-2">Tiếp tục mua sắm</a>
                <?php else: ?>
                    <p class="text-center">Giỏ hàng của bạn đang trống.</p>
                    <div class="text-center">
                        <a href="/webbanhang/Product" class="btn btn-secondary">Quay lại cửa hàng</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, action) {
    fetch('/webbanhang/cart/updateCartQuantity.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${productId}&action=${action}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`quantity-${productId}`).textContent = data.newQuantity;
            document.getElementById(`price-${productId}`).textContent = data.totalPrice.toLocaleString() + " VND";
            document.getElementById("total-price").textContent = data.totalCartPrice.toLocaleString() + " VND";
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Lỗi:', error));
}

function removeFromCart(productId) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
        fetch('/webbanhang/cart/removeFromCart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }
}

</script>

<?php include 'app/views/shares/footer.php'; ?>
