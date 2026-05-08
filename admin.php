<?php
session_start();
// Ziyaretçi kartı yoksa kov!
if(!isset($_SESSION['giris_izni'])) {
    header("Location: login.php");
    exit;
}

include 'baglan.php';

// --- A. VİZYON YAZISINI GÜNCELLEME İŞLEMİ ---
if(isset($_POST['vizyon_kaydet'])) {
    $yeni_vizyon = mysqli_real_escape_string($baglanti, $_POST['vizyon']);
    mysqli_query($baglanti, "UPDATE ayarlar SET vizyon='$yeni_vizyon' WHERE id=1");
    header("Location: admin.php");
}

$ayar_sorgu = mysqli_query($baglanti, "SELECT * FROM ayarlar WHERE id=1");
$ayar = mysqli_fetch_assoc($ayar_sorgu);

// --- B. PROJE DÜZENLEME İÇİN BİLGİLERİ GETİRME ---
$duzenle_id = ""; $duzenle_baslik = ""; $duzenle_konum = ""; $duzenle_aciklama = "";
if(isset($_GET['duzenleid'])) {
    $id = $_GET['duzenleid'];
    $sorgu = mysqli_query($baglanti, "SELECT * FROM projeler WHERE id=$id");
    $row = mysqli_fetch_assoc($sorgu);
    $duzenle_id = $row['id'];
    $duzenle_baslik = $row['baslik'];
    $duzenle_konum = $row['konum_yil'];
    $duzenle_aciklama = $row['aciklama'];
}

// --- C. PROJE SİLME İŞLEMİ ---
if(isset($_GET['silid'])) {
    $sil_id = $_GET['silid'];
    $resim_bul = mysqli_query($baglanti, "SELECT resim_yolu FROM projeler WHERE id=$sil_id");
    $resim_verisi = mysqli_fetch_assoc($resim_bul);
    if(file_exists($resim_verisi['resim_yolu'])) { unlink($resim_verisi['resim_yolu']); }
    mysqli_query($baglanti, "DELETE FROM projeler WHERE id=$sil_id");
    header("Location: admin.php");
}

// --- YENİ: MESAJ SİLME İŞLEMİ ---
if(isset($_GET['mesaj_silid'])) {
    $sil_id = $_GET['mesaj_silid'];
    mysqli_query($baglanti, "DELETE FROM mesajlar WHERE id=$sil_id");
    header("Location: admin.php");
}

