<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class PaymentController extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function index()
    {
        $data['cartItems'] = getCartItems();
        $data['subTotal'] = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data['cartItems']));
        return view('pages/public/payment', $data);
    }

    public function processPayment($kind)
    {
        // Validate cart exists
        $cartItems = getCartItems();
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        // Calculate totals
        $subTotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        // Calculate tax (example: 10%)
        $tax = $subTotal * 0.1;
        $total = $subTotal + $tax;
        // Prepare order data
        $orderData = [
            'tanggal' => date('Y-m-d H:i:s'),
            'total' => $total,
            'catatan' => $this->request->getPost('notes') ?? '',
            'status' => 'paid', // or 'pending' if you need kitchen confirmation
            'payment_method' => $kind, // 1 for cash
            'transaction_code' => 'TR-' . date('YmdHis'),
            'tax' => $tax
        ];

        // Start database transaction
        $db = db_connect();
        $db->transStart();

        try {
            // Insert order
            $orderId = $this->orderModel->insert($orderData);

            // Insert order details
            foreach ($cartItems as $item) {
                $this->orderDetailModel->insert([
                    'order_id' => $orderId,
                    'menu_id' => $item['id'],
                    'qty' => $item['quantity'],
                    'harga' => $item['price'],
                    'catatan' => $item['notes'] ?? ''
                ]);
            }

            // Commit transaction
            $db->transComplete();

            // Clear cart
            clearCart();

            // Redirect to success page
            return redirect()->to('/payment/success/' . $orderId)->with('success', 'Pembayaran berhasil diproses');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function orderSuccess($orderId)
    {
        $data['order'] = $this->orderModel->find($orderId);
        $data['orderDetails'] = $this->orderModel->getOrderByIdWithDetails($orderId);

        return view('pages/public/order_success', $data);
    }
}