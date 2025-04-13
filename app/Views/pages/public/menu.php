<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-dvh flex flex-col bg-amber-50">
  <!-- Header -->
  <header class="bg-amber-600 text-white shadow-md sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
      <h1 class="text-xl font-bold text-center">Menu Kami</h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-6 flex-1">
    <!-- Category Tabs -->
    <div class="flex overflow-x-auto mb-6 pb-2 gap-2">
      <button class="px-4 py-2 bg-amber-100 text-amber-800 rounded-full whitespace-nowrap font-medium">Semua</button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full whitespace-nowrap">Makanan</button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full whitespace-nowrap">Minuman</button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full whitespace-nowrap">Snack</button>
    </div>

    <!-- Menu Items Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <!-- Menu Item 1 -->
      <div class="card hover:shadow-lg transition-shadow">
        <div class="relative h-40 bg-gray-200 rounded-t-lg overflow-hidden">
          <!-- Replace with actual image -->
          <div class="absolute inset-0 flex items-center justify-center text-gray-400">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
        <div class="p-4 bg-white rounded-b-lg">
          <div class="flex justify-between items-start">
            <h3 class="font-bold text-gray-800">Nasi Goreng Spesial</h3>
            <span class="font-bold text-amber-600">Rp 25.000</span>
          </div>
          <p class="text-sm text-gray-500 mt-1">Nasi goreng dengan telur, ayam, dan sayuran</p>
          <button class="mt-3 w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-medium transition-colors">
            + Tambahkan
          </button>
        </div>
      </div>

      <!-- Menu Item 2 -->
      <div class="card hover:shadow-lg transition-shadow">
        <div class="relative h-40 bg-gray-200 rounded-t-lg overflow-hidden">
          <!-- Replace with actual image -->
          <div class="absolute inset-0 flex items-center justify-center text-gray-400">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
        <div class="p-4 bg-white rounded-b-lg">
          <div class="flex justify-between items-start">
            <h3 class="font-bold text-gray-800">Es Teh Manis</h3>
            <span class="font-bold text-amber-600">Rp 8.000</span>
          </div>
          <p class="text-sm text-gray-500 mt-1">Es teh dengan gula spesial</p>
          <button class="mt-3 w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-medium transition-colors">
            + Tambahkan
          </button>
        </div>
      </div>

      <!-- Add more menu items as needed -->
    </div>
  </main>

  <!-- Order Summary Floating Button -->
  <div class="fixed bottom-4 right-4">
    <button class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-full shadow-lg flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
      <span class="ml-1 font-medium">3 Items</span>
    </button>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-auto">
    <div class="container mx-auto px-4 text-center">
      <p class="text-xs">&copy; 2023 [Nama Usaha Anda]. All rights reserved.</p>
    </div>
  </footer>
</div>

<?= $this->endSection() ?>
