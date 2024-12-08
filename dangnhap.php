<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay đổi với tên người dùng MySQL của bạn
$password = ""; // Thay đổi với mật khẩu MySQL của bạn
$dbname = "shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu người dùng đã gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Tìm người dùng theo email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // So sánh mật khẩu
        if (password_verify($password, $user['password'])) {
            echo "Đăng nhập thành công!";
        } else {
            echo "Mật khẩu không đúng!";
        }
    } else {
        echo "Tài khoản không tồn tại!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Đăng Nhập">
    </form>
</body>
</html>
