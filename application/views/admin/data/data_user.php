<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data User</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <?php
                                $flashMessage = $this->session->flashdata('pesan');
                                if ($flashMessage) {
                                    echo $flashMessage;
                                }
                            ?>
                            <button class="btn btn-sm btn-primary text-left mr-1 mb-2" data-toggle="modal" data-target="#tambah_pengguna">
                                <i class="fas fa-plus fa-sm"></i> Tambah User
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#mahasiswa" data-toggle="tab" data-type="mahasiswa">Mahasiswa</a></li>
                                <li class="nav-item"><a class="nav-link" href="#dosen" data-toggle="tab" data-type="dosen">Dosen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tendik" data-toggle="tab" data-type="tendik">Tendik</a></li>
                            </ul>
                            <hr>
                            <div class="tab-content">
                                <!-- Tab Mahasiswa -->
                                <div class="tab-pane active" id="mahasiswa">
                                    <h3>Mahasiswa</h3>
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr style="background-color: #015F29; color: white;">
                                                <th>No</th>
                                                <th>ID User</th>
                                                <th>Nama Lengkap</th>
                                                <th>Fakultas</th>
                                                <th>Program Studi</th>
                                                <th>Email</th>
                                                <th>Reset Password</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            foreach ($pengguna_mahasiswa as $user) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($user->id_user, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->fakultas, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->prodi, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm resetPasswordBtn" data-id="<?php echo $user->id_user; ?>">Reset</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm deleteUserBtn" data-id="<?php echo $user->id_user; ?>">Hapus</button>
                                                    
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tab Dosen -->
                                <div class="tab-pane" id="dosen">
                                    <h3>Dosen</h3>
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr style="background-color: #015F29; color: white;">
                                                <th>No</th>
                                                <th>ID User</th>
                                                <th>Nama Lengkap</th>
                                                <th>Fakultas</th>
                                                <th>Program Studi</th>
                                                <th>Email</th>
                                                <th>Reset Password</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            foreach ($pengguna_dosen as $user) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($user->id_user, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->fakultas, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->prodi, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm resetPasswordBtn" data-id="<?php echo $user->id_user; ?>">Reset</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm deleteUserBtn" data-id="<?php echo $user->id_user; ?>">Hapus</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tab Tendik -->
                                <div class="tab-pane" id="tendik">
                                    <h3>Tendik</h3>
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr style="background-color: #015F29; color: white;">
                                                <th>No</th>
                                                <th>ID User</th>
                                                <th>Nama Lengkap</th>
                                                <th>Fakultas</th>
                                                <th>Program Studi</th>
                                                <th>Email</th>
                                                <th>Reset Password</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            foreach ($pengguna_tendik as $user) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($user->id_user, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->fakultas, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->prodi, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm resetPasswordBtn" data-id="<?php echo $user->id_user; ?>">Reset</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm deleteUserBtn" data-id="<?php echo $user->id_user; ?>">Hapus</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambah_pengguna" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel"><b>Tambah Data Pengguna</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah" action="<?php echo base_url('admin/tambah'); ?>" method="post">
                    <input type="hidden" name="keterangan" id="keterangan" value="mahasiswa">
                    <div class="form-group">
                        <label>ID User</label>
                        <input type="text" name="id_user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Fakultas</label>
                        <select name="fakultas" id="fakultas" class="form-control" required onchange="updateProgramStudi()">
                            <option value="">Pilih Fakultas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi" id="programStudi" class="form-control" required>
                            <option value="">Pilih Program Studi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <p><strong>Note:</strong> Default password will be set to ID User.</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mereset password user ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmResetPasswordBtn" class="btn btn-warning">Reset Password</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus User -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserLabel">Hapus User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteUserBtn" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Fakultas data object
    const fakultasData = {
        "Fakultas Sains dan Informatika": ["Teknik Informatika S-1", "Sistem Informasi S-1", "Kimia S-1"],
        "Fakultas Teknik Metalurgi": ["Teknik Metalurgi S-1"],
        "Fakultas Teknik": ["Teknik Elektro S-1", "Teknik Kimia S-1", "Teknik Sipil S-1", 
                            "Magister Teknik Sipil S-2", "Teknik Geomatika S-1", "Teknik Mesin S-1", "Teknik Industri S-1"],
        "Fakultas Ekonomi dan Bisnis": ["Akuntansi S-1", "Manajemen S-1", "Magister Manajemen S-2"],
        "Fakultas Ilmu Sosial dan Ilmu Politik": ["Ilmu Pemerintahan S-1", "Ilmu Hub. Internasional S-1", 
                                                "Magister Hub. Internasional S-2", "Ilmu Hukum S-1", "Magister Ilmu Pemerintahan S-2"],
        "Fakultas Farmasi": ["Farmasi S-1", "Profesi Apoteker", "Magister Farmasi S-2"],
        "Fakultas Kedokteran": ["Pendidikan Dokter S-1", "Profesi Dokter"],
        "Fakultas Kedokteran Gigi": ["Kedokteran Gigi S-1", "Profesi Dokter Gigi"],
        "Fakultas Ilmu Teknologi Kesehatan": ["Administrasi Rumah Sakit S-1", "Magister Penuaan Kulit dan Estetika S-2", 
                                            "Magister Keperawatan S-2", "Profesi Ners", "Ilmu Keperawatan S-1", "Keperawatan D-3", 
                                            "Kesehatan Masyarakat S-1", "Teknologi Laboratorium Medis D-4", 
                                            "Teknologi Laboratorium Medis D-3", "Kebidanan S-1", "Profesi Bidan"],
        "Fakultas Psikologi": ["Psikologi S-1"]
    };

    // Function to update Program Studi options based on selected Fakultas
    function updateProgramStudi() {
        const fakultasSelect = document.getElementById('fakultas');
        const programStudiSelect = document.getElementById('programStudi');

        // Clear existing Program Studi options
        programStudiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

        // Get selected Fakultas
        const selectedFakultas = fakultasSelect.value;

        // Populate Program Studi options based on selected Fakultas
        if (fakultasData[selectedFakultas]) {
            fakultasData[selectedFakultas].forEach(program => {
                const option = document.createElement('option');
                option.value = program;
                option.textContent = program;
                programStudiSelect.appendChild(option);
            });
        }
    }

    // Populate Fakultas dropdown on page load
    document.addEventListener('DOMContentLoaded', function() {
        const fakultasSelect = document.getElementById('fakultas');
        for (const fakultas in fakultasData) {
            const option = document.createElement('option');
            option.value = fakultas;
            option.textContent = fakultas;
            fakultasSelect.appendChild(option);
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class `resetPasswordBtn`
            if (event.target.classList.contains('resetPasswordBtn')) {
                const userId = event.target.getAttribute('data-id');
                const resetUrl = `<?php echo base_url('admin/reset_password/'); ?>${userId}`;
                document.getElementById('confirmResetPasswordBtn').setAttribute('href', resetUrl);
                $('#resetPasswordModal').modal('show');
            }

            // Check if the clicked element has the class `deleteUserBtn`
            if (event.target.classList.contains('deleteUserBtn')) {
                const userId = event.target.getAttribute('data-id');
                const deleteUrl = `<?php echo base_url('admin/hapus_user/'); ?>${userId}`;
                document.getElementById('confirmDeleteUserBtn').setAttribute('href', deleteUrl);
                $('#deleteUserModal').modal('show');
            }
        });
    });

    if (event.target.classList.contains('resetPasswordBtn')) {
        const userId = event.target.getAttribute('data-id');
        console.log('Reset Password clicked for ID:', userId); // Debugging line
    }

    if (event.target.classList.contains('deleteUserBtn')) {
        const userId = event.target.getAttribute('data-id');
        console.log('Delete User clicked for ID:', userId); // Debugging line
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Save the clicked tab in local storage
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.getAttribute('href'));
            });
        });

        // Check if an active tab is saved in local storage
        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            // Show the saved tab and set it as active
            document.querySelector(`a[href="${activeTab}"]`).classList.add('active');
            document.querySelector(activeTab).classList.add('active');
        } else {
            // Default to the first tab if none is saved
            document.querySelector('a.nav-link').classList.add('active');
            document.querySelector('.tab-pane').classList.add('active');
        }

        // Event delegation for reset and delete buttons
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('resetPasswordBtn')) {
                const userId = event.target.getAttribute('data-id');
                const resetUrl = `<?php echo base_url('admin/reset_password/'); ?>${userId}`;
                document.getElementById('confirmResetPasswordBtn').setAttribute('href', resetUrl);
                $('#resetPasswordModal').modal('show');
            }

            if (event.target.classList.contains('deleteUserBtn')) {
                const userId = event.target.getAttribute('data-id');
                const deleteUrl = `<?php echo base_url('admin/hapus_user/'); ?>${userId}`;
                document.getElementById('confirmDeleteUserBtn').setAttribute('href', deleteUrl);
                $('#deleteUserModal').modal('show');
            }
        });
    });


</script>