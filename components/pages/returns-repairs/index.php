<?php
$activePage = 'returns-repairs';
$basePath = '../';
$pageTitle = 'Returns & Repairs';
$pageSubtitle = 'Manage return products and mobile phone repairs.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage return products and repairs">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Returns & Repairs</title>
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
                        <input type="text" class="search-input" placeholder="Search by customer, device, or ticket..." id="searchRepair" style="width: 300px;">
                        <select class="filter-select" id="filterType">
                            <option value="">All Types</option>
                            <option value="return">Return</option>
                            <option value="repair">Repair</option>
                            <option value="warranty">Warranty Claim</option>
                        </select>
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus"></i>
                            New Ticket
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
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Tickets</div>
                            <div class="metric-value">156</div>
                            <div class="metric-change positive">+12 this month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">In Progress</div>
                            <div class="metric-value">23</div>
                            <div class="metric-change">Currently being worked on</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Pending</div>
                            <div class="metric-value">8</div>
                            <div class="metric-change" style="color: #ff9800;">Awaiting action</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Completed (Month)</div>
                            <div class="metric-value">45</div>
                            <div class="metric-change positive">+8% from last month</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Tickets</button>
                    <button class="pill" data-filter="pending">Pending</button>
                    <button class="pill" data-filter="progress">In Progress</button>
                    <button class="pill" data-filter="completed">Completed</button>
                    <button class="pill" data-filter="delivered">Delivered</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Ticket #</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 15%;">Customer</th>
                                <th style="width: 15%;">Device</th>
                                <th style="width: 15%;">Issue</th>
                                <th style="width: 10%;">Date Received</th>
                                <th style="width: 10%;">Est. Completion</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="repairTableBody">
                            <tr data-type="repair" data-status="progress">
                                <td><strong>TKT-2026-0145</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Repair</span></td>
                                <td>Sandun Kumarasinghe</td>
                                <td>iPhone 14 Pro</td>
                                <td>Screen Replacement</td>
                                <td>Feb 20, 2026</td>
                                <td>Feb 24, 2026</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">In Progress</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="warranty" data-status="pending">
                                <td><strong>TKT-2026-0144</strong></td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Warranty</span></td>
                                <td>Nimal Perera</td>
                                <td>Samsung S23 Ultra</td>
                                <td>Battery Issue</td>
                                <td>Feb 22, 2026</td>
                                <td>Feb 28, 2026</td>
                                <td><span class="status-badge" style="background: #e1f5fe; color: #0277bd;">Pending</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="return" data-status="completed">
                                <td><strong>TKT-2026-0143</strong></td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Return</span></td>
                                <td>Anusha Silva</td>
                                <td>Google Pixel 7</td>
                                <td>Customer Changed Mind</td>
                                <td>Feb 18, 2026</td>
                                <td>Feb 18, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Completed</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="repair" data-status="completed">
                                <td><strong>TKT-2026-0142</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Repair</span></td>
                                <td>Kasun De Silva</td>
                                <td>Xiaomi 13</td>
                                <td>Camera Malfunction</td>
                                <td>Feb 15, 2026</td>
                                <td>Feb 20, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Completed</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="repair" data-status="delivered">
                                <td><strong>TKT-2026-0141</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Repair</span></td>
                                <td>Thilini Pathirana</td>
                                <td>iPhone 13</td>
                                <td>Charging Port Issue</td>
                                <td>Feb 12, 2026</td>
                                <td>Feb 16, 2026</td>
                                <td><span class="status-badge" style="background: #e0f2f1; color: #00695c;">Delivered</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="warranty" data-status="progress">
                                <td><strong>TKT-2026-0140</strong></td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Warranty</span></td>
                                <td>Rashmi Fernando</td>
                                <td>OnePlus 11</td>
                                <td>Display Defect</td>
                                <td>Feb 10, 2026</td>
                                <td>Feb 25, 2026</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">In Progress</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="repair" data-status="pending">
                                <td><strong>TKT-2026-0139</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Repair</span></td>
                                <td>Nuwan Jayawardena</td>
                                <td>Samsung A54</td>
                                <td>Software Issue</td>
                                <td>Feb 23, 2026</td>
                                <td>Feb 27, 2026</td>
                                <td><span class="status-badge" style="background: #e1f5fe; color: #0277bd;">Pending</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-type="return" data-status="completed">
                                <td><strong>TKT-2026-0138</strong></td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Return</span></td>
                                <td>Dilshan Perera</td>
                                <td>Wireless Earbuds</td>
                                <td>Defective - Sound Issues</td>
                                <td>Feb 8, 2026</td>
                                <td>Feb 8, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Completed</span></td>
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
        const searchInput = document.getElementById('searchRepair');
        const typeFilter = document.getElementById('filterType');
        const statusFilter = document.getElementById('filterStatus');
        const tableBody = document.getElementById('repairTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchRepairs() {
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

        searchInput.addEventListener('input', searchRepairs);
        typeFilter.addEventListener('change', searchRepairs);
        statusFilter.addEventListener('change', searchRepairs);

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
                        row.style.display = row.dataset.status === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
