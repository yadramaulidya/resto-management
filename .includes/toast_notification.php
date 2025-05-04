<!-- Bootstrap Toast -->
<?php if ($notification): ?>
  <div id="notifikasi" class="bs-toast toast fade position-absolute m-3 end-0 bg-custom-brown" role="alert" data-bs-autohide="true">
    <div class="toast-header" style="background-color: #8B4513; color: white;">
      <i class="bx bx-bell me-2"></i>
      <strong class="me-auto"><?= $notification['title'] ?? 'Notifikasi' ?></strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?= $notification['message'] ?>
    </div>
  </div>
<?php endif; ?>

<!-- CSS Kustom untuk Toast Berwarna Coklat -->
<style>
  .bg-custom-brown {
      background-color: #8B4513 !important;
      color: white !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('notifikasi');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>