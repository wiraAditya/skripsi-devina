<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold mb-6">Manajemen Kategori</h1>
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Kategori</h2>
            <a href="/admin/kategori/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
                <i class="fas fa-plus-circle mr-2"></i>Tambah 
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Kategori
                        </th>
                       
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($kategories)): ?>
                        <?php foreach ($kategories as $index => $kategori): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $index + 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage() ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($kategori['kategori']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/admin/kategori/edit/<?= $kategori['id'] ?>" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showModal('deleteModal', '/admin/kategori/delete/<?= $kategori['id'] ?>')" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                <i class="fas fa-database mr-2"></i>Tidak ada data kategori
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($kategories)): ?>
            <?= view('components/admin/_pagination', ['pager' => $pager]) ?>
        <?php endif; ?>
    </div>
    
    <?= view('components/admin/modal_delete', [
        'modalTitle' => 'Hapus Kategori',
        'message' => 'Apakah Anda yakin ingin menghapus kategori ini? Data yang sudah dihapus tidak dapat dikembalikan.'
    ]) ?>

<?= $this->endSection() ?>