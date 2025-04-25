<?php
    $tax = $subTotal * 0.1; // 10% PPN
    $total = $subTotal + $tax;
?>

<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Cart Items -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <!-- Cart Header - Desktop -->
          <div class="hidden md:grid grid-cols-6 bg-gray-100 p-4 font-medium text-gray-600">
            <div class="col-span-3">Produk</div>
            <div class="text-center">Harga</div>
            <div class="w-32 text-center">Jumlah</div>
            <div class="text-right">Total</div>
          </div>
          
          <!-- Cart Items List -->
          <div class="divide-y divide-gray-200">
            <?php foreach ($cartItems as $id => $item): ?>
              <div class="p-4 hover:bg-gray-50">
                <!-- Mobile View -->
                <div class="md:hidden flex flex-col space-y-3">
                  <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                      <button class="cursor-pointer text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                      </button>
                      <button class="cursor-pointer text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-pencil-alt"></i>
                      </button>
                      <?php if ($item['image']): ?>
                        <img src="/uploads/menu/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-16 h-16 object-cover rounded">
                      <?php else: ?>
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                          <i class="fas fa-utensils text-gray-400"></i>
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="font-medium text-gray-800">
                      Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                    </div>
                  </div>
                  
                  <div class="pl-10">
                    <h3 class="font-medium text-gray-800"><?= $item['name'] ?></h3>
                    <?php if (!empty($item['notes'])): ?>
                      <p class="text-sm text-gray-500 mt-1">Catatan: <?= $item['notes'] ?></p>
                    <?php endif; ?>
                  </div>
                  
                  <div class="flex justify-between items-center pl-10">
                    <div class="text-gray-700">
                      Rp <?= number_format($item['price'], 0, ',', '.') ?> × <?= $item['quantity'] ?>
                    </div>
                  </div>
                </div>
                
                <!-- Desktop View -->
                <div class="hidden md:flex flex-col md:grid md:grid-cols-6 gap-4 items-center">
                  <!-- Product Image & Name -->
                  <div class="cursor-pointer md:col-span-3 flex items-center space-x-4">
                    <button class="text-red-500 hover:text-red-700">
                      <i class="fas fa-trash"></i>
                    </button>
                    <button class=" text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-pencil-alt"></i>
                      </button>
                    <?php if ($item['image']): ?>
                      <img src="/uploads/menu/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-16 h-16 object-cover rounded">
                    <?php else: ?>
                      <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                        <i class="fas fa-utensils text-gray-400"></i>
                      </div>
                    <?php endif; ?>
                    <div>
                      <h3 class="font-medium text-gray-800"><?= $item['name'] ?></h3>
                      <?php if (!empty($item['notes'])): ?>
                        <p class="text-sm text-gray-500 mt-1">Catatan: <?= $item['notes'] ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                  
                  <!-- Price -->
                  <div class="text-center text-gray-700">
                    Rp <?= number_format($item['price'], 0, ',', '.') ?>
                  </div>
                  
                  <!-- Quantity -->
                  <div class="w-32 text-center">
                    <?= $item['quantity'] ?>
                  </div>
                  
                  <!-- Total -->
                  <div class="text-right font-medium text-gray-800">
                    Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      
      <!-- Order Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-4">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>
          
          <div class="space-y-4 flex flex-col">
            <div class="flex justify-between">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-medium">Rp <?= number_format($subTotal, 0, ',', '.') ?></span>
            </div>
            
            <div class="flex justify-between">
              <span class="text-gray-600">PPN (10%)</span>
              <span class="font-medium">Rp <?= number_format($tax, 0, ',', '.') ?></span>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
              <div class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
              </div>
            </div>
            
            <a href="/payment" id="pay-button" class="w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition-colors mt-6">
              Lanjut ke Pembayaran
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>