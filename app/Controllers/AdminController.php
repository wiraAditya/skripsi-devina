<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Default to daily view
        $filter = 'daily';
        $date = date('Y-m-d');
        $month = date('n');
        $year = date('Y');

        // Get filter from session or request
        if ($this->request->getGet('filter')) {
            $filter = $this->request->getGet('filter');
            session()->set('dashboard_filter', $filter);
        } elseif (session()->has('dashboard_filter')) {
            $filter = session()->get('dashboard_filter');
        }

        // Get data based on filter
        if ($filter === 'daily') {
            if ($this->request->getGet('date')) {
                $date = $this->request->getGet('date');
                session()->set('dashboard_date', $date);
            } elseif (session()->has('dashboard_date')) {
                $date = session()->get('dashboard_date');
            }
            
            $data = $this->getDailyData($date);
        } else {
            if ($this->request->getGet('month')) {
                $month = $this->request->getGet('month');
                session()->set('dashboard_month', $month);
            } elseif (session()->has('dashboard_month')) {
                $month = session()->get('dashboard_month');
            }
            
            if ($this->request->getGet('year')) {
                $year = $this->request->getGet('year');
                session()->set('dashboard_year', $year);
            } elseif (session()->has('dashboard_year')) {
                $year = session()->get('dashboard_year');
            }
            
            $data = $this->getMonthlyData($month, $year);
        }

        // Prepare view data
        $viewData = [
            'filter' => $filter,
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'summary' => $data['summary'],
            'chartData' => $data['charts'],
            'recentOrders' => $data['recentOrders'],
            'pendingPayments' => $data['pendingPayments'],
            'processingOrders' => $data['processingOrders'],
            'months' => $this->getMonthsList(),
            'years' => $this->getYearsList(),
            'activeRoute' => 'dashboard',
            'orderModel' => $this->orderModel

        ];

        return view('pages/admin/dashboard', $viewData,);
    }

    public function updateOrderStatus()
    {
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        if (!in_array($status, [
            $this->orderModel::STATUS_PAID,
            $this->orderModel::STATUS_DONE
        ])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $updated = $this->orderModel->update($orderId, ['status' => $status]);

        if ($updated) {
            return redirect()->back()->with('message', 'Status pesanan berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status pesanan');
    }

    protected function getDailyData($date)
    {
        // Summary data
        $orders = $this->orderModel->where('DATE(tanggal)', $date)->findAll();
        $totalOrders = count($orders);
        
        $totalRevenue = array_reduce($orders, function($carry, $order) {
            return $carry + $order['total'];
        }, 0);
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Get popular menu
        $popularMenu = '';
        if ($totalOrders > 0) {
            $orderIds = array_column($orders, 'id');
            $details = $this->orderDetailModel->select('menu_id, menu.nama, SUM(qty) as total_qty')
                ->join('menu', 'menu.id = order_detail.menu_id')
                ->whereIn('order_id', $orderIds)
                ->groupBy('menu_id, menu.nama')
                ->orderBy('total_qty', 'DESC')
                ->first();
            
            if ($details) {
                $popularMenu = $details['nama'];
            }
        }

        // Charts data (by hour)
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $hourlyData[$hour] = [
                'orders' => 0,
                'revenue' => 0
            ];
        }

        foreach ($orders as $order) {
            $hour = date('H', strtotime($order['tanggal']));
            $hourlyData[$hour]['orders']++;
            $hourlyData[$hour]['revenue'] += $order['total'];
        }

        // Recent orders
        $recentOrders = array_slice($orders, 0, 5);
        foreach ($recentOrders as &$order) {
            $order['statusText'] = $this->orderModel->getOrderStatus($order['status']);
            $order['paymentMethodText'] = $this->orderModel->getPaymentMethodText($order['payment_method']);
        }

        // Role-specific data
        $pendingPayments = [];
        $processingOrders = [];

        if (in_array(session()->user_role, [1, 3])) { // Admin or Cashier
            $pendingPayments = $this->orderModel->where('status', $this->orderModel::STATUS_WAITING_CASH)
                ->where('DATE(tanggal)', $date)
                ->findAll();
        }

        if (in_array(session()->user_role, [1, 2])) { // Admin or Barista
            $processingOrders = $this->orderModel->where('status', $this->orderModel::STATUS_PROCESS)
                ->where('DATE(tanggal)', $date)
                ->findAll();
            
            foreach ($processingOrders as &$order) {
                $order['items'] = $this->orderDetailModel->where('order_id', $order['id'])->findAll();
            }
        }

        return [
            'summary' => [
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'avgOrderValue' => $avgOrderValue,
                'popularMenu' => $popularMenu
            ],
            'charts' => [
                'labels' => array_keys($hourlyData),
                'ordersData' => array_column($hourlyData, 'orders'),
                'revenueData' => array_column($hourlyData, 'revenue')
            ],
            'recentOrders' => $recentOrders,
            'pendingPayments' => $pendingPayments,
            'processingOrders' => $processingOrders
        ];
    }

    protected function getMonthlyData($month, $year)
    {
        // Get days in month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Summary data
        $orders = $this->orderModel->where('YEAR(tanggal)', $year)
            ->where('MONTH(tanggal)', $month)
            ->findAll();
        
        $totalOrders = count($orders);
        $totalRevenue = array_reduce($orders, function($carry, $order) {
            return $carry + $order['total'];
        }, 0);
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Get popular menu
        $popularMenu = '';
        if ($totalOrders > 0) {
            $orderIds = array_column($orders, 'id');
            $details = $this->orderDetailModel->select('menu_id, menu.nama, SUM(qty) as total_qty')
                ->join('menu', 'menu.id = order_detail.menu_id')
                ->whereIn('order_id', $orderIds)
                ->groupBy('menu_id, menu.nama')
                ->orderBy('total_qty', 'DESC')
                ->first();
            
            if ($details) {
                $popularMenu = $details['nama'];
            }
        }

        // Charts data (by day)
        $dailyData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $dailyData[$day] = [
                'orders' => 0,
                'revenue' => 0
            ];
        }

        foreach ($orders as $order) {
            $day = date('d', strtotime($order['tanggal']));
            $dailyData[$day]['orders']++;
            $dailyData[$day]['revenue'] += $order['total'];
        }

        // Recent orders
        $recentOrders = $this->orderModel->where('YEAR(tanggal)', $year)
            ->where('MONTH(tanggal)', $month)
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->findAll();
        
        foreach ($recentOrders as &$order) {
            $order['statusText'] = $this->orderModel->getOrderStatus($order['status']);
            $order['paymentMethodText'] = $this->orderModel->getPaymentMethodText($order['payment_method']);
        }

        // Role-specific data
        $pendingPayments = [];
        $processingOrders = [];

        if (in_array(session()->user_role, [1, 3])) { // Admin or Cashier
            $pendingPayments = $this->orderModel->where('status', $this->orderModel::STATUS_WAITING_CASH)
                ->where('YEAR(tanggal)', $year)
                ->where('MONTH(tanggal)', $month)
                ->findAll();
        }

        if (in_array(session()->user_role, [1, 2])) { // Admin or Barista
            $processingOrders = $this->orderModel->where('status', $this->orderModel::STATUS_PROCESS)
                ->where('YEAR(tanggal)', $year)
                ->where('MONTH(tanggal)', $month)
                ->findAll();
            
            foreach ($processingOrders as &$order) {
                $order['items'] = $this->orderDetailModel->where('order_id', $order['id'])->findAll();
            }
        }

        return [
            'summary' => [
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'avgOrderValue' => $avgOrderValue,
                'popularMenu' => $popularMenu
            ],
            'charts' => [
                'labels' => array_keys($dailyData),
                'ordersData' => array_column($dailyData, 'orders'),
                'revenueData' => array_column($dailyData, 'revenue')
            ],
            'recentOrders' => $recentOrders,
            'pendingPayments' => $pendingPayments,
            'processingOrders' => $processingOrders
        ];
    }

    protected function getMonthsList()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }
        return $months;
    }

    protected function getYearsList()
    {
        $years = [];
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }
}