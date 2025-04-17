<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Menu</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/admin/menu/update/<?= $menu['id'] ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama Menu -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                <input type="text" name="nama" id="nama" value="<?= old('nama', $menu['nama']) ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama menu">
            </div>
            <!-- Kategori -->
            <div>
                <label for="idKategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="idKategori" id="idKategori" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategories as $kategori): ?>
                        <option value="<?= $kategori['id'] ?>" <?= (old('idKategori', $menu['idKategori']) == $kategori['id']) ? 'selected' : '' ?>>
                            <?= esc($kategori['kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Harga -->
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="harga" id="harga" value="<?= old('harga', $menu['harga']) ?>" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan harga">
            </div>
            
            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Menu</label>
                
                <div class="flex items-center mb-2">
                    <img src="/uploads/menu/<?= esc($menu['gambar']) ?>" alt="<?= esc($menu['nama']) ?>" class="h-16 w-16 rounded object-cover mr-4">
                    <input type="file" name="gambar" id="gambar" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <p class="text-xs text-gray-500">Biarkan kosong untuk menggunakan gambar yang ada. Maksimal 2MB (JPG, JPEG, PNG)</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="/admin/menu" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>