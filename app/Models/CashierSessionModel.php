<?php
namespace App\Models;

use CodeIgniter\Model;

class CashierSessionModel extends Model
{
    protected $table = 'cashier_sessions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'start_time', 'starting_cash', 'status', 'ending_cash', 'expected_cash', 'discrepancy', 'end_time'];

    public function getActiveSession(int $userId)
    {
        return $this->where('user_id', $userId)
                   ->where('status', 'open')
                   ->first();
    }
}