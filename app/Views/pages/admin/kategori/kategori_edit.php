<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Kategori</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/admin/kategori/update/<?= $kategori['id'] ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Kategori Name -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="kategori" id="kategori" value="<?= old('kategori', $kategori['kategori']) ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama kategori">
                <p class="mt-1 text-xs text-gray-500">Minimal 3 karakter, maksimal 50 karakter</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="/admin/kategori" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>