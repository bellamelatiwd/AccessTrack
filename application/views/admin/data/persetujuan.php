<?php
// persetujuan.php (view)
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
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#mahasiswa" data-toggle="tab">Mahasiswa</a></li>
                  <li class="nav-item"><a class="nav-link" href="#dosen" data-toggle="tab">Dosen</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tendik" data-toggle="tab">Tendik</a></li>
                </ul>
              </div>
              <div class="card-header">
                  <?php if ($title === 'Menu Approved' || $title === 'Menu Rejected') : ?>
                      <form action="<?php echo base_url('admin/export_pdf'); ?>" method="get" class="form-inline">
                          <label for="start_date">Tanggal Mulai:</label>
                          <input type="date" name="start_date" class="form-control mx-1" required>

                          <label for="end_date">Tanggal Akhir:</label>
                          <input type="date" name="end_date" class="form-control mx-1" required>

                          <!-- Input tersembunyi untuk menyimpan tab aktif dan status halaman -->
                          <input type="hidden" name="tab" id="activeTab" value="mahasiswa">
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
                <div class="tab-content">
                  <!-- Tab Mahasiswa -->
                  <div class="tab-pane active" id="mahasiswa">
                    <h3>Mahasiswa</h3>
                    <table class="table table-bordered table-striped text-center">
                      <thead>
                        <tr style="background-color: #015F29; color: white;">
                          <th>No</th>
                          <th>Nama Lengkap</th>
                          <th>NIM</th>
                          <th>Program Studi</th>
                          <th>Alasan Ganti Kartu</th>
                          <th>Tanggal Pengajuan</th>
                          <th>Bukti Transfer</th>
                          <th>Bukti KTM</th>
                          <th>Status</th>
                          <?php if ($title === 'Menu Rejected') : ?>
                            <th>Alasan Ditolak</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Approved') : ?>
                            <th>Kwitansi</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                            <th>Aksi</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        if (!empty($pengajuan_mahasiswa)) {
                            foreach ($pengajuan_mahasiswa as $pgn) : ?>
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
                                        <?php if ($pgn['bukti_kartu']) : ?>
                                            <a href="<?php echo base_url($pgn['bukti_kartu']); ?>" target="_blank">Lihat Bukti</a>
                                        <?php else : ?>
                                            Tidak ada bukti
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $status = $pgn['status'] ?? '';
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
                                    <?php if ($title === 'Menu Rejected') : ?>
                                      <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($pgn['kwitansi']) : ?>
                                              <a href="<?php echo base_url($pgn['kwitansi']); ?>" target="_blank">Lihat Kwitansi</a>
                                          <?php else : ?>
                                              Tidak ada kwitansi
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($status === 'Pending') : ?>
                                              <form action="<?php echo base_url('admin/approved/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                              </form>
                                              <form action="<?php echo base_url('admin/rejected/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                                  <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                              </form>
                                          <?php elseif ($status === 'Approved') : ?>
                                              <?php if ($pgn['keterangan_kartu'] === 'kartu bisa diambil') : ?>
                                                  <button type="button" class="btn btn-success btn-sm" disabled>kartu bisa diambil</button>
                                              <?php else : ?>
                                                  <form action="<?php echo base_url('admin/kartu_bisa_diambil/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                      <button type="submit" class="btn btn-success btn-sm">kartu bisa diambil</button>
                                                  </form>
                                              <?php endif; ?>
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="<?php echo ($title === 'Menu Rejected') ? '9' : (($title === 'Menu Approved') ? '10' : '9'); ?>">Data pengajuan tidak ditemukan.</td>
                            </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <!-- Tab Dosen -->
                  <div class="tab-pane" id="dosen">
                    <h3>Dosen</h3>
                    <table class="table table-bordered table-striped text-center">
                      <thead>
                        <tr style="background-color: #015F29; color: white;">
                          <th>No</th>
                          <th>Nama Lengkap</th>
                          <th>NID</th>
                          <th>Program Studi</th>
                          <th>Alasan Ganti Kartu</th>
                          <th>Tanggal Pengajuan</th>
                          <th>Bukti Transfer</th>
                          <th>Bukti ID Card</th>

                          <th>Status</th>
                          <?php if ($title === 'Menu Rejected') : ?>
                            <th>Alasan Ditolak</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Approved') : ?>
                            <th>Kwitansi</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                            <th>Aksi</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        if (!empty($pengajuan_dosen)) {
                            foreach ($pengajuan_dosen as $pgn) : ?>
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
                                        <?php if ($pgn['bukti_kartu']) : ?>
                                            <a href="<?php echo base_url($pgn['bukti_kartu']); ?>" target="_blank">Lihat Bukti</a>
                                        <?php else : ?>
                                            Tidak ada bukti
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $status = $pgn['status'] ?? '';
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
                                    <?php if ($title === 'Menu Rejected') : ?>
                                      <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                                      <!-- <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> -->
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($pgn['kwitansi']) : ?>
                                              <a href="<?php echo base_url($pgn['kwitansi']); ?>" target="_blank">Lihat Kwitansi</a>
                                          <?php else : ?>
                                              Tidak ada kwitansi
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($status === 'Pending') : ?>
                                              <form action="<?php echo base_url('admin/approved/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                              </form>
                                              <form action="<?php echo base_url('admin/rejected/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                                  <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                              </form>
                                          <?php elseif ($status === 'Approved') : ?>
                                              <?php if ($pgn['keterangan_kartu'] === 'kartu bisa diambil') : ?>
                                                  <button type="button" class="btn btn-success btn-sm" disabled>kartu bisa diambil</button>
                                              <?php else : ?>
                                                  <form action="<?php echo base_url('admin/kartu_bisa_diambil/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                      <button type="submit" class="btn btn-success btn-sm">kartu bisa diambil</button>
                                                  </form>
                                              <?php endif; ?>
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="<?php echo ($title === 'Menu Rejected') ? '9' : (($title === 'Menu Approved') ? '10' : '9'); ?>">Data pengajuan tidak ditemukan.</td>
                            </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <!-- Tab Tendik -->
                  <div class="tab-pane" id="tendik">
                    <h3>Tendik</h3>
                    <table class="table table-bordered table-striped text-center">
                      <thead>
                        <tr style="background-color: #015F29; color: white;">
                          <th>No</th>
                          <th>Nama Lengkap</th>
                          <th>NIP</th>
                          <th>Program Studi</th>
                          <th>Alasan Ganti Kartu</th>
                          <th>Tanggal Pengajuan</th>
                          <th>Bukti Transfer</th>
                          <th>Bukti ID Card</th>

                          <th>Status</th>
                          <?php if ($title === 'Menu Rejected') : ?>
                            <th>Alasan Ditolak</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Approved') : ?>
                            <th>Kwitansi</th>
                          <?php endif; ?>
                          <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                            <th>Aksi</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        if (!empty($pengajuan_tendik)) {
                            foreach ($pengajuan_tendik as $pgn) : ?>
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
                                        <?php if ($pgn['bukti_kartu']) : ?>
                                            <a href="<?php echo base_url($pgn['bukti_kartu']); ?>" target="_blank">Lihat Bukti</a>
                                        <?php else : ?>
                                            Tidak ada bukti
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $status = $pgn['status'] ?? '';
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
                                    <?php if ($title === 'Menu Rejected') : ?>
                                      <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($pgn['kwitansi']) : ?>
                                              <a href="<?php echo base_url($pgn['kwitansi']); ?>" target="_blank">Lihat Kwitansi</a>
                                          <?php else : ?>
                                              Tidak ada kwitansi
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                    <?php if ($title === 'Menu Persetujuan' || $title === 'Menu Approved') : ?>
                                      <td>
                                          <?php if ($status === 'Pending') : ?>
                                              <form action="<?php echo base_url('admin/approved/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                              </form>
                                              <form action="<?php echo base_url('admin/rejected/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                  <input type="text" name="alasan_ditolak" placeholder="Alasan ditolak" required class="form-control mb-1">
                                                  <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                              </form>
                                          <?php elseif ($status === 'Approved') : ?>
                                              <?php if ($pgn['keterangan_kartu'] === 'kartu bisa diambil') : ?>
                                                  <button type="button" class="btn btn-success btn-sm" disabled>kartu bisa diambil</button>
                                              <?php else : ?>
                                                  <form action="<?php echo base_url('admin/kartu_bisa_diambil/' . $pgn['id_ka']); ?>" method="post" style="display: inline;">
                                                      <button type="submit" class="btn btn-success btn-sm">kartu bisa diambil</button>
                                                  </form>
                                              <?php endif; ?>
                                          <?php endif; ?>
                                      </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="<?php echo ($title === 'Menu Rejected') ? '9' : (($title === 'Menu Approved') ? '10' : '9'); ?>">Data pengajuan tidak ditemukan.</td>
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
      </div>
    </section>
</div>

<script>
    // JavaScript untuk mendeteksi tab aktif dan mengatur nilai input tersembunyi
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('activeTab').value = link.getAttribute('href').substring(1);
        });
    });
</script>