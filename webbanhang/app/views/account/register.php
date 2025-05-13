<?php include 'app/views/shares/header.php'; ?> 

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="width: 500px;">
        <h3 class="text-center mb-4"><i class="bi bi-person-plus"></i> Đăng Ký Tài Khoản</h3>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="user" action="/webbanhang/account/save" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="bi bi-person-circle"></i> Tên đăng nhập
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" 
                        placeholder="Nhập username" required autocomplete="username"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="fullname" class="form-label">
                    <i class="bi bi-card-text"></i> Họ và tên
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" class="form-control" id="fullname" name="fullname" 
                        placeholder="Nhập họ và tên" required autocomplete="name"
                        value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" 
                        placeholder="Nhập email" required autocomplete="email"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i> Mật khẩu
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Nhập mật khẩu" required minlength="8">
                </div>
                <small class="text-muted">Mật khẩu phải có ít nhất 8 ký tự.</small>
            </div>

            <div class="mb-3">
                <label for="confirmpassword" class="form-label">
                    <i class="bi bi-lock-fill"></i> Xác nhận mật khẩu
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" 
                        placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-check-circle"></i> Đăng Ký
            </button>

            <div class="text-center mt-3">
                <p>Đã có tài khoản? <a href="/webbanhang/account/login" class="text-decoration-none">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 