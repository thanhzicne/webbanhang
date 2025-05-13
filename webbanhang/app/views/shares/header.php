<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand btn btn-info" href="/webbanhang/Product/index"><i class="fa fa-box"></i> Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Chuyển đổi điều hướng">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-dark mr-2" href="/webbanhang/Product/"><i class="fa fa-list"></i> Danh sách sản phẩm</a>
                </li>
                <?php if (SessionHelper::isLoggedIn() && !SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark mr-2" href="/webbanhang/Product/purchaseHistory"><i class="fa fa-history"></i> Lịch sử mua hàng</a>
                    </li>
                <?php endif; ?>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark mr-2" href="/webbanhang/Product/add"><i class="fa fa-plus-circle"></i> Thêm sản phẩm</a>                    
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?php 
                    if (SessionHelper::isLoggedIn()) { 
                        echo "<a class='nav-link btn btn-outline-dark'><i class='fa fa-user'></i> " . htmlspecialchars($_SESSION['username']) . " (" . SessionHelper::getRole() . ")</a>"; 
                    } else { 
                        echo "<a class='nav-link btn btn-outline-dark' href='/webbanhang/account/login'><i class='fa fa-sign-in'></i> Đăng nhập</a>"; 
                    } 
                    ?>
                </li>
                <li class="nav-item">
                    <?php 
                    if (SessionHelper::isLoggedIn()) { 
                        echo "<a class='nav-link btn btn-outline-dark' href='/webbanhang/account/logout'><i class='fa fa-sign-out'></i> Đăng xuất</a>"; 
                    } 
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">