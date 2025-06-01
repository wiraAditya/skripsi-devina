<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-dvh flex flex-col bg-gray-100">
  <!-- Header - Kiosk Style -->
  <header class="bg-amber-600 text-white shadow-md sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center">
        <img class="mx-auto rounded-full mr-2 h-16 w-16" src="/uploads/logo.png" alt="logo">

        <h1 class="text-xl font-bold"><?= $title ?></h1>
      </div>
      <div class="flex items-center">
        <a href="/cart" class="cursor-pointer bg-yellow-400 text-black px-4 py-2 rounded-full font-bold flex items-center">
          <i class="fas fa-shopping-cart mr-2"></i>
          <span class="cart-count"><?=$cart?></span>
        </a>
      </div>
    </div>
  </header>

  <!-- Category Navigation - Kiosk Style -->
  <?= view('components/home/category_pills') ?>


  <!-- Main Content - Kiosk Grid Layout -->
  <main class="container mx-auto px-4 py-6 flex-1">
    <?php if (session()->has('success')): ?>
        <div class="fixed top-16 right-4 z-50">
            <div class="bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
                <?= session('success') ?>
            </div>
        </div>
        <script>
            // Auto-hide after 3 seconds
            setTimeout(() => {
                document.querySelector('.fixed.top-16.right-4').remove();
            }, 3000);
        </script>
    <?php endif; ?>
    <!-- Menu Items Grid - Kiosk Style -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach($menus as $item): ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
          <!-- Image Container -->
          <div class="relative h-48 bg-gray-100 overflow-hidden">
            <?php if(!empty($item['gambar'])): ?>
              <img src="/uploads/menu/<?= esc($item['gambar']) ?>"
                   alt="<?= esc($item['nama']) ?>"
                   class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
            <?php else: ?>
              <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-200">
                <i class="fas fa-utensils text-5xl"></i>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Item Details -->
          <div class="p-4">
            <div class="flex justify-between items-start mb-2">
              <h3 class="font-bold text-gray-800 text-lg truncate"><?= esc($item['nama']) ?></h3>
            </div>
            
            <p class="text-sm text-gray-500"><?= esc($item['nama_kategori']) ?></p>
            <p  class="mb-4 font-bold text-amber-600 whitespace-nowrap">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
            <!-- Kiosk-style Add Button -->
            <button class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-lg font-bold transition-colors flex items-center justify-center add-to-cart-btn"
                    data-id="<?= $item['id'] ?>"
                    data-name="<?= esc($item['nama']) ?>"
                    data-price="<?= $item['harga'] ?>"
                    data-icon="fa-utensils"
                    data-image="<?= $item['gambar'] ?? '-' ?>"
                    aria-label="Tambahkan <?= esc($item['nama']) ?> ke pesanan">
                <i class="fas fa-plus mr-1" aria-hidden="true"></i> Tambahkan
            </button>
          </div>
        </div>
      <?php endforeach; ?>
      
      <?php if(empty($menus)): ?>
        <div class="col-span-full text-center py-12">
          <div class="text-gray-400 mb-4">
            <i class="fas fa-utensils text-5xl"></i>
          </div>
          <p class="text-gray-500 text-lg">Tidak ada menu yang tersedia saat ini</p>
        </div>
      <?php endif; ?>
    </div>
  </main>
  <?= view('components/home/add_to_cart_modal') ?>
  <!-- Footer - Simplified -->
  <footer class="bg-gray-800 text-white py-3 mt-auto">
    <div class="container mx-auto px-4 text-center text-xs">
      <p>&copy; <?= date('Y') ?> KORNER CIRCLE K. All rights reserved.</p>
    </div>
  </footer>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Open modal when "Tambahkan" is clicked
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const modal = document.getElementById('addToCartModal');
        
        // Set form values
        document.getElementById('modalMenuId').value = this.dataset.id;
        document.getElementById('modalMenuName').textContent = this.dataset.name;
        document.getElementById('modalMenuNameInput').value = this.dataset.name;
        document.getElementById('modalMenuPrice').value = this.dataset.price;
        document.getElementById('modalMenuImageInput').value = this.dataset.image;
        
        // Set image display
        const imgElement = document.getElementById('modalMenuImage');
        const imgContainer = document.getElementById('modalMenuImage').parentElement;
        const iconElement = imgContainer.querySelector('i');
        
        if (iconElement) {
            iconElement.remove();
        }

        if (this.dataset.image && this.dataset.image !== '-') {
            imgElement.src = `/uploads/menu/${this.dataset.image}`;
            imgElement.alt = this.dataset.name;
            imgElement.classList.remove('hidden');
        } else {
            imgElement.classList.add('hidden');
            imgContainer.insertAdjacentHTML('beforeend',
                `<i class="fas ${this.dataset.icon} text-2xl text-gray-400"></i>`);
        }
        
        // Reset quantity and notes
        document.getElementById('quantity').value = 1;
        document.getElementById('notes').value = '';
        
        modal.classList.remove('hidden');
    });
});
    
    
});
</script>
<?= $this->endSection() ?>
