<?= $this->extend('layouts/clear') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <img class="mx-auto rounded-full mt-2 h-16 w-16 " src="/uploads/logo.png" alt="logo">

        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('login') ?>" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan Username"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    placeholder="Masukkan Password"
                >
            </div>
            <button
                type="submit"
                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-amber-400"
            >
                Masuk
            </button>
        </form>

    </div>
</div>
<?= $this->endSection() ?>
