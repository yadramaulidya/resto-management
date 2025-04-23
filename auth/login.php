<?php 
session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit();
}
?>

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
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Form login -->
    <form action="login_auth.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p class="mt-3">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>
</div>
<!-- /Login -->
<?php include(".layouts/footer.php"); ?>