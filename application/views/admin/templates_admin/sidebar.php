<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background-color: #015F29; color: white;">
    <!-- Brand Logo -->
    <a href="<?= base_url('Admin/Persetujuan'); ?>" class="brand-link" style="width: 100%; display: flex; align-items: center; color:white;">
      <img src="https://student.unjani.ac.id//client/demounjani2/images/htzg21674013098.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;">
      <span class="brand-text font-weight-light">Approval</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Akun User Menu -->
          <li class="nav-item">
            <a href="<?= base_url('admin/akun_data_user'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fa fa-user"></i>
              <p>Akun User</p>
            </a>
          </li>
          
          <!-- Persetujuan Kartu Akses Menu -->
          <li class="nav-item">
            <a href="<?= base_url('Admin/Persetujuan'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-user-check" style="color: white;"></i>
              <p>Persetujuan Kartu Akses</p>
            </a>
          </li>
          
          <!-- Data Approved Menu -->
          <!-- <li class="nav-item">
            <a href="<?= base_url('Admin/Data_Approved'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-check-circle" style="color: white;"></i>
              <p>Data Approved</p>
            </a>
          </li> -->
          
          <!-- Data Rejected Menu -->
          <!-- <li class="nav-item">
            <a href="<?= base_url('Admin/Data_Rejected'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-times-circle" style="color: white;"></i>
              <p>Data Rejected</p>
            </a>
          </li> -->
          
          <!-- Rekapitulasi Kartu Akses Menu -->
          <li class="nav-item">
            <a href="<?= base_url('Admin/Data_Rekapitulasi'); ?>" class="nav-link" style="color: white;">
                <i class="nav-icon fas fa-table" style="color: white;"></i>
                <p>Rekapitulasi Kartu Akses</p>
            </a>
          </li>
          
          <!-- Persetujuan Pelaporan CSIRT Menu -->
          <li class="nav-item">
            <a href="<?= base_url('Admin/persetujuan_csirt'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-user-check" style="color: white;"></i>
              <p>Persetujuan CSIRT</p>
            </a>
          </li>
          
          <!-- Approved CSIRT Reports Menu -->
          <!-- <li class="nav-item">
            <a href="<?= base_url('Admin/Data_Approved_CSIRT'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-check-circle" style="color: white;"></i>
              <p>Data Approved CSIRT</p>
            </a>
          </li> -->
          
          <!-- Rejected CSIRT Reports Menu -->
          <!-- <li class="nav-item">
            <a href="<?= base_url('Admin/Data_Rejected_CSIRT'); ?>" class="nav-link" style="color: white;">
              <i class="nav-icon fas fa-times-circle" style="color: white;"></i>
              <p>Data Rejected CSIRT</p>
            </a>
          </li> -->
          
          <!-- Rekapitulasi Pelaporan CSIRT Menu -->
          <li class="nav-item">
            <a href="<?= base_url('Admin/data_rekapitulasi_csirt'); ?>" class="nav-link" style="color: white;">
                <i class="nav-icon fas fa-table" style="color: white;"></i>
                <p>Rekapitulasi Pelaporan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('Auth/admin'); ?>" class="nav-link" data-toggle="modal" data-target="#logoutModal" onclick="return confirmLogout();" style="color: white;">
              <i class="nav-icon fas fa-sign-out-alt" style="color: white;"></i>
              <p>Logout</p>
            </a>
          </li>
          
        </ul>
      </nav>
    </div>
  </aside>

<script>
    function confirmLogout() {
        if (confirm('Apakah Kamu Yakin Ingin Logout?')) {
            // If user confirms, proceed with logout by navigating to the logout URL
            window.location.href = '<?= base_url('Auth/logout_admin'); ?>';
        }
        return false; // Prevent the default action of the link
    }
</script>