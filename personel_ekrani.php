<?php
session_start();

// Veritabanı bağlantısı
$host = "localhost";
$dbname = "demo";
$username = "root"; // MySQL kullanıcı adı
$password = ""; // MySQL şifresi

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Çıkış yapma işlemi
if (isset($_POST['logout'])) {
    // Çıkış yapıldığında giris_yapildi'yi 0 yap
    $sql = "UPDATE calisanlar SET giris_yapildi = 0 WHERE giris_yapildi = 1 LIMIT 1";
    if (mysqli_query($conn, $sql)) {
        // Oturumdan çıkış yap ve acilis.php'ye yönlendir
        session_destroy();
        header("Location: acilis.php");
        exit();
    } else {
        echo "Hata oluştu: " . mysqli_error($conn);
    }
}

// Giriş yapan kişinin bilgilerini almak
$sql = "SELECT * FROM calisanlar WHERE giris_yapildi = 1 LIMIT 1"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Sorgu hatası: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personel Ekranı</title>
    <style>
        /* Genel Stil */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            text-align: center;
            background-color: transparent;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 95%;
            max-width: 1200px;
        }

        header h1 {
            color: #333;
            font-size: 48px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .buttons, .bottom-buttons {
            margin-top: 30px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            padding: 30px 60px;
            font-size: 24px;
            margin: 30px 15px;
            border-radius: 12px;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .izin-al {
            background-color: #d9534f;
        }

        .avans-iste {
            background-color: #5bc0de;
        }

        .iletisim {
            background-color: #5bc0de;
        }

        .mesailerim {
            background-color: #f0ad4e;
        }

        .mesajlarim {
            background-color: #0275d8;
        }

        .taleblerim {
            background-color: #5bc0de;
        }

        .button:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .bottom-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: space-evenly;
            width: 100%;
        }

        /* Çıkış Butonu */
        .logout-button {
            position: absolute;
            top: 10px;
            right: 20px;
            padding: 15px 30px;
            font-size: 24px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s, transform 0.2s;
        }

        .logout-button:hover {
            background-color: #c9302c;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- Çıkış Butonu -->
    <form action="personel_ekrani.php" method="POST">
        <button type="submit" name="logout" class="logout-button">Çıkış Yap</button>
    </form>

    <div class="container">
        <header>
            <h1>Hoşgeldiniz, <?php echo $user['ad']; ?>!</h1>
        </header>

        <div class="buttons">
            <a href="izin_al.php" class="button izin-al">İzin Al</a>
            <a href="avans_iste.php" class="button avans-iste">Avans İste</a>
            <a href="iletisim.php" class="button iletisim">İletişim</a>
            <a href="mesailerim.php" class="button mesailerim">Mesailerim</a>
        </div>

        <div class="bottom-buttons">
            <a href="mesajlarim.php" class="button mesajlarim">Mesajlarım</a>
            <a href="taleblerim.php" class="button taleblerim">Taleblerim</a>
        </div>
    </div>
</body>
</html>
