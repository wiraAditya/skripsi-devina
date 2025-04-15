<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Pengguna Baru</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/admin/users/store" method="POST">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="<?= old('nama') ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?= old('email') ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                <p class="mt-1 text-xs text-gray-500">Minimal 3 karakter</p>
            </div>
            
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <option value="">Pilih Role</option>
                    <option value="2" <?= old('role') == '2' ? 'selected' : '' ?>>Barista</option>
                    <option value="3" <?= old('role') == '3' ? 'selected' : '' ?>>Kasir</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="/admin/users" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                Batal
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>