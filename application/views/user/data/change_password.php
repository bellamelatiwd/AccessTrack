<body class="hold-transition login-page" style="background: url('/AccessTrack/assets/img/bg.png') no-repeat center center fixed; background-size: cover;">
  <div class="login-box">
    <!-- /.login-logo -->
    <div style="background-color: pink; color: black; padding: 15px; border: 1px solid #FF69B4; border-radius: 5px; display: flex; align-items: center; margin-bottom: 20px;">
      <span style="font-size: 40px; font-weight: bold; margin-right: 20px;">⚠️</span>
      <h5 style="text-transform: capitalize; font-size: 14px; margin: 0;">Silakan ubah kata sandi Anda terlebih dahulu untuk meningkatkan keamanan sebelum mengakses dashboard.</h5>
    </div>

    <div class="card card-outline">
      <div class="card-header text-center">
        <h5><b>UBAH PASSWORD</b></h5>
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
        <form action="<?php echo base_url('auth/change_password'); ?>" method="post">
          <div class="input-group mb-3">
            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Password Baru" 
                  title="Password Baru harus minimal 8 karakter, gabungan antara angka dan huruf." 
                  required 
                  pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" 
                  oninvalid="this.setCustomValidity('Password Baru harus minimal 8 karakter, gabungan antara angka dan huruf.')"
                  oninput="setCustomValidity('')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" 
                  title="Konfirmasi Password Baru harus minimal 8 karakter, gabungan antara angka dan huruf." 
                  required 
                  pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" 
                  oninvalid="this.setCustomValidity('Konfirmasi Password Baru harus minimal 8 karakter, gabungan antara angka dan huruf.')"
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
                <input type="checkbox" id="showNewPassword" onchange="toggleNewPassword()">
                <label for="showNewPassword">Tampilkan Password</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-block" style="background-color: #015F29; color: white;">Simpan Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleNewPassword() {
      const checkbox = document.getElementById('showNewPassword');
      const newPasswordField = document.getElementById('new_password');
      const confirmPasswordField = document.getElementById('confirm_password');

      if (checkbox.checked) {
          newPasswordField.type = 'text';
          confirmPasswordField.type = 'text';
      } else {
          newPasswordField.type = 'password';
          confirmPasswordField.type = 'password';
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var alertElement = document.querySelector(".alert");

        if (alertElement) {
            setTimeout(function() {
                alertElement.style.opacity = 0;
                setTimeout(function() {
                    alertElement.style.display = "none";
                }, 1000);
            }, 4000);

            var closeButton = alertElement.querySelector(".close");
            if (closeButton) {
                closeButton.addEventListener("click", function() {
                    alertElement.style.display = "none";
                });
            }
        }
    });
  </script>
</body>
