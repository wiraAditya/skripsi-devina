<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'total', 'catatan', 'status', 'payment_method', 'transaction_code', 'tax'];
    protected $useTimestamps = false;

    // Payment method constants
    public const PAYMENT_CASH = 'payment_cash';
    public const PAYMENT_DIGITAL = 'payment_digital';
    
    // Order status constants
    public const STATUS_WAITING_CASH = 'status_waiting_cash';
    public const STATUS_PAID = 'status_paid';
    public const STATUS_PROCESS = 'status_process';
    public const STATUS_DONE = 'status_done';
    public const STATUS_CANCELED = 'status_canceled';

    /**
     * Get order with details by ID
     *
     * @param int $orderId
     * @return array
     */
    public function getOrderByIdWithDetails(int $orderId): array
    {
        return $this->select('order.*, order_detail.id as detail_id, order_detail.qty, order_detail.harga, 
                            order_detail.catatan as detail_catatan, menu.nama as menu_name')
            ->join('order_detail', 'order_detail.order_id = order.id')
            ->join('menu', 'menu.id = order_detail.menu_id')
            ->where('order.id', $orderId)
            ->findAll();
    }

    /**
     * Get human-readable payment method text
     *
     * @param string $payment
     * @return string
     */
    public function getPaymentMethodText(string $payment): string
    {
        $methods = [
            self::PAYMENT_CASH => 'Cash',
            self::PAYMENT_DIGITAL => 'Digital'
        ];

        if (!array_key_exists($payment, $methods)) {
            log_message('warning', "Unknown payment method: {$payment}");
            return 'Unknown';
        }

        return $methods[$payment];
    }

    /**
     * Get human-readable order status text
     *
     * @param string $status
     * @return string
     */
    public function getOrderStatus(string $status): string
    {
        $statuses = [
            self::STATUS_WAITING_CASH => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Terbayar',
            self::STATUS_PROCESS => 'Diproses',
            self::STATUS_DONE => 'Selesai',
            self::STATUS_CANCELED => 'Dibatalkan',
        ];

        if (!array_key_exists($status, $statuses)) {
            log_message('warning', "Unknown order status: {$status}");
            return 'Unknown';
        }

        return $statuses[$status];
    }
    
    /**
     * Get all available payment methods
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return [
            self::PAYMENT_CASH => 'Cash',
            self::PAYMENT_DIGITAL => 'Digital'
        ];
    }
    
    /**
     * Get all available order statuses
     *
     * @return array
     */
    public function getOrderStatuses(): array
    {
        return [
            self::STATUS_WAITING_CASH => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Terbayar',
            self::STATUS_PROCESS => 'Diproses',
            self::STATUS_DONE => 'Selesai',
            self::STATUS_CANCELED => 'Dibatalkan',
        ];
    }
}