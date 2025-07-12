<?php
$roles = [
    1 => 'Admin',
    2 => 'Barista',
    3 => 'Kasir',
];
$sidebar = [
    'dashboard' => [
        'title' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'url' => site_url('admin'),
        'allowed_roles' => [1, 2,3],
        'children' => []
    ],
    'users' => [
        'title' => 'Users',
        'icon' => 'fas fa-users',
        'url' => site_url('admin/users'),
        'allowed_roles' => [1],
        'children' => []
    ],
    'kategori' => [
        'title' => 'Kategori',
        'icon' => 'fas fa-tags',
        'url' => site_url('admin/kategori'),
        'allowed_roles' => [1], 
        'children' => []
    ],
    'menu' => [
        'title' => 'Menu',
        'icon' => 'fas fa-utensils',
        'url' => site_url('admin/menu'),
        'allowed_roles' => [1], 
        'children' => []
    ],
    'order' => [
        'title' => $roles[session()->get('user_role')].' Orders',
        'icon' => 'fas fa-money-bill',
        'url' => site_url('admin/order'),
        'allowed_roles' => [1, 2, 3], 
        'children' => []
    ],
    'all_orders' => [
        'title' => 'History Orders',
        'icon' => 'fas fa-money-bill',
        'url' => site_url('admin/all-order'),
        'allowed_roles' => [2, 3], 
        'children' => []
    ],
    
    'laporan_harian' => [
        'title' => 'Laporan Harian',
        'icon' => 'fas fa-money-bill',
        'url' => site_url('admin/laporan/harian'),
        'allowed_roles' => [ 3], 
        'children' => []
    ],
    'laporan_penjualan' => [
        'title' => 'Laporan Penjualan',
        'icon' => 'fas fa-money-bill',
        'url' => site_url('admin/laporan/penjualan'),
        'allowed_roles' => [1, 3], 
        'children' => []
    ],
];
?>

<aside class="fixed top-0 left-0 h-screen w-64 bg-gray-800 text-gray-100 flex flex-col border-r border-gray-700">
    <!-- Sidebar Header -->
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-lg font-semibold flex items-center">
            <i class="fas fa-cog mr-2 text-blue-400"></i>
            <span>Korner Circle K</span>
        </h2>
    </div>

    <!-- Scrollable Menu Items -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-2">
        <ul class="space-y-1 px-2">
            <?php 
            $currentRole = session()->get('user_role'); // Make sure this is set in your login
            $currentRoleText = session()->get('user_role_text'); // Make sure this is set in your login
            foreach ($sidebar as $route => $item): 
            // Check if user role has access to this menu item
                if (!empty($item['allowed_roles'])) {
                    if (!in_array($currentRole, $item['allowed_roles'])) {
                        continue; // Skip this item if role not allowed
                    }
                }
            ?>
                <?php if (empty($item['children'])): ?>
                    <!-- Single Menu Item -->
                    <li>
                        <a href="<?= $item['url'] ?>" class="flex items-center p-3 rounded-lg <?= ($activeRoute === $route) ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' ?>">
                            <i class="<?= $item['icon'] ?> mr-3 w-5 text-center"></i>
                            <span><?= $item['title'] ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Collapsible Menu Item -->
                    <li x-data="{ open: <?= in_array($activeRoute, array_keys($item['children'])) ? 'true' : 'false' ?> }">
                        <button @click="open = !open" class="w-full flex items-center p-3 rounded-lg hover:bg-gray-700">
                            <i class="<?= $item['icon'] ?> mr-3 w-5 text-center"></i>
                            <span class="flex-1 text-left"><?= $item['title'] ?></span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <ul x-show="open" class="mt-1 pl-8 space-y-1">
                            <?php foreach ($item['children'] as $childRoute => $childItem): 
                                // Check role access for child items too
                                if (!empty($childItem['allowed_roles'])) {
                                    if (!in_array($currentRole, $childItem['allowed_roles'])) {
                                        continue;
                                    }
                                }
                            ?>
                                <li>
                                    <a href="<?= $childItem['url'] ?>" class="block p-2 rounded-lg <?= ($activeRoute === $childRoute) ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' ?>">
                                        <?= $childItem['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
        <i class="fas fa-user-circle mr-2"></i>
        <span>Logged in as <?= session()->get('user_name') ?> (Role: <?= $currentRoleText ?>)</span>
    </div>
</aside>