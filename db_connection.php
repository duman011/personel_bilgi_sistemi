<?php

// MySQL bağlantı ayarları
$host = "localhost";
$dbname = "demo";
$username = "root"; // MySQL kullanıcı adı
$password = ""; // MySQL şifreniz (genelde localhost için boş)

// Bağlantıyı oluştur
$conn = new mysqli($host, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>