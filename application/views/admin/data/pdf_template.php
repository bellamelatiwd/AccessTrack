<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #015F29; color: white; }
    </style>
</head>
<body>
    <h2>Data Pengajuan <?php echo isset($keterangan) ? $keterangan : ''; ?> - Dari <?php echo isset($start_date) ? $start_date : ''; ?> hingga <?php echo isset($end_date) ? $end_date : ''; ?></h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>ID User</th>
                <th>Program Studi</th>
                <th>Alasan Ganti Kartu</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pengajuan)) : ?>
                <?php $no = 1; foreach ($pengajuan as $pgn) : ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo isset($pgn['nama_lengkap']) ? htmlspecialchars($pgn['nama_lengkap'], ENT_QUOTES, 'UTF-8') : ''; ?></td>
                        <td><?php echo isset($pgn['id_user']) ? htmlspecialchars($pgn['id_user'], ENT_QUOTES, 'UTF-8') : ''; ?></td>
                        <td><?php echo isset($pgn['prodi']) ? htmlspecialchars($pgn['prodi'], ENT_QUOTES, 'UTF-8') : ''; ?></td>
                        <td><?php echo isset($pgn['alasan_ganti_kartu']) ? htmlspecialchars($pgn['alasan_ganti_kartu'], ENT_QUOTES, 'UTF-8') : ''; ?></td>
                        <td><?php echo isset($pgn['tanggal_pengajuan']) ? date('d F Y', strtotime($pgn['tanggal_pengajuan'])) : ''; ?></td>
                        <td><?php echo isset($pgn['status']) ? htmlspecialchars($pgn['status'], ENT_QUOTES, 'UTF-8') : ''; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">Data pengajuan tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
