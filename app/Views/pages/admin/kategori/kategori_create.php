<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Baru</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/admin/kategori/store" method="POST">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Kategori Name -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="kategori" id="kategori" value="<?= old('kategori') ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan nama kategori">
                <p class="mt-1 text-xs text-gray-500">Minimal 3 karakter, maksimal 50 karakter</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="/admin/kategori" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                Batal
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>