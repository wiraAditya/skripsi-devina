<?php
    $cartItems = [
      '1' => [
        'id' => 1,
        'name' => 'Nasi Goreng Spesial',
        'price' => 25000,
        'image' => 'https://images.unsplash.com/photo-1631898034271-9a677e5727d2',
        'quantity' => 2,
        'notes' => 'Pedas level 2'
      ],
      '2' => [
        'id' => 2,
        'name' => 'Es Teh Manis',
        'price' => 8000,
        'image' => '',
        'quantity' => 1,
        'notes' => 'Kurang manis'
      ],
      '3' => [
        'id' => 3,
        'name' => 'Mie Ayam',
        'price' => 20000,
        'image' => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841',
        'quantity' => 1,
        'notes' => ''
      ]
    ];
    
    $subtotal = 0;
    foreach ($cartItems as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }
    $tax = $subtotal * 0.1; // 10% PPN
    $total = $subtotal + $tax;
?>

<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>
    
    <!-- Hardcoded Cart Data -->
    
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Cart Items -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <!-- Cart Header -->
          <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-medium text-gray-600">
            <div class="col-span-5">Produk</div>
            <div class="col-span-3 text-center">Harga</div>
            <div class="col-span-3 text-center">Jumlah</div>
            <div class="col-span-1 text-right">Total</div>
          </div>
          
          <!-- Cart Items List -->
          <div class="divide-y divide-gray-200">
            <?php foreach ($cartItems as $id => $item): ?>
              <div class="p-4 hover:bg-gray-50">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                  <!-- Product Image & Name -->
                  <div class="md:col-span-5 flex items-center space-x-4">
                    <button class="text-red-500 hover:text-red-700">
                      <i class="fas fa-times"></i>
                    </button>
                    <?php if ($item['image']): ?>
                      <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-16 h-16 object-cover rounded">
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
                  <div class="md:col-span-3 text-center text-gray-700">
                    Rp <?= number_format($item['price'], 0, ',', '.') ?>
                  </div>
                  
                  <!-- Quantity -->
                  <div class="md:col-span-3">
                    <div class="flex items-center justify-center space-x-2">
                      <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                        <i class="fas fa-minus text-xs"></i>
                      </button>
                      <div class="w-12 text-center border border-gray-300 rounded py-1 bg-gray-50">
                        <?= $item['quantity'] ?>
                      </div>
                      <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                        <i class="fas fa-plus text-xs"></i>
                      </button>
                    </div>
                  </div>
                  
                  <!-- Total -->
                  <div class="md:col-span-1 text-right font-medium text-gray-800">
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
          
          <div class="space-y-4">
            <div class="flex justify-between">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-medium">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
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
            
            <button class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition-colors mt-6">
              Lanjut ke Pembayaran
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>