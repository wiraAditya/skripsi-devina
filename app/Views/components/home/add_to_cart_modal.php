<div id="addToCartModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-col">
                    <!-- Menu Image -->
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-40 w-full  bg-gray-100">
                        <img id="modalMenuImage" src="" alt="" class="h-full w-full object-cover rounded-full">
                    </div>
                    
                    <!-- Menu Details -->
                    <div class="mt-4 text-left">
                        <h3 id="modalMenuName" class="text-lg leading-6 font-medium text-gray-900">title</h3>
                        <div class="mt-2">
                            <!-- Hidden Menu ID -->
                            <input type="hidden" id="modalMenuId" value="">
                            
                            <!-- Quantity Selector -->
                            <div class="mt-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <div class="mt-1 flex items-center">
                                    <button id="decrementQty" class="bg-gray-200 px-3 py-1 rounded-l-lg">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" 
                                           class="w-16 text-center border-t border-b border-gray-300 py-1">
                                    <button id="incrementQty" class="bg-gray-200 px-3 py-1 rounded-r-lg">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea id="notes" name="notes" rows="2" 
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmAddToCart" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Tambahkan ke Keranjang
                </button>
                <button type="button" id="cancelAddToCart" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.getElementById('incrementQty').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });
    
    document.getElementById('decrementQty').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });
    
    // Modal controls
    document.getElementById('cancelAddToCart').addEventListener('click', function() {
        document.getElementById('addToCartModal').classList.add('hidden');
    });
    
    // Close modal when clicking outside
    document.getElementById('addToCartModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>