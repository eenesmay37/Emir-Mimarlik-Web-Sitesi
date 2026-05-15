<?php
// ==========================================
// 1. VERİTABANI BAĞLANTILARI VE SORGULAR
// ==========================================

// Hakkımda bölümündeki vizyon yazısını çekmek için (Eski bağlantın)
include 'baglan.php';

// Projeleri çekmek için yeni PDO bağlantımız
try {
    $db = new PDO("mysql:host=localhost;dbname=mimar_db;charset=utf8", "root", "");
    
    // En güncel 10 projeyi çekiyoruz
    $projeler_sorgu = $db->query("SELECT * FROM projeler ORDER BY id DESC LIMIT 10");
    $projeler = $projeler_sorgu->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
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
    
    <div class="hero-slider">
        <div class="slide active" style="background-image: url('arkaplan.jpg');"></div>
        <div class="slide" style="background-image: url('arkaplan2.jpg');"></div>
        <div class="slide" style="background-image: url('arkaplan3.jpg');"></div>
    </div>

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
        <?php foreach($projeler as $p): ?>
        <a href="detay.php?id=<?php echo $p['id']; ?>" class="project-card" data-category="mimari">
            <div class="card-img-wrapper">
                
                <img src="<?php echo $p['resim_yolu']; ?>" alt="<?php echo $p['baslik']; ?>" loading="lazy">
                
                <div class="card-overlay">
                    <div class="card-text">
                        <h3><?php echo $p['baslik']; ?></h3>
                        <span><?php echo $p['konum_yil']; ?></span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<script>
    const filters = document.querySelectorAll('.project-filters li');
    const cards = document.querySelectorAll('.project-card');

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            filters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');

            const target = this.getAttribute('data-filter');

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

<section id="hakkimda" class="about-minimal">
    <div class="about-grid">
        <div class="about-text">
            <h2>Vizyon.</h2>
            <p>
                <?php
                // Ayarlar tablosundan vizyon yazısını çekiyoruz
                $ayar_sorgu = mysqli_query($baglanti, "SELECT * FROM ayarlar WHERE id=1");
                if($ayar_sorgu && mysqli_num_rows($ayar_sorgu) > 0) {
                    $ayar = mysqli_fetch_assoc($ayar_sorgu);
                    echo nl2br($ayar['vizyon']);
                } else {
                    echo "Vizyon metni yüklenemedi.";
                }
                ?>
            </p>
            <span class="signature">Mimar Emir</span>
        </div>
        <div class="about-img">
            <img src="profil.jpg" alt="Mimar Emir" loading="lazy">
        </div>
    </div>
</section>

<section class="premium-cta">
    <h2 class="cta-title">Hayalinizdeki Projeyi Beraber İnşa Edelim.</h2>
    <p class="cta-text">Sizinle tanışmaktan mutluluk duyarız. Fikirlerinizi gerçeğe dönüştürmek ve detayları konuşmak için bizimle iletişime geçin.</p>
    <a href="iletisim.php" class="premium-btn">BİZE ULAŞIN</a>
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
                <li><a href="#projeler">Projelerimiz</a></li>
                <li><a href="#hakkimda">Hakkımızda</a></li>
                <li><a href="iletisim.php">İletişim</a></li> 
            </ul>
        </div>
        
    </div>
</footer>

<script>
    setInterval(function() {
        const slides = document.querySelectorAll('.slide');
        if(slides.length === 0) return; // Slayt yoksa hata verme
        
        let activeIndex = 0;
        
        // Hangi resmin ekranda olduğunu bul
        slides.forEach((slide, index) => {
            if(slide.classList.contains('active')) {
                activeIndex = index;
                slide.classList.remove('active'); // Ekranda olanı gizle
            }
        });

        // Bir sonraki resme geç, eğer son resimdeyse başa dön
        let nextIndex = (activeIndex + 1) % slides.length;
        slides[nextIndex].classList.add('active'); // Yeni resmi göster
        
    }, 1500); // 3000 milisaniye = Tam 3 saniye
</script>

</body>
</html>