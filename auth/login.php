<?php include(".layouts/header.php"); ?>
<!-- Login -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder"> BiteNest 🍖</span>
      </a>
    </div>
    <!-- /Logo -->
    <h4 class="mb-2">Laper? Masuk dulu, baru pilih menu favorit kamu! </h4>

    <!-- Cek apakah ada notifikasi -->
    <?php if (isset($_SESSION['notification'])): ?>
      <div class="alert alert-<?php echo $_SESSION['notification']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['notification']['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['notification']); ?> <!-- Hapus notifikasi setelah ditampilkan -->
    <?php endif; ?>

    <!-- Form Login -->
    <form class="mb-3" action="login_auth.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Masukkan username" autofocus required />
      </div>

      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password</label>
        </div>
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>

      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
      </div>
    </form>

    <p class="text-center">
      <span>Belum jadi bagian dari BiteNest 🍖?</span><a href="register.php"><span> Daftar yuk</span></a>
    </p>
  </div>
</div>
<!-- /Login -->
<?php include(".layouts/footer.php"); ?>