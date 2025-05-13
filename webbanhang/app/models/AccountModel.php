<?php 
class AccountModel 
{ 
    private $conn; 
    private $table_name = "users"; 

    public function __construct($db) 
    { 
        $this->conn = $db; 
    } 

    // ========================================  
    // Lấy thông tin tài khoản theo username
    public function getAccountByUsername($username) 
    { 
        $query = "SELECT * FROM users WHERE username = :username"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
        $stmt->execute(); 
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }
    
    // Lấy thông tin tài khoản theo email
    public function getAccountByEmail($email) 
    { 
        $query = "SELECT * FROM users WHERE email = :email"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
        $stmt->execute(); 
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }

    // ========================================  
    // Đăng ký tài khoản mới
    public function save($username, $fullname, $email, $password, $role = "user") 
    {  
        $query = "INSERT INTO users (username, fullname, email, password, role)  
                  VALUES (:username, :fullname, :email, :password, :role)";  

        $stmt = $this->conn->prepare($query);  

        $stmt->bindParam(':username', $username);  
        $stmt->bindParam(':fullname', $fullname);  
        $stmt->bindParam(':email', $email);  
        $stmt->bindParam(':password', $password);  
        $stmt->bindParam(':role', $role);  

        return $stmt->execute();  
    }

    // ========================================  
    // Cập nhật mật khẩu theo email
    public function updatePassword($email, $newPassword) 
    {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $newPassword);
        return $stmt->execute();
    }

    // ========================================  
    // Lưu mã reset password vào bảng password_resets
  // Lưu mã reset vào DB (KHÔNG mã hóa)
public function saveResetCode($email, $resetCode) {
    $query = "INSERT INTO password_resets (email, reset_code, expired_at) 
              VALUES (:email, :reset_code, DATE_ADD(NOW(), INTERVAL 10 MINUTE))";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':reset_code', $resetCode); // Không mã hóa mã reset

    return $stmt->execute();
}


// Lấy mã reset từ DB và so sánh trực tiếp
// Chỉ cần email để kiểm tra mã có tồn tại không
public function getResetCode($email) 
{
    $query = "SELECT * FROM password_resets 
              WHERE email = :email AND expired_at > NOW() LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Xóa mã reset password sau khi sử dụng
public function deleteResetCode($email) 
{
    $query = "DELETE FROM password_resets WHERE email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
    return $stmt->execute();
}

} 
?>
