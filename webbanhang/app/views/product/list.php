<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    

    <?php if (SessionHelper::isAdmin()): ?>
        <!-- Giao diện dành cho Admin: Danh sách dạng bảng -->
         <div class="mt-4 p-5 text-white rounded my-4" style="background: linear-gradient(135deg, #ff6b6b, #4ecdc4);">
            <h1 class="text-center mb-4 text-white fw-bold">Danh sách sản phẩm</h1>
        </div>
        <!--  -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/webbanhang/Product/add" class="btn btn-success shadow-sm px-4 py-2 fw-bold">Thêm sản phẩm</a>
            <a href="/webbanhang/Product/history" class="btn btn-primary shadow-sm px-4 py-2 fw-bold ms-2">Xem lịch sử mua hàng</a>
            <a href="/webbanhang/Product/revenueStatistics" class="btn btn-warning shadow-sm px-4 py-2 fw-bold ms-2 text-white">
                <i class="fas fa-chart-line me-1"></i> Thống kê doanh thu
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product->id; ?></td>
                            <td>
                                <?php if ($product->image): ?>
                                    <img src="/webbanhang/<?php echo $product->image; ?>" alt="Hình ảnh sản phẩm" style="width: 100px; height: auto; object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">Không có hình ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo number_format($product->price, 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm px-3 fw-bold text-white rounded-pill">
                                    <i class="fas fa-edit me-1"></i> Sửa
                                </a>
                                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm px-3 fw-bold rounded-pill delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fas fa-trash me-1"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>

        <!-- Giao diện dành cho User: Lưới sản phẩm -->
         <div class="mt-4 p-5 text-white rounded my-4" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <h1 class="text-center mb-4 text-white fw-bold">Cửa hàng sản phẩm</h1>
        </div>
        <!--  -->
        <div class="row row-cols-1 row-cols-md-3 gy-5">
            <?php foreach ($products as $product): ?>
                <div class="col mb-5">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <?php if ($product->image): ?>
                            <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top" alt="Hình ảnh sản phẩm" style="height: 250px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title text-dark fw-bold">
                                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small"> <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?> </p>
                            <p class="card-text text-danger fw-bold fs-5"> <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                            <p class="card-text text-secondary small">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-end">
                            <?php if (SessionHelper::isLoggedIn()): ?>
                                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm px-3 fw-bold rounded-pill transition-all hover-btn">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                </a>
                            <?php else: ?>
                                <a href="/webbanhang/account/login" class="btn btn-primary btn-sm px-3 fw-bold rounded-pill transition-all hover-btn">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>