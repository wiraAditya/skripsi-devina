<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\CashierSessionModel;
use App\Models\CasheirSessionModel;

class OrderController extends BaseController
{
    public function index(): string
    {
        $cashierSessionModel = new CashierSessionModel();
        $orderModel = new OrderModel();
        $orderDetailModel = new OrderDetailModel();
        $statusOptions = [
            '' => 'Semua Status',
            'status_waiting_cash' => 'Menunggu Pembayaran',
            'status_paid' => 'Sudah Dibayar',
            'status_process' => 'Diproses',
            'status_done' => 'Selesai',
            'status_canceled' => 'Dibatalkan',
        ];
        if(session()->get('user_role') == 2) {
            $statusOptions = [
                '' => 'Semua Status',
                'status_paid' => 'Sudah Dibayar',
                'status_process' => 'Diproses',
            ];
        }
        
        $cashierSession = session()->get('user_role') == 3 ? $cashierSessionModel
        ->select("cashier_sessions.*, user.nama, user.email")
        ->where('cashier_sessions.status', 'open')
        ->join('user', 'user.id = cashier_sessions.user_id')
        ->first() : null;
        

        [$filterStatus, $sortOrder] = $this->getFilterStatusAndSortOrder();

        
        $orderModel->whereIn('status', $filterStatus)->orderBy('tanggal', 'DESC');
        
        $perPage = 10;
        
        // Handle search and filter functionality
        $filterStatus = $this->request->getGet('status');
       
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $orderModel->like('transaction_code', $search)
                    ->orLike('id', $search);
        }

        if (!empty($filterStatus)) {
            $orderModel->where('status', $filterStatus);
        }
        // end filter section

        // Fetch paginated orders
        $orders = $orderModel->paginate($perPage);
        $pager = $orderModel->pager;

        // Collect order IDs for fetching details
        $listOfId = array_column($orders, 'id');

        // Fetch order details
        $orderDetails = [];
        if(empty($listOfId)) {
            $orderDetails = [];
        } else {
            $orderDetails= $orderDetailModel->getOrderDetailsByIds($listOfId);
            
        }
        // Map order details to orders
        foreach ($orders as &$order) {
            $order['status_text'] = $orderModel->getOrderStatus($order['status']);
            $order['payment_text'] = $orderModel->getPaymentMethodText($order['payment_method']);
            $order['details'] = array_filter($orderDetails, function ($detail) use ($order) {
                return $detail['order_id'] === $order['id'];
            });
        }

        // Render the view
        $isShowDetails = session()->get('user_role') == 2;


        return view('pages/admin/order/order', [
            'title' => 'Order Management',
            'activeRoute' => 'order',
            'search' => $search,
            'orders' => $orders,
            'pager' => $pager,
            'isShowDetails' => $isShowDetails,
            'statusOptions'=> $statusOptions,
            'filterStatus'=> $filterStatus,
            'cashierSession' => $cashierSession,
            'needValidateSession' => session()->get('user_role') == 3
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
                    'detail_catatan' => $item['detail_catatan'],
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
        $orderModel = new OrderModel();
        $cashierSessionModel = new CashierSessionModel();
        $userId = session()->get('user_id');
        $status = "status_paid";
        $sessionId = null;

        $session = $cashierSessionModel->getActiveSession($userId);
        
        if (!$session) {
            return redirect()->back()->with('error', 'Open a cashier shift first');
        }
        $sessionId = $session['id'];
        
        self::_updateStatus($id, $status);
        $orderModel->update($id, ["cashier_session_id" => $sessionId]);
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
    /**
     * Get filter status and sort order based on user role.
     *
     * @return array
     */
    private function getFilterStatusAndSortOrder(): array
    {
        $filterStatus = [];
        $sortOrder = 'DESC';

        switch (session()->get('user_role')) {
            case 2:
                $filterStatus = ['status_paid', 'status_process'];
                $sortOrder = 'ASC';
                break;
            case 3:
                $filterStatus = ['status_waiting_cash'];
                break;
            default:
                $filterStatus = [
                    'status_waiting_cash',
                    'status_paid',
                    'status_process',
                    'status_done',
                    'status_canceled',
                ];
                break;
        }

        return [$filterStatus, $sortOrder];
    }
}