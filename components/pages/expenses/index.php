<?php
$activePage = 'expenses';
$basePath = '../';
$pageTitle = 'Expenses';
$pageSubtitle = 'Manage shop expenses and track spending.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Expenses</title>
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
                        <input type="text" class="search-input" placeholder="Search expenses..." id="searchExpense" style="width: 300px;">
                        <select class="filter-select" id="filterCategory">
                            <option value="">All Categories</option>
                            <option value="utilities">Utilities</option>
                            <option value="rent">Rent</option>
                            <option value="salary">Salary</option>
                            <option value="supplies">Supplies</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="other">Other</option>
                        </select>
                        <select class="filter-select" id="filterPayment">
                            <option value="">All Payment Methods</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="card">Credit Card</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus"></i>
                            Add Expense
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
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Expenses (Month)</div>
                            <div class="metric-value">LKR 842,500</div>
                            <div class="metric-change" style="color: #f44336;">+5.2% from last month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Today's Expenses</div>
                            <div class="metric-value">LKR 28,500</div>
                            <div class="metric-change">4 transactions</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Average Daily Expense</div>
                            <div class="metric-value">LKR 36,630</div>
                            <div class="metric-change">Based on 23 days</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Top Category</div>
                            <div class="metric-value">Salary</div>
                            <div class="metric-change">LKR 280,000 this month</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Expenses</button>
                    <button class="pill" data-filter="utilities">Utilities</button>
                    <button class="pill" data-filter="rent">Rent</button>
                    <button class="pill" data-filter="salary">Salary</button>
                    <button class="pill" data-filter="supplies">Supplies</button>
                    <button class="pill" data-filter="maintenance">Maintenance</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 15%;">Category</th>
                                <th style="width: 25%;">Description</th>
                                <th style="width: 12%;">Amount</th>
                                <th style="width: 12%;">Payment Method</th>
                                <th style="width: 12%;">Paid To</th>
                                <th style="width: 10%;">Receipt</th>
                                <th style="width: 4%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTableBody">
                            <tr data-category="utilities" data-payment="cash">
                                <td>Feb 22, 2026</td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Utilities</span></td>
                                <td>Electricity Bill - February</td>
                                <td><strong>LKR 28,500</strong></td>
                                <td>Cash</td>
                                <td>Ceylon Electricity Board</td>
                                <td><i class="fas fa-file-pdf" style="color: #f44336;"></i> Attached</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="salary" data-payment="bank">
                                <td>Feb 22, 2026</td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Salary</span></td>
                                <td>Staff Salary Payment - February</td>
                                <td><strong>LKR 280,000</strong></td>
                                <td>Bank Transfer</td>
                                <td>Staff Team</td>
                                <td>—</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="rent" data-payment="bank">
                                <td>Feb 15, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Rent</span></td>
                                <td>Shop Rent - February 2026</td>
                                <td><strong>LKR 150,000</strong></td>
                                <td>Bank Transfer</td>
                                <td>Property Owner</td>
                                <td><i class="fas fa-file-pdf" style="color: #f44336;"></i> Attached</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="supplies" data-payment="cash">
                                <td>Feb 12, 2026</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Supplies</span></td>
                                <td>Office Stationery & Packaging Materials</td>
                                <td><strong>LKR 15,800</strong></td>
                                <td>Cash</td>
                                <td>Stationery Supplier</td>
                                <td><i class="fas fa-file-pdf" style="color: #f44336;"></i> Attached</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="maintenance" data-payment="cash">
                                <td>Feb 10, 2026</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;">Maintenance</span></td>
                                <td>Air Conditioning Repair - Main Shop</td>
                                <td><strong>LKR 35,000</strong></td>
                                <td>Cash</td>
                                <td>AC Service Center</td>
                                <td>—</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="utilities" data-payment="cheque">
                                <td>Feb 8, 2026</td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Utilities</span></td>
                                <td>Water Bill - February</td>
                                <td><strong>LKR 4,200</strong></td>
                                <td>Cheque</td>
                                <td>Water Board</td>
                                <td><i class="fas fa-file-pdf" style="color: #f44336;"></i> Attached</td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="other" data-payment="cash">
                                <td>Feb 5, 2026</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #616161;">Other</span></td>
                                <td>Marketing & Advertising - Social Media</td>
                                <td><strong>LKR 48,000</strong></td>
                                <td>Cash</td>
                                <td>Marketing Agency</td>
                                <td>—</td>
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
        const searchInput = document.getElementById('searchExpense');
        const categoryFilter = document.getElementById('filterCategory');
        const paymentFilter = document.getElementById('filterPayment');
        const tableBody = document.getElementById('expenseTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchExpenses() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const categoryValue = categoryFilter.value;
                const paymentValue = paymentFilter.value;
                
                const matchesCategory = !categoryValue || row.dataset.category === categoryValue;
                const matchesPayment = !paymentValue || row.dataset.payment === paymentValue;

                if (matchesSearch && matchesCategory && matchesPayment) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', searchExpenses);
        categoryFilter.addEventListener('change', searchExpenses);
        paymentFilter.addEventListener('change', searchExpenses);

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
                    } else {
                        row.style.display = row.dataset.category === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
