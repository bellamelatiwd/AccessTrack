<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background-color: #015F29; color: white;">
    <!-- Brand Logo -->
    <a href="<?= base_url('User/index'); ?>" class="brand-link d-flex align-items-center text-white">
        <img src="https://student.unjani.ac.id/client/demounjani2/images/htzg21674013098.png" 
             alt="Logo" 
             class="brand-image img-circle elevation-3" 
             style="opacity: 0.8;">
        <span class="brand-text font-weight-light ml-2">User (<?= ucfirst($this->session->userdata('keterangan')); ?>)</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('User/Pengajuan'); ?>" class="nav-link text-white">
                        <i class="nav-icon fa fa-id-card text-white"></i>
                        <p>Pengajuan Kartu Akses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('User/status_pengajuan'); ?>" class="nav-link text-white">
                        <i class="nav-icon fa fa-check-circle text-white"></i>
                        <p>Riwayat Pengajuan</p>
                    </a>
                </li>
                <!-- CSIRT Reporting Menu for Tendik Only -->
                <?php if ($this->session->userdata('keterangan') === 'tendik'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('User/pelaporan_csirt'); ?>" class="nav-link text-white">
                            <i class="nav-icon fa fa-bug text-white"></i>
                            <p>Pelaporan CSIRT</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('User/riwayat_pelaporan'); ?>" class="nav-link text-white">
                            <i class="nav-icon fa fa-history text-white"></i>
                            <p>Riwayat Pelaporan</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" data-toggle="modal" data-target="#logoutModal">
                        <i class="nav-icon fas fa-sign-out-alt text-white"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin ingin logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="<?= base_url('Auth/logout'); ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
