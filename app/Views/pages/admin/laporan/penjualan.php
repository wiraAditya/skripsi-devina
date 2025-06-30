<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
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
    <h1 class="text-2xl font-bold mb-6">Laporan Penjualan</h1>
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Transaksi</h2>
            <div class="flex items-center space-x-4">
                <form method="get" action="" class="flex items-center space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" value="<?= $start_date ?>" 
                            class="mt-1 block rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="<?= $end_date ?>" 
                            class="mt-1 block rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <button type="submit" 
                            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Filter
                    </button>
                </form>
                <a href="/admin/laporan/cetak-penjualan?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" 
                   target="_blank"
                   class="mt-6 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-print mr-2"></i>Cetak
                </a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pajak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grand Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y H:i', strtotime($order['tanggal'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= $order['transaction_code'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($order['total']- $order['tax'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($order['tax'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($order['total'] , 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $order['payment_method'] === $orderModel->PAYMENT_CASH ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' ?>">
                                    <?= $orderModel->getPaymentMethodText($order['payment_method']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= getStatusColor($order['status']) ?>">
                                    <?= $orderModel->getOrderStatus($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                Rp <?= number_format($total, 0, ',', '.') ?>
                            </td>
                            <td colspan="4"></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                <i class="fas fa-database mr-2"></i>Tidak ada data transaksi
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>