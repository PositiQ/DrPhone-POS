<?php
$activePage = 'customers';
$basePath = '../';
$pageTitle = 'Customers';
$pageSubtitle = 'Manage customers, invoices, and credit sales.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Customers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <div class="top-header">
                <div class="header-left">
                    <i class="fas fa-bars menu-toggle" id="menuToggle" onclick="toggleSidebar()"></i>
                    <h1 class="page-title"><?php echo $pageTitle; ?></h1>
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

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <input type="text" id="searchCustomers" placeholder="Search by name, phone, email..." style="min-width: 300px;">
                        <select id="statusFilter" aria-label="Status">
                            <option>All Customers</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>VIP</option>
                        </select>
                        <select id="creditFilter" aria-label="Credit Status">
                            <option>All Credit Status</option>
                            <option>Has Outstanding</option>
                            <option>Fully Paid</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="add-customer.php">
                            <i class="fas fa-plus"></i>
                            Add Customer
                        </a>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Total Customers</h4>
                        <div class="metric-value">1,847</div>
                        <div class="metric-sub">Registered customers</div>
                    </div>
                    <div class="metric-card">
                        <h4>Active Customers</h4>
                        <div class="metric-value" style="color: #4caf50;">1,623</div>
                        <div class="metric-sub">Recent purchases</div>
                    </div>
                    <div class="metric-card">
                        <h4>Outstanding Credit</h4>
                        <div class="metric-value" style="color: #ff9800;">LKR 2.8M</div>
                        <div class="metric-sub">Pending payments</div>
                    </div>
                    <div class="metric-card">
                        <h4>VIP Customers</h4>
                        <div class="metric-value" style="color: #2196f3;">87</div>
                        <div class="metric-sub">Premium members</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Customer Directory</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-filter="all">All</button>
                            <button class="pill" type="button" data-filter="active">Active</button>
                            <button class="pill" type="button" data-filter="vip">VIP</button>
                            <button class="pill" type="button" data-filter="credit">Has Credit</button>
                        </div>
                    </div>
                    <table style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Customer Name</th>
                                <th style="width: 12%;">Phone</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 12%;">Total Purchases</th>
                                <th style="width: 10%;">Credit Balance</th>
                                <th style="width: 10%;">Last Purchase</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 11%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customerTable">
                            <tr data-status="vip" data-credit="has">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1a237e; font-size: 16px; font-weight: 600;">
                                            SK
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Sandun Kumarasinghe</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1024</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 77 123 4567</td>
                                <td>sandun.k@email.com</td>
                                <td><strong>LKR 2.4M</strong></td>
                                <td><strong style="color: #ff9800;">LKR 125,000</strong></td>
                                <td>2026-02-21</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #b45f06;">VIP</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-credit="none">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 600;">
                                            NP
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Nimal Perera</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1025</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 71 234 5678</td>
                                <td>nimal.p@email.com</td>
                                <td><strong>LKR 850,000</strong></td>
                                <td><strong style="color: #4caf50;">LKR 0</strong></td>
                                <td>2026-02-18</td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-credit="has">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 600;">
                                            AS
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Anusha Silva</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1026</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 76 345 6789</td>
                                <td>anusha.s@email.com</td>
                                <td><strong>LKR 1.2M</strong></td>
                                <td><strong style="color: #ff9800;">LKR 45,000</strong></td>
                                <td>2026-02-20</td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="vip" data-credit="none">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1a237e; font-size: 16px; font-weight: 600;">
                                            RF
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Rashmi Fernando</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1027</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 75 456 7890</td>
                                <td>rashmi.f@email.com</td>
                                <td><strong>LKR 3.1M</strong></td>
                                <td><strong style="color: #4caf50;">LKR 0</strong></td>
                                <td>2026-02-22</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #b45f06;">VIP</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-credit="none">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 600;">
                                            KD
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Kasun De Silva</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1028</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 70 567 8901</td>
                                <td>kasun.d@email.com</td>
                                <td><strong>LKR 620,000</strong></td>
                                <td><strong style="color: #4caf50;">LKR 0</strong></td>
                                <td>2026-02-15</td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="inactive" data-credit="none">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: #bdbdbd; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 600;">
                                            TP
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Thilini Pathirana</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Customer #C-1029</span>
                                        </div>
                                    </div>
                                </td>
                                <td>+94 72 678 9012</td>
                                <td>thilini.p@email.com</td>
                                <td><strong>LKR 185,000</strong></td>
                                <td><strong style="color: #4caf50;">LKR 0</strong></td>
                                <td>2025-11-10</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #757575;">Inactive</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
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

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

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

        document.addEventListener('keydown', function(event) {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                openSearchModal();
            }

            if (event.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                closeSearchModal();
            }
        });

        // Customer search functionality
        const searchCustomers = document.getElementById('searchCustomers');
        const customerTable = document.getElementById('customerTable');
        
        if (searchCustomers && customerTable) {
            searchCustomers.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = customerTable.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }

        // Pill filter functionality
        const pills = document.querySelectorAll('.pill');
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                const rows = customerTable.querySelectorAll('tr');

                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    const rowCredit = row.getAttribute('data-credit');

                    if (filter === 'all') {
                        row.style.display = '';
                    } else if (filter === 'active') {
                        row.style.display = rowStatus === 'active' ? '' : 'none';
                    } else if (filter === 'vip') {
                        row.style.display = rowStatus === 'vip' ? '' : 'none';
                    } else if (filter === 'credit') {
                        row.style.display = rowCredit === 'has' ? '' : 'none';
                    }
                });
            });
        });

        // Dropdown filters
        const statusFilter = document.getElementById('statusFilter');
        const creditFilter = document.getElementById('creditFilter');

        function applyFilters() {
            const status = statusFilter.value.toLowerCase();
            const credit = creditFilter.value.toLowerCase();
            const rows = customerTable.querySelectorAll('tr');

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status') || '';
                const rowCredit = row.getAttribute('data-credit') || '';

                let showRow = true;

                // Status filter
                if (status !== 'all customers') {
                    if (status === 'active' && rowStatus !== 'active') showRow = false;
                    if (status === 'inactive' && rowStatus !== 'inactive') showRow = false;
                    if (status === 'vip' && rowStatus !== 'vip') showRow = false;
                }

                // Credit filter
                if (credit !== 'all credit status') {
                    if (credit === 'has outstanding' && rowCredit !== 'has') showRow = false;
                    if (credit === 'fully paid' && rowCredit !== 'none') showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (creditFilter) creditFilter.addEventListener('change', applyFilters);
    </script>
</body>
</html>
