<?php include 'app/views/shares/header.php'; ?>

<style>
    .gradient-custom {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    min-height: 100vh; /* Phủ hết chiều cao màn hình */
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    margin: 0; /* Xóa margin nếu có */
    padding: 0; /* Xóa padding nếu có */
}

    .card-custom {
        border-radius: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(10px);
    }
    .form-control {
        border-radius: 10px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: none;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.2);
        box-shadow: none;
        border: none;
    }
    .input-group-text {
        background: transparent;
        border: none;
        color: white;
    }
    .btn-custom {
        background: #ff9800;
        color: white;
        border-radius: 10px;
        padding: 12px;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: #e68900;
    }
    .text-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: 0.3s;
    }
    .text-link:hover {
        color: #fff;
    }
</style>

<section class="gradient-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-custom text-white p-4">
                    <div class="card-body">
                        <h2 class="fw-bold text-center mb-3">Đăng Nhập</h2>
                        <p class="text-center text-white-50">Vui lòng nhập thông tin đăng nhập</p>

                        <form action="/webbanhang/account/checklogin" method="post">
                            <div class="form-group mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Nhập username" required>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <a href="/webbanhang/account/forgotpassword" class="text-link">Quên mật khẩu?</a>
                            </div>

                            <button class="btn btn-custom w-100" type="submit">Đăng Nhập</button>
                        </form>

                        <div class="text-center mt-4">
                            <p>Chưa có tài khoản? <a href="/webbanhang/account/register" class="text-link fw-bold">Đăng Ký</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>
