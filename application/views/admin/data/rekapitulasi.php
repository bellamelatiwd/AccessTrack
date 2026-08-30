<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab === 'mahasiswa' ? 'active' : ''; ?>" href="#mahasiswa" data-toggle="tab">Mahasiswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab === 'dosen' ? 'active' : ''; ?>" href="#dosen" data-toggle="tab">Dosen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $tab === 'tendik' ? 'active' : ''; ?>" href="#tendik" data-toggle="tab">Tendik</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-header">
                            <form action="<?php echo base_url('admin/export_pdf_rekap'); ?>" method="get" class="form-inline">
                                <label for="start_date">Tanggal Mulai:</label>
                                <input type="date" name="start_date" class="form-control mx-1" required>

                                <label for="end_date">Tanggal Akhir:</label>
                                <input type="date" name="end_date" class="form-control mx-1" required>

                                <input type="hidden" name="tab" id="activeTab" value="mahasiswa">
                                <input type="hidden" name="title" value="<?php echo $title; ?>">

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-download fa-sm"></i> Export PDF
                                </button>
                            </form>
                        </div>
                        <?php
                        $flashMessage = $this->session->flashdata('pesan');
                        if ($flashMessage) {
                            echo $flashMessage;
                        }
                        ?>
                        <div class="card-body">
                            <div class="tab-content">
                                <?php 
                                $tabs = ['mahasiswa' => $pengajuan_mahasiswa, 'dosen' => $pengajuan_dosen, 'tendik' => $pengajuan_tendik];
                                foreach ($tabs as $tab => $data) : ?>
                                    <div class="tab-pane fade <?php echo $tab === 'mahasiswa' ? 'show active' : ''; ?>" id="<?php echo $tab; ?>">
                                        <h3><?php echo ucfirst($tab); ?></h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped text-center">
                                                <thead>
                                                    <tr style="background-color: #015F29; color: white;">
                                                        <th>No</th>
                                                        <th>Nama Lengkap</th>
                                                        <th><?php echo $tab === 'mahasiswa' ? 'NIM' : ($tab === 'dosen' ? 'NID' : 'NIP'); ?></th>
                                                        <th>Program Studi</th>
                                                        <th>Alasan Ganti Kartu</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Bukti Transfer</th>
                                                        <th>Status</th>
                                                        <th>Alasan Ditolak</th>
                                                        <th>Kwitansi</th>
                                                        <th>Kartu Bisa Diambil</th>
                                                        <?php if ($title === 'Menu Persetujuan') : ?>
                                                            <th>Aksi</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $no = 1;
                                                    if (!empty($data)) {
                                                        foreach ($data as $pgn) : ?>
                                                            <tr>
                                                                <td><?php echo $no++; ?></td>
                                                                <td><?php echo htmlspecialchars($pgn['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td><?php echo htmlspecialchars($pgn['id_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td><?php echo htmlspecialchars($pgn['prodi'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td><?php echo htmlspecialchars($pgn['alasan_ganti_kartu'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td><?php echo date('d F Y', strtotime($pgn['tanggal_pengajuan'])); ?></td>
                                                                <td>
                                                                    <?php if ($pgn['bukti_pembayaran']) : ?>
                                                                        <a href="<?php echo base_url($pgn['bukti_pembayaran']); ?>" target="_blank">Lihat Bukti</a>
                                                                    <?php else : ?>
                                                                        Tidak ada bukti
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    $status = $pgn['status'] ?? '';
                                                                    $color = $status === 'Pending' ? 'yellow; color: black;' : ($status === 'Approved' ? 'green; color: white;' : 'red; color: white;');
                                                                    ?>
                                                                    <span style="background-color: <?php echo $color; ?>; padding: 5px 10px; border-radius: 5px;">
                                                                        <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                                                    </span>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td>
                                                                    <?php if ($pgn['kwitansi']) : ?>
                                                                        <a href="<?php echo base_url($pgn['kwitansi']); ?>" target="_blank">Lihat Kwitansi</a>
                                                                    <?php else : ?>
                                                                        Tidak ada kwitansi
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($status === 'Approved') : ?>
                                                                        <?php if ($pgn['keterangan_kartu'] === 'kartu bisa diambil') : ?>
                                                                            <button type="button" class="btn btn-success btn-sm" disabled>kartu bisa diambil</button>
                                                                        <?php else : ?>
                                                                            <form action="<?php echo base_url('admin/kartu_bisa_diambil/' . $pgn['id_ka']); ?>" method="post">
                                                                                <button type="submit" class="btn btn-success btn-sm">kartu bisa diambil</button>
                                                                            </form>
                                                                        <?php endif; ?>
                                                                    <?php else : ?>
                                                                        <!-- Tidak menampilkan tombol jika status bukan 'Approved' -->
                                                                    <?php endif; ?>
                                                                </td>
                                                                <?php if ($title === 'Menu Persetujuan') : ?>
                                                                    <td>
                                                                        <?php if ($status === 'Pending') : ?>
                                                                            <form action="<?php echo base_url('admin/approved/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                                            </form>
                                                                            <form action="<?php echo base_url('admin/rejected/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                                                <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                                            </form>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; 
                                                    } else { ?>
                                                        <tr>
                                                            <td colspan="<?php echo $title === 'Menu Persetujuan' ? '12' : '11'; ?>">Data pengajuan tidak ditemukan.</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('activeTab').value = link.getAttribute('href').substring(1);
            });
        });
    });
</script>

<style>
    .table th, .table td {
        padding: 12px 15px;
    }
    .btn-sm {
        padding: 8px 15px;
    }
    .btn-success, .btn-danger {
        font-size: 14px;
        padding: 10px 20px;
    }
    .nav-link.active {
        background-color: #015F29;
        color: white;
    }
</style>
