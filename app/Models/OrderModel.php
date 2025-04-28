<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'total', 'catatan', 'status', 'payment_method', 'transaction_code', 'tax'];
    protected $useTimestamps = false;

    public function getOrderByIdWithDetails($orderId)
    {
        return $this->select('order.*, order_detail.id as detail_id, order_detail.qty, order_detail.harga, 
                            order_detail.catatan as detail_catatan, menu.nama as menu_name')
            ->join('order_detail', 'order_detail.order_id = order.id')
            ->join('menu', 'menu.id = order_detail.menu_id')
            ->where('order.id', $orderId)
            ->findAll();
    }
}