<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KategoriModel;

class MenuController extends BaseController
{
    protected $helpers = ['form'];
    
    public function index(): string
    {
        $menuModel = new MenuModel();
        $perPage = 10;

        $menus = $menuModel->getPaginatedMenuWithKategori($perPage);
        $pager = $menuModel->pager;

        return view('pages/admin/menu/menu', [
            'title' => 'Manajemen Menu',
            'activeRoute' => 'menu',
            'menus' => $menus,
            'pager' => $pager,
            'model' => $menuModel
        ]);
    }

    public function create()
    {
        $kategoriModel = new KategoriModel();
        $kategories = $kategoriModel->where('status !=', 1)->findAll();

        return view('pages/admin/menu/menu_create', [
            'title' => 'Tambah Menu Baru',
            'activeRoute' => 'menu',
            'kategories' => $kategories,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        $menuModel = new MenuModel();
        
        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'harga' => 'required|numeric',
            'idKategori' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $file = $this->request->getFile('gambar');
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/menu', $newName);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'idKategori' => $this->request->getPost('idKategori'),
            'gambar' => $newName,
            'status' => MenuModel::STATUS_AKTIF,
        ];

        $menuModel->insert($data);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu || $menu['status'] == MenuModel::STATUS_TERHAPUS) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $kategoriModel = new KategoriModel();
        $kategories = $kategoriModel->where('status !=', 1)->findAll();

        return view('pages/admin/menu/menu_edit', [
            'title' => 'Edit Menu',
            'activeRoute' => 'menu',
            'menu' => $menu,
            'kategories' => $kategories,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);
        
        if (!$menu || $menu['status'] == MenuModel::STATUS_TERHAPUS) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'harga' => 'required|numeric',
            'idKategori' => 'required|numeric',
        ];

        // Only validate image if uploaded
        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'idKategori' => $this->request->getPost('idKategori'),
        ];

        // Handle file upload if new image is provided
        $file = $this->request->getFile('gambar');
        if ($file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if ($menu['gambar'] && file_exists(ROOTPATH . 'public/uploads/menu/' . $menu['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/menu/' . $menu['gambar']);
            }
            
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/menu', $newName);
            $data['gambar'] = $newName;
        }

        $menuModel->update($id, $data);

        return redirect()->to('/admin/menu')->with('success', 'Data menu berhasil diperbarui');
    }
    
    
    public function delete($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu || $menu['status'] == MenuModel::STATUS_TERHAPUS) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $menuModel->hapus($id);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil dihapus');
    }
    
    public function toggleStatus($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu || $menu['status'] == MenuModel::STATUS_TERHAPUS) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $newStatus = ($menu['status'] == MenuModel::STATUS_AKTIF)
            ? MenuModel::STATUS_TIDAK_TERSEDIA
            : MenuModel::STATUS_AKTIF;
            
        $menuModel->update($id, ['status' => $newStatus]);

        $message = ($newStatus == MenuModel::STATUS_AKTIF)
            ? 'Menu diaktifkan kembali'
            : 'Menu ditandai tidak tersedia';
            
        return redirect()->to('/admin/menu')->with('success', $message);
    }
}