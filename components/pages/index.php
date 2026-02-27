<?php
$activePage = 'dashboard';
$basePath = './';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Dashboard</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../UI/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <div class="top-header">
                <div class="header-left">
                    <i class="fas fa-bars menu-toggle" id="menuToggle" onclick="toggleSidebar()"></i>
                    <h1 class="page-title">Dashboard</h1>
                </div>

                <div class="header-center">
                    <div class="search-box" id="searchTrigger" role="button" aria-haspopup="dialog" aria-controls="searchOverlay" tabindex="0">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search..." id="globalSearch" aria-label="Global search" readonly>
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-icon">
                        <i class="far fa-bell"></i>
                        <span class="badge">5</span>
                    </div>

                    <div class="header-icon">
                        <i class="far fa-envelope"></i>
                        <span class="badge">3</span>
                    </div>

                    <div class="user-profile">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=1a237e&color=ffd700&bold=true" alt="User">
                        <div class="user-info">
                            <h4>Admin User</h4>
                            <p>Super Admin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Low Stock Alert -->
                <div class="alert-card">
                    <div class="alert-content">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>4 products are running low on stock. 2 items are out of stock!</span>
                    </div>
                    <div class="alert-btn">View Inventory</div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Today's Sales</h3>
                            <div class="value">LKR 12,450</div>
                            <small style="color: #4caf50;">↑ 12% from yesterday</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Orders</h3>
                            <div class="value">156</div>
                            <small style="color: #4caf50;">+23 new</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Products</h3>
                            <div class="value">1,245</div>
                            <small style="color: #ff9800;">12 low stock</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Customers</h3>
                            <div class="value">892</div>
                            <small style="color: #4caf50;">+18 this week</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                    </div>
                </div>

                
                    <br>

                    

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Sale</span>
                    </div>
                    <div class="action-btn">
                        <i class="fas fa-file-invoice"></i>
                        <span>Create Invoice</span>
                    </div>
                    <div class="action-btn">
                        <i class="fas fa-box"></i>
                        <span>Add Product</span>
                    </div>
                    <div class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        <span>New Customer</span>
                    </div>
                    <div class="action-btn">
                        <i class="fas fa-truck"></i>
                        <span>New Order</span>
                    </div>
                    <div class="action-btn">
                        <i class="fas fa-print"></i>
                        <span>Print Label</span>
                    </div>
                </div>

                <br>
                

                <!-- Charts Row -->
                <div class="charts-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Sales Overview</h3>
                            <select>
                                <option>This Week</option>
                                <option>This Month</option>
                                <option>This Year</option>
                            </select>
                        </div>
                        <div style="height: 250px; display: flex; align-items: flex-end; gap: 10px;">
                            <!-- Simple bar chart representation -->
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 120px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Mon</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 180px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Tue</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 150px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Wed</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 200px; background: #ffd700; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Thu</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 160px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Fri</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 190px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Sat</span>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <div style="height: 140px; background: #1a237e; border-radius: 8px 8px 0 0; margin-bottom: 8px;"></div>
                                <span style="font-size: 12px;">Sun</span>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Top Products</h3>
                            <select>
                                <option>Today</option>
                                <option>This Week</option>
                            </select>
                        </div>
                        <div style="padding: 10px 0;">
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">iPhone 14 Pro</span>
                                    <span style="font-size: 13px; font-weight: 600;">45%</span>
                                </div>
                                <div style="height: 8px; background: #f0f0f0; border-radius: 4px;">
                                    <div style="width: 45%; height: 100%; background: #1a237e; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Samsung S23</span>
                                    <span style="font-size: 13px; font-weight: 600;">32%</span>
                                </div>
                                <div style="height: 8px; background: #f0f0f0; border-radius: 4px;">
                                    <div style="width: 32%; height: 100%; background: #1a237e; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Google Pixel 7</span>
                                    <span style="font-size: 13px; font-weight: 600;">28%</span>
                                </div>
                                <div style="height: 8px; background: #f0f0f0; border-radius: 4px;">
                                    <div style="width: 28%; height: 100%; background: #1a237e; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Xiaomi 13</span>
                                    <span style="font-size: 13px; font-weight: 600;">21%</span>
                                </div>
                                <div style="height: 8px; background: #f0f0f0; border-radius: 4px;">
                                    <div style="width: 21%; height: 100%; background: #1a237e; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Recent Invoices</h3>
                        <span class="view-all">View All →</span>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-2024-001</td>
                                <td>John Smith</td>
                                <td>2024-01-15</td>
                                <td>LKR 1,299</td>
                                <td><span class="status-badge status-paid">Paid</span></td>
                                <td><i class="fas fa-print" style="cursor: pointer; color: #1a237e;"></i></td>
                            </tr>
                            <tr>
                                <td>INV-2024-002</td>
                                <td>Sarah Johnson</td>
                                <td>2024-01-15</td>
                                <td>LKR 899</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><i class="fas fa-print" style="cursor: pointer; color: #1a237e;"></i></td>
                            </tr>
                            <tr>
                                <td>INV-2024-003</td>
                                <td>Mike Wilson</td>
                                <td>2024-01-14</td>
                                <td>LKR 2,450</td>
                                <td><span class="status-badge status-processing">Processing</span></td>
                                <td><i class="fas fa-print" style="cursor: pointer; color: #1a237e;"></i></td>
                            </tr>
                            <tr>
                                <td>INV-2024-004</td>
                                <td>Emma Davis</td>
                                <td>2024-01-14</td>
                                <td>LKR 699</td>
                                <td><span class="status-badge status-paid">Paid</span></td>
                                <td><i class="fas fa-print" style="cursor: pointer; color: #1a237e;"></i></td>
                            </tr>
                            <tr>
                                <td>INV-2024-005</td>
                                <td>David Brown</td>
                                <td>2024-01-13</td>
                                <td>LKR 1,599</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><i class="fas fa-print" style="cursor: pointer; color: #1a237e;"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="Global search">
        <div class="search-dialog" role="document">
            <div class="search-dialog-header">
                <i class="fas fa-search"></i>
                <button class="search-close" type="button" id="searchClose" aria-label="Close search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <input type="text" id="globalSearchModal" placeholder="Type to search..." autocomplete="off">
            <p class="search-hint">Press Esc to close</p>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Make nav items clickable
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        const searchOverlay = document.getElementById('searchOverlay');
        const searchModalInput = document.getElementById('globalSearchModal');
        const searchTrigger = document.getElementById('searchTrigger');
        const searchClose = document.getElementById('searchClose');

        function openSearchModal() {
            if (!searchOverlay || !searchModalInput) {
                return;
            }

            searchOverlay.classList.add('active');
            searchModalInput.focus();
            searchModalInput.select();
        }

        function closeSearchModal() {
            if (!searchOverlay) {
                return;
            }

            searchOverlay.classList.remove('active');
        }

        if (searchTrigger) {
            searchTrigger.addEventListener('click', openSearchModal);
            searchTrigger.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openSearchModal();
                }
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', closeSearchModal);
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', function(event) {
                if (event.target === searchOverlay) {
                    closeSearchModal();
                }
            });
        }

        // Ctrl/Cmd + K opens the global search
        document.addEventListener('keydown', function(event) {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                openSearchModal();
            }

            if (event.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                closeSearchModal();
            }
        });
    </script>
</body>

</html>