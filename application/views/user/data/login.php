<body class="hold-transition login-page" style="background: url('assets/img/bg.png') no-repeat center center fixed; background-size: cover;">
  <div class="login-box">
  <div class="card-header text-center" style="margin-bottom: 20px;">
      <h1 class="title" style="font-size: 50px; font-weight: bold; color: #fff; 
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); font-family: 'Arial', sans-serif;">
        AccessTrack
      </h1>
    <!-- /.login-logo -->
    <div class="card card-outline" >
      <div class="card-header text-center">
        <h5><b>LOGIN USER</b></h5>
      </div>
      <div class="text-center">
        <img src="https://student.unjani.ac.id//client/demounjani2/images/htzg21674013098.png" alt="" width="100" height="100">
      </div>
      <div class="card-body">
      <?php
      $flashMessage = $this->session->flashdata('pesan');
      if ($flashMessage) {
          echo $flashMessage;
      }
      ?>
        <form action="<?php echo base_url('Auth') ?>" method="post">
          <div class="input-group mb-3">
            <input type="number" name="id_user" id="id_user" class="form-control" placeholder="NIM/NID/NIP" 
                title="NIM/NID/NIP wajib Diisi dan harus berupa angka." required 
                oninvalid="this.setCustomValidity('NIM/NID/NIP Wajib Diisi dan harus berupa angka.')"
                oninput="setCustomValidity('')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" 
                  title="Password wajib diisi." required 
                  oninvalid="this.setCustomValidity('Password wajib diisi.')"
                  oninput="setCustomValidity('')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="icheck-primary">
                <input type="checkbox" id="showPassword" onchange="togglePassword()">
                <label for="showPassword">Tampilkan Password</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-block" style="background-color: #015F29; color: white;">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->


<script>

  function togglePassword() {
      // Get references to the checkbox and password input field
      const checkbox = document.getElementById('showPassword');
      const passwordField1 = document.getElementById('password');

      // Check the checkbox state
      if (checkbox.checked) {
          // If checked, show the password
          passwordField1.type = 'text';

      } else {
          // If unchecked, hide the password (show asterisks)
          passwordField1.type = 'password';
      }
  }

  document.addEventListener("DOMContentLoaded", function() {
      var alertElement = document.querySelector(".alert"); // Ganti dengan selector elemen spesifik Anda

      // Tampilkan pesan flash jika ada
      if (alertElement) {
          setTimeout(function() {
              alertElement.style.opacity = 0;
              setTimeout(function() {
                  alertElement.style.display = "none";
              }, 1000); // Sembunyikan pesan setelah 1 detik (1000 milidetik)
          }, 4000); // Tampilkan pesan selama 4 detik (4000 milidetik)

          // Tambahkan event listener untuk tombol close
          var closeButton = alertElement.querySelector(".close");
          if (closeButton) {
              closeButton.addEventListener("click", function() {
                  alertElement.style.display = "none";
              });
          }
      }
  });

</script>
