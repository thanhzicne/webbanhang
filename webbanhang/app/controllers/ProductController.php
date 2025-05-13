<?php 
// Require SessionHelper and other necessary files 
require_once('app/config/database.php'); 
require_once('app/models/ProductModel.php'); 
require_once('app/models/CategoryModel.php'); 
require_once('app/helpers/SessionHelper.php'); 
class ProductController 
{ 
    private $productModel; 
    private $db; 
 
    public function __construct() 
    { 
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db);
    } 
    // ====================================================
    // Kiểm tra quyền Admin 
    private function isAdmin() { 
        return SessionHelper::isAdmin(); 
    }
    //====================================================
    public function index() 
    { 
        $products = $this->productModel->getProducts(); 
        include 'app/views/product/list.php'; 
    } 
    //====================================================
    public function show($id) 
    { 
        $product = $this->productModel->getProductById($id); 
 
        if ($product) { 
            include 'app/views/product/show.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
    //====================================================
    public function add() 
    { 
       if (!$this->isAdmin()) { 
        echo "Bạn không có quyền truy cập chức năng này!"; 
        exit; 
        } 
        $categories = (new CategoryModel($this->db))->getCategories(); 
        include_once 'app/views/product/add.php';
    } 
    //====================================================
    public function save() 
    { 
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        } 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            $category_id = $_POST['category_id'] ?? null; 
 
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = ""; 
            } 
           
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image); 
 
            if (is_array($result)) { 
                $errors = $result; 
                $categories = (new CategoryModel($this->db))->getCategories(); 
                include 'app/views/product/add.php'; 
            } else { 
                header('Location: /webbanhang/Product'); 
            } 
        } 
    } 
    //====================================================
    public function edit($id) 
    { 
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        } 
        $product = $this->productModel->getProductById($id); 
        $categories = (new CategoryModel($this->db))->getCategories(); 
 
        if ($product) { 
            include 'app/views/product/edit.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
    //====================================================
    public function update() 
    { 
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $id = $_POST['id']; 
            $name = $_POST['name']; 
            $description = $_POST['description']; 
            $price = $_POST['price']; 
            $category_id = $_POST['category_id']; 
 
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = $_POST['existing_image']; 
            } 
 
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image); 
 
            if ($edit) { 
                header('Location: /webbanhang/Product'); 
            } else { 
                echo "Đã xảy ra lỗi khi lưu sản phẩm."; 
            } 
        } 
    } 
    //====================================================
    public function delete($id) 
    { 
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        } 
        if ($this->productModel->deleteProduct($id)) {
              header('Location: /webbanhang/Product'); 
        } else { 
            echo "Đã xảy ra lỗi khi xóa sản phẩm."; 
        } 
    } 
    //====================================================
    private function uploadImage($file) 
    { 
        $target_dir = "uploads/"; 
         
        // Kiểm tra và tạo thư mục nếu chưa tồn tại 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        } 
     
        $target_file = $target_dir . basename($file["name"]); 
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 
     
        // Kiểm tra xem file có phải là hình ảnh không 
        $check = getimagesize($file["tmp_name"]); 
        if ($check === false) { 
            throw new Exception("File không phải là hình ảnh."); 
        } 
     
         // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes) 
        if ($file["size"] > 10 * 1024 * 1024) { 
        throw new Exception("Hình ảnh có kích thước quá lớn."); 
        } 
     
        // Chỉ cho phép một số định dạng hình ảnh nhất định 
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { 
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        } 
     
        // Lưu file 
        if (!move_uploaded_file($file["tmp_name"], $target_file)) { 
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh."); 
        } 
     
        return $target_file; 
    } 
    //====================================================
    public function addToCart($id) 
    { 
        $product = $this->productModel->getProductById($id); 
        if (!$product) {
             echo "Không tìm thấy sản phẩm."; 
            return; 
        } 
 
        if (!isset($_SESSION['cart'])) { 
            $_SESSION['cart'] = []; 
        } 
 
        if (isset($_SESSION['cart'][$id])) { 
            $_SESSION['cart'][$id]['quantity']++; 
        } else { 
            $_SESSION['cart'][$id] = [ 
                'name' => $product->name, 
                'price' => $product->price, 
                'quantity' => 1, 
                'image' => $product->image 
            ]; 
        } 
 
        header('Location: /webbanhang/Product/cart'); 
    } 
    //====================================================
    public function cart() 
    { 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; 
        include 'app/views/product/cart.php'; 
    } 
    //====================================================
    public function checkout() 
    { 
        include 'app/views/product/checkout.php'; 
    } 
    //====================================================
    public function processCheckout() 
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $name = $_POST['name']; 
        $phone = $_POST['phone']; 
        $address = $_POST['address']; 

        // Kiểm tra giỏ hàng 
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { 
            echo "Giỏ hàng trống."; 
            return; 
        } 

        // Bắt đầu giao dịch
        $this->db->beginTransaction(); 

        try { 
            // Lưu thông tin đơn hàng vào bảng orders 
            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)"; 
            $stmt = $this->db->prepare($query); 
            $stmt->bindParam(':name', $name); 
            $stmt->bindParam(':phone', $phone); 
            $stmt->bindParam(':address', $address); 
            $stmt->execute(); 
            $order_id = $this->db->lastInsertId(); 

            // Lưu chi tiết đơn hàng vào bảng order_details 
            $cart = $_SESSION['cart']; 
            foreach ($cart as $product_id => $item) { 
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)"; 
                $stmt = $this->db->prepare($query); 
                $stmt->bindParam(':order_id', $order_id); 
                $stmt->bindParam(':product_id', $product_id); 
                $stmt->bindParam(':quantity', $item['quantity']); 
                $stmt->bindParam(':price', $item['price']); 
                $stmt->execute(); 
            } 

            // Xóa giỏ hàng sau khi đặt hàng thành công 
            unset($_SESSION['cart']); 

            // Commit giao dịch 
            $this->db->commit(); 

            // Lưu thông tin đơn hàng mới nhất vào session
            $_SESSION['purchase_history'][] = [
                'order_id' => $order_id,
                'products' => $cart,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Chuyển hướng đến trang xác nhận đơn hàng 
            header('Location: /webbanhang/Product/orderConfirmation'); 
        } catch (Exception $e) { 
            // Rollback giao dịch nếu có lỗi 
            $this->db->rollBack(); 
            echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage(); 
        } 
    } 
}


    //====================================================
    public function orderConfirmation() 
    { 
        include 'app/views/product/orderConfirmation.php'; 
    } 
    // ----------------------//
    public function updateCartQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['cart'][$id])) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
                return;
            }

            $action = $_POST['action'] ?? '';

            if ($action === 'increase') {
                $_SESSION['cart'][$id]['quantity']++;
            } elseif ($action === 'decrease') {
                if ($_SESSION['cart'][$id]['quantity'] > 1) {
                    $_SESSION['cart'][$id]['quantity']--;
                } else {
                    unset($_SESSION['cart'][$id]); // Xóa sản phẩm nếu số lượng về 0
                }
            }

            // Tính tổng tiền sản phẩm đó
            $newQuantity = $_SESSION['cart'][$id]['quantity'] ?? 0;
            $totalPrice = $newQuantity * $_SESSION['cart'][$id]['price'];

            echo json_encode([
                'success' => true,
                'newQuantity' => $newQuantity,
                'totalPrice' => $totalPrice
            ]);
        }
    }
    // ----------------------//
