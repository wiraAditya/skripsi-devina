<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-dvh flex flex-col ">
  <!-- Header -->
  <header class="bg-amber-600 text-white shadow-md">
    <div class="container mx-auto px-4 py-4 md:py-6">
      <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-center">Selamat Datang di [Nama Usaha Anda]!</h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-6 md:py-8 max-w-3xl flex-1">
    <div class="card">
      <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4 text-center">
        Pesan, Bayar, Nikmati - Cepat & Praktis!
      </h2>
      <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 text-center">
        Langsung pilih menu favoritmu, bayar online atau tunai, dan makanan/minuman siap disajikan. 
        Tanpa ribet, tanpa antri!
      </p>

      <div class="bg-amber-50 border-l-4 border-amber-500 p-3 md:p-4 mb-4 md:mb-6">
        <h3 class="font-semibold text-gray-800 mb-1 md:mb-2">🍟 Cara Pesan:</h3>
        <ol class="list-decimal list-inside space-y-1 text-sm md:text-base text-gray-700">
          <li><span class="font-medium">Pilih Menu</span> - Cari yang kamu suka dari daftar kami</li>
          <li><span class="font-medium">Bayar</span> - Transfer atau tunai di kasir</li>
          <li><span class="font-medium">Tunggu & Nikmati</span> - Pesananmu akan segera dibuat</li>
        </ol>
      </div>

      <div class="text-center">
        <a href="/menu" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-medium md:font-bold py-2 px-6 md:py-3 md:px-8 rounded-lg shadow-md transition duration-300 transform hover:scale-105 text-sm md:text-base">
          Pilih Menu Sekarang
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 md:py-6 mt-auto">
    <div class="container mx-auto px-4 text-center">
      <p class="text-xs md:text-sm">&copy; 2023 [Nama Usaha Anda]. All rights reserved.</p>
    </div>
  </footer>
</div>
<?= $this->endSection() ?>
