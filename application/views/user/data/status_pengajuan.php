<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Riwayat Pengajuan</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped text-center">
                  <thead>
                  </thead>
                  <tbody>
                    <?php
                    $flashMessage = $this->session->flashdata('pesan');
                    if ($flashMessage) {
                        echo $flashMessage;
                        echo '
                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                var alertElement = document.querySelector(".alert"); // Change to your specific element selector
                                if (alertElement) {
                                    alertElement.style.opacity = 0;
                                    setTimeout(function() {
                                        alertElement.style.display = "none";
                                    }, 1000); // Hide the alert after 1 second (1000 milliseconds)
                                }
                            }, 2000); // Show the alert for 2 seconds (2000 milliseconds)
                        });
                        </script>';
                    }
                    ?>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?php echo strtoupper($this->session->userdata('nama_lengkap')); ?></td>

                    </tr>
                    <tr>
                        <?php
                            $keterangan = $this->session->userdata('keterangan');
                            if ($keterangan == "mahasiswa") {
                                echo "<td>NIM</td>";
                            } elseif ($keterangan == "dosen") {
                                echo "<td>NID</td>";
                            } elseif ($keterangan == "tendik") {
                                echo "<td>NIP</td>";
                            }
                        ?>
                        <td>:</td>

                        <td><?php echo $this->session->userdata('id_user'); ?></td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>:</td>
                        <td><?php echo ucwords($this->session->userdata('prodi')); ?></td>

                    </tr>
                  </tbody>
                </table>
                <table id="example1" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr class="text-center" style="background-color: #015F29; color: white;">
                        <th>No</th>
                        <th>Alasan Ganti Kartu</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Bukti Transfer</th>
                        <th>Bukti Kartu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Alasan Ditolak</th>
                        <th>Kwitansi</th>
                    </tr>
                  </thead>
                  <tbody>
                                               
                    <?php 
                    $no = 1;
                    if (!empty($pengajuan)) {
                        foreach ($pengajuan as $pgn) : ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($pgn['alasan_ganti_kartu'], ENT_QUOTES, 'UTF-8'); ?></td>
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
                                <td>
                                    <?php 
                                    $keterangan = $pgn['keterangan_kartu'] ?? '';
                                    $color = '';
                                    if ($keterangan === 'sedang diproses') {
                                        $color = 'background-color: yellow; color: black;';
                                    } elseif ($keterangan === 'kartu bisa diambil') {
                                        $color = 'background-color: green; color: white;';
                                    }
                                    ?>
                                    <span style="<?php echo $color; ?>">
                                        <?php echo htmlspecialchars($keterangan, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($pgn['alasan_ditolak'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (!empty($pgn['kwitansi'])) : ?>
                                        <a href="<?php echo base_url($pgn['kwitansi']); ?>" target="_blank">Lihat Kwitansi</a>
                                    <?php else : ?>
                                        Tidak ada kwitansi
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; 
                    } else { ?>
                        <tr>
                            <td colspan="10">Data pengajuan tidak ditemukan.</td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>