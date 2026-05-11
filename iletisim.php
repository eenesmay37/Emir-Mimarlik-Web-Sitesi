<?php
// 1. Veritabanı bağlantısını çağırıyoruz
include 'baglan.php';

// 2. Eğer "mesaj_gonder" isimli butona basıldıysa çalışacak kodlar
if (isset($_POST['mesaj_gonder'])) {
    
    // Formdan gelen verileri alıyoruz
    $ad = $_POST['name'];
    $eposta = $_POST['email'];
    $mesaj = $_POST['message'];
    
    // NOKTA ATIŞI DÜZELTME: "ad_soyad" yerine senin tablondaki "isim" kelimesini yazdık
    $kaydet = mysqli_query($baglanti, "INSERT INTO mesajlar (isim, eposta, mesaj) VALUES ('$ad', '$eposta', '$mesaj')");
    
    // Başarılı olursa ekrana şık bir uyarı verip sayfayı yeniliyoruz
    if ($kaydet) {
        echo "<script>alert('Mesajınız başarıyla gönderildi! Sizinle en kısa sürede iletişime geçeceğiz.'); window.location.href='iletisim.php';</script>";
    } else {
        echo "<script>alert('Bir hata oluştu, lütfen tekrar deneyin.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Emir Mimarlık</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="contact-page-bg">

    <header class="luxury-header">
    <div class="logo">
        <a href="index.php"><img src="uploads/logo.png" alt="Emir Mimarlık Logo" class="site-logo"></a>
    </div>
    
    <div style="margin-left: auto; padding-right: 40px;">
        <a href="index.php" class="orijinal-altin-link">← PORTFOLYOYU DÖN</a>
    </div>
</header>

    <main class="contact-wrapper">
        <div class="contact-grid">
            
            <div class="contact-visual">
                <h4 class="mini-title">BİZE ULAŞIN</h4>
                <h1 class="main-heading">SİZİNLE TANIŞMAKTAN<br>MUTLULUK DUYARIZ.</h1>
                
                <div class="contact-details">
                    <div class="detail-item">
                        <span>ADRES</span>
                        <p>Levent Mahallesi, Mimarlar Sokak.<br>No: 10 Beşiktaş / İstanbul</p>
                    </div>
                    <div class="detail-item">
                        <span>TELEFON</span>
                        <p>+90 212 555 12 34</p>
                    </div>
                    <div class="detail-item">
                        <span>E-POSTA</span>
                        <p>info@emirmimarlik.com</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-side">
                <form action="#" method="POST" class="ghost-form">
                    <div class="input-group">
                        <input type="text" name="name" placeholder="ADINIZ SOYADINIZ" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="E-POSTA ADRESİNİZ" required>
                    </div>
                    <div class="input-group">
                        <textarea name="message" rows="5" placeholder="MESAJINIZ / PROJE DETAYLARI" required></textarea>
                    </div>
                   <button type="submit" name="mesaj_gonder" class="send-btn">GÖNDER</button>
                </form>
            </div>

        </div>
    </main>

    <section class="full-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3015.0964972403917!2d29.202610611624582!3d40.913630025128036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cac4eb2dfb4103%3A0x866b0acfb67c8242!2sOrta%2C%20Turgut%20Reis%20Sk.%20No%3A11%2C%2034880%20Kartal%2F%C4%B0stanbul!5e0!3m2!1str!2str!4v1778419174313!5m2!1str!2str" width="100%" height="450" class="interactive-map" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
<footer class="premium-footer">
    <div class="premium-footer-container">
        
        <div class="footer-brand">
            <img src="uploads/logo.png" alt="Emir Mimarlık Logo" class="footer-logo">
            <div class="social-icons">
                <a href="#">Instagram</a> | <a href="#">LinkedIn</a>
            </div>
            <p class="copyright-text">© 2026 Emir Mimarlık.<br>Tüm hakları saklıdır.</p>
        </div>

        <div class="footer-info">
            <div class="info-item">
                <p>Levent Mahallesi, Mimarlar Sokak.<br>No: 10 Avrupa Yakası<br>Beşiktaş / İstanbul</p>
            </div>
            <div class="info-item">
                <p>Telefon<br>+90 212 555 12 34</p>
            </div>
            <div class="info-item">
                <p>E-posta<br>info@emirmimarlik.com</p>
            </div>
        </div>

        <div class="footer-menu">
            <h4>Menü</h4>
            <ul>
                <li><a href="index.php#projeler">Projelerimiz</a></li>
                <li><a href="index.php#hakkimda">Hakkımızda</a></li>
                <li><a href="iletisim.php">İletişim</a></li>
            </ul>
        </div>
        
    </div>
</footer>
</body>
</html>