<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
    $flashMessage = $this->session->flashdata('pesan');
    if ($flashMessage) {
        echo $flashMessage;
    }
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="small-box" style="background-color: #ffc107; color: #000000;">
              <div class="inner">
                <h3><?php echo $count_pending; ?></h3>
                <p>Pending</p>
              </div>
              <div class="icon">
                <i class="fas fa-hourglass-half"></i> <!-- Updated icon -->
              </div>
              <a href="<?= base_url('Admin/Persetujuan'); ?>" class="small-box-footer" style="color: #000000;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- Additional boxes for statuses -->
          <div class="col-lg-4 col-6">
            <div class="small-box" style="background-color: #28a745; color: #ffffff;">
              <div class="inner">
                <h3><?php echo $count_approve; ?></h3>
                <p>Approved</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i> <!-- Updated icon -->
              </div>
              <a href="<?= base_url('Admin/Data_Approved'); ?>" class="small-box-footer" style="color: #ffffff;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <div class="col-lg-4 col-6">
            <div class="small-box" style="background-color: #dc3545; color: #ffffff;">
              <div class="inner">
                <h3><?php echo $count_rejected; ?></h3>
                <p>Rejected</p>
              </div>
              <div class="icon">
                <i class="fas fa-times-circle"></i> <!-- Updated icon -->
              </div>
              <a href="<?= base_url('Admin/Data_Rejected'); ?>" class="small-box-footer" style="color: #ffffff;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
