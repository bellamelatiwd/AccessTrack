<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-">Riwayat Pelaporan CSIRT</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- User Information Table -->
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Nama Lengkap</td>
                                        <td>:</td>
                                        <td><?php echo strtoupper($this->session->userdata('nama_lengkap')); ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $keterangan = $this->session->userdata('keterangan');
                                        $label = ($keterangan == "mahasiswa") ? "NIM" : (($keterangan == "dosen") ? "NID" : "NIP");
                                        ?>
                                        <td class="font-weight-bold"><?php echo $label; ?></td>
                                        <td>:</td>
                                        <td><?php echo $this->session->userdata('id_user'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Program Studi</td>
                                        <td>:</td>
                                        <td><?php echo ucwords($this->session->userdata('prodi')); ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Report History Table -->
                            <div class="table-responsive mt-4">
                                <table id="example1" class="table table-striped table-bordered text-center">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Website</th>
                                            <th>Deskripsi Masalah</th>
                                            <th>Tanggal Pelaporan</th>
                                            <th>Status</th>
                                            <th>Bukti File</th>
                                            <th>Alasan Pelaporan Ditolak</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        if (!empty($riwayat_pelaporan)) {
                                            foreach ($riwayat_pelaporan as $report) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($report['nama_website'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($report['deskripsi_masalah'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo date('d F Y', strtotime($report['tanggal_pelaporan'])); ?></td>
                                                    <td>
                                                        <?php 
                                                        $status = strtolower($report['status'] ?? ''); // Mengubah status menjadi huruf kecil
                                                        $color = ($status === 'pending') ? 'yellow' : (($status === 'approved') ? 'green' : 'red'); 
                                                        ?>
                                                        <span class="badge" style="background-color: <?php echo $color; ?>; color: white;">
                                                            <?php echo ucfirst($status); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($report['bukti_file']) : ?>
                                                            <a href="<?php echo base_url($report['bukti_file']); ?>" class="btn btn-success btn-sm" target="_blank">Lihat Bukti</a>
                                                        <?php else : ?>
                                                            <span class="text-muted">Tidak ada bukti</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo ($status === 'rejected') ? htmlspecialchars($report['alasan_pelaporan_ditolak'] ?? 'Tidak ada alasan', ENT_QUOTES, 'UTF-8') : '-'; ?></td>
                                                    <td><?php echo htmlspecialchars($report['keterangan_pelaporan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                </tr>
                                            <?php endforeach; 
                                        } else { ?>
                                            <tr>
                                                <td colspan="8" class="text-muted">Data pelaporan tidak ditemukan.</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
