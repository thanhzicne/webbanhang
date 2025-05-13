<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryController
{
    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }
    public function createCategory($name)
    {
        $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        
        return $this->db->lastInsertId(); // Trả về ID của danh mục mới
    }

}
?>