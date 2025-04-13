<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/public/order');
    }
    public function menu(): string
    {
        return view('pages/public/menu');
    }
}
