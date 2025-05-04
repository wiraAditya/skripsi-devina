<?php

namespace App\Controllers;

class ExpiredController extends BaseController
{
    public function index()
    {
        return view('expired/index');
    }
}