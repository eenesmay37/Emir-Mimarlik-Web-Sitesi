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
            <li><a href="#iletisim">İLETİŞİM</a></li>
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

    <section id="projeler" class="projects">
        <h2>Öne Çıkan Projeler</h2>
        <div class="project-grid">
            
            <?php
            $sorgu = "SELECT * FROM projeler ORDER BY id DESC";
            $sonuc = mysqli_query($baglanti, $sorgu);

            if (mysqli_num_rows($sonuc) == 0) {
                echo "<p style='text-align:center; width:100%; color:#888;'>Henüz hiç proje eklenmemiş.</p>";
            } else {
                while($satir = mysqli_fetch_assoc($sonuc)) {
                    // Tıklanabilir Link Başlangıcı (Projeye ait ID'yi detay.php'ye gönderiyoruz)
                    echo '<a href="detay.php?id=' . $satir['id'] . '" style="text-decoration: none; color: inherit;">';
                    echo '<div class="project-card">';
                    
                    // Resim Alanı
                    echo '<div class="img-container">';
                    echo '<img src="' . $satir['resim_yolu'] . '" alt="Proje" loading="lazy">';
                    echo '</div>';
                    
                    // Bilgi Alanı
                    echo '<div class="project-info">';
                    echo '<h3>' . $satir['baslik'] . '</h3>';
                    echo '<p>' . $satir['konum_yil'] . '</p>';
                    echo '</div>';
                    
                    echo '</div>';
                    echo '</a>'; // Link Bitişi
                }
            }
            ?>

        </div>
    </section>
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

    <!-- İLETİŞİM BÖLÜMÜ (Ultra Minimal) -->
    <section id="iletisim" class="contact-minimal">
        <div class="contact-container">
            <h2>İletişim.</h2>
            <?php if($mesaj_bildirim != "") echo "<p style='color: #28a745; font-weight: bold; margin-bottom: 20px;'>$mesaj_bildirim</p>"; ?>
            
            <form action="index.php#iletisim" method="POST">
                <input type="text" name="isim" placeholder="ADINIZ SOYADINIZ" required>
                <input type="email" name="eposta" placeholder="E-POSTA ADRESİNİZ" required>
                <textarea name="mesaj" placeholder="PROJENİZDEN BAHSEDİN..." rows="1" required></textarea>
                <button type="submit" name="mesaj_gonder">GÖNDER</button>
            </form>
        </div>
    </section>

    <!-- ALT BİLGİ -->
    <footer>
        <p>&copy; 2026 Mimar Tasarım Stüdyosu. Tüm hakları saklıdır.</p>
    </footer>

</body>
</html>