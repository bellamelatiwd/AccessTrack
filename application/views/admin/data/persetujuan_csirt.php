<?php
// persetujuan_csirt.php (view)
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
              <?php
                $flashMessage = $this->session->flashdata('pesan');
                if ($flashMessage) {
                    echo $flashMessage;
                }
              ?>
              <div class="card-body">
                <h3>CSIRT Reports - Tendik</h3>
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
                      <th>Aksi</th>
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
                                <td>
                                    <?php if ($status === 'pending') : ?>
                                        <form action="<?php echo base_url('admin/approve_csirt/' . $report['id']); ?>" method="post" style="display: inline;">
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="<?php echo base_url('admin/reject_csirt/' . $report['id']); ?>" method="post" style="display: inline;">
                                            <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    <?php elseif ($status === 'approved') : ?>
                                        <button type="button" class="btn btn-success btn-sm" disabled>Approved</button>
                                    <?php elseif ($status === 'rejected') : ?>
                                        <button type="button" class="btn btn-danger btn-sm" disabled>Rejected</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; 
                    } else { ?>
                        <tr>
                            <td colspan="9">Data pelaporan tidak ditemukan.</td>
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
