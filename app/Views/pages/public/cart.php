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
            <?php foreach ($cartItems as $key => $item): ?>
              <div class="p-4 hover:bg-gray-50">
                <!-- Mobile View -->
                <div class="md:hidden flex flex-col space-y-3">
                  <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                      <a href="/cart/remove/<?= $key ?>" class="cursor-pointer text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                      </a>
                      <button class="edit-cart-item-btn cursor-pointer text-yellow-500 hover:text-yellow-700"
                              data-index="<?= $key ?>"
                              data-item='<?= json_encode($item) ?>'>
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
                    <a href="/cart/remove/<?= $key ?>" class="cursor-pointer text-red-500 hover:text-red-700">
                      <i class="fas fa-trash"></i>
                    </a>
                    <button class="edit-cart-item-btn text-yellow-500 hover:text-yellow-700"
                            data-index="<?= $key ?>"
                            data-item='<?= json_encode($item) ?>'>
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
        <p class="text-sm italic text-center mt-2 text-gray-400">
          <?= count($cartItems) ? "" : "Keranjang belanja anda masih kosong"?>
        </p>
        <div class="mt-8">

          <a class="px-4 py-2 mt-4 rounded-md bg-white border-2 border-amber-500 text-amber-500" href="/menu"><i class="fas fa-arrow-left"></i> Pilih menu </a>
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
            <?php if(count($cartItems)): ?>
            <a href="/payment" id="pay-button" class="w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition-colors mt-6">
              Lanjut ke Pembayaran
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Cart Modal -->
<div id="editCartModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="/cart/update">
                <input type="hidden" name="itemIndex" id="editItemIndex" value="">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex flex-col">
                        <!-- Menu Image -->
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-48 bg-gray-100 overflow-hidden">
                            <img id="editModalMenuImage" src="" alt="" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                        
                        <!-- Menu Details -->
                        <div class="mt-4 text-left">
                            <h3 id="editModalMenuName" class="text-lg leading-6 font-medium text-gray-900">-</h3>
                            <div class="mt-2">
                                <!-- Hidden Menu ID -->
                                <input type="hidden" id="editModalMenuId" name="itemId" value="">
                                <input type="hidden" id="editModalMenuNameInput" name="name" value="">
                                <input type="hidden" id="editModalMenuPrice" name="price" value="">
                                <input type="hidden" id="editModalMenuImageInput" name="image" value="">
                                
                                <!-- Quantity Selector -->
                                <div class="mt-4">
                                    <label for="editQuantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                    <div class="mt-1 flex items-center">
                                        <button type="button" id="editDecrementQty" class="bg-gray-200 px-3 py-1 rounded-l-lg">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="editQuantity" name="quantity" min="1" value="1" 
                                            class="w-16 text-center border-t border-b border-gray-300 py-1">
                                        <button type="button" id="editIncrementQty" class="bg-gray-200 px-3 py-1 rounded-r-lg">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Notes -->
                                <div class="mt-4">
                                    <label for="editNotes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea id="editNotes" name="notes" rows="2" 
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Update Item
                    </button>
                    <button type="button" id="cancelEditCart"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editCartModal');
    
    // Handle edit cart item button clicks
    document.querySelectorAll('.edit-cart-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemData = JSON.parse(this.dataset.item);
            
            // Set form values
            document.getElementById('editItemIndex').value = this.dataset.index;
            document.getElementById('editModalMenuId').value = itemData.id;
            document.getElementById('editModalMenuName').textContent = itemData.name;
            document.getElementById('editModalMenuNameInput').value = itemData.name;
            document.getElementById('editModalMenuPrice').value = itemData.price;
            document.getElementById('editModalMenuImageInput').value = itemData.image || '';
            document.getElementById('editQuantity').value = itemData.quantity;
            document.getElementById('editNotes').value = itemData.notes || '';
            
            // Set image display
            const imgElement = document.getElementById('editModalMenuImage');
            const imgContainer = imgElement.parentElement;
            const iconElement = imgContainer.querySelector('i');
            
            if (iconElement) {
                iconElement.remove();
            }

            if (itemData.image && itemData.image !== '-') {
                imgElement.src = `/uploads/menu/${itemData.image}`;
                imgElement.alt = itemData.name;
                imgElement.classList.remove('hidden');
            } else {
                imgElement.classList.add('hidden');
                imgContainer.insertAdjacentHTML('beforeend',
                    `<i class="fas fa-utensils text-2xl text-gray-400"></i>`);
            }
            
            editModal.classList.remove('hidden');
        });
    });
    
    // Handle cancel
    document.getElementById('cancelEditCart').addEventListener('click', function() {
        editModal.classList.add('hidden');
    });
    
    // Quantity controls
    document.getElementById('editIncrementQty').addEventListener('click', function() {
        const quantityInput = document.getElementById('editQuantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });
    
    document.getElementById('editDecrementQty').addEventListener('click', function() {
        const quantityInput = document.getElementById('editQuantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });
});
</script>
<?= $this->endSection() ?>