<?php
include 'baglan.php';

$mesaj_bildirim = "";
if(isset($_POST['mesaj_gonder'])) {
    $isim = mysqli_real_escape_string($baglanti, $_POST['isim']);
    $eposta = mysqli_real_escape_string($baglanti, $_POST['eposta']);
    $mesaj = mysqli_real_escape_string($baglanti, $_POST['mesaj']);

    $ekle = mysqli_query($baglanti, "INSERT INTO mesajlar (isim, eposta, mesaj) VALUES ('$isim', '$eposta', '$mesaj')");
    if($ekle) {
        $mesaj_bildirim = "Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.";
    }
}
?>

<?php
// Depomuza bağlanıyoruz
include 'baglan.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimarlık Portfolyosu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
    <div class="logo">
        <a href="#anasayfa">
            <img src="uploads/logo.png" alt="Emir Mimarlık Logo" class="site-logo">
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="#anasayfa">ANA SAYFA</a></li>
            <li><a href="#projeler">PROJELER</a></li>
            <li><a href="#hakkimda">HAKKIMDA</a></li>
            <li><a href="iletisim.php">İLETİŞİM</a></li>
        </ul>
    </nav>
</header>

    <section id="anasayfa" class="hero">
        <div class="hero-overlay">
            <h1>Mekanlara Ruh Katıyoruz</h1>    
            <p>Modern, sürdürülebilir ve estetik mimari çözümler.</p>
            <a href="#projeler" class="btn">Projeleri Keşfet</a>
        </div>
    </section>

    <section id="projeler" class="premium-projects-section">
    <div class="section-title-container">
        
        <ul class="project-filters">
            <li class="active" data-filter="all">TÜMÜ</li>
            <li data-filter="mimari">MİMARİ</li>
            <li data-filter="peyzaj">PEYZAJ</li>
            <li data-filter="ic-mekan">İÇ MEKAN</li>
        </ul>
    </div>

    <div class="projects-grid">
        
        <a href="detay.php?id=7" class="project-card" data-category="mimari">
            <div class="card-img-wrapper">
                <img src="https://picsum.photos/800/600?random=20" alt="Rami Kütüphanesi">
                <div class="card-overlay">
                    <div class="card-text">
                        <h3>Rami Kütüphanesi</h3>
                        <span>MİMARİ / 2022</span>
                    </div>
                </div>
            </div>
        </a>

        <a href="detay.php?id=8" class="project-card" data-category="peyzaj">
            <div class="card-img-wrapper">
                <img src="https://picsum.photos/800/600?random=21" alt="Seddülbahir Kalesi">
                <div class="card-overlay">
                    <div class="card-text">
                        <h3>Seddülbahir Kalesi</h3>
                        <span>PEYZAJ / 2023</span>
                    </div>
                </div>
            </div>
        </a>

        <a href="detay.php?id=9" class="project-card" data-category="ic-mekan">
            <div class="card-img-wrapper">
                <img src="https://picsum.photos/800/600?random=22" alt="Dereköy Villa Projesi">
                <div class="card-overlay">
                    <div class="card-text">
                        <h3>Dereköy Villa Projesi</h3>
                        <span>İÇ MEKAN / 2024</span>
                    </div>
                </div>
            </div>
        </a>

        <a href="detay.php?id=10" class="project-card" data-category="mimari">
            <div class="card-img-wrapper">
                <img src="https://picsum.photos/800/600?random=23" alt="TC Ulusal Arşiv Binası">
                <div class="card-overlay">
                    <div class="card-text">
                        <h3>TC Ulusal Arşiv Binası</h3>
                        <span>MİMARİ / 2021</span>
                    </div>
                </div>
            </div>
        </a>

         <a href="detay.php?id=11" class="project-card" data-category="mimari">
            <div class="card-img-wrapper">
                <img src="https://picsum.photos/800/600?random=23" alt="TC Ulusal Arşiv Binası">
                <div class="card-overlay">
                    <div class="card-text">
                        <h3>TC Ulusal Arşiv Binası</h3>
                        <span>MİMARİ / 2021</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>

<script>
    const filters = document.querySelectorAll('.project-filters li');
    const cards = document.querySelectorAll('.project-card');

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Aktif olan sekmenin alt çizgisini değiştir
            filters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');

            const target = this.getAttribute('data-filter');

            // Sadece seçilen kategoriye ait projeleri göster
            cards.forEach(card => {
                if (target === 'all' || card.getAttribute('data-category') === target) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
<!-- HAKKIMDA BÖLÜMÜ (Ultra Minimal) -->
    <section id="hakkimda" class="about-minimal">
        <div class="about-grid">
            <div class="about-text">
                <h2>Vizyon.</h2>
                <p>
                    <?php
                    // Ayarlar tablosundan vizyon yazısını çekiyoruz
                    $ayar_sorgu = mysqli_query($baglanti, "SELECT * FROM ayarlar WHERE id=1");
                    $ayar = mysqli_fetch_assoc($ayar_sorgu);
                    echo nl2br($ayar['vizyon']);
                    ?>
                </p>
                <span class="signature">Mimar Emir</span>
            </div>
            <div class="about-img">
                <img src="profil.jpg" alt="Mimar Emir">
            </div>
        </div>
    </section>

  <section class="premium-cta">
    <h2 class="cta-title">Hayalinizdeki Projeyi Beraber İnşa Edelim.</h2>
    <p class="cta-text">Sizinle tanışmaktan mutluluk duyarız. Fikirlerinizi gerçeğe dönüştürmek ve detayları konuşmak için bizimle iletişime geçin.</p>
    <a href="iletisim.php" class="premium-btn">BİZE ULAŞIN</a>
</section>

    <!-- ALT BİLGİ -->
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
                <li><a href="#projeler">Projelerimiz</a></li>
                <li><a href="#hakkimda">Hakkımızda</a></li>
                <li><a href="iletisim.php">İletişim</a></li> </ul>
        </div>
        
    </div>
</footer>

</body>
</html>