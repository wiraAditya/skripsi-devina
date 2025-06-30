<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'menu_id', 'qty', 'harga', 'catatan'];
    protected $useTimestamps = false;

    public function getOrderDetailsByIds(array $orderIds): array
    {
        return $this->select('order_detail.order_id, order_detail.id as detail_id, order_detail.qty, order_detail.harga, 
                            order_detail.catatan as detail_catatan, menu.nama as menu_name')
            ->join('menu', 'menu.id = order_detail.menu_id')
            ->whereIn('order_id', $orderIds)
            ->findAll();
    }
}