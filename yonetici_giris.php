<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";  // MySQL kullanıcı adı (root ya da sizin kullanıcı adınız)
$password = "";      // MySQL şifresi (boş bırakılabilir veya uygun şifreyi girin)
$dbname = "demo";    // Veritabanı adı

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kullanıcı girişini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // SQL sorgusu ile kullanıcıyı kontrol et
    $sql = "SELECT * FROM adminler WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Eğer kullanıcı bulunduysa, yönlendir
    if ($result->num_rows > 0) {
        // Başarılı giriş, yonetici_ekrani.php'ye yönlendir
        header("Location: yonetici_ekrani.php");
        exit();
    } else {
        $error = "Yanlış kullanıcı adı veya şifre!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli Girişi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #2d3a51; /* Koyu arka plan */
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Daha belirgin gölge */
            width: 350px; /* Formu daha geniş yapalım */
            text-align: center;
            box-sizing: border-box;
        }
        h2 {
            color: #ffffff;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            padding: 12px;
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #3c4b60; /* Koyu gri mavi */
            color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #74ebd5; /* Odaklanıldığında daha soft bir mavi */
        }
        button {
            width: 48%;
            padding: 12px;
            background-color: #4e88b0; /* Koyu mavi */
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
            margin: 10px 1%;
        }
        button:hover {
            background-color: #6ba4d8; /* Hover efekti */
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Yönetici Girişi</h2>

        <!-- Giriş formu -->
        <form  method="post">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <div><button type="submit">Giriş Yap</button>
            <button  type="button" onclick="window.location.href='admin_ekle.php';">Admin Ekle</button></div>
        </form>

        <?php
        // Hata mesajı göster
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
    </div>
</body>
</html>
