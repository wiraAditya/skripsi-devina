<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <div class="bg-white p-6 rounded shadow">
    <p class="text-xl font-bold" >Selamat datang, anda login sebagai: <?=session()->user_role_text?></p>
    <p>Silakan mulai dengan memilih menu yang tersedia.</p>

        <!-- Dashboard content -->
    </div>
<?= $this->endSection() ?>