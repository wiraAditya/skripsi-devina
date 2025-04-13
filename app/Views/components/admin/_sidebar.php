<aside class="fixed top-0 left-0 h-screen w-64 bg-gray-800 text-gray-100 flex flex-col border-r border-gray-700">
    <!-- Sidebar Header -->
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-lg font-semibold flex items-center">
            <i class="fas fa-cog mr-2 text-blue-400"></i>
            <span>Admin Panel</span>
        </h2>
    </div>

    <!-- Scrollable Menu Items -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-2">
        <ul class="space-y-1 px-2">
            <!-- Dashboard -->
            <li>
                <a href="<?= site_url('admin/dashboard') ?>" class="flex items-center p-3 rounded-lg <?= ($activeRoute === 'dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Users -->
            <li>
                <a href="<?= site_url('admin/users') ?>" class="flex items-center p-3 rounded-lg <?= ($activeRoute === 'users') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-users mr-3 w-5 text-center"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Products (Example) -->
            <li>
                <a href="<?= site_url('admin/products') ?>" class="flex items-center p-3 rounded-lg <?= ($activeRoute === 'products') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-boxes mr-3 w-5 text-center"></i>
                    <span>Products</span>
                </a>
            </li>

            <!-- Collapsible Settings Menu -->
            <li x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center p-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                    <span class="flex-1 text-left">Settings</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>
                <ul x-show="open" class="mt-1 pl-8 space-y-1">
                    <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-700">General</a></li>
                    <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-700">Security</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
        <i class="fas fa-user-circle mr-2"></i>
        <span>Logged in as Admin</span>
    </div>
</aside>