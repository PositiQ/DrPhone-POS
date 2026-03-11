<?php
$activePage = 'users';
$basePath = '../';
$pageTitle = 'Users';
$pageSubtitle = 'Add and manage system users.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage system users">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Users</title>
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
                        <input type="text" class="search-input" placeholder="Search users..." id="searchUser" style="width: 300px;">
                        <select class="filter-select" id="filterRole">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="cashier">Cashier</option>
                            <option value="staff">Staff</option>
                        </select>
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-plus"></i>
                            Add User
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
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Users</div>
                            <div class="metric-value">12</div>
                            <div class="metric-change">System accounts</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Active Users</div>
                            <div class="metric-value">10</div>
                            <div class="metric-change positive">Currently enabled</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Administrators</div>
                            <div class="metric-value">2</div>
                            <div class="metric-change">Full system access</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Online Now</div>
                            <div class="metric-value">4</div>
                            <div class="metric-change">Currently logged in</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Users</button>
                    <button class="pill" data-filter="admin">Admins</button>
                    <button class="pill" data-filter="manager">Managers</button>
                    <button class="pill" data-filter="cashier">Cashiers</button>
                    <button class="pill" data-filter="staff">Staff</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 12%;">Phone</th>
                                <th style="width: 12%;">Role</th>
                                <th style="width: 12%;">Last Login</th>
                                <th style="width: 12%;">Created</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 7%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <tr data-role="admin" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            AU
                                        </div>
                                        <strong>Admin User</strong>
                                    </div>
                                </td>
                                <td>admin@doctorphone.lk</td>
                                <td>+94 77 123 4567</td>
                                <td><span class="status-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Admin</span></td>
                                <td>2 mins ago</td>
                                <td>Jan 1, 2025</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="admin" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            SK
                                        </div>
                                        <strong>Sandun Kumarasinghe</strong>
                                    </div>
                                </td>
                                <td>sandun@doctorphone.lk</td>
                                <td>+94 77 234 5678</td>
                                <td><span class="status-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Admin</span></td>
                                <td>15 mins ago</td>
                                <td>Jan 15, 2025</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="manager" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            NP
                                        </div>
                                        <strong>Nimal Perera</strong>
                                    </div>
                                </td>
                                <td>nimal@doctorphone.lk</td>
                                <td>+94 71 345 6789</td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Manager</span></td>
                                <td>Today, 9:30 AM</td>
                                <td>Feb 1, 2025</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="manager" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            AS
                                        </div>
                                        <strong>Anusha Silva</strong>
                                    </div>
                                </td>
                                <td>anusha@doctorphone.lk</td>
                                <td>+94 76 456 7890</td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Manager</span></td>
                                <td>Yesterday, 5:45 PM</td>
                                <td>Feb 5, 2025</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="cashier" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            KD
                                        </div>
                                        <strong>Kasun De Silva</strong>
                                    </div>
                                </td>
                                <td>kasun@doctorphone.lk</td>
                                <td>+94 75 567 8901</td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Cashier</span></td>
                                <td>Today, 8:15 AM</td>
                                <td>Jan 20, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="cashier" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            TP
                                        </div>
                                        <strong>Thilini Pathirana</strong>
                                    </div>
                                </td>
                                <td>thilini@doctorphone.lk</td>
                                <td>+94 77 678 9012</td>
                                <td><span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Cashier</span></td>
                                <td>Today, 10:00 AM</td>
                                <td>Jan 25, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="staff" data-status="active">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            RF
                                        </div>
                                        <strong>Rashmi Fernando</strong>
                                    </div>
                                </td>
                                <td>rashmi@doctorphone.lk</td>
                                <td>+94 71 789 0123</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Staff</span></td>
                                <td>Yesterday, 6:30 PM</td>
                                <td>Feb 10, 2026</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <button class="icon-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr data-role="staff" data-status="inactive">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #9e9e9e; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            NJ
                                        </div>
                                        <strong>Nuwan Jayawardena</strong>
                                    </div>
                                </td>
                                <td>nuwan@doctorphone.lk</td>
                                <td>+94 76 890 1234</td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Staff</span></td>
                                <td>Feb 15, 2026</td>
                                <td>Dec 1, 2025</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #616161;">Inactive</span></td>
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
        const searchInput = document.getElementById('searchUser');
        const roleFilter = document.getElementById('filterRole');
        const statusFilter = document.getElementById('filterStatus');
        const tableBody = document.getElementById('userTableBody');
        const pills = document.querySelectorAll('.pill');

        function searchUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const roleValue = roleFilter.value;
                const statusValue = statusFilter.value;
                
                const matchesRole = !roleValue || row.dataset.role === roleValue;
                const matchesStatus = !statusValue || row.dataset.status === statusValue;

                if (matchesSearch && matchesRole && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', searchUsers);
        roleFilter.addEventListener('change', searchUsers);
        statusFilter.addEventListener('change', searchUsers);

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
                        row.style.display = row.dataset.role === filter ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
