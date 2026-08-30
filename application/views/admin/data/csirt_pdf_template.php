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
                <th>NIP</th>
                <th>Nama Website</th>
                <th>Deskripsi Masalah</th>
                <th>Tanggal Pelaporan</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                
            
            </tr>
        </thead>
        <tbody>
        <?php 
                                        $no = 1;
                                        if (!empty($csirt_reports)) :
                                            foreach ($csirt_reports as $report) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($report['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($report['id_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($report['nama_website'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="text-wrap"><?php echo htmlspecialchars($report['deskripsi_masalah'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo date('d F Y', strtotime($report['tanggal_pelaporan'])); ?></td>
                                                    
                                                    <td>
                                                        <span>
                                                            <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                                        </span>
                                                    </td>
                                                        <td><?php echo htmlspecialchars($report['alasan_pelaporan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                    
                                                    
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="8">Data pengajuan tidak ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
