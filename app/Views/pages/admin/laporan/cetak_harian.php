<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .header { text-align: center; margin-bottom: 15px; }
        .section-title { font-weight: bold; margin: 15px 0 8px 0; }
        .positive { color: green; }
        .negative { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="font-weight:bold;">LAPORAN HARIAN</h2>
        <p>Tanggal: <?= date('d/m/Y', strtotime($report_date)) ?></p>
        <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>
    </div>

    <div class="section-title">1. PENDAPATAN PER METODE PEMBAYARAN</div>
    <table>
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th class="text-right">Total Pendapatan (Net)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incomeByPayment as $income): ?>
            <tr>
                <td><?= $orderModel->getPaymentMethodText($income['payment_method']) ?></td>
                <td class="text-right">Rp <?= number_format($income['net_total'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="font-weight:bold;">
                <td>TOTAL KESELURUHAN</td>
                <td class="text-right">Rp <?= number_format(array_sum(array_column($incomeByPayment, 'net_total')), 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">2. REKAPITULASI KASIR</div>
    <table>
        <thead>
            <tr>
                <th>Kasir</th>
                <th>Waktu Buka</th>
                <th>Waktu Tutup</th>
                <th class="text-right">Saldo Awal</th>
                <th class="text-right">Saldo Akhir</th>
                <th class="text-right">Selisih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashierSessions as $session): ?>
            <tr>
                <td><?= $session['nama'] ?? 'N/A' ?></td>
                <td><?= date('H:i', strtotime($session['start_time'])) ?></td>
                <td><?= $session['end_time'] ? date('H:i', strtotime($session['end_time'])) : '-' ?></td>
                <td class="text-right">Rp <?= number_format($session['starting_cash'], 0, ',', '.') ?></td>
                <td class="text-right"><?= $session['ending_cash'] ? 'Rp ' . number_format($session['ending_cash'], 0, ',', '.') : '-' ?></td>
                <td class="text-right">
                    <?php if ($session['status'] === 'closed'): ?>
                        <span class="<?= ($session['discrepancy'] >= 0) ? 'positive' : 'negative' ?>">
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

    <div style="margin-top: 30px;">
        <div style="float: right; width: 200px; text-align: center;">
            <p>Mengetahui,</p>
            <br><br><br>
            <p>(___________________)</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>