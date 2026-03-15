<?php
$activePage = 'dashboard';
$basePath = './';
require_once __DIR__ . '/../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#111111">
    <meta name="description" content="Dr.Mobile POS System - Dashboard">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Dashboard</title>
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- PWA Icons -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/dashboard.css">
</head>

<body>
    <!-- PWA Client Library -->
    <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../UI/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php include __DIR__ . '/../UI/top-navigation.php'; ?>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Low Stock Alert -->
                <div class="alert-card" id="dashboardAlertCard" style="display: none;">
                    <div class="alert-content">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span id="dashboardAlertText">Loading stock alerts...</span>
                    </div>
                    <a class="alert-btn" href="./inventory/index.php" style="text-decoration: none; color: inherit;">View Inventory</a>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Today's Sales</h3>
                            <div class="value" id="statTodaysSales">LKR 0.00</div>
                            <small style="color: #4caf50;" id="statTodaysSalesSub">Live from sales records</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Orders</h3>
                            <div class="value" id="statOrders">0</div>
                            <small style="color: #4caf50;" id="statOrdersSub">Today's invoices</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Products</h3>
                            <div class="value" id="statProducts">0</div>
                            <small style="color: #ff9800;" id="statProductsSub">0 low stock</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>Customers</h3>
                            <div class="value" id="statCustomers">0</div>
                            <small style="color: #4caf50;" id="statCustomersSub">Registered customers</small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
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
                        <div id="salesOverviewBars" style="height: 250px; display: flex; align-items: flex-end; gap: 10px;">
                            <div style="width: 100%; text-align: center; color: #7a86ad;">Loading chart...</div>
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
                        <div id="topProductsList" style="padding: 10px 0; color: #7a86ad;">Loading top products...</div>
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
                        <tbody id="recentInvoicesBody">
                            <tr>
                                <td colspan="6" style="text-align:center; color:#7a86ad;">Loading invoices...</td>
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
        const DASHBOARD_API = 'http://localhost:3000/api/dashboard/overview';

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function statusBadgeClass(status) {
            const s = String(status || '').toLowerCase();
            if (s === 'completed' || s === 'paid') return 'status-paid';
            if (s === 'processing') return 'status-processing';
            return 'status-pending';
        }

        function renderSalesOverview(data) {
            const root = document.getElementById('salesOverviewBars');
            if (!root) return;
            const labels = Array.isArray(data?.labels) ? data.labels : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            const values = Array.isArray(data?.values) ? data.values : [0, 0, 0, 0, 0, 0, 0];
            const max = Math.max(...values, 1);

            root.innerHTML = labels.map((label, idx) => {
                const value = Number(values[idx] || 0);
                const h = Math.max(10, Math.round((value / max) * 210));
                const highlight = value === Math.max(...values) && value > 0;
                const color = highlight ? '#ffd700' : '#111111';
                return `
                    <div style="flex:1; text-align:center;">
                        <div title="${formatLkr(value)}" style="height:${h}px; background:${color}; border-radius:8px 8px 0 0; margin-bottom:8px;"></div>
                        <span style="font-size:12px;">${label}</span>
                    </div>
                `;
            }).join('');
        }

        function renderTopProducts(list) {
            const root = document.getElementById('topProductsList');
            if (!root) return;
            if (!Array.isArray(list) || list.length === 0) {
                root.innerHTML = '<div style="padding: 6px 0; color:#7a86ad;">No product sales yet.</div>';
                return;
            }

            root.innerHTML = list.map((p) => {
                const pct = Number(p.percentage || 0);
                return `
                    <div style="margin-bottom: 15px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:5px; gap: 8px;">
                            <span style="font-size:13px; overflow-wrap:anywhere;">${p.name}</span>
                            <span style="font-size:13px; font-weight:600;">${pct}%</span>
                        </div>
                        <div style="height:8px; background:#f0f0f0; border-radius:4px;">
                            <div style="width:${Math.min(100, pct)}%; height:100%; background:#111111; border-radius:4px;"></div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderRecentInvoices(rows) {
            const body = document.getElementById('recentInvoicesBody');
            if (!body) return;
            if (!Array.isArray(rows) || rows.length === 0) {
                body.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#7a86ad;">No invoices found.</td></tr>';
                return;
            }

            body.innerHTML = rows.map((r) => `
                <tr>
                    <td>${r.invoiceNo || '-'}</td>
                    <td>${r.customer || 'Walk-in Customer'}</td>
                    <td>${r.date || '-'}</td>
                    <td>${formatLkr(r.amount)}</td>
                    <td><span class="status-badge ${statusBadgeClass(r.status)}">${String(r.status || 'pending').toUpperCase()}</span></td>
                    <td><a href="./invoices-quotations/index.php" title="View Invoices"><i class="fas fa-print" style="cursor:pointer; color:#111111;"></i></a></td>
                </tr>
            `).join('');
        }

        async function loadDashboardOverview() {
            try {
                const resp = await fetch(DASHBOARD_API);
                const json = await resp.json();
                if (!resp.ok || !json.success || !json.data) {
                    throw new Error(json.message || 'Failed to load dashboard data');
                }
                const data = json.data;

                const stats = data.stats || {};
                const alerts = data.alerts || {};

                const alertCard = document.getElementById('dashboardAlertCard');
                const alertText = document.getElementById('dashboardAlertText');
                const lowStockCount = Number(alerts.lowStock || 0);
                const outOfStockCount = Number(alerts.outOfStock || 0);
                const hasStockAlert = lowStockCount > 0 || outOfStockCount > 0;

                if (alertCard) {
                    alertCard.style.display = hasStockAlert ? '' : 'none';
                }
                if (alertText && hasStockAlert) {
                    alertText.textContent = alerts.text || 'Stock attention required.';
                }

                const statTodaysSales = document.getElementById('statTodaysSales');
                const statOrders = document.getElementById('statOrders');
                const statProducts = document.getElementById('statProducts');
                const statCustomers = document.getElementById('statCustomers');
                const statProductsSub = document.getElementById('statProductsSub');

                if (statTodaysSales) statTodaysSales.textContent = formatLkr(stats.todaysSales || 0);
                if (statOrders) statOrders.textContent = Number(stats.todaysOrders || 0).toLocaleString();
                if (statProducts) statProducts.textContent = Number(stats.productsCount || 0).toLocaleString();
                if (statCustomers) statCustomers.textContent = Number(stats.customersCount || 0).toLocaleString();
                if (statProductsSub) statProductsSub.textContent = `${Number(stats.lowStock || 0).toLocaleString()} low stock`;

                renderSalesOverview(data.salesOverview);
                renderTopProducts(data.topProducts || []);
                renderRecentInvoices(data.recentInvoices || []);
            } catch (error) {
                const alertCard = document.getElementById('dashboardAlertCard');
                const alertText = document.getElementById('dashboardAlertText');
                if (alertCard) {
                    alertCard.style.display = 'none';
                }
                if (alertText) {
                    alertText.textContent = 'Failed to load live dashboard data.';
                }
                console.error('Dashboard data load failed:', error);
            }
        }

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

        document.addEventListener('DOMContentLoaded', loadDashboardOverview);
    </script>
</body>

</html>