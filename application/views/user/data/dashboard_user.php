<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Informasi <?php echo ucfirst($this->session->userdata('keterangan')); ?></h1>
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
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $this->session->userdata('email'); ?></td>
                    </tr>
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

