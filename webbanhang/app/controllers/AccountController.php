<?php 
require_once('app/config/database.php'); 
require_once('app/models/AccountModel.php');

class AccountController { 
    private $accountModel; 
    private $db; 

    public function __construct() { 
        $this->db = (new Database())->getConnection(); 
        $this->accountModel = new AccountModel($this->db); 
    } 

    // ========================================  
    function register(){ 
        include_once 'app/views/account/register.php'; 
    }

    // ========================================  
    public function login() { 
        include_once 'app/views/account/login.php'; 
    } 

    // ========================================  
    function save(){  
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
            $username = $_POST['username'] ?? '';  
            $fullName = $_POST['fullname'] ?? '';  
            $email = $_POST['email'] ?? '';  
            $password = $_POST['password'] ?? '';  
            $confirmPassword = $_POST['confirmpassword'] ?? '';  

            $errors = [];  

            if(empty($username)){  
                $errors['username'] = "Vui lòng nhập Username!";  
            }  
            if(empty($fullName)){  
                $errors['fullname'] = "Vui lòng nhập Họ và tên!";  
            }  
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){  
                $errors['email'] = "Vui lòng nhập Email hợp lệ!";  
            }  
            if(empty($password) || strlen($password) < 8){  
                $errors['password'] = "Mật khẩu phải từ 8 ký tự trở lên!";  
            }  
            if($password != $confirmPassword){  
                $errors['confirmPass'] = "Mật khẩu và xác nhận không khớp!";  
            }  

            $account = $this->accountModel->getAccountByUsername($username);  
            if($account){  
                $errors['account'] = "Tài khoản này đã có người đăng ký!";  
            }  

            if(count($errors) > 0){  
                include_once 'app/views/account/register.php';  
            } else {  
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);  
                $result = $this->accountModel->save($username, $fullName, $email, $hashedPassword);  

                if($result){  
                    header('Location: /webbanhang/account/login');  
                }  
            }  
        }  
    }

    // ========================================  
    function logout(){ 
        session_start();
        session_destroy();
        header('Location: /webbanhang/product'); 
        exit;
    } 

    // ========================================  
    public function checkLogin(){ 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $username = $_POST['username'] ?? ''; 
            $password = $_POST['password'] ?? ''; 

            $account = $this->accountModel->getAccountByUsername($username); 
            if ($account) { 
                $pwd_hashed = $account->password; 
                if (password_verify($password, $pwd_hashed)) { 
                    session_start(); 
                    $_SESSION['username'] = $account->username; 
                    $_SESSION['role'] = $account->role; 
                    header('Location: /webbanhang/product'); 
                    exit; 
                } else { 
                    echo "Mật khẩu không đúng."; 
                } 
            } else { 
                echo "Không tìm thấy tài khoản."; 
            } 
        } 
    } 

    // ============================ Quên mật khẩu
    public function forgotPassword() {
        include_once 'app/views/account/forgot_password.php';
    }

    // ========================== Gửi mã reset qua email
    function sendResetCode() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Nếu email hợp lệ, chúng tôi sẽ gửi mã reset.";
                return;
            }

            $account = $this->accountModel->getAccountByEmail($email);
            if (!$account) {
                echo "Nếu email hợp lệ, chúng tôi sẽ gửi mã reset.";
                return;
            }

            // Xóa mã cũ nếu có
            $this->accountModel->deleteResetCode($email);

            // Tạo mã reset mới (6 chữ số)
            $resetCode = rand(100000, 999999);

            // Lưu mã vào database
            $this->accountModel->saveResetCode($email, $resetCode);

            // Lưu email vào session để kiểm tra sau này
            session_start();
            $_SESSION['reset_email'] = $email;

            echo "Mã xác nhận mới đã được tạo và lưu vào database.";

            // Chuyển hướng đến trang nhập mã xác nhận
            header('Location: /webbanhang/account/resetPasswordForm');
            exit;
        }
    }

    // ========================== Gửi lại mã
    function resendResetCode() {
        // session_start();
        if (!isset($_SESSION['reset_email'])) {
            echo "Không tìm thấy yêu cầu đặt lại mật khẩu!";
            return;
        }

        $email = $_SESSION['reset_email'];

        // Xóa mã cũ và tạo mã mới
        $this->accountModel->deleteResetCode($email);
        $resetCode = rand(100000, 999999);
        $this->accountModel->saveResetCode($email, $resetCode);

        // Chuyển hướng về trang đặt lại mật khẩu
        $_SESSION['message'] = "Mã xác nhận mới đã được gửi lại!";
        header("Location: /webbanhang/account/resetPasswordForm");
        exit();
    }


    // Hiển thị form nhập mã xác nhận
    public function resetPasswordForm() {
        include_once 'app/views/account/reset_password.php';
    }

    // Xử lý đặt lại mật khẩu
    function resetPassword(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $code = $_POST['code'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if (!isset($_SESSION['reset_email'])) {
                echo "Không có yêu cầu đặt lại mật khẩu!";
                return;
            }

            $email = $_SESSION['reset_email'];

            // Lấy mã reset từ DB
            $resetData = $this->accountModel->getResetCode($email, $code);
            if (!$resetData) {
                echo "Mã xác nhận không đúng hoặc đã hết hạn!";
                return;
            }

            if (strlen($newPassword) < 8) {
                echo "Mật khẩu mới phải từ 8 ký tự trở lên!";
                return;
            }

            if ($newPassword !== $confirmPassword) {
                echo "Mật khẩu xác nhận không khớp!";
                return;
            }

            // Cập nhật mật khẩu mới
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $this->accountModel->updatePassword($email, $hashedPassword);

            // Xóa mã reset khỏi database
            $this->accountModel->deleteResetCode($email);

            // Xóa session reset
            unset($_SESSION['reset_email']);

            header('Location: /webbanhang/account/login');
            exit;
        }
    }
}
?>
