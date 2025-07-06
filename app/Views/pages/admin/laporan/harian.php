<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold mb-6">Laporan Harian</h1>
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Ringkasan Harian</h2>
            <div class="flex items-center space-x-4">
                <form method="get" action="" class="flex items-center space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Laporan</label>
                        <input type="date" name="report_date" value="<?= $report_date ?>" 
                            class="mt-1 block rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <button type="submit" 
                            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Filter
                    </button>
                </form>
                <a href="/admin/laporan/cetak-harian?report_date=<?= $report_date ?>" 
                   target="_blank"
                   class="mt-6 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-print mr-2"></i>Cetak
                </a>
            </div>
        </div>

        <!-- 1. Pendapatan per Metode Pembayaran -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">1. Pendapatan per Metode Pembayaran</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan (Net)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($incomeByPayment as $income): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $income['payment_method'] === $orderModel->PAYMENT_CASH ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' ?>">
                                    <?= $orderModel->getPaymentMethodText($income['payment_method']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($income['net_total'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">TOTAL KESELURUHAN</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                Rp <?= number_format(array_sum(array_column($incomeByPayment, 'net_total')), 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Rekapitulasi Kasir -->
        <div>
            <h3 class="text-lg font-semibold mb-4">2. Rekapitulasi Kasir</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Buka</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Tutup</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Awal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Akhir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($cashierSessions as $session): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $session['nama'] ?? 'N/A' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('H:i', strtotime($session['start_time'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $session['end_time'] ? date('H:i', strtotime($session['end_time'])) : '-' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp <?= number_format($session['starting_cash'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $session['ending_cash'] ? 'Rp ' . number_format($session['ending_cash'], 0, ',', '.') : '-' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if ($session['status'] === 'closed'): ?>
                                    <span class="<?= ($session['discrepancy'] >= 0) ? 'text-green-600' : 'text-red-600' ?>">
                                        Rp <?= number_format(abs($session['discrepancy']), 0, ',', '.') ?>
                                        (<?= ($session['discrepancy'] >= 0) ? '+' : '-' ?>)
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>