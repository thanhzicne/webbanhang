<?php include 'app/views/shares/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 500px;">
        <h3 class="text-center mb-4"><i class="bi bi-key"></i> Quên Mật Khẩu</h3>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/webbanhang/account/sendResetCode" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" 
                        placeholder="Nhập email của bạn" required autocomplete="email">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-send"></i> Gửi Mã Xác Nhận
            </button>

            <div class="text-center mt-3">
                <p><a href="/webbanhang/account/login" class="text-decoration-none">Quay lại đăng nhập</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>