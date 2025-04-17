<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = ['kategori', 'status'];

    protected $useTimestamps = false;
    
    // Only get active categories (status != 1)
    public function getActiveCategories()
    {
        return $this->where('status !=', 1)->findAll();
    }
    
    // Soft delete by setting status to 1
    public function softDelete($id)
    {
        return $this->update($id, ['status' => 1]);
    }
}