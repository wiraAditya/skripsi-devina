<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tutup Sesi Kasir</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="mb-6">
        <p class="font-medium">Waktu Buka: <?= date('d/m/Y H:i', strtotime($session['start_time'])) ?></p>
        <p class="font-medium">Saldo Awal: Rp <?= number_format($session['starting_cash'], 0, ',', '.') ?></p>
    </div>
    
    <form action="/admin/sessions/close/<?= $session['id'] ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Ending Cash -->
            <div>
                <label for="ending_cash" class="block text-sm font-medium text-gray-700">Saldo Akhir</label>
                <input type="number" name="ending_cash" id="ending_cash" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan saldo akhir kas"
                    required>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <a href="/admin/sessions" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                Batal
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Tutup Sesi
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>