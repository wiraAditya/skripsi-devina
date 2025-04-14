<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="container mx-auto px-4 max-w-4xl">
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
            
            <!-- Payment Gateway Selection -->
            <div id="gatewayOptions" class="hidden bg-gray-50 p-4 rounded-lg mt-4">
              <h4 class="font-medium text-gray-700 mb-3">Pilih Metode Pembayaran:</h4>
              <div class="grid grid-cols-1 gap-3">
                <button type="button" class="gateway-method flex items-center p-3 border border-gray-300 rounded-lg hover:border-amber-500">
                  <img src="https://logo.clearbit.com/midtrans.com" alt="Midtrans" class="h-8 w-8 object-contain mr-3">
                  <span class="font-medium">Midtrans</span>
                </button>
                <button type="button" class="gateway-method flex items-center p-3 border border-gray-300 rounded-lg hover:border-amber-500">
                  <img src="https://logo.clearbit.com/gopay.com" alt="Gopay" class="h-8 w-8 object-contain mr-3">
                  <span class="font-medium">Gopay</span>
                </button>
                <button type="button" class="gateway-method flex items-center p-3 border border-gray-300 rounded-lg hover:border-amber-500">
                  <img src="https://logo.clearbit.com/ovo.id" alt="OVO" class="h-8 w-8 object-contain mr-3">
                  <span class="font-medium">OVO</span>
                </button>
                <button type="button" class="gateway-method flex items-center p-3 border border-gray-300 rounded-lg hover:border-amber-500">
                  <img src="https://logo.clearbit.com/dana.id" alt="DANA" class="h-8 w-8 object-contain mr-3">
                  <span class="font-medium">DANA</span>
                </button>
              </div>
            </div>
          </div>
          
          <!-- Order Notes -->
          <div class="mt-8">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pesanan (Opsional)</label>
            <textarea id="notes" name="notes" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-amber-500 focus:border-amber-500"></textarea>
          </div>
        </div>
      </div>
      
      <!-- Order Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-4">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>
          
          <div class="space-y-4 mb-6">
            <div class="flex justify-between">
              <span class="text-gray-600">Nasi Goreng Spesial × 2</span>
              <span class="font-medium">Rp 50.000</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Es Teh Manis × 1</span>
              <span class="font-medium">Rp 8.000</span>
            </div>
          </div>
          
          <div class="space-y-4 border-t border-gray-200 pt-4">
            <div class="flex justify-between">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-medium">Rp 58.000</span>
            </div>
            
            <div class="flex justify-between">
              <span class="text-gray-600">PPN (10%)</span>
              <span class="font-medium">Rp 5.800</span>
            </div>
            
            <div class="flex justify-between font-bold text-lg mt-4">
              <span>Total</span>
              <span>Rp 63.800</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle payment gateway options
  const gatewayRadio = document.getElementById('gateway');
  const gatewayOptions = document.getElementById('gatewayOptions');
  const radios = document.querySelectorAll('input[name="payment_method"]');
  
  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      console.log('You selected:', radio.value);
      if(radio.value === "gateway") {
        gatewayOptions.classList.remove('hidden');
      } else {
        gatewayOptions.classList.add('hidden');
      }
    });
  });
  
  // Handle payment method selection
  document.querySelectorAll('.gateway-method').forEach(button => {
    button.addEventListener('click', function() {
      document.querySelectorAll('.gateway-method').forEach(btn => {
        btn.classList.remove('border-amber-500', 'bg-amber-50');
      });
      this.classList.add('border-amber-500', 'bg-amber-50');
    });
  });
  
  // Submit payment
  document.getElementById('submitPayment').addEventListener('click', function() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (paymentMethod === 'gateway') {
      const selectedGateway = document.querySelector('.gateway-method.border-amber-500');
      if (!selectedGateway) {
        alert('Silakan pilih metode pembayaran digital');
        return;
      }
      alert('Anda akan diarahkan ke halaman pembayaran digital');
    } else {
      alert('Pesanan Anda telah diterima. Silakan siapkan pembayaran saat pesanan datang.');
    }
  });
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