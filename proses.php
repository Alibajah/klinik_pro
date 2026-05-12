<?php
include 'koneksi.php';

if(isset($_POST['simpan_transaksi'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $diagnosa  = $_POST['diagnosa'];
    $biaya_obat= $_POST['biaya_obat'];

    // 1. Ambil tarif dokter dari database
    $cek_dokter = mysqli_query($conn, "SELECT tarif FROM dokter WHERE id_dokter = '$id_dokter'");
    $data_dokter = mysqli_fetch_array($cek_dokter);
    $biaya_jasa = $data_dokter['tarif'];

    // 2. Hitung Total
    $total_bayar = $biaya_jasa + $biaya_obat;

    // 3. Simpan
    $query = "INSERT INTO transaksi (id_pasien, id_dokter, diagnosa, biaya_jasa, biaya_obat, total_bayar) 
              VALUES ('$id_pasien', '$id_dokter', '$diagnosa', '$biaya_jasa', '$biaya_obat', '$total_bayar')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Transaksi Berhasil! Total: Rp ".number_format($total_bayar)."'); window.location='index.php?page=riwayat';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>