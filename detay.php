<?php
// Depomuza bağlanıyoruz
include 'baglan.php';

// Eğer linkte bir ID yoksa (biri sayfaya yanlışlıkla girdiyse) ana sayfaya postala
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$sorgu = mysqli_query($baglanti, "SELECT * FROM projeler WHERE id=$id");
$proje = mysqli_fetch_assoc($sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $proje['baslik']; ?> - Mimar.</title>
    <!-- Aynı şık tasarımı burada da kullanıyoruz -->
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fff;">

    <!-- Üst Kısım: Sade bir Geri Dönüş Menüsü -->
    <header style="position: relative; padding: 40px 60px; background: #fff; z-index: 10;">
        <div class="logo" style="color: #111;">Mimar.</div>
        <nav>
            <ul>
                <li><a href="index.php" style="color: #111; font-weight: 700; border-bottom: 2px solid #d4af37; padding-bottom: 5px;">&larr; PORTFOLYOYU DÖN</a></li>
            </ul>
        </nav>
    </header>

    <!-- Proje Sunum Alanı -->
    <section style="max-width: 1400px; margin: 0 auto; padding: 50px;">
        
        <!-- Dev Başlık -->
        <h1 style="font-size: 5vw; font-weight: 300; margin-bottom: 10px; color: #111; line-height: 1.1; letter-spacing: -2px;">
            <?php echo $proje['baslik']; ?>
        </h1>
        <p style="color: #999; font-size: 14px; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 60px;">
            <?php echo $proje['konum_yil']; ?>
        </p>
        
        <!-- Devasa Tam Ekran Fotoğraf -->
        <img src="<?php echo $proje['resim_yolu']; ?>" style="width: 100%; max-height: 80vh; object-fit: cover; margin-bottom: 80px;">
        
       <!-- Hikaye / Açıklama Alanı -->
        <div style="max-width: 800px; margin: 0 auto; color: #555; font-size: 20px; line-height: 1.8; font-weight: 300;">
            <p>
                <?php 
                // Eğer açıklama boşsa varsayılan metin gösterelim
                if(!empty($proje['aciklama'])) {
                    echo nl2br($proje['aciklama']); // nl2br: Admin panelindeki satır atlamalarını (enter) HTML'e yansıtır
                } else {
                    echo "Bu proje için henüz bir açıklama girilmemiştir.";
                }
                ?>
            </p>
        </div>

    </section>

</body>
</html>