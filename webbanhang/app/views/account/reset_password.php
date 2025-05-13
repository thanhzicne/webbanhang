<?php include 'app/views/shares/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 500px;">
        <h3 class="text-center mb-4"><i class="bi bi-shield-lock"></i> Đặt Lại Mật Khẩu</h3>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/webbanhang/account/resetPassword" method="post">
            <div class="mb-3">
                <label for="code" class="form-label">
                    <i class="bi bi-key"></i> Mã Xác Nhận
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="text" class="form-control" id="code" name="code" 
                        placeholder="Nhập mã xác nhận" required>
                </div>
                <div class="text-end mt-2">
                    <a href="/webbanhang/account/resendResetCode" class="text-decoration-none">Gửi lại mã</a>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['message']; ?>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i> Mật khẩu mới
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Nhập mật khẩu mới" required minlength="8">
                </div>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">
                    <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                        placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-check-circle"></i> Đổi Mật Khẩu
            </button>

            <div class="text-center mt-3">
                <p><a href="/webbanhang/account/login" class="text-decoration-none">Quay lại đăng nhập</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>