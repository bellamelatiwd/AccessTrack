<?php
// persetujuan_csirt.php (view for CSIRT approvals)
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <?php if ($title === 'Data Approved CSIRT' || $title === 'Data Rejected CSIRT') : ?>
                                <form action="<?php echo base_url('admin/export_pdf_csirt'); ?>" method="get" class="form-inline">
                                    <label for="start_date">Tanggal Mulai:</label>
                                    <input type="date" name="start_date" class="form-control mx-1" required>

                                    <label for="end_date">Tanggal Akhir:</label>
                                    <input type="date" name="end_date" class="form-control mx-1" required>

                                    <input type="hidden" name="title" value="<?php echo $title; ?>">
                                    
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-download fa-sm"></i> Export PDF
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <?php
                        $flashMessage = $this->session->flashdata('pesan');
                        if ($flashMessage) {
                            echo $flashMessage;
                        }
                        ?>
                        <div class="card-body">
                            <h3>Tendik - CSIRT Reports</h3>
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
                                    if (!empty($csirt_reports)) {
                                        foreach ($csirt_reports as $report) : ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($report['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($report['id_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($report['nama_website'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($report['deskripsi_masalah'], ENT_QUOTES, 'UTF-8'); ?></td>
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
                                                    $color = '';
                                                    if ($status === 'Pending') {
                                                        $color = 'background-color: yellow; color: black;';
                                                    } elseif ($status === 'Approved') {
                                                        $color = 'background-color: green; color: white;';
                                                    } elseif ($status === 'Rejected') {
                                                        $color = 'background-color: red; color: white;';
                                                    }
                                                    ?>
                                                    <span style="<?php echo $color; ?>">
                                                        <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                                    </span>
                                                </td>
                                                <?php if ($title === 'Data Rejected CSIRT') : ?>
                                                    <td><?php echo htmlspecialchars($report['alasan_pelaporan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <?php endif; ?>
                                                <?php if ($title === 'Persetujuan Pelaporan CSIRT') : ?>
                                                    <td>
                                                        <?php if ($status === 'Pending') : ?>
                                                            <form action="<?php echo base_url('admin/approve_csirt/' . $report['id']); ?>" method="post" style="display: inline;">
                                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                            </form>
                                                            <form action="<?php echo base_url('admin/reject_csirt/' . $report['id']); ?>" method="post" style="display: inline;">
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
                                            <td colspan="<?php echo ($title === 'Data Rejected CSIRT') ? '9' : '8'; ?>">Data pelaporan tidak ditemukan.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // JavaScript to manage active tab for export purposes
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('activeTab').value = link.getAttribute('href').substring(1);
        });
    });
</script>
