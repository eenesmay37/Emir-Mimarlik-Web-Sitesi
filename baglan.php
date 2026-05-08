<?php
// 1. Gerekli anahtarları tanımlıyoruz
$sunucu = "localhost"; 
$kullanici = "root"; 
$sifre = ""; 
$veritabani = "mimar_db"; 

// 2. Köprüyü (Bağlantıyı) kuruyoruz
$baglanti = mysqli_connect($sunucu, $kullanici, $sifre, $veritabani);

// 3. Türkçe karakter sorunu yaşamamak için
mysqli_set_charset($baglanti, "UTF8");

// 4. Bağlantı başarılı mı diye kontrol ediyoruz
if (!$baglanti) {
    die("Eyvah, depoya bağlanamadık: " . mysqli_connect_error());
} else {
    
}
?>