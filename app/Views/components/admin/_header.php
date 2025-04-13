<header class="sticky top-0 z-50 bg-gray-900 text-white shadow-md ml-64">
    <div class="flex items-center justify-between p-4">
        <!-- Left: Page Title & Breadcrumbs -->
        <div class="flex items-center space-x-4">
            <!-- Toggle Sidebar Button (Mobile) - Optional -->
            <button class="lg:hidden text-gray-300 hover:text-white focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Page Title -->
            <h1 class="text-xl font-semibold">
                <?= $title ?? 'Dashboard' ?>
            </h1>
        </div>

        <!-- Right: User Menu & Notifications -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative p-1 text-gray-300 hover:text-white focus:outline-none">
                <i class="fas fa-bell"></i>
                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
            </button>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    class="flex items-center space-x-2 focus:outline-none"
                >
                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="hidden md:inline">John Doe</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="open" 
                    @click.away="open = false" 
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-800 z-50"
                >
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-2"></i> Profile
                    </a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="<?= site_url('logout') ?>" class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>