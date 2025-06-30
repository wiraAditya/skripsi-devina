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
        .footer { margin-top: 30px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2 class="bold">LAPORAN PENJUALAN</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?></p>
        <p>Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Total</th>
                <th>Pajak</th>
                <th>Grand Total</th>
                <th>Metode Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($order['tanggal'])) ?></td>
                    <td><?= $order['transaction_code'] ?></td>
                    <td class="text-right">Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                    <td class="text-right">Rp <?= number_format($order['tax'], 0, ',', '.') ?></td>
                    <td class="text-right">Rp <?= number_format($order['total'] + $order['tax'], 0, ',', '.') ?></td>
                    <td><?= $orderModel->getPaymentMethodText($order['payment_method']) ?></td>
                    <td><?= $orderModel->getOrderStatus($order['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="bold">
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    <td colspan="4"></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
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