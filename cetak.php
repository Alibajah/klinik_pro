<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM transaksi 
    JOIN pasien ON transaksi.id_pasien = pasien.id_pasien 
    JOIN dokter ON transaksi.id_dokter = dokter.id_dokter 
    WHERE id_transaksi = '$id'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: 'Courier New', monospace; background: #eee; padding: 20px; }
        .struk { width: 320px; background: white; padding: 20px; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px; margin-bottom: 10px; }
        .item { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .total { border-top: 2px dashed #333; margin-top: 10px; padding-top: 10px; font-weight: bold; font-size: 1.2rem; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.8rem; color: #666; }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <div class="header">
            <h3>KLINIK SEHAT PRO</h3>
            <p>Jl. Jendral Sudirman No.45<br>Telp: (021) 555-8888</p>
        </div>

        <div class="item">
            <span>Tgl:</span>
            <span><?= date('d/m/Y', strtotime($data['tgl_transaksi'])) ?></span>
        </div>
        <div class="item">
            <span>Pasien:</span>
            <span><?= substr($data['nama_pasien'], 0, 15) ?>..</span>
        </div>
        <div class="item">
            <span>Dokter:</span>
            <span><?= substr($data['nama_dokter'], 0, 15) ?>..</span>
        </div>
        
        <hr style="border-top: 1px dashed #ccc;">
        
        <div class="item">
            <span>Jasa Medis</span>
            <span>Rp <?= number_format($data['biaya_jasa']) ?></span>
        </div>
        <div class="item">
            <span>Obat-obatan</span>
            <span>Rp <?= number_format($data['biaya_obat']) ?></span>
        </div>
        
        <div class="item total">
            <span>TOTAL</span>
            <span>Rp <?= number_format($data['total_bayar']) ?></span>
        </div>

        <div class="footer">
            <p>Diagnosa: <?= $data['diagnosa'] ?></p>
            <p>Semoga Lekas Sembuh!</p>
        </div>
    </div>
</body>
</html>