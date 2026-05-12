<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Klinik Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #0d6efd 0%, #0043a8 100%); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-custom:hover { transform: translateY(-5px); }
        .icon-box { font-size: 2rem; opacity: 0.8; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4">
            <h4 class="mb-4"><i class="fas fa-heartbeat me-2"></i>Klinik PRO</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="index.php" class="nav-link active"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                <li class="nav-item"><a href="index.php?page=transaksi" class="nav-link"><i class="fas fa-cash-register me-2"></i>Transaksi Baru</a></li>
                <li class="nav-item"><a href="index.php?page=riwayat" class="nav-link"><i class="fas fa-history me-2"></i>Riwayat</a></li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            
            <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';

            // --- HALAMAN DASHBOARD ---
            if($page == 'home'): 
                // Hitung data untuk dashboard
                $pasien = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pasien"));
                $dokter = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dokter"));
                $duit = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM transaksi"));
            ?>
                <h3 class="mb-4 text-secondary">Dashboard Overview</h3>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card card-custom p-4 bg-white text-primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Pasien</h6>
                                    <h3><?= $pasien ?> Orang</h3>
                                </div>
                                <i class="fas fa-users icon-box"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom p-4 bg-white text-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Dokter</h6>
                                    <h3><?= $dokter ?> Dokter</h3>
                                </div>
                                <i class="fas fa-user-md icon-box"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom p-4 bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50">Total Pendapatan</h6>
                                    <h3>Rp <?= number_format($duit['total'] ?? 0) ?></h3>
                                </div>
                                <i class="fas fa-wallet icon-box"></i>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($page == 'transaksi'): ?>
                <div class="card card-custom bg-white p-4">
                    <h4 class="mb-4 text-primary"><i class="fas fa-plus-circle me-2"></i>Input Transaksi Medis</h4>
                    <form action="proses.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pilih Pasien</label>
                                <select name="id_pasien" class="form-select" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    <?php 
                                    $q = mysqli_query($conn, "SELECT * FROM pasien");
                                    while($r = mysqli_fetch_array($q)){
                                        echo "<option value='$r[id_pasien]'>$r[kode_pasien] - $r[nama_pasien]</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pilih Dokter</label>
                                <select name="id_dokter" class="form-select" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    <?php 
                                    $q = mysqli_query($conn, "SELECT * FROM dokter");
                                    while($r = mysqli_fetch_array($q)){
                                        // Tarif kita taruh di attribute data-tarif agar bisa dilihat (opsional)
                                        echo "<option value='$r[id_dokter]'>$r[nama_dokter] ($r[spesialisasi])</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Diagnosa Dokter</label>
                                <textarea name="diagnosa" class="form-control" rows="3" required placeholder="Contoh: Demam berdarah ringan..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Total Harga Obat (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_obat" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="simpan_transaksi" class="btn btn-primary btn-lg w-100"><i class="fas fa-save me-2"></i>Simpan & Hitung Biaya</button>
                    </form>
                </div>

            <?php elseif($page == 'riwayat'): ?>
                <div class="card card-custom bg-white p-4">
                    <h4 class="mb-4 text-primary">Riwayat Transaksi</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($conn, "SELECT * FROM transaksi 
                                    JOIN pasien ON transaksi.id_pasien = pasien.id_pasien 
                                    JOIN dokter ON transaksi.id_dokter = dokter.id_dokter 
                                    ORDER BY id_transaksi DESC");
                                while($row = mysqli_fetch_array($q)){
                                ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($row['tgl_transaksi'])) ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $row['nama_pasien'] ?></div>
                                        <small class="text-muted"><?= $row['kode_pasien'] ?></small>
                                    </td>
                                    <td><?= $row['nama_dokter'] ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($row['total_bayar']) ?></td>
                                    <td>
                                        <a href="cetak.php?id=<?= $row['id_transaksi'] ?>" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fas fa-print"></i> Struk</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
</body>
</html>