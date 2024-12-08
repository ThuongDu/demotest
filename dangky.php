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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Kiểm tra xem email đã tồn tại chưa
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Email đã tồn tại!";
    } else {
        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Tạo tài khoản thành công!";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<body>
    <h2>Đăng Ký Tài Khoản</h2>
    <form action="register.php" method="POST">
        <label for="username">Tên người dùng:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Đăng Ký">
    </form>
</body>
</html>
