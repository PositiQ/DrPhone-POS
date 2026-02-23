<?php
$activePage = 'vault-balance';
$basePath = '../';
$pageTitle = 'Vault & Balance';
$pageSubtitle = 'Add bank accounts and cash drawers for POS transaction tracking.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Vault & Balance</title>
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
                        <input type="text" class="search-input" placeholder="Search transactions..." id="searchTransaction" style="width: 300px;">
                        <select class="filter-select" id="filterAccount">
                            <option value="">All Accounts</option>
                            <option value="cash">Cash Register</option>
                            <option value="bank">Bank Account</option>
                        </select>
                        <select class="filter-select" id="filterType">
                            <option value="">All Types</option>
                            <option value="in">Money In</option>
                            <option value="out">Money Out</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus-circle"></i>
                            Add Transaction
                        </button>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-university"></i>
                            Add Account
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
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Cash Register</div>
                            <div class="metric-value">LKR 485,000</div>
                            <div class="metric-change">Current balance</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Bank Balance</div>
                            <div class="metric-value">LKR 12.4M</div>
                            <div class="metric-change positive">+3.5% this week</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Money In (Today)</div>
                            <div class="metric-value">LKR 345,000</div>
                            <div class="metric-change positive">+18 transactions</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Money Out (Today)</div>
                            <div class="metric-value">LKR 125,000</div>
                            <div class="metric-change">12 transactions</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Transactions</button>
                    <button class="pill" data-filter="cash">Cash Register</button>
                    <button class="pill" data-filter="bank">Bank Account</button>
                    <button class="pill" data-filter="in">Money In</button>
                    <button class="pill" data-filter="out">Money Out</button>
                </div>

                <div class="cards-row full-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3>Payment Accounts</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px; border-left: 4px solid #4caf50;">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-cash-register" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <strong style="display: block; margin-bottom: 4px;">Main Cash Register</strong>
                                        <span style="color: #666; font-size: 13px;">Active • Last updated 2 min ago</span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 20px; font-weight: 700; color: #2e7d32;">LKR 485,000</div>
                                    <div style="font-size: 13px; color: #666;">Available Balance</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px; border-left: 4px solid #1976d2;">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-university" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <strong style="display: block; margin-bottom: 4px;">Commercial Bank - 8001234567</strong>
                                        <span style="color: #666; font-size: 13px;">Business Account • Main Shop</span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 20px; font-weight: 700; color: #1976d2;">LKR 8,750,000</div>
                                    <div style="font-size: 13px; color: #666;">Available Balance</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px; border-left: 4px solid #1976d2;">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-university" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <strong style="display: block; margin-bottom: 4px;">Bank of Ceylon - 7009876543</strong>
                                        <span style="color: #666; font-size: 13px;">Savings Account • Branch Operations</span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 20px; font-weight: 700; color: #1976d2;">LKR 3,650,000</div>
                                    <div style="font-size: 13px; color: #666;">Available Balance</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Recent Transactions</h3>
                    </div>
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 15%;">Account</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 20%;">Description</th>
                                <th style="width: 15%;">Reference</th>
                                <th style="width: 12%;">Amount</th>
                                <th style="width: 13%;">Balance After</th>
                                <th style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody">
                            <tr data-account="cash" data-type="in">
                                <td>Feb 23, 10:30 AM</td>
                                <td>Cash Register</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-arrow-down"></i> Money In</span></td>
                                <td>Sale Payment - Customer</td>
                                <td>INV-2026-0245</td>
                                <td style="color: #2e7d32; font-weight: 600;">+LKR 125,000</td>
                                <td><strong>LKR 485,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="bank" data-type="in">
                                <td>Feb 23, 9:15 AM</td>
                                <td>Commercial Bank</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-arrow-down"></i> Money In</span></td>
                                <td>Bank Transfer - Customer Payment</td>
                                <td>TRF-8923456</td>
                                <td style="color: #2e7d32; font-weight: 600;">+LKR 87,500</td>
                                <td><strong>LKR 8,750,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="cash" data-type="out">
                                <td>Feb 23, 8:00 AM</td>
                                <td>Cash Register</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;"><i class="fas fa-arrow-up"></i> Money Out</span></td>
                                <td>Supplier Payment - Stock Purchase</td>
                                <td>SUP-PAY-045</td>
                                <td style="color: #c62828; font-weight: 600;">-LKR 45,000</td>
                                <td><strong>LKR 360,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="cash" data-type="in">
                                <td>Feb 22, 4:45 PM</td>
                                <td>Cash Register</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-arrow-down"></i> Money In</span></td>
                                <td>Sale Payment - Cash</td>
                                <td>INV-2026-0243</td>
                                <td style="color: #2e7d32; font-weight: 600;">+LKR 156,000</td>
                                <td><strong>LKR 405,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="bank" data-type="out">
                                <td>Feb 22, 2:30 PM</td>
                                <td>Bank of Ceylon</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;"><i class="fas fa-arrow-up"></i> Money Out</span></td>
                                <td>Salary Payment - Staff</td>
                                <td>SAL-02-2026</td>
                                <td style="color: #c62828; font-weight: 600;">-LKR 280,000</td>
                                <td><strong>LKR 3,650,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="cash" data-type="out">
                                <td>Feb 22, 1:15 PM</td>
                                <td>Cash Register</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;"><i class="fas fa-arrow-up"></i> Money Out</span></td>
                                <td>Expense - Shop Utilities</td>
                                <td>EXP-0234</td>
                                <td style="color: #c62828; font-weight: 600;">-LKR 28,500</td>
                                <td><strong>LKR 249,000</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="cash" data-type="in">
                                <td>Feb 22, 11:00 AM</td>
                                <td>Cash Register</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-arrow-down"></i> Money In</span></td>
                                <td>Sale Payment - Customer</td>
                                <td>INV-2026-0241</td>
                                <td style="color: #2e7d32; font-weight: 600;">+LKR 68,900</td>
                                <td><strong>LKR 277,500</strong></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-account="bank" data-type="in">
                                <td>Feb 21, 3:20 PM</td>
                                <td>Commercial Bank</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-arrow-down"></i> Money In</span></td>
                                <td>Bank Transfer - Bulk Order Payment</td>
                                <td>TRF-8912345</td>
                                <td style="color: #2e7d32; font-weight: 600;">+LKR 550,000</td>
                                <td><strong>LKR 8,662,500</strong></td>
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
        const searchInput = document.getElementById('searchTransaction');
        const accountFilter = document.getElementById('filterAccount');
        const typeFilter = document.getElementById('filterType');
        const tableBody = document.getElementById('transactionTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchTransactions() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const accountValue = accountFilter.value;
                const typeValue = typeFilter.value;
                
                const matchesAccount = !accountValue || row.dataset.account === accountValue;
                const matchesType = !typeValue || row.dataset.type === typeValue;

                if (matchesSearch && matchesAccount && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', searchTransactions);
        accountFilter.addEventListener('change', searchTransactions);
        typeFilter.addEventListener('change', searchTransactions);

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
                    } else if (filter === 'cash' || filter === 'bank') {
                        row.style.display = row.dataset.account === filter ? '' : 'none';
                    } else {
                        row.style.display = row.dataset.type === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
