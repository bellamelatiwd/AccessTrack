<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header">
                            <!-- Form Export PDF -->
                                <form action="<?php echo base_url('admin/export_pdf_csirt'); ?>" method="get" class="form-inline">
                                    <label for="start_date" class="mr-2">Tanggal Mulai:</label>
                                    <input type="date" name="start_date" class="form-control mr-3" required>

                                    <label for="end_date" class="mr-2">Tanggal Akhir:</label>
                                    <input type="date" name="end_date" class="form-control mr-3" required>

                                    <input type="hidden" name="title" value="<?php echo $title; ?>">

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-download"></i> Export PDF
                                    </button>
                                </form>
                        </div>

                        <!-- Flash Message -->
                        <?php if ($this->session->flashdata('pesan')) : ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('pesan'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h3 class="mb-3">CSIRT Reports - Tendik</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr style="background-color: #015F29; color: white;">
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIP</th>
                                            <th>Nama Website</th>
                                            <th>Deskripsi Masalah</th>
                                            <th>Tanggal Pelaporan</th>
                                            <th>Bukti File</th>
                                            <th>Status</th>
                                            <?php if ($title === 'Data Rejected CSIRT') : ?>
                                                <th>Alasan Ditolak</th>
                                            <?php endif; ?>
                                            <?php if ($title === 'Persetujuan Pelaporan CSIRT') : ?>
                                                <th>Aksi</th>
                                            <?php endif; ?>
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
                                                        <?php if ($report['bukti_file']) : ?>
                                                            <a href="<?php echo base_url($report['bukti_file']); ?>" target="_blank">Lihat Bukti</a>
                                                        <?php else : ?>
                                                            Tidak ada bukti
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $status = $report['status'] ?? '';
                                                        $color = match ($status) {
                                                            'Pending' => 'badge-warning',
                                                            'Approved' => 'badge-success',
                                                            'Rejected' => 'badge-danger',
                                                            default => '',
                                                        };
                                                        ?>
                                                        <span class="badge <?php echo $color; ?>">
                                                            <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($title === 'Data Rejected CSIRT') : ?>
                                                        <td><?php echo htmlspecialchars($report['alasan_pelaporan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <?php endif; ?>
                                                    <?php if ($title === 'Persetujuan Pelaporan CSIRT') : ?>
                                                        <td>
                                                            <?php if ($status === 'Pending') : ?>
                                                                <form action="<?php echo base_url('admin/approve_csirt/' . $report['id']); ?>" method="post" class="d-inline">
                                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                                </form>
                                                                <form action="<?php echo base_url('admin/reject_csirt/' . $report['id']); ?>" method="post" class="d-inline">
                                                                    <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; 
                                        else : ?>
                                            <tr>
                                                <td colspan="<?php echo ($title === 'Data Rejected CSIRT') ? '9' : '8'; ?>">Data pelaporan tidak ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Rekapitulasi Pelaporan CSIRT -->
                        <div class="card-body mt-5">
                            <h3 class="mb-3">Rekapitulasi Pelaporan CSIRT</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr style="background-color: #007BFF; color: white;">
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIP</th>
                                            <th>Jumlah Pelaporan</th>
                                            <th>Disetujui</th>
                                            <th>Ditolak</th>
                                            <th>Pending</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (!empty($rekapitulasi)) :
                                            foreach ($rekapitulasi as $rekap) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['nip'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['jumlah_pelaporan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['disetujui'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['ditolak'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rekap['pending'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                </tr>
                                            <?php endforeach;
                                        else : ?>
                                            <tr>
                                                <td colspan="7">Data tidak ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Rekapitulasi -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
