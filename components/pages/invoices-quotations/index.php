<?php
$activePage = 'invoices-quotations';
$basePath = '../';
$pageTitle = 'Invoices & Quotations';
$pageSubtitle = 'View, manage, and re-print invoices, credit bills, and quotations.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Invoices & Quotations</title>
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
                        <input type="text" class="search-input" placeholder="Search by invoice/quotation number, customer..." id="searchInvoice" style="width: 300px;">
                        <select class="filter-select" id="filterType">
                            <option value="">All Types</option>
                            <option value="invoice">Invoices</option>
                            <option value="quotation">Quotations</option>
                        </select>
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending Payment</option>
                            <option value="partial">Partially Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="draft">Draft</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus"></i>
                            New Invoice
                        </button>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-file-alt"></i>
                            New Quotation
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
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Invoices</div>
                            <div class="metric-value">1,245</div>
                            <div class="metric-change positive">+8.2% from last month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Active Quotations</div>
                            <div class="metric-value">87</div>
                            <div class="metric-change">Awaiting response</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Revenue (Invoiced)</div>
                            <div class="metric-value">LKR 45.8M</div>
                            <div class="metric-change positive">+12.4% from last month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Overdue Invoices</div>
                            <div class="metric-value">23</div>
                            <div class="metric-change" style="color: #f44336;">LKR 1.2M outstanding</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All</button>
                    <button class="pill" data-filter="invoice">Invoices</button>
                    <button class="pill" data-filter="quotation">Quotations</button>
                    <button class="pill" data-filter="paid">Paid</button>
                    <button class="pill" data-filter="pending">Pending</button>
                    <button class="pill" data-filter="overdue">Overdue</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 12%;">Document No.</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 16%;">Customer</th>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 12%;">Amount</th>
                                <th style="width: 12%;">Paid</th>
                                <th style="width: 10%;">Due Date</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 8%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                            <tr data-type="invoice" data-status="paid">
                                <td><strong>INV-2026-0245</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Invoice</span></td>
                                <td>Sandun Kumarasinghe</td>
                                <td>Feb 20, 2026</td>
                                <td><strong>LKR 125,000</strong></td>
                                <td style="color: #4caf50;">LKR 125,000</td>
                                <td>Feb 25, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Paid</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="quotation" data-status="accepted">
                                <td><strong>QUO-2026-0089</strong></td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Quotation</span></td>
                                <td>Nimal Perera</td>
                                <td>Feb 22, 2026</td>
                                <td><strong>LKR 87,500</strong></td>
                                <td style="color: #9e9e9e;">—</td>
                                <td>Mar 01, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Accepted</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Convert to Invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="invoice" data-status="pending">
                                <td><strong>INV-2026-0244</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Invoice</span></td>
                                <td>Anusha Silva</td>
                                <td>Feb 19, 2026</td>
                                <td><strong>LKR 45,000</strong></td>
                                <td style="color: #ff9800;">LKR 20,000</td>
                                <td>Feb 26, 2026</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Partial</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Record Payment">
                                        <i class="fas fa-money-bill"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="invoice" data-status="overdue">
                                <td><strong>INV-2026-0238</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Invoice</span></td>
                                <td>Kasun De Silva</td>
                                <td>Feb 10, 2026</td>
                                <td><strong>LKR 68,900</strong></td>
                                <td style="color: #9e9e9e;">LKR 0</td>
                                <td>Feb 17, 2026</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;">Overdue</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Send Reminder">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="quotation" data-status="draft">
                                <td><strong>QUO-2026-0090</strong></td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Quotation</span></td>
                                <td>Thilini Pathirana</td>
                                <td>Feb 23, 2026</td>
                                <td><strong>LKR 92,000</strong></td>
                                <td style="color: #9e9e9e;">—</td>
                                <td>Mar 05, 2026</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #616161;">Draft</span></td>
                                <td>
                                    <button class="icon-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="icon-btn" title="Send">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="invoice" data-status="paid">
                                <td><strong>INV-2026-0243</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Invoice</span></td>
                                <td>Rashmi Fernando</td>
                                <td>Feb 18, 2026</td>
                                <td><strong>LKR 156,000</strong></td>
                                <td style="color: #4caf50;">LKR 156,000</td>
                                <td>Feb 25, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Paid</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="invoice" data-status="pending">
                                <td><strong>INV-2026-0242</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Invoice</span></td>
                                <td>Nuwan Jayawardena</td>
                                <td>Feb 17, 2026</td>
                                <td><strong>LKR 34,500</strong></td>
                                <td style="color: #9e9e9e;">LKR 0</td>
                                <td>Feb 28, 2026</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Pending</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Record Payment">
                                        <i class="fas fa-money-bill"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="quotation" data-status="rejected">
                                <td><strong>QUO-2026-0085</strong></td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Quotation</span></td>
                                <td>Dilshan Perera</td>
                                <td>Feb 15, 2026</td>
<td><strong>LKR 198,000</strong></td>
                                <td style="color: #9e9e9e;">—</td>
                                <td>Feb 22, 2026</td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;">Rejected</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="icon-btn" title="Archive">
                                        <i class="fas fa-archive"></i>
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

        // Search functionality
        const searchInput = document.getElementById('searchInvoice');
        const typeFilter = document.getElementById('filterType');
        const statusFilter = document.getElementById('filterStatus');
        const tableBody = document.getElementById('invoiceTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchInvoices() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const typeValue = typeFilter.value;
                const statusValue = statusFilter.value;
                
                const matchesType = !typeValue || row.dataset.type === typeValue;
                const matchesStatus = !statusValue || row.dataset.status === statusValue;

                if (matchesSearch && matchesType && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', searchInvoices);
        typeFilter.addEventListener('change', searchInvoices);
        statusFilter.addEventListener('change', searchInvoices);

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
                    } else if (filter === 'invoice' || filter === 'quotation') {
                        row.style.display = row.dataset.type === filter ? '' : 'none';
                    } else {
                        row.style.display = row.dataset.status === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
