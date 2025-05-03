<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class ApiTransactionController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $orderModel = new OrderModel();
        $orderDetailModel = new OrderDetailModel();

        // Get all orders
        $orders = $orderModel->findAll();

        $result = [];
        foreach ($orders as $order) {
            // Get order details for each order
            $details = $orderDetailModel->where('order_id', $order['id'])->findAll();

            // Map status to named status
            $statusText = $orderModel->getOrderStatus($order['status']);

            // Map payment method to text
            $paymentMethodText = $orderModel->getPaymentMethodText($order['payment_method']);

            $result[] = [
                'id' => $order['id'],
                'transaction_code' => $order['transaction_code'],
                'tanggal' => $order['tanggal'],
                'total' => $order['total'],
                'tax' => $order['tax'],
                'grand_total' => $order['total'] + $order['tax'],
                'catatan' => $order['catatan'],
                'status' => $statusText,
                'payment_method' => $paymentMethodText,
                'details' => array_map(function($detail) {
                    return [
                        'menu_id' => $detail['menu_id'],
                        'qty' => $detail['qty'],
                        'harga' => $detail['harga'],
                        'subtotal' => $detail['qty'] * $detail['harga'],
                        'catatan' => $detail['catatan'],
                    ];
                }, $details)
            ];
        }

        return $this->respond($result);
    }
}