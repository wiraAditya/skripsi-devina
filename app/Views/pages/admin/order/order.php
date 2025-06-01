<?= $this->extend('layouts/admin') ?>

<?php

    function getPaymentColor(string $payment): string
    {
        $colors = [
            "payment_cash" => 'bg-blue-100 text-blue-800',
            "payment_digital" => 'bg-purple-100 text-purple-800'
        ];
        
        return $colors[$payment] ?? 'bg-gray-100 text-gray-800';
    }
    function getStatusColor(string $status): string
    {
        $colors = [
            "status_waiting_cash" => 'bg-yellow-100 text-yellow-800',
            "status_paid" => 'bg-green-100 text-green-800',
            "status_process" => 'bg-blue-100 text-blue-800',
            "status_done" => 'bg-indigo-100 text-indigo-800',
            "status_canceled" => 'bg-red-100 text-red-800'
        ];
        
        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }
?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-6">Manajemen Order</h1>
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Order</h2>
            <div class="flex space-x-4">
                <form method="get" action="" class="flex">
                    <input 
                        type="text" 
                        name="search" 
                        value="<?= esc($search ?? '') ?>" 
                        placeholder="Cari Kode..."
                        class="border rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r transition duration-200"
                    >
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
                <!-- <a href="/admin/orders/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah 
                </a> -->
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kode
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tax
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            GrandTotal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Catatan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis Bayar
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                       
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $index + 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage() ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- <a href="/admin/orders/edit/<?= $order['id'] ?>" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> -->
                                <a href="/admin/order/detail/<?= $order['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($order['status'] == 'status_waiting_cash'):
                                ?>
                                <button onclick="showModalWithOrder('deleteModal', '/admin/order/cancel/<?= $order['id'] ?>', '<?= $order['transaction_code'] ?>')" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <?php endif;?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($order['transaction_code']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($order['tanggal']) ?>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format(esc($order['total']), 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format(esc($order['tax']), 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= number_format(esc($order['total'] + $order['tax']), 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($order['catatan']) ?>
                            </td>
                            

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getPaymentColor($order['payment_method']) ?>">
                                    <?= $order['payment_text'] ?>
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getStatusColor($order['status']) ?>">
                                    <?= $order['status_text'] ?>
                                </span>
                            </td>
                            
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                <i class="fas fa-database mr-2"></i>Tidak ada data order
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        <?php if (!empty($orders)): ?>
            <?= view('components/admin/_pagination', ['pager' => $pager]) ?>
        <?php endif; ?>
    </div>
    
    
    <?= view('components/admin/modal_delete', [
        'modalTitle' => 'Batalkan order',
        'message' => 'Apakah Anda yakin ingin membatalkan order ini?'
    ]) ?>
    <script>
        function showModalWithOrder(modalId, formAction, orderCode) {
            // First show the modal with the form action
            showModal(modalId, formAction);
            
            // Then update the message to include the order code
            const modal = document.getElementById(modalId);
            const messageElement = document.getElementById('deleteModalMessage');
            if (messageElement) {
                messageElement.innerHTML = `Apakah Anda yakin ingin membatalkan order <b>${orderCode}</b>? `;
            }
        }
    </script>
<?= $this->endSection() ?>