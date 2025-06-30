<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold mb-6">Manajemen Menu</h1>
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Menu</h2>
            <a href="/admin/menu/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Baru
            </a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($menus)): ?>
                        <?php foreach ($menus as $index => $menu): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $index + 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage() ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="/uploads/menu/<?= esc($menu['gambar']) ?>" alt="<?= esc($menu['nama']) ?>" class="h-12 w-12 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($menu['nama']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($menu['nama_kategori'] ?? '-') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($menu['harga'], 0, ',', '.') ?>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $menu['status'] == $model::STATUS_AKTIF ? 'bg-green-100 text-green-800' : 
                                       ($menu['status'] == $model::STATUS_TIDAK_TERSEDIA ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= $model->getStatusName($menu['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/admin/menu/edit/<?= $menu['id'] ?>" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- <button onclick="showModal('deleteModal', '/admin/menu/delete/<?= $menu['id'] ?>')" 
                                    class="text-red-600 hover:text-red-900 mr-3" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button> -->
                                <a href="/admin/menu/toggle-status/<?= $menu['id'] ?>" 
                                    class="<?= $menu['status'] == $model::STATUS_AKTIF ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' ?>" 
                                    title="<?= $menu['status'] == $model::STATUS_AKTIF ? 'Set Tidak Tersedia' : 'Set Aktif' ?>">
                                    <i class="fas <?= $menu['status'] == $model::STATUS_AKTIF ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                <i class="fas fa-database mr-2"></i>Tidak ada data menu
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($menus)): ?>
            <?= view('components/admin/_pagination', ['pager' => $pager]) ?>
        <?php endif; ?>
    </div>
    
    <?= view('components/admin/modal_delete', [
        'modalTitle' => 'Hapus Menu',
        'message' => 'Apakah Anda yakin ingin menghapus menu ini? Data yang sudah dihapus tidak dapat dikembalikan.'
    ]) ?>

<?= $this->endSection() ?>