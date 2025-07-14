<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Libraries\MidtransService;
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
        date_default_timezone_set('Asia/singapore');
        $orderData = [
            'tanggal' => date('Y-m-d H:i:s'),
            'total' => $total,
            'catatan' => $this->request->getPost('notes') ?? '',
            'nama' => $this->request->getPost('nama') ?? '',
            'status' => $kind == $this->orderModel::PAYMENT_DIGITAL ?  $this->orderModel::STATUS_PAID : $this->orderModel::STATUS_WAITING_CASH, 
            'payment_method' => $kind, 
            'transaction_code' => 'TR-' . date('YmdHis'),
            'tax' => $tax
        ];
        print_r($this->request->getPost('nama'));
        print_r($orderData);
        
        // die();
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

    public function token()
    {
        $midtrans = new MidtransService();
        $data  = getCartItems();
        $subTotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data));
        $tax = $subTotal *(10/100);
        $gt = $subTotal+$tax;
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $gt,
            ],
        ];

        $snapToken = $midtrans->createSnapToken($params);

        return $this->response->setJSON(['token' => $snapToken]);
    }


    public function orderSuccess($orderId)
    {
        $data['order'] = $this->orderModel->find($orderId);
        $data['orderDetails'] = $this->orderModel->getOrderByIdWithDetails($orderId);

        return view('pages/public/order_success', $data);
    }
    public function struk($orderId)
    {
        $order = $this->orderModel->find($orderId);
        $orderDetails = $this->orderModel->getOrderByIdWithDetails($orderId);

        // Add payment method text and status text
        $order['payment_method_text'] = $this->orderModel->getPaymentMethodText($order['payment_method']);
        $order['status_text'] = $this->orderModel->getOrderStatus($order['status']);

        $data['order'] = $order;
        $data['orderDetails'] = $orderDetails;

        return view('pages/public/struk', $data);
    }
}