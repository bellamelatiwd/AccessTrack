<div class="content-wrapper">

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

                            <div class="row justify-content-center">
                                <div class="col-md-8 text-center">
                                    <h2 class="text-success">Terima Kasih!</h2>
                                    <p>Laporan CSIRT Anda telah berhasil dikirim dan sedang dalam proses pengecekan oleh Tim CSIRT. Salinan data laporan Anda juga telah dikirimkan ke email Anda. <b style="font-size: 18px;"><span style="background-color: rgba(255, 255, 0, 0.3); padding: 8px; border-radius: 4px; display: inline-block;">Silakan periksa kotak masuk email atau folder spam pada akun Gmail Anda</span></b></p>
                                </div>
                            </div>
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
