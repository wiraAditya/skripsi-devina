<?php

namespace App\Controllers;

use App\Libraries\MidtransService;

class PaymentController extends BaseController
{
    public function index()
    {
        $data['cartItems'] = getCartItems();
        $data['subTotal'] = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data['cartItems']));
        return view('pages/public/payment', $data);
    }

    public function token()
    {
        $midtrans = new MidtransService();

        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => 100000,
            ],
            'customer_details' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '08123456789',
            ]
        ];

        $snapToken = $midtrans->createSnapToken($params);

        return $this->response->setJSON(['token' => $snapToken]);
    }
}
