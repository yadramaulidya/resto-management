<?php include(".layouts/header.php"); ?>
<!-- Register -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder"> BiteNest 🍖</span>
      </a>
    </div>
    <!-- /Logo -->
    <h4 class="mb-2">laper? masuk dulu, baru pilih menu favorit kamu! </h4>
    <form class="mb-3" action="login_auth.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama"
          placeholder="isi nama kamu ya.." autofocus required />
      </div>
      <div class="mb-3">
        <label class="form-label">Isi Kontak </label>
        <input type="text" class="form-control" name="kontak"
          placeholder="nomor kontak dulu ya.." required />
      </div>
      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password dulu, baru kita mulai</label>
        </div>
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password" required />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
      </div>
    </form>
    <p class="text-center">
      <span>Belum jadi bagian dari BiteNest 🍖?</span><a href="register.php"><span> daftar yuk</span></a>
    </p>
  </div>
</div>
<!-- /Register -->
<?php include(".layouts/footer.php"); ?>