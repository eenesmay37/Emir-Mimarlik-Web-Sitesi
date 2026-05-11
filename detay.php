<?php
// Senin veritabanına bağlantı (Bu kısım zaten var)
$db = new PDO("mysql:host=localhost;dbname=mimar_db;charset=utf8", "root", "");
$proje_id = $_GET['id'];

// 1. Mevcut projeyi çek (Bu da var)
$sorgu = $db->prepare("SELECT * FROM projeler WHERE id = ?");
$sorgu->execute([$proje_id]);
$proje = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$proje) {
    header("Location: index.php");
    exit;
}

// ==== YENİ EKLENECEK KISIM BURASI ====

// 2. ÖNCEKİ PROJEYİ BUL (Mevcut ID'den küçük olan İLK projeyi getirir)
$sorgu_onceki = $db->prepare("SELECT * FROM projeler WHERE id < ? ORDER BY id DESC LIMIT 1");
$sorgu_onceki->execute([$proje_id]);
$onceki_proje = $sorgu_onceki->fetch(PDO::FETCH_ASSOC);

// 3. SONRAKİ PROJEYİ BUL (Mevcut ID'den büyük olan İLK projeyi getirir)
$sorgu_sonraki = $db->prepare("SELECT * FROM projeler WHERE id > ? ORDER BY id ASC LIMIT 1");
$sorgu_sonraki->execute([$proje_id]);
$sonraki_proje = $sorgu_sonraki->fetch(PDO::FETCH_ASSOC);

// ==== YENİ EKLENECEK KISIM BİTTİ ====
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proje Detay - Emir Mimarlık</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <section class="project-hero" style="background-image: url('<?php echo $proje['resim_yolu']; ?>');">
    <div class="hero-overlay"></div>

    <div class="hero-top">
        <a href="index.php" class="hero-back-btn">← Back</a>
    </div>

    <div class="hero-center-content">
        <h1 class="project-main-title"><?php echo $proje['baslik']; ?></h1>

        <div class="project-meta-grid">
            <div class="meta-item">
                <span class="meta-label">KONUM / YIL:</span>
                <span class="meta-val"><?php echo $proje['konum_yil']; ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">AÇIKLAMA:</span>
                <span class="meta-val"><?php echo $proje['aciklama']; ?></span>
            </div>
        </div>
    </div>
</section>
<section class="project-gallery-section">
        <div class="gallery-grid">
            <img src="https://picsum.photos/800/800?random=1" class="gallery-img large" alt="Galeri 1">
            <img src="https://picsum.photos/800/400?random=2" class="gallery-img wide" alt="Galeri 2">
            <img src="https://picsum.photos/400/400?random=3" class="gallery-img" alt="Galeri 3">
            <img src="https://picsum.photos/400/400?random=4" class="gallery-img" alt="Galeri 4">
            <img src="https://picsum.photos/1600/600?random=5" class="gallery-img full-width" alt="Galeri 5">
            <img src="https://picsum.photos/400/400?random=6" class="gallery-img" alt="Galeri 6">
            <img src="https://picsum.photos/400/800?random=7" class="gallery-img tall" alt="Galeri 7">
            <img src="https://picsum.photos/800/800?random=8" class="gallery-img large" alt="Galeri 8">
            <img src="https://picsum.photos/800/400?random=9" class="gallery-img wide" alt="Galeri 9">
            <img src="https://picsum.photos/400/400?random=10" class="gallery-img" alt="Galeri 10">
        </div>
    </section>


    <div class="project-navigation has-thumbs">
        
        <?php if($onceki_proje): ?>
            <a href="detay.php?id=<?php echo $onceki_proje['id']; ?>" class="nav-item prev-project">
                <img src="<?php echo $sonraki_proje['resim_yolu']; ?>" alt="Sonraki" class="nav-thumb">
                <div class="nav-text">
                    <span class="nav-label">ÖNCEKİ PROJE</span>
                    <span class="nav-title"><?php echo $onceki_proje['baslik']; ?></span>
                </div>
            </a>
        <?php else: ?>
            <div class="nav-item prev-project" style="visibility: hidden;"></div>
        <?php endif; ?>


        <a href="index.php#projeler" class="nav-center-grid" title="Tüm Projelere Dön">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M4 4h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 10h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4zM4 16h4v4H4zm6 0h4v4h-4zm6 0h4v4h-4z"/>
            </svg>
        </a>


        <?php if($sonraki_proje): ?>
            <a href="detay.php?id=<?php echo $sonraki_proje['id']; ?>" class="nav-item next-project">
                <div class="nav-text">
                    <span class="nav-label">SONRAKİ PROJE</span>
                    <span class="nav-title"><?php echo $sonraki_proje['baslik']; ?></span>
                </div>
                <img src="<?php echo $sonraki_proje['resim_yolu']; ?>" alt="Sonraki" class="nav-thumb">
            </a>
        <?php else: ?>
            <div class="nav-item next-project" style="visibility: hidden;"></div>
        <?php endif; ?>

    </div>


    <footer class="premium-footer">
        <div class="premium-footer-container">
            <div class="footer-brand">
                <img src="uploads/logo.png" alt="Emir Mimarlık Logo" class="footer-logo">
                <div class="social-icons"><a href="#">Instagram</a> | <a href="#">LinkedIn</a></div>
                <p class="copyright-text">© 2026 Emir Mimarlık.<br>Tüm hakları saklıdır.</p>
            </div>
            <div class="footer-info">
                <div class="info-item"><p>Levent Mahallesi, Mimarlar Sokak.<br>No: 10 Avrupa Yakası<br>Beşiktaş / İstanbul</p></div>
                <div class="info-item"><p>Telefon<br>+90 212 555 12 34</p></div>
                <div class="info-item"><p>E-posta<br>info@emirmimarlik.com</p></div>
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
<div id="lightbox" class="lightbox">
        <span class="close-lightbox">&times;</span>
        <img class="lightbox-content" id="lightbox-img">
    </div>

    <script>
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const galleryImages = document.querySelectorAll('.gallery-img');
        const closeBtn = document.querySelector('.close-lightbox');

        // Resimlere tıklandığında tam ekran aç
        galleryImages.forEach(img => {
            img.addEventListener('click', function() {
                lightbox.style.display = 'flex';
                lightboxImg.src = this.src; // Tıklanan resmin linkini al, büyüğe kopyala
            });
        });

        // Çarpı ikonuna basınca kapat
        closeBtn.addEventListener('click', () => {
            lightbox.style.display = 'none';
        });

        // Karanlık arka plana tıklayınca da kapat (kullanıcı deneyimi)
        lightbox.addEventListener('click', (e) => {
            if (e.target !== lightboxImg) {
                lightbox.style.display = 'none';
            }
        });
    </script>
</body>
</html>