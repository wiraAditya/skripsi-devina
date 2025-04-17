<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = ['nama', 'harga', 'gambar', 'status', 'idKategori'];

    protected $useTimestamps = false;
    
    // Status constants
    const STATUS_AKTIF = 0;
    const STATUS_TERHAPUS = 1;
    const STATUS_TIDAK_TERSEDIA = 2;
    
    // Get status name in Indonesian
    public function getStatusName($status)
    {
        $statuses = [
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_TERHAPUS => 'Terhapus',
            self::STATUS_TIDAK_TERSEDIA => 'Tidak Tersedia'
        ];
        
        return $statuses[$status] ?? 'Tidak Diketahui';
    }
    
    // Get active menus with kategori
    public function getMenuWithKategori()
    {
        return $this->select('menu.*, kategori.kategori as nama_kategori')
                   ->join('kategori', 'kategori.id = menu.idKategori', 'left')
                   ->where('menu.status !=', self::STATUS_TERHAPUS)
                   ->findAll();
    }
    
    // Get paginated menus with kategori
    public function getPaginatedMenuWithKategori($perPage)
    {
        return $this->select('menu.*, kategori.kategori as nama_kategori')
                   ->join('kategori', 'kategori.id = menu.idKategori', 'left')
                   ->where('menu.status !=', self::STATUS_TERHAPUS)
                   ->paginate($perPage);
    }
    
    // Soft delete by setting status to 1
    public function hapus($id)
    {
        return $this->update($id, ['status' => self::STATUS_TERHAPUS]);
    }
    
    // Set as unavailable
    public function setTidakTersedia($id)
    {
        return $this->update($id, ['status' => self::STATUS_TIDAK_TERSEDIA]);
    }
    
    // Set as available
    public function setAktif($id)
    {
        return $this->update($id, ['status' => self::STATUS_AKTIF]);
    }
}