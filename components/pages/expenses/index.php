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
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage shop expenses and spending">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Expenses</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
</head>
<body>
    <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

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
            font-size: 18px;
            color: #1a237e;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <?php include('../../UI/sidebar.php'); ?>

    <div class="main-content">
        <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Page Header -->
            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <h2 style="margin: 0; font-size: 24px; color: #1a237e; font-weight: 700;">Expenses</h2>
                    <button class="button-primary" id="addExpenseBtn" style="cursor: pointer;">
                        <i class="fas fa-plus"></i> Add Expense
                    </button>
                </div>
                <p style="margin: 0; font-size: 13px; color: #7a86ad;">Track and manage business expenses</p>
            </div>

            <!-- Summary Cards -->
            <div class="cards-row">
                <div class="metric-card">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Total Expenses</div>
                        <div class="metric-value" id="totalExpenses">LKR 0.00</div>
                        <div class="metric-change">All approved expenses</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Pending Expenses</div>
                        <div class="metric-value" id="pendingCount">0</div>
                        <div class="metric-change">Awaiting approval</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Monthly Average</div>
                        <div class="metric-value" id="monthlyAvg">LKR 0.00</div>
                        <div class="metric-change">Per expense</div>
                    </div>
                </div>
            </div>

            <br>

            <!-- Filter Section -->
            <div class="filter-card">
                <div style="margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">From Date</label>
                            <input type="date" id="filterStartDate" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">To Date</label>
                            <input type="date" id="filterEndDate" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Category</label>
                            <select id="filterCategory" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All Categories</option>
                                <option value="rent">Rent</option>
                                <option value="utilities">Utilities</option>
                                <option value="salary">Salary</option>
                                <option value="supplies">Supplies</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Status</label>
                            <select id="filterStatus" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; gap: 10px;">
                        <button class="button-primary" onclick="filterExpenses()" style="flex: 1; cursor: pointer;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <button class="button-secondary" onclick="resetFilters()" style="flex: 1; cursor: pointer;">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <br>

            <!-- Expenses Section -->
            <div class="recent-orders">
                <div class="section-header">
                    <h3>All Expenses</h3>
                    <span id="expenseCount" style="font-size: 13px; color: #7a86ad;"></span>
                </div>

                <div id="expensesContainer">
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <i class="fas fa-spinner fa-spin"></i> Loading expenses...
                    </div>
                </div>

                <div id="paginationContainer" style="display: flex; justify-content: center; gap: 5px; margin-top: 20px;"></div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div id="addExpenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Expense</h2>
                <button class="close-btn" onclick="closeAddExpenseModal()">×</button>
            </div>

            <form id="addExpenseForm" onsubmit="saveExpense(event)">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Category</label>
                    <select id="expCategory" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        <option value="">Select Category</option>
                        <option value="rent">Rent</option>
                        <option value="utilities">Utilities</option>
                        <option value="salary">Salary</option>
                        <option value="supplies">Supplies</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Amount (LKR)</label>
                    <input type="number" id="expAmount" step="0.01" min="0" required placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Date</label>
                    <input type="date" id="expDate" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Description</label>
                    <input type="text" id="expDescription" placeholder="Enter description" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Payment Method</label>
                    <select id="expPaymentMethod" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="check">Check</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="button-primary" style="flex: 1; cursor: pointer;">
                        <i class="fas fa-save"></i> Save Expense
                    </button>
                    <button type="button" class="button-secondary" style="flex: 1; cursor: pointer;" onclick="closeAddExpenseModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE_URL = 'http://localhost:3000/api';
        const EXPENSE_API = `${API_BASE_URL}/expenses`;
        let currentPage = 1;
        let totalPages = 1;

        // Format currency
        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        // Format date
        function formatDate(dateValue) {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) {
                return '-';
            }
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
        }

        // Get category color
        function getCategoryColor(category) {
            const colors = {
                'rent': '#3f51b5',
                'utilities': '#ff9800',
                'salary': '#d32f2f',
                'supplies': '#2e7d32',
                'maintenance': '#9c27b0',
                'other': '#795548',
            };
            return colors[category] || '#999';
        }

        // Load summary
        async function loadSummary() {
            try {
                const response = await fetch(`${EXPENSE_API}/summary`);
                const result = await response.json();

                if (!result.success) return;

                const summaryData = result.data;
                let totalAmount = 0;
                let pendingCount = 0;

                summaryData.forEach(item => {
                    if (item.status === 'approved') {
                        totalAmount += parseFloat(item.total || 0);
                    }
                    if (item.status === 'pending') {
                        pendingCount += item.count;
                    }
                });

                document.getElementById('totalExpenses').textContent = formatLkr(totalAmount);
                document.getElementById('pendingCount').textContent = pendingCount;
                document.getElementById('monthlyAvg').textContent = formatLkr(summaryData.length > 0 ? totalAmount / summaryData.length : 0);
            } catch (error) {
                console.error('Error loading summary:', error);
            }
        }

        // Load expenses
        async function loadExpenses(page = 1) {
            try {
                const startDate = document.getElementById('filterStartDate').value;
                const endDate = document.getElementById('filterEndDate').value;
                const category = document.getElementById('filterCategory').value;
                const status = document.getElementById('filterStatus').value;

                let url = `${EXPENSE_API}?page=${page}&limit=20`;
                if (startDate) url += `&startDate=${startDate}`;
                if (endDate) url += `&endDate=${endDate}`;
                if (category) url += `&category=${category}`;
                if (status) url += `&status=${status}`;

                const response = await fetch(url);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load expenses');
                }

                const expenses = result.data;
                const pagination = result.pagination;
                currentPage = pagination.page;
                totalPages = pagination.pages;

                const container = document.getElementById('expensesContainer');

                if (!expenses.length) {
                    container.innerHTML = '<div style="text-align: center; padding: 40px; color: #999; background: #f9f9f9; border-radius: 6px; border: 1px dashed #e0e0e0;"><i class="fas fa-inbox"></i> No expenses found</div>';
                } else {
                    const rows = expenses.map(exp => {
                        const categoryColor = getCategoryColor(exp.category);
                        const categoryCode = exp.category.charAt(0).toUpperCase();
                        let statusClass = 'status-pending';
                        if (exp.status === 'approved') statusClass = 'status-paid';
                        else if (exp.status === 'rejected') statusClass = 'status-processing';

                        return `
                            <tr>
                                <td>${formatDate(exp.expense_date)}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: ${categoryColor}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px;">${categoryCode}</div>
                                        <div>
                                            <div style="font-weight: 600; color: #1a237e;">${exp.category.toUpperCase()}</div>
                                            <div style="font-size: 12px; color: #999;">${exp.description || '-'}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${exp.payment_method.replace(/_/g, ' ').toUpperCase()}</td>
                                <td style="color: #d32f2f; font-weight: 600;">-${formatLkr(exp.amount)}</td>
                                <td><span class="status-badge ${statusClass}">${exp.status.toUpperCase()}</span></td>
                            </tr>
                        `;
                    }).join('');

                    container.innerHTML = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${rows}
                            </tbody>
                        </table>
                    `;
                }

                document.getElementById('expenseCount').textContent = `${pagination.total} expenses found`;
                updatePagination();
            } catch (error) {
                console.error('Error loading expenses:', error);
                document.getElementById('expensesContainer').innerHTML = `<div style="text-align: center; padding: 40px; color: #d32f2f; background: #ffebee; border-radius: 6px;"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
            }
        }

        // Update pagination
        function updatePagination() {
            const container = document.getElementById('paginationContainer');
            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '';
            if (currentPage > 1) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px;" onclick="loadExpenses(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
            }

            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                const activeStyle = i === currentPage ? 'background: #3f51b5; color: white; border-color: #3f51b5;' : '';
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px; ${activeStyle}" onclick="loadExpenses(${i})">${i}</button>`;
            }

            if (currentPage < totalPages) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px;" onclick="loadExpenses(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
            }

            container.innerHTML = html;
        }

        // Filter expenses
        function filterExpenses() {
            loadExpenses(1);
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            document.getElementById('filterCategory').value = '';
            document.getElementById('filterStatus').value = '';
            loadExpenses(1);
        }

        // Open add expense modal
        document.getElementById('addExpenseBtn')?.addEventListener('click', function() {
            document.getElementById('expDate').valueAsDate = new Date();
            document.getElementById('addExpenseModal').classList.add('active');
        });

        // Close modal
        function closeAddExpenseModal() {
            document.getElementById('addExpenseModal').classList.remove('active');
            document.getElementById('addExpenseForm').reset();
        }

        // Save expense
        async function saveExpense(event) {
            event.preventDefault();

            try {
                const payload = {
                    category: document.getElementById('expCategory').value,
                    amount: parseFloat(document.getElementById('expAmount').value),
                    expense_date: document.getElementById('expDate').value,
                    description: document.getElementById('expDescription').value,
                    payment_method: document.getElementById('expPaymentMethod').value,
                };

                const response = await fetch(EXPENSE_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to save expense');
                }

                alert('Expense saved successfully!');
                closeAddExpenseModal();
                loadSummary();
                loadExpenses(1);
            } catch (error) {
                console.error('Error saving expense:', error);
                alert('Error: ' + error.message);
            }
        }

        // Close modal on outside click
        document.getElementById('addExpenseModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAddExpenseModal();
            }
        });

        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
        }

        // Load page
        document.addEventListener('DOMContentLoaded', function() {
            loadSummary();
            loadExpenses(1);
        });
    </script>
</body>
</html>
