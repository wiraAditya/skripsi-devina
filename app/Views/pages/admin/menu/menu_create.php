<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Menu Baru</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/admin/menu/store" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama Menu -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Menu</label>
                <input type="text" name="nama" id="nama" value="<?= old('nama') ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan nama menu">
            </div>
            
            <div>
                <label for="idKategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="idKategori" id="idKategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategories as $kategori): ?>
                        <option value="<?= $kategori['id'] ?>" <?= old('idKategori') == $kategori['id'] ? 'selected' : '' ?>>
                            <?= esc($kategori['kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Harga -->
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" value="<?= old('harga') ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan harga">
            </div>
            
            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Menu</label>
                <input type="file" name="gambar" id="gambar" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                <p class="mt-1 text-xs text-gray-500">Maksimal 2MB (JPG, JPEG, PNG)</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="/admin/menu" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                Batal
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>