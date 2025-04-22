<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KategoriModel;

class HomeMenuController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        $kategoriModel = new KategoriModel();

        // Get filter from query string
        $selectedFilter = $this->request->getGet('filter') ?? 'semua';

        // Get active menus with kategori
        $query = $menuModel->select('menu.*, kategori.kategori as nama_kategori')
                          ->join('kategori', 'kategori.id = menu.idKategori', 'left')
                          ->where('menu.status', MenuModel::STATUS_AKTIF);

        // Apply category filter if selected
        if ($selectedFilter !== 'semua') {
            $query->where('kategori.kategori', $selectedFilter);
        }

        $menus = $query->findAll();

        // Get unique categories for filter pills
        $categories = $kategoriModel->select('kategori')
                                  ->where('status !=', 1)
                                  ->findAll();
        
        $pils = ['Semua']; // Default first option
        foreach ($categories as $category) {
            $pils[] = $category['kategori'];
        }

        return view('pages/public/menu', [
            'title' => 'Menu Kami',
            'menus' => $menus,
            'pils' => $pils,
            'selectedPils' => $selectedFilter,
            'baseUrl' => '/menu'
        ]);
    }
}