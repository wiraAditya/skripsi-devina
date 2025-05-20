<?= $this->extend('layouts/clear') ?>
<?= $this->section('content') ?>

<div class="w-[300px] mx-auto p-4 text-sm text-gray-800 font-mono" style="font-size: 12px;">
  <div class="text-center mb-4">
    <h1 class="font-bold text-lg">KORNER CIRCLE K</h1>
    <p class="text-xs">Jl raya dalung buduk</p>
    <p class="text-xs">Telepon: 082236812974</p>
    <hr class="my-2 border-gray-400">
  </div>
  
  <div class="mb-2">
    <div class="flex justify-between">
      <span>No. Transaksi:</span>
      <span><?= esc($order['transaction_code']) ?></span>
    </div>
    <div class="flex justify-between">
      <span>Tanggal:</span>
      <span><?= date('d/m/Y H:i', strtotime($order['tanggal'])) ?></span>
    </div>
    <div class="flex justify-between">
      <span>Jenis Pembayaran:</span>
      <span><?=$order['payment_method_text'] ?></span>
    </div>
  </div>

  <hr class="my-2 border-gray-400">

  <div class="mb-2">
    <?php foreach ($orderDetails as $detail): ?>
      <div class="flex justify-between">
        <div class="flex-1">
          <p><?= esc($detail['menu_name']) ?></p>
          <p class="text-xs text-gray-600"><?= esc($detail['qty']) ?> x <?= number_format($detail['harga'], 0, ',', '.') ?></p>
        </div>
        <div>
          <p><?= number_format($detail['qty'] * $detail['harga'], 0, ',', '.') ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <hr class="my-2 border-gray-400">

  <div class="mb-2">
    <div class="flex justify-between">
      <span>Subtotal</span>
      <span><?= number_format($order['total'] - $order['tax'], 0, ',', '.') ?></span>
    </div>
    <div class="flex justify-between">
      <span>PPN</span>
      <span><?= number_format($order['tax'], 0, ',', '.') ?></span>
    </div>
    <div class="flex justify-between font-bold">
      <span>Total</span>
      <span><?= number_format($order['total'], 0, ',', '.') ?></span>
    </div>
  </div>

  <hr class="my-2 border-gray-400">

  <div class="text-center mt-4">
    <p><?=$order['payment_method'] === 'payment_cash' ? 'Silakan menuju kasir untuk melanjutkan proses pembayaran' : 'Selakan menunggu makanan anda untuk siap disajikan'?></p>
    <p>Terima Kasih</p>
    <p>Sudah Berbelanja</p>
  </div>
</div>

<script>
  window.onload = function() {
    window.print();

    window.onafterprint = function() {
      window.close();
    };
  };
</script>

<?= $this->endSection() ?>
