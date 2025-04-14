<?php
$menuItems = [
  [
      'id' => 1,
      'name' => 'Nasi Goreng Spesial',
      'price' => 25000,
      'description' => 'Nasi goreng dengan telur, ayam, dan sayuran',
      'category' => 'Makanan',
      'icon' => 'fa-utensils'
  ],
  [
      'id' => 2,
      'name' => 'Es Teh Manis',
      'price' => 8000,
      'description' => 'Es teh dengan gula spesial',
      'category' => 'Minuman',
      'icon' => 'fa-coffee'
  ],
  // Add more menu items as needed
];
$selectedPils = $_GET['filter'] ?? 'semua';
$pils = ["Semua", "Makanan", "Minuman", "Snack"]; // Define if not already in controller
?>

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
    <!-- Category Pills Component -->
    <?= view('components/home/category_pills', [
        'pils' => $pils,
        'selectedPils' => $selectedPils,
        'baseUrl' => '/menu' // Optional if you want to customize the base URL
    ]) ?>

    <!-- Rest of your content remains the same -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" >
      <?php foreach($menuItems as $item): ?>
        <?php if($selectedPils === 'semua' || strtolower($item['category']) === $selectedPils): ?>
        <div class="card hover:shadow-lg transition-shadow" >
          <div class="relative h-40 bg-gray-200 rounded-t-lg overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
              <i class="fas <?= $item['icon'] ?> text-4xl" aria-hidden="true"></i>
            </div>
          </div>
          <div class="p-4 bg-white rounded-b-lg">
            <div class="flex justify-between items-start">
              <h3 class="font-bold text-gray-800"><?= $item['name'] ?></h3>
              <span class="font-bold text-amber-600">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
            </div>
            <p class="text-sm text-gray-500 mt-1"><?= $item['description'] ?></p>
            <button class="mt-3 w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-medium transition-colors add-to-cart-btn"
                    data-id="<?= $item['id'] ?>"
                    data-name="<?= $item['name'] ?>"
                    data-icon="<?= $item['icon'] ?>"
                    data-image="<?= $item['image_url'] ?? '' ?>"
                    aria-label="Tambahkan <?= $item['name'] ?> ke pesanan">
                <i class="fas fa-plus mr-1" aria-hidden="true"></i> Tambahkan
            </button>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Footer and other elements -->
  <div class="fixed bottom-4 right-4">
    <button class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-full shadow-lg flex items-center justify-center"
            aria-label="3 items in cart">
      <i class="fas fa-shopping-cart" aria-hidden="true"></i>
      <span class="ml-2 font-medium">3 <span class="sr-only">items in cart</span></span>
    </button>
  </div>
  <?= view('components/home/add_to_cart_modal') ?>
  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-auto">
    <div class="container mx-auto px-4 text-center">
      <p class="text-xs">&copy; <?= date('Y') ?> Nama Usaha Anda. All rights reserved.</p>
    </div>
  </footer>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Open modal when "Tambahkan" is clicked
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const modal = document.getElementById('addToCartModal');
            document.getElementById('modalMenuId').value = this.dataset.id;
            document.getElementById('modalMenuName').textContent = this.dataset.name;
            console.log('dataset', this.dataset);
            // Set image if available
            const imgElement = document.getElementById('modalMenuImage');
            const imgContainer = document.getElementById('modalMenuImage').parentElement;

            // Remove any existing icon first
            const iconElement = imgContainer.querySelector('i');
            if (iconElement) {
                iconElement.remove();
            }

            if (this.dataset.image) {
                // Show image
                imgElement.src = this.dataset.image;
                imgElement.alt = this.dataset.name;
                imgElement.classList.remove('hidden');
            } else {
                // Hide image
                imgElement.classList.add('hidden');
                // Add new icon (we've already removed any existing one)
                imgContainer.insertAdjacentHTML('beforeend',
                    `<i class="fas ${this.dataset.icon} text-2xl text-gray-400"></i>`);
            }
            
            // Reset quantity and notes
            document.getElementById('quantity').value = 1;
            document.getElementById('notes').value = '';
            
            modal.classList.remove('hidden');
        });
    });
    
    // Handle form submission
    document.getElementById('confirmAddToCart').addEventListener('click', function() {
        const itemId = document.getElementById('modalMenuId').value;
        const quantity = document.getElementById('quantity').value;
        const notes = document.getElementById('notes').value;
        
        // Here you would typically send this data to your server
        console.log('Adding to cart:', { itemId, quantity, notes });
        
        // Close modal
        document.getElementById('addToCartModal').classList.add('hidden');
        
        // Show success message (optional)
        alert('Item berhasil ditambahkan ke keranjang!');
    });
});
</script>
<?= $this->endSection() ?>
