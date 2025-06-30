<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\CashierSessionModel;
use App\Models\CasheirSessionModel;

class LaporanController extends BaseController
{
  public function laporanPenjualan()
  {
      $orderModel = new OrderModel();
      
      // Default: awal bulan ini sampai hari ini
      $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
      $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
      
      $orders = $orderModel->where('tanggal >=', $startDate . ' 00:00:00')
                          ->where('tanggal <=', $endDate . ' 23:59:59')
                          ->whereIn('status', [
                              OrderModel::STATUS_PAID,
                              OrderModel::STATUS_PROCESS,
                              OrderModel::STATUS_DONE
                          ])
                          ->orderBy('tanggal', 'ASC')
                          ->findAll();
  
     // Calculate total (total - tax) for each order and sum them
      $netTotal = array_reduce($orders, function($carry, $order) {
          return $carry + ($order['total'] - $order['tax']);
      }, 0);

      $data = [
          'title' => 'Laporan Penjualan',
          'orders' => $orders,
          'start_date' => $startDate,
          'end_date' => $endDate,
          'activeRoute'=>'laporan_penjualan',
          'total' => $netTotal, // Now using total - tax
          'orderModel' => $orderModel
      ];
      
      
      return view('pages/admin/laporan/penjualan', $data);
  }
  
  public function cetakLaporanPenjualan()
  {
      $orderModel = new OrderModel();
      
      $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
      $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
      
      $orders = $orderModel->where('tanggal >=', $startDate . ' 00:00:00')
                          ->where('tanggal <=', $endDate . ' 23:59:59')
                          ->whereIn('status', [
                              OrderModel::STATUS_PAID,
                              OrderModel::STATUS_PROCESS,
                              OrderModel::STATUS_DONE
                          ])
                          ->orderBy('tanggal', 'ASC')
                          ->findAll();
  
      // Calculate total (total - tax) for each order and sum them
      $netTotal = array_reduce($orders, function($carry, $order) {
          return $carry + ($order['total'] - $order['tax']);
      }, 0);

      $data = [
          'title' => 'Cetak Laporan Penjualan',
          'orders' => $orders,
          'start_date' => $startDate,
          'end_date' => $endDate,
          'activeRoute'=>'laporan_penjualan',
          'total' => $netTotal, // Now using total - tax
          'orderModel' => $orderModel
      ];
      
      return view('pages/admin/laporan/cetak_penjualan', $data);
  }

  public function laporanHarian()
  {
      $orderModel = new OrderModel();
      $sessionModel = new CashierSessionModel();
      
      // Default: hari ini
      $reportDate = $this->request->getGet('report_date') ?? date('Y-m-d');
      
      // 1. Total income by payment method (only PAID/PROCESS/DONE statuses)
      $incomeByPayment = $orderModel->select('payment_method, SUM(total - tax) as net_total')
                                  ->where('DATE(tanggal)', $reportDate)
                                  ->whereIn('status', [
                                      OrderModel::STATUS_PAID,
                                      OrderModel::STATUS_PROCESS,
                                      OrderModel::STATUS_DONE
                                  ])
                                  ->groupBy('payment_method')
                                  ->findAll();
      
      // 2. Cashier sessions for the day
      $cashierSessions = $sessionModel->where('DATE(start_time)', $reportDate)
                                    ->select("cashier_sessions.*, user.nama, user.email")
                                    ->orderBy('start_time', 'ASC')
                                    ->join('user', 'user.id = cashier_sessions.user_id', 'left')
                                    ->findAll();
      $data = [
          'title' => 'Laporan Harian',
          'report_date' => $reportDate,
          'incomeByPayment' => $incomeByPayment,
          'cashierSessions' => $cashierSessions,
          'activeRoute' => 'laporan_harian',
          'orderModel' => $orderModel
      ];
      
      return view('pages/admin/laporan/harian', $data);
  }

  public function cetakLaporanHarian()
  {
      $orderModel = new OrderModel();
      $sessionModel = new CashierSessionModel();
      
      $reportDate = $this->request->getGet('report_date') ?? date('Y-m-d');
      
      $incomeByPayment = $orderModel->select('payment_method, SUM(total - tax) as net_total')
                                  ->where('DATE(tanggal)', $reportDate)
                                  ->whereIn('status', [
                                      OrderModel::STATUS_PAID,
                                      OrderModel::STATUS_PROCESS,
                                      OrderModel::STATUS_DONE
                                  ])
                                  ->groupBy('payment_method')
                                  ->findAll();
      
      $cashierSessions = $sessionModel->where('DATE(start_time)', $reportDate)
                                    ->orderBy('start_time', 'ASC')
                                    ->findAll();

                                    

      $data = [
          'title' => 'Cetak Laporan Harian',
          'report_date' => $reportDate,
          'incomeByPayment' => $incomeByPayment,
          'cashierSessions' => $cashierSessions,
          'orderModel' => $orderModel
      ];
      
      return view('pages/admin/laporan/cetak_harian', $data);
  }
}