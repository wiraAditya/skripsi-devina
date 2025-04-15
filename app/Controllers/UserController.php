<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $perPage = 10;
        $users = $userModel->paginate($perPage);
        $pager = $userModel->pager;

        // Add role_name to each user
        foreach ($users as &$user) {
            $user['role_name'] = $userModel->getRoleName($user['role']);
        }

        return view('pages/admin/user/user', [
            'title' => 'Dashboard',
            'activeRoute' => 'dashboard',
            'users' => $users,
            'pager' => $pager,
        ]);
    }

    public function create()
    {
        return view('pages/admin/user/user_create', [
            'title' => 'Tambah Pengguna Baru',
            'activeRoute' => 'users',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[3]',
            'role' => 'required|in_list[2,3]', // 2=barista, 3=kasir
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'status' => 1,
        ];

        $userModel->insert($data);

        return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        return view('pages/admin/user/user_edit', [
            'title' => 'Edit User',
            'activeRoute' => 'users',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        
        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'email' => "required|valid_email|is_unique[user.email,id,$id]",
            'role' => 'required|in_list[1,2,3]', // 1=admin, 2=barista, 3=kasir
        ];

        // Only validate password if it's provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[3]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
            // Model's beforeUpdate will handle the MD5 hashing
        }

        $userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diperbarui');
    }
    
    public function delete($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
    }
}
