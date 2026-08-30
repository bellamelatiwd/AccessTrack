<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-8 text-center">
                    <h1>Form Pengajuan Kartu Akses</h1>
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

                            <form action="<?php echo base_url('user/submit'); ?>" method="post" enctype="multipart/form-data" class="text-center">
                                <div class="form-group text-left">
                                    <label for="alasan_ganti_kartu">Alasan Ganti Kartu:</label><br>
                                    <div class="d-flex justify-content-start">
                                        <div class="form-check mr-3">
                                            <input type="radio" name="alasan_ganti_kartu" id="alasan1" value="Kartu Hilang" class="form-check-input" required>
                                            <label for="alasan1" class="form-check-label">Kartu Hilang</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="alasan_ganti_kartu" id="alasan2" value="Kartu Rusak / Tidak Bisa Digunakan" class="form-check-input" required>
                                            <label for="alasan2" class="form-check-label">Kartu Rusak / Tidak Bisa Digunakan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conditional Payment Section for 'Mahasiswa' -->
                                <?php if ($this->session->userdata('keterangan') == 'mahasiswa'): ?>
                                    <div id="payment_section" class="payment-section text-center mb-3">
                                        <p>Silakan bayar melalui QR Code berikut:</p>
                                        <img src="<?= base_url('assets/img/qr_code.png'); ?>" alt="QR Code Pembayaran" style="width: 180px; height: 180px;">
                                        <p><strong>Nominal: Rp 40.000</strong></p>
                                    </div>

                                    <div class="form-group text-left">
                                        <label for="bukti_pembayaran" id="bukti_label">Upload Bukti Transfer:</label>
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file" required>
                                    </div>

                                    <div class="form-group text-left">
                                        <label for="bukti_kartu" id="bukti_label">Upload Bukti KTM:</label>
                                        <input type="file" name="bukti_kartu" id="bukti_kartu" class="form-control-file" required>
                                    </div>
                                <?php else: ?>
                                    <div id="payment_section" class="payment-section text-center mb-3" style="text-align: center; margin-bottom: 1rem;">
                                        <label for="bukti_kartu" id="bukti_label" style="display: block; text-align: left; margin-bottom: 0.5rem; font-weight: bold;">
                                            Upload Bukti ID Card:
                                        </label>
                                        <input type="file" name="bukti_kartu" id="bukti_kartu" style="display: block; text-align: left; margin-bottom: 0.5rem; font-weight: bold;" required >
                                    </div>
                               
                                <?php endif; ?>

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