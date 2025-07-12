<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    
    <!-- Welcome Message -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <p class="text-xl font-bold">Selamat datang di KORNER CIRCLE K Dalung</p>
        <p>Anda login sebagai: <?= session()->user_role_text ?></p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <form method="get" action="<?= base_url('admin') ?>">
            <div class="flex items-center space-x-4 mb-4">
                <div class="flex items-center">
                    <input type="radio" id="dailyFilter" name="filter" value="daily" 
                        <?= $filter === 'daily' ? 'checked' : '' ?> class="mr-2">
                    <label for="dailyFilter">Harian</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="monthlyFilter" name="filter" value="monthly" 
                        <?= $filter === 'monthly' ? 'checked' : '' ?> class="mr-2">
                    <label for="monthlyFilter">Bulanan</label>
                </div>
            </div>

            <div id="dailyInput" class="mb-4 <?= $filter === 'monthly' ? 'hidden' : '' ?>">
                <label for="dateInput" class="block mb-2">Pilih Tanggal:</label>
                <input type="date" id="dateInput" name="date" class="border rounded p-2" 
                    value="<?= $date ?>">
            </div>

            <div id="monthlyInput" class="mb-4 <?= $filter === 'daily' ? 'hidden' : '' ?>">
                <div class="flex space-x-4">
                    <div>
                        <label for="monthInput" class="block mb-2">Bulan:</label>
                        <select id="monthInput" name="month" class="border rounded p-2">
                            <?php foreach ($months as $key => $name): ?>
                                <option value="<?= $key ?>" <?= $key == $month ? 'selected' : '' ?>>
                                    <?= $name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="yearInput" class="block mb-2">Tahun:</label>
                        <select id="yearInput" name="year" class="border rounded p-2">
                            <?php foreach ($years as $yearOption): ?>
                                <option value="<?= $yearOption ?>" <?= $yearOption == $year ? 'selected' : '' ?>>
                                    <?= $yearOption ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Summary Cards - Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Orders -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Total Pesanan</h3>
            <p class="text-3xl font-bold"><?= $summary['totalOrders'] ?></p>
            <p class="text-sm text-gray-500">
                <?= $filter === 'daily' ? 'Hari ini' : 'Bulan ini' ?>
            </p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Total Pendapatan</h3>
            <p class="text-3xl font-bold">Rp <?= number_format($summary['totalRevenue']) ?></p>
            <p class="text-sm text-gray-500">
                <?= $filter === 'daily' ? 'Hari ini' : 'Bulan ini' ?>
            </p>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Rata-rata Pesanan</h3>
            <p class="text-3xl font-bold">Rp <?= number_format($summary['avgOrderValue']) ?></p>
            <p class="text-sm text-gray-500">
                <?= $filter === 'daily' ? 'Hari ini' : 'Bulan ini' ?>
            </p>
        </div>

        <!-- Popular Menu -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Menu Populer</h3>
            <p class="text-3xl font-bold"><?= $summary['popularMenu'] ?: '-' ?></p>
            <p class="text-sm text-gray-500">
                <?= $filter === 'daily' ? 'Hari ini' : 'Bulan ini' ?>
            </p>
        </div>
    </div>

    <!-- Summary Cards - Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Pesanan Terakhir</h3>
            <p class="text-3xl font-bold"><?= count($recentOrders) ?></p>
            <p class="text-sm text-gray-500">5 pesanan terbaru</p>
        </div>

        <!-- Pending Payments (Admin/Cashier only) -->
        <?php if (in_array(session()->user_role, [1, 3])): ?>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-2">Pembayaran Tertunda</h3>
                <p class="text-3xl font-bold"><?= count($pendingPayments) ?></p>
                <p class="text-sm text-gray-500">Menunggu pembayaran</p>
            </div>
        <?php endif; ?>

        <!-- Processing Orders (Admin/Barista only) -->
        <?php if (in_array(session()->user_role, [1, 2])): ?>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-2">Pesanan Diproses</h3>
                <p class="text-3xl font-bold"><?= count($processingOrders) ?></p>
                <p class="text-sm text-gray-500">Sedang diproses</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Orders Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Grafik Pesanan</h3>
            <div style="max-height: 400px; position: relative;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Grafik Pendapatan</h3>
            <div style="max-height: 400px; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($chartData['labels']) ?>,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: <?= json_encode($chartData['ordersData']) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartData['labels']) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode($chartData['revenueData']) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Toggle between daily and monthly inputs
        document.getElementById('dailyFilter').addEventListener('change', function() {
            document.getElementById('dailyInput').classList.remove('hidden');
            document.getElementById('monthlyInput').classList.add('hidden');
        });

        document.getElementById('monthlyFilter').addEventListener('change', function() {
            document.getElementById('dailyInput').classList.add('hidden');
            document.getElementById('monthlyInput').classList.remove('hidden');
        });
    </script>
<?= $this->endSection() ?>