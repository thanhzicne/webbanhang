<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg p-4 rounded-4 border-0">
                <h2 class="text-center text-primary fw-bold mb-4">Thanh toán</h2>

                <form method="POST" action="/webbanhang/Product/processCheckout">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Họ tên:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ tên của bạn" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Địa chỉ:</label>
                        <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ nhận hàng" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fas fa-credit-card"></i> Xác nhận thanh toán
                    </button>
                </form>
                <a href="/webbanhang/Product/cart" class="btn btn-secondary mt-3 w-100">
                    <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
