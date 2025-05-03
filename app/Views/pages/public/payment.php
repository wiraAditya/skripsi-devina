<?php
    $tax = $subTotal * 0.1; // 10% PPN
    $total = $subTotal + $tax;
?>

<?= $this->extend('layouts/clear') ?>


<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="container mx-auto px-4 max-w-6xl">
    <!-- Checkout Progress Component -->
    <?= view('components/home/checkout_steps') ?>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Metode Pembayaran</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Payment Methods -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Pilih Metode Pembayaran</h2>
          
          <!-- Payment Options -->
          <div class="space-y-4">
            <!-- Cash Option -->
            <div class="payment-option">
              <input type="radio" id="cash" name="payment_method" value="cash" class="hidden peer" checked>
              <label for="cash" class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 peer-checked:border-amber-500 peer-checked:bg-amber-50">
                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-amber-500 peer-checked:bg-amber-500 flex items-center justify-center mr-4">
                  <i class="fas fa-check text-xs text-white peer-checked:block hidden"></i>
                </div>
                <i class="fas fa-money-bill-wave text-2xl text-gray-400 mr-4"></i>
                <div class="flex-1">
                  <h3 class="font-medium text-gray-800">Bayar di Kasir (Tunai)</h3>
                  <p class="text-sm text-gray-500">Lakukan pembayaran langsung ke kasir</p>
                </div>
              </label>
            </div>
            
            <!-- Payment Gateway Option -->
            <div class="payment-option">
              <input type="radio" id="gateway" name="payment_method" value="gateway" class="hidden peer">
              <label for="gateway" class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 peer-checked:border-amber-500 peer-checked:bg-amber-50">
                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-amber-500 peer-checked:bg-amber-500 flex items-center justify-center mr-4">
                  <i class="fas fa-check text-xs text-white peer-checked:block hidden"></i>
                </div>
                <i class="fas fa-credit-card text-2xl text-gray-400 mr-4"></i>
                <div class="flex-1">
                  <h3 class="font-medium text-gray-800">Pembayaran Digital</h3>
                  <p class="text-sm text-gray-500">Bayar sekarang dengan kartu atau e-wallet</p>
                </div>
              </label>
            </div>
            
          </div>
          
          <!-- Order Notes -->
          <div class="mt-8">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pesanan (Opsional)</label>
            <textarea id="notes" id="notes" name="notes" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-amber-500 focus:border-amber-500"></textarea>
          </div>
        </div>
      </div>
      
      <!-- Order Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-4">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>
          
          <div class="space-y-4 mb-6 text-sm">
          <?php foreach ($cartItems as $id => $item): ?>
            <div class="flex justify-between">
              <div class="flex flex-col">
                <span class="text-gray-600"><?=$item['name']?> x<?=$item['quantity']?></span>
                <span class=" text-gray-400 text-xs italic">catatan: <?=$item['notes']?></span>
              </div>
              <span class="font-medium">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
            </div>
          <?php endforeach; ?>

          </div>
          
          <div class="space-y-4 border-t border-gray-200 pt-4 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-medium">Rp <?= number_format($subTotal, 0, ',', '.') ?></span>
            </div>
            
            <div class="flex justify-between">
              <span class="text-gray-600">PPN (10%)</span>
              <span class="font-medium">Rp <?= number_format($tax, 0, ',', '.') ?></span>
            </div>
            
            <div class="flex justify-between font-bold text-lg mt-4">
              <span>Total</span>
              <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
            </div>
            
            <button id="submitPayment" type="button" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition-colors mt-6">
              Konfirmasi Pembayaran
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-F_W8rGGPgKe1RB8d"></script>

<script>
  
document.addEventListener('DOMContentLoaded', function() {
 
  
  // Submit payment
  document.getElementById('submitPayment').addEventListener('click', function() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (paymentMethod === 'gateway') {
      fetch('/cart/payment')
        .then(response => response.json())
        .then(data => {
            snap.pay(data.token, {
                onSuccess: function (result) {
                    // do insert DB
                    submitData('payment_digital');
                    console.log(result);
                },
                onPending: function (result) {
                    console.log(result);
                },
                onError: function (result) {
                    console.log(result);
                }
            });
        });
      
    } else {
      submitData('payment_cash');
    }
  });
  function submitData(kind) {
    console.log('kind', kind);
    const form = document.createElement('form');
      form.method = 'POST';
      form.action = `payment/process/${kind}`;
      const formData = new FormData();
      formData.append('notes', document.getElementById("notes").value);
      for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
      }

      // Append the form to the body
      document.body.appendChild(form);

      // Submit the form
      form.submit();
  }
});
</script>

<style>
.payment-option input:checked + label {
  border-color: #f59e0b;
  background-color: #fffbeb;
}
.payment-option input:checked + label div:first-child {
  background-color: #f59e0b;
  border-color: #f59e0b;
}
.payment-option input:checked + label div:first-child i {
  display: block;
}
.gateway-method.active {
  border-color: #f59e0b;
  background-color: #fffbeb;
}
</style>

<?= $this->endSection() ?>