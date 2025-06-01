<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>

<div class="h-screen flex flex-col items-center justify-center text-center px-4">
  <i class="fas fa-circle-check text-green-700 text-9xl mb-6"></i>

  <h3 class="text-2xl font-semibold mb-4">Pembayaran Berhasil</h3>

  <?php if ($order['payment_method'] == "2"): ?>
    <p class="text-gray-600 mb-8">
      Terima kasih! Pesanan Anda sedang diproses. Mohon tunggu konfirmasi selanjutnya.
    </p>
  <?php else: ?>
    <p class="text-gray-600 mb-8">
      Terima kasih! Pesanan Anda telah kami terima. Silakan melakukan pembayaran di kasir dengan nomor order <strong><?= esc($order['transaction_code']) ?></strong>.
    </p>
  <?php endif; ?>

  <div class="flex flex-col gap-4">
    <a href="<?= base_url('payment/cetak-struk/' . esc($order['id'])) ?>" class="text-2xl bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 px-6 rounded-lg" target="_blank">
      Cetak Struk
    </a>
    <a href="<?= base_url('/') ?>" class="text-2xl transparent border border-amber-600 hover:bg-amber-700 text-amber-600 hover:text-white font-semibold py-3 px-6 rounded-lg">
      Kembali ke Beranda
    </a>

  </div>

</div>

<?= $this->endSection() ?>
