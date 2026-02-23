<?php
$activePage = 'suppliers';
$basePath = '../';
$pageTitle = 'Suppliers';
$pageSubtitle = 'Manage suppliers, bills, credits, and shipments.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Suppliers</title>
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
                        <input type="text" class="search-input" placeholder="Search suppliers..." id="searchSupplier" style="width: 300px;">
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <select class="filter-select" id="filterPayment">
                            <option value="">All Payment Status</option>
                            <option value="paid">Paid Up</option>
                            <option value="pending">Payment Pending</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus"></i>
                            Add Supplier
                        </button>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="cards-row">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Suppliers</div>
                            <div class="metric-value">24</div>
                            <div class="metric-change positive">+2 new this month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Active Suppliers</div>
                            <div class="metric-value">19</div>
                            <div class="metric-change">Currently trading</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Payable</div>
                            <div class="metric-value">LKR 3.4M</div>
                            <div class="metric-change" style="color: #f44336;">Outstanding balance</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Overdue Payments</div>
                            <div class="metric-value">3</div>
                            <div class="metric-change" style="color: #f44336;">Requires attention</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Suppliers</button>
                    <button class="pill" data-filter="active">Active</button>
                    <button class="pill" data-filter="inactive">Inactive</button>
                    <button class="pill" data-filter="overdue">Overdue</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 18%;">Supplier Name</th>
                                <th style="width: 15%;">Contact Person</th>
                                <th style="width: 13%;">Phone</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 12%;">Total Orders</th>
                                <th style="width: 12%;">Outstanding</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="supplierTableBody">
                            <tr data-status="active" data-payment="overdue">
                                <td><strong>Tech World Distributors</strong></td>
                                <td>Ranil Fernando</td>
                                <td>+94 77 345 6789</td>
                                <td>info@techworld.lk</td>
                                <td>145 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 850,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="paid">
                                <td><strong>Smart Mobile Solutions</strong></td>
                                <td>Dilshan Perera</td>
                                <td>+94 71 234 5678</td>
                                <td>contact@smartmobile.lk</td>
                                <td>98 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="pending">
                                <td><strong>Global Electronics Ltd</strong></td>
                                <td>Kumari Silva</td>
                                <td>+94 77 987 6543</td>
                                <td>orders@globalelec.lk</td>
                                <td>87 orders</td>
                                <td style="color: #ff9800; font-weight: 600;">LKR 450,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="overdue">
                                <td><strong>Mobile Kingdom</strong></td>
                                <td>Chaminda Jayawardena</td>
                                <td>+94 76 543 2109</td>
                                <td>sales@mobilekingdom.lk</td>
                                <td>124 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 680,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="inactive" data-payment="paid">
                                <td><strong>ValueTech Imports</strong></td>
                                <td>Nimal Rodrigo</td>
                                <td>+94 75 678 9012</td>
                                <td>info@valuetech.lk</td>
                                <td>34 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #616161;">Inactive</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="pending">
                                <td><strong>Premium Accessories Co.</strong></td>
                                <td>Thilini Gunasekara</td>
                                <td>+94 77 456 7890</td>
                                <td>orders@premiumacc.lk</td>
                                <td>156 orders</td>
                                <td style="color: #ff9800; font-weight: 600;">LKR 285,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="overdue">
                                <td><strong>Digital Source LK</strong></td>
                                <td>Sandun Wijesinghe</td>
                                <td>+94 71 890 1234</td>
                                <td>contact@digitalsource.lk</td>
                                <td>67 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 920,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="paid">
                                <td><strong>Phone Parts Hub</strong></td>
                                <td>Anusha Fernando</td>
                                <td>+94 76 234 5678</td>
                                <td>info@phonepartshub.lk</td>
                                <td>89 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
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

        // Search and filter functionality
        const searchInput = document.getElementById('searchSupplier');
        const statusFilter = document.getElementById('filterStatus');
        const paymentFilter = document.getElementById('filterPayment');
        const tableBody = document.getElementById('supplierTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchSuppliers() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const statusValue = statusFilter.value;
                const paymentValue = paymentFilter.value;
                
                const matchesStatus = !statusValue || row.dataset.status === statusValue;
                const matchesPayment = !paymentValue || row.dataset.payment === paymentValue;

                if (matchesSearch && matchesStatus && matchesPayment) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', searchSuppliers);
        statusFilter.addEventListener('change', searchSuppliers);
        paymentFilter.addEventListener('change', searchSuppliers);

        // Pill filters
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const rows = tableBody.querySelectorAll('tr');

                rows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else if (filter === 'overdue') {
                        row.style.display = row.dataset.payment === 'overdue' ? '' : 'none';
                    } else {
                        row.style.display = row.dataset.status === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
