<?php
namespace App\Controllers;

use App\Models\OrderModel;

class OrderController extends BaseController
{
    public function index(): string
    {
        $orderModel = new OrderModel();
        $filterStatus = [];
        $sortOrder = 'DESC'; 
        if(session()->get('user_role') == 2) {
            $filterStatus = ['status_paid', "status_process"];
            $sortOrder = 'ASC'; 
        } else if(session()->get('user_role') == 3) {
            $filterStatus = ["status_waiting_cash"];
        }else {
            $filterStatus = ["status_waiting_cash",
                                "status_paid",
                                "status_process",
                                "status_done",
                                "status_canceled",];
        }
        $orderModel->whereIn('status', $filterStatus)->orderBy('id', $sortOrder);
        $perPage = 10;

        $search = $this->request->getGet('search');
        $query = $orderModel;

        if (!empty($search)) {
            $orderModel = $orderModel->like('transaction_code', $search)
                          ->orLike('id', $search);
        }
        
        $orders = $orderModel->paginate($perPage);
        $pager = $orderModel->pager;
        
        // Add display texts and colors
        foreach ($orders as &$order) {
            $order['status_text'] = $orderModel->getOrderStatus($order['status']);
            $order['payment_text'] = $orderModel->getPaymentMethodText($order['payment_method']);
        }
        
        return view('pages/admin/order/order', [
            'title' => 'Order Management',
            'activeRoute' => 'order',
            'search' => $search,
            'orders' => $orders,
            'pager' => $pager,
            'search' => $search // Pass search term back to view
        ]);
    }
    public function detail($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderByIdWithDetails($id);

        if (empty($order)) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        // Group order details by menu item
        $orderDetails = [];
        $total = 0;
        // print_r($order);
        // die();
        foreach ($order as &$item) {
            if (!isset($orderDetails[$item['menu_name']])) {
                $orderDetails[$item['menu_name']] = [
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['qty'] * $item['harga']
                ];
            } else {
                $orderDetails[$item['menu_name']]['qty'] += $item['qty'];
                $orderDetails[$item['menu_name']]['subtotal'] += $item['qty'] * $item['harga'];
            }
            $total += $item['qty'] * $item['harga'];
            $item['status_text'] = $orderModel->getOrderStatus($item['status']);
            $item['payment_text'] = $orderModel->getPaymentMethodText($item['payment_method']);
        }
        return view('pages/admin/order/detail_order', [
            'title' => 'Order Detail',
            'activeRoute' => 'order',
            'order' => $order[0],
            'orderDetails' => $orderDetails,
            'total' => $total
        ]);
    }

    public function printReceipt($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderByIdWithDetails($id);

        if (empty($order)) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        // Group order details by menu item
        $orderDetails = [];
        $total = 0;
        foreach ($order as $item) {
            if (!isset($orderDetails[$item['menu_name']])) {
                $orderDetails[$item['menu_name']] = [
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['qty'] * $item['harga']
                ];
            } else {
                $orderDetails[$item['menu_name']]['qty'] += $item['qty'];
                $orderDetails[$item['menu_name']]['subtotal'] += $item['qty'] * $item['harga'];
            }
            $total += $item['qty'] * $item['harga'];
        }

        return view('pages/admin/order/print_receipt', [
            'order' => $order[0],
            'orderDetails' => $orderDetails,
            'total' => $total
        ]);
    }


    public function _updateStatus($id, $status) 
    {
        $orderModel = new OrderModel();
        $orderModel->update($id, ["status" => $status]);
        
    }

    public function confirm($id) {
        $status = "status_paid";
        self::_updateStatus($id, $status);
        return redirect()->to('/admin/order')->with('success', 'Order updated');
        
    }
    public function proccess($id) {
        $status = "status_process";
        self::_updateStatus($id, $status);
        return redirect()->to('/admin/order')->with('success', 'Order updated');
        
    }
    
    public function done($id) {
        $status = "status_done";
        self::_updateStatus($id, $status);
        return redirect()->to('/admin/order')->with('success', 'Order updated');
        
    }
    
    public function cancel($id) {
        $status = "status_canceled";
        self::_updateStatus($id, $status);
        return redirect()->to('/admin/order')->with('success', 'Order updated');
        
    }
}