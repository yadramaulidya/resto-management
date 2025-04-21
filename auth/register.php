<?php include(".layouts/header.php"); ?>
<!-- Register Card -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"></span>
        <span class="app-brand-text demo text-uppercase fw-bolder">BiteNest 🍖</span>
      </a>
    </div>
    
    <!-- /Logo -->
    <form action="register_process.php" class="mb-3" method="POST">
      <div class="mb-3">
        <label for="kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" name="kontak" placeholder="Masukkan kontak" autofocus required />
      </div>

      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required />
      </div>

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Buat username" required />
      </div>

      <div class="mb-3 form-password-toggle">
        <label class="form-label" for="password">Password</label>
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>

      <button class="btn btn-primary d-grid w-100">Daftar</button>
    </form>

    <p class="text-center">
      <span>Sudah punya akun?</span>
      <a href="login.php"><span> Mari masuk</span></a>
    </p>
  </div>
</div>
<!-- Register Card -->
<?php include(".layouts/footer.php"); ?>