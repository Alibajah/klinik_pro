<?php
$conn = mysqli_connect("localhost", "root", "", "db_klinik_pro");
if (!$conn) { die("Koneksi Gagal: " . mysqli_connect_error()); }
?>