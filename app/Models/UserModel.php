<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = ['email', 'password', 'role', 'nama', 'status'];

    protected $useTimestamps = false;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }


    public function getUsersWithRoleName()
    {
        $users = $this->findAll();

        foreach ($users as &$user) {
            $user['role_name'] = $this->getRoleName($user['role']);
        }

        return $users;
    }

    public function getRoleName($role)
    {
        $roles = [
            1 => 'Admin',
            2 => 'Barista',
            3 => 'Kasir',
        ];

        return $roles[$role] ?? 'Unknown';
    }
}
