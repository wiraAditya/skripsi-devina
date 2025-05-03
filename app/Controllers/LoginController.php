<?php

namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index(): string
    {
        return view('pages/auth/login');
    }
    public function login()
    {
        $session = session();
        $userModel = new UserModel();
        
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();
            if ($user) {
                if (password_verify($password, $user['password']))  {
                    // Set session
                    $sessionData = [
                        'user_id' => $user['id'],
                        'user_name' => $user['nama'],
                        'user_email' => $user['email'],
                        'user_role' => $user['role'],
                        'user_role_text' =>$userModel->getRoleName($user['role'])
                    ];
                    $session->set($sessionData);

                    return redirect()->to('/admin');
                } else {
                    return redirect()->back()->with('error', 'Password salah.');
                }
            } else {
                return redirect()->back()->with('error', 'Email tidak ditemukan.');
            }
        }

        return redirect()->back();

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
