<?php
session_start();

if(isset($_SESSION['giris_izni'])) {
    header("Location: admin.php");
    exit;
}

$hata = "";
if(isset($_POST['giris'])) {
    $kullanici = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    if($kullanici == "mimar" && $sifre == "123456") {
        $_SESSION['giris_izni'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Girişi</title>
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-kutu { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 350px; text-align: center; }
        input { width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; outline: none; }
        button { width: 100%; padding: 15px; background: #111; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; letter-spacing: 2px; margin-top: 15px; transition: 0.3s; }
        button:hover { background: #d4af37; color: #111; }
        .hata { color: #dc3545; font-size: 14px; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-kutu">
        <h2 style="margin-top: 0; color: #111; letter-spacing: 2px;">MİMAR.<br><span style="font-size: 14px; color: #888;">YÖNETİM PANELİ</span></h2>
        
        <?php if($hata != "") echo "<div class='hata'>$hata</div>"; ?>
        
        <form action="login.php" method="POST">
            <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit" name="giris">GİRİŞ YAP</button>
        </form>
    </div>
</body>
</html>