public function purchaseHistory() 
{
    // Kiểm tra đăng nhập và quyền User
    if (!SessionHelper::isLoggedIn()) {
        header("Location: /webbanhang/account/login");
        exit();
    }

    // Kiểm tra nếu có lịch sử mua hàng trong session
    $purchaseHistory = $_SESSION['purchase_history'] ?? [];

    // Gọi view để hiển thị lịch sử mua hàng
    include_once 'app/views/product/purchaseHistory.php';
}


 //====================================================
    public function history() 
    {
        // Kiểm tra quyền Admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        // Truy vấn dữ liệu lịch sử mua hàng của tất cả khách hàng
        $query = "SELECT o.id AS order_id, o.name AS customer_name, o.phone, o.address, o.created_at AS order_date, 
                         od.product_id, p.name AS product_name, od.quantity, od.price AS unit_price,
                         (od.quantity * od.price) AS total_price
                  FROM orders o
                  LEFT JOIN order_details od ON o.id = od.order_id
                  LEFT JOIN product p ON od.product_id = p.id
                  ORDER BY o.created_at DESC";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }

        // Gọi view để hiển thị lịch sử mua hàng
        include_once 'app/views/product/adminPurchaseHistory.php';
    }
// ===============================================================
public function revenueStatistics()
{
    if (!$this->isAdmin()) {
        echo "Bạn không có quyền truy cập chức năng này!";
        exit;
    }

    try {
        // Doanh thu theo ngày
        $stmt = $this->db->prepare("
            SELECT DATE(o.created_at) AS label, 
                   SUM(od.quantity * od.price) AS revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            GROUP BY label
            ORDER BY label DESC
        ");
        $stmt->execute();
        $dailyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doanh thu theo tuần
        $stmt = $this->db->prepare("
            SELECT 
                CONCAT('Tuần ', WEEK(o.created_at, 1), '/', YEAR(o.created_at)) AS label,
                SUM(od.quantity * od.price) AS revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            GROUP BY label
            ORDER BY MAX(o.created_at) DESC
        ");
        $stmt->execute();
        $weeklyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doanh thu theo tháng
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(o.created_at, '%Y-%m') AS label,
                   SUM(od.quantity * od.price) AS revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            GROUP BY label
            ORDER BY label DESC
        ");
        $stmt->execute();
        $monthlyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doanh thu theo năm
        $stmt = $this->db->prepare("
            SELECT YEAR(o.created_at) AS label,
                   SUM(od.quantity * od.price) AS revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            GROUP BY label
            ORDER BY label DESC
        ");
        $stmt->execute();
        $yearlyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Lỗi truy vấn thống kê: " . $e->getMessage());
    }

    include_once 'app/views/product/revenueStatistics.php';
}


  
}
?>