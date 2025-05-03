<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Order Detail</h1>
    
    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <p><strong>Order ID:</strong> <?= esc($order['id']) ?></p>
            <p><strong>Transaction Code:</strong> <?= esc($order['transaction_code']) ?></p>
            <p><strong>Date:</strong> <?= esc($order['tanggal']) ?></p>
        </div>
        <div>
            <p><strong>Payment Method:</strong> <?= esc($order['payment_text']) ?></p>
            <p><strong>Status:</strong> <?= esc($order['status_text']) ?></p>
            <p><strong>Note:</strong> <?= esc($order['catatan']) ?></p>
        </div>
    </div>

    <table class="min-w-full divide-y divide-gray-200 mb-6">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orderDetails as $item => $detail): ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?= esc($item) ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?= esc($detail['qty']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">Rp <?= number_format($detail['harga'], 0, ',', '.') ?></td>
                <td class="px-6 py-4 whitespace-nowrap">Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="flex justify-end">
        <div class="w-1/3">
            <div class="flex justify-between mb-2">
                <span>Subtotal:</span>
                <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Tax:</span>
                <span>Rp <?= number_format($order['tax'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Total:</span>
                <span>Rp <?= number_format($total + $order['tax'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
    <?php if($order['status'] == "status_waiting_cash" && (session()->get('user_role') == 3)):?>
    <div class="mt-6">
        <a href="/admin/order/confirm/<?=$order['id']?>" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded transition duration-200">
            Konfirmasi Pembayaran
        </a>
    </div>
    <?php endif;?>
    <?php if($order['status'] == "status_paid" && (session()->get('user_role') == 2)):?>
        <div class="mt-6">
            <a href="/admin/order/proccess/<?=$order['id']?>" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded transition duration-200">
                Prosess
            </a>
        </div>
    <?php endif;?>

    <?php if($order['status'] == "status_process" &&(session()->get('user_role') == 2)):?>
        <div class="mt-6">
            <a href="/admin/order/done/<?=$order['id']?>" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded transition duration-200">
                Selesaikan Pesanan
            </a>
        </div>
    <?php endif;?>

     <div class="mt-6">
        <a href="/admin/order/print-receipt/<?=$order['id']?>" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded transition duration-200">
            Cetak Struk
        </a>
    </div>
</div>
<?= $this->endSection() ?>