<?php namespace App\Controllers;

use App\Models\CashierSessionModel;
use App\Models\OrderModel;

class CashierSessionController extends BaseController
{
    public function open()
    {
        return view('pages/admin/sessions/open',[
        'activeRoute' => 'order',

        ]);
    }

    public function storeOpen()
    {
        $rules = [
            'starting_cash' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $sessionModel = new CashierSessionModel();
        $userId = session()->get('user_id');

        // Check for existing open session
        if ($sessionModel->where('user_id', $userId)
                        ->where('status', 'open')
                        ->countAllResults() > 0) {
            return redirect()->to('/admin/order')
                           ->with('error', 'You already have an open session');
        }

        $sessionModel->insert([
            'user_id' => $userId,
            'start_time' => date('Y-m-d H:i:s'),
            'starting_cash' => $this->request->getPost('starting_cash'),
            'status' => 'open'
        ]);

        return redirect()->to('/admin/order')
                       ->with('success', 'Cashier session opened successfully');
    }

    public function close($sessionId)
    {
        $sessionModel = new CashierSessionModel();
        $session = $sessionModel->find($sessionId);
        
        if (!$session || $session['status'] === 'closed') {
            return redirect()->to('/admin/order')
                           ->with('error', 'Invalid session');
        }

        return view('pages/admin/sessions/close', ['session' => $session, 
        'activeRoute' => 'order',
      ]);
    }

    public function storeClose($sessionId)
    {
        $rules = [
            'ending_cash' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                          ->withInput()
                          ->with('errors', $this->validator->getErrors());
        }

        $sessionModel = new CashierSessionModel();
        $orderModel = new OrderModel();
        $session = $sessionModel->find($sessionId);
        
        if (!$session || $session['status'] === 'closed') {
            return redirect()->to('/admin/order')
                          ->with('error', 'Invalid session');
        }

        // Calculate expected cash - only count PAID, PROCESS, DONE statuses
        $cashOrders = $orderModel->where('cashier_session_id', $sessionId)
                                ->where('payment_method', OrderModel::PAYMENT_CASH)
                                ->whereIn('status', [
                                    OrderModel::STATUS_PAID,
                                    OrderModel::STATUS_PROCESS,
                                    OrderModel::STATUS_DONE
                                ])
                                ->select('SUM(total) AS net_cash')
                                ->first();

        $expectedCash = $session['starting_cash'] + ($cashOrders['net_cash'] ?? 0);
        $endingCash = $this->request->getPost('ending_cash');
        $discrepancy = $endingCash - $expectedCash;


        $sessionModel->update($sessionId, [
            'end_time' => date('Y-m-d H:i:s'),
            'ending_cash' => $endingCash,
            'expected_cash' => $expectedCash,
            'status' => 'closed',
            'discrepancy' => $discrepancy
        ]);

        // Prepare success message with financial summary
        $discrepancyFormatted = number_format(abs($discrepancy), 0, ',', '.');
        $message = sprintf(
            "Sesi kasir ditutup. Saldo akhir: Rp %s | Selisih: Rp %s (%s)",
            number_format($endingCash, 0, ',', '.'),
            $discrepancyFormatted,
            ($discrepancy >= 0) ? 'lebih' : 'kurang'
        );

        return redirect()->to('/admin/order')
                      ->with('success', $message);
    }
}