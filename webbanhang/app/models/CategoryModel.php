<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category"; // Chắc chắn rằng tên bảng đúng

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //====================================================
    public function getAllCategories() {
        $query = "SELECT * FROM " . $this->table_name; // Sử dụng $this->table_name
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ); // ✅ Đúng, trả về object
    }
    //====================================================
    // Lấy danh sách danh mục, sắp xếp theo tên
    public function getCategories()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //====================================================
    // Thêm danh mục mới nếu chưa có
    public function addCategory($name, $description = '')
    {
        // Kiểm tra xem danh mục đã tồn tại chưa
        $query = "SELECT id FROM " . $this->table_name . " WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$name]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return ['error' => 'Danh mục đã tồn tại', 'id' => $category['id']];
        }

        // Nếu chưa có, thêm mới
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$name, $description])) {
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        }
        
        return ['error' => 'Không thể thêm danh mục'];
    }
    //====================================================
    public function createCategory($categoryName) {
        // Kiểm tra nếu categoryName rỗng
        if (empty($categoryName)) {
            return ['error' => 'Tên danh mục không được để trống'];
        }

        // Kiểm tra xem danh mục đã tồn tại chưa
        $query = "SELECT id FROM " . $this->table_name . " WHERE name = :name"; // Sửa tên bảng thành $this->table_name
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        $existingCategory = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingCategory) {
            return $existingCategory['id']; // Nếu danh mục đã tồn tại, trả về ID của nó
        }

        // Nếu danh mục chưa tồn tại, thêm mới
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $categoryName);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Trả về ID của danh mục mới
        }

        return ['error' => 'Không thể thêm danh mục'];
    }
}
?>
