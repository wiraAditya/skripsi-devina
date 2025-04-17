<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    public function index(): string
    {
        $kategoriModel = new KategoriModel();

        $perPage = 10;
        $kategories = $kategoriModel->where('status !=', 1)->paginate($perPage);
        $pager = $kategoriModel->pager;

        return view('pages/admin/kategori/kategori', [
            'title' => 'Manajemen Kategori',
            'activeRoute' => 'kategori',
            'kategories' => $kategories,
            'pager' => $pager,
        ]);
    }

    public function create()
    {
        return view('pages/admin/kategori/kategori_create', [
            'title' => 'Tambah Kategori Baru',
            'activeRoute' => 'kategori',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'kategori' => 'required|min_length[3]|max_length[50]|is_unique[kategori.kategori]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kategoriModel = new KategoriModel();
        
        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'status' => 0, // Active by default
        ];

        $kategoriModel->insert($data);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori || $kategori['status'] == 1) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        return view('pages/admin/kategori/kategori_edit', [
            'title' => 'Edit Kategori',
            'activeRoute' => 'kategori',
            'kategori' => $kategori,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->find($id);
        
        if (!$kategori || $kategori['status'] == 1) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'kategori' => "required|min_length[3]|max_length[50]|is_unique[kategori.kategori,id,$id]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
        ];

        $kategoriModel->update($id, $data);

        return redirect()->to('/admin/kategori')->with('success', 'Data kategori berhasil diperbarui');
    }
    
    public function delete($id)
    {
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori || $kategori['status'] == 1) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        // Soft delete by setting status to 1
        $kategoriModel->softDelete($id);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}