// --- D. PROJE KAYDET VEYA GÜNCELLE İŞLEMİ (OTOMATİK SIKIŞTIRMA MOTORLU) ---
if(isset($_POST['islem_yap'])) {
    $baslik = $_POST['baslik'];
    $konum = $_POST['konum_yil'];
    $aciklama = mysqli_real_escape_string($baglanti, $_POST['aciklama']);
    $gelen_id = $_POST['proje_id'];
    $yol = "";

    if($_FILES['resim']['name'] != "") {
        $resim_adi = time() . "_" . $_FILES['resim']['name'];
        $gecici_yol = $_FILES['resim']['tmp_name'];
        $hedef_yol = "uploads/" . $resim_adi;
        $yol = $hedef_yol;

        $resim_bilgisi = getimagesize($gecici_yol);
        $mime = $resim_bilgisi['mime'];

        if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
            $kaynak_resim = imagecreatefromjpeg($gecici_yol);
            imagejpeg($kaynak_resim, $hedef_yol, 60); 
            imagedestroy($kaynak_resim); 
        } elseif ($mime == 'image/png') {
            $kaynak_resim = imagecreatefrompng($gecici_yol);
            imagepng($kaynak_resim, $hedef_yol, 8); 
            imagedestroy($kaynak_resim);
        } else {
            move_uploaded_file($gecici_yol, $hedef_yol); 
        }
    }

    if($gelen_id == "") { 
        mysqli_query($baglanti, "INSERT INTO projeler (baslik, konum_yil, aciklama, resim_yolu) VALUES ('$baslik', '$konum', '$aciklama', '$yol')");
    } else { 
        if($yol != "") { 
            mysqli_query($baglanti, "UPDATE projeler SET baslik='$baslik', konum_yil='$konum', aciklama='$aciklama', resim_yolu='$yol' WHERE id=$gelen_id");
        } else { 
            mysqli_query($baglanti, "UPDATE projeler SET baslik='$baslik', konum_yil='$konum', aciklama='$aciklama' WHERE id=$gelen_id");
        }
    }
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gelişmiş Yönetim Paneli</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 40px; }
        .kutu { background: #fff; padding: 30px; border-radius: 12px; max-width: 900px; margin: 0 auto 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h2 { margin-top: 0; color: #1a1a1a; border-bottom: 2px solid #eee; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        input, button, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background: #0056b3; }
        .btn-cikis { background: #dc3545; padding: 8px 15px; border-radius: 5px; color: white; text-decoration: none; font-size: 14px; }
        .btn-vazgec { background: #6c757d; display: block; text-align: center; color: white; text-decoration: none; padding: 10px; border-radius: 6px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .islem-linkleri a { margin-right: 15px; text-decoration: none; font-weight: bold; }
        .duzenle { color: #28a745; }
        .sil { color: #dc3545; }
    </style>
</head>
<body>

<div class="kutu" style="border-left: 5px solid #d4af37;">
    <h2>Site Ayarları <a href="cikis.php" class="btn-cikis">Güvenli Çıkış</a></h2>
    <form action="admin.php" method="POST">
        <label>Ana Sayfa Hakkımda (Vizyon) Yazısı:</label>
        <textarea name="vizyon" rows="4" required><?php echo $ayar['vizyon']; ?></textarea>
        <button type="submit" name="vizyon_kaydet" style="background: #111;">VİZYON YAZISINI GÜNCELLE</button>
    </form>
</div>

<!-- YENİ EKLENEN GELEN KUTUSU BÖLÜMÜ -->
<div class="kutu" style="border-left: 5px solid #17a2b8;">
    <h2>Gelen Mesajlar (İletişim Formu)</h2>
    <table style="font-size: 14px;">
        <thead>
            <tr>
                <th>Tarih</th>
                <th>İsim</th>
                <th>E-Posta</th>
                <th>Mesaj</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // En son atılan mesaj en üstte çıkacak şekilde (DESC) sıralıyoruz
            $mesaj_sorgu = mysqli_query($baglanti, "SELECT * FROM mesajlar ORDER BY id DESC");
            if(mysqli_num_rows($mesaj_sorgu) > 0) {
                while($mesaj = mysqli_fetch_assoc($mesaj_sorgu)) {
                    // Tarihi biraz daha şık gösterelim (Sadece gün-ay-yıl ve saat)
                    $tarih_formatli = date("d.m.Y H:i", strtotime($mesaj['tarih']));
                    
                    echo "<tr>";
                    echo "<td style='color:#666; font-size:13px;'>".$tarih_formatli."</td>";
                    echo "<td><strong>".$mesaj['isim']."</strong></td>";
                    echo "<td><a href='mailto:".$mesaj['eposta']."' style='color:#007bff; text-decoration:none;'>".$mesaj['eposta']."</a></td>";
                    echo "<td>".$mesaj['mesaj']."</td>";
                    echo "<td class='islem-linkleri'>
                            <a href='admin.php?mesaj_silid=".$mesaj['id']."' class='sil' onclick='return confirm(\"Bu mesajı silmek istediğine emin misin?\")'>SİL</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; color:#888; padding:20px;'>Henüz yeni mesaj yok.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="kutu">
    <h2><?php echo ($duzenle_id != "") ? "Projeyi Düzenle" : "Yeni Proje Ekle"; ?></h2>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="proje_id" value="<?php echo $duzenle_id; ?>">
        <label>Proje Başlığı:</label>
        <input type="text" name="baslik" value="<?php echo $duzenle_baslik; ?>" required>
        <label>Konum ve Yıl:</label>
        <input type="text" name="konum_yil" value="<?php echo $duzenle_konum; ?>" required>
        <label>Proje Açıklaması / Hikayesi:</label>
        <textarea name="aciklama" rows="5" required><?php echo $duzenle_aciklama; ?></textarea>
        <label>Proje Fotoğrafı <?php if($duzenle_id != "") echo "(Değiştirmek istemiyorsanız boş bırakın)"; ?>:</label>
        <input type="file" name="resim" <?php echo ($duzenle_id == "") ? "required" : ""; ?>>
        <button type="submit" name="islem_yap">
            <?php echo ($duzenle_id != "") ? "DEĞİŞİKLİKLERİ KAYDET" : "PROJEYİ YÜKLE"; ?>
        </button>
        <?php if($duzenle_id != ""): ?>
            <a href="admin.php" class="btn-vazgec">İPTAL ET / YENİ EKLEME MODUNA DÖN</a>
        <?php endif; ?>
    </form>
</div>

<div class="kutu">
    <h2>Yüklü Projeler</h2>
    <table>
        <thead>
            <tr>
                <th>Görsel</th>
                <th>Başlık</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sorgu = mysqli_query($baglanti, "SELECT * FROM projeler ORDER BY id DESC");
            while($satir = mysqli_fetch_assoc($sorgu)) {
                echo "<tr>";
                echo "<td><img src='".$satir['resim_yolu']."' width='70' style='border-radius:4px;'></td>";
                echo "<td>".$satir['baslik']."</td>";
                echo "<td class='islem-linkleri'>
                        <a href='admin.php?duzenleid=".$satir['id']."' class='duzenle'>DÜZENLE</a>
                        <a href='admin.php?silid=".$satir['id']."' class='sil' onclick='return confirm(\"Silmek istediğine emin misin?\")'>SİL</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>