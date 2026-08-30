<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-8 text-center">
                    <h1>Form Pelaporan CSIRT</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php
                            $flashMessage = $this->session->flashdata('pesan');
                            if ($flashMessage): ?>
                                <div class="alert alert-info">
                                    <?= $flashMessage; ?>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        setTimeout(function() {
                                            var alertElement = document.querySelector(".alert");
                                            if (alertElement) {
                                                alertElement.style.transition = "opacity 1s";
                                                alertElement.style.opacity = 0;
                                                setTimeout(function() {
                                                    alertElement.style.display = "none";
                                                }, 1000); // Hide the alert after 1 second (1000 milliseconds)
                                            }
                                        }, 2000); // Show the alert for 2 seconds (2000 milliseconds)
                                    });
                                </script>
                            <?php endif; ?>

                            <form action="<?php echo base_url('user/submit_csirt'); ?>" method="post" enctype="multipart/form-data" class="text-center">
                                
                                <!-- Website Name Field -->
                                <div class="form-group text-left">
                                    <label for="nama_website">Nama Website:</label>
                                    <input type="text" name="nama_website" id="nama_website" class="form-control" required>
                                </div>

                                <!-- Problem Description Field -->
                                <div class="form-group text-left">
                                    <label for="deskripsi_masalah">Deskripsi Masalah:</label>
                                    <textarea name="deskripsi_masalah" id="deskripsi_masalah" class="form-control" rows="4" required></textarea>
                                </div>

                                <!-- File Upload for Evidence -->
                                <div class="form-group text-left">
                                    <label for="bukti_file">Upload Bukti File:</label>
                                    <input type="file" name="bukti_file" id="bukti_file" class="form-control-file" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
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
