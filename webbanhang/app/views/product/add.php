<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4 rounded-4 border-0">
                <h2 class="text-center text-success fw-bold mb-4">🛍️ Thêm sản phẩm</h2>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên sản phẩm:</label>
                        <input type="text" id="name" name="name" class="form-control rounded-3" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control rounded-3" rows="3" required><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-bold">Giá:</label>
                        <input type="number" id="price" name="price" class="form-control rounded-3" step="0.01" required value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
                            </div>
                    <div class="mb-3">
                         <label for="category_id" class="form-label fw-bold">Danh mục:</label>
                            <select id="category_id" name="category_id" class="form-select rounded-3" required onchange="toggleNewCategoryInput(this)">
                                <option value="">-- Chọn danh mục --</option>
                                <?php if (!empty($categories)) { foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category->id) ?>">
                                        <?= htmlspecialchars($category->name) ?>
                                    </option>
                                <?php endforeach; } ?>
                    
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold"> Hình ảnh:</label>
                        <input type="file" id="image" name="image" class="form-control rounded-3" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-3 text-center">
                            <img id="imagePreview" src="" alt="Xem trước hình ảnh" class="img-fluid rounded shadow d-none" style="max-height: 200px;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 rounded-3 shadow-sm"> Thêm sản phẩm</button>
                </form>

                <a href="/webbanhang/Product/index" class="btn btn-secondary mt-3 w-100 rounded-3"> Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleNewCategoryInput(select) {
    let newCategoryDiv = document.getElementById("newCategoryDiv");
    let newCategoryInput = document.getElementById("new_category");

    if (select.value === "new") {
        newCategoryDiv.classList.remove("d-none");
        newCategoryInput.setAttribute("required", "required");
    } else {
        newCategoryDiv.classList.add("d-none");
        newCategoryInput.removeAttribute("required");
    }
}

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.classList.remove('d-none');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
