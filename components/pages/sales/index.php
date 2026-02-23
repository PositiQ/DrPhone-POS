<?php
$activePage = 'sales';
$basePath = '../';
$pageTitle = 'Sales';
$pageSubtitle = 'View sales insights and add new sales.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Sales</title>
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
                        <button class="pill active" type="button">Today</button>
                        <button class="pill" type="button">This Week</button>
                        <button class="pill" type="button">This Month</button>
                        <button class="pill" type="button">Custom</button>
                        <select aria-label="View type">
                            <option>View by Day</option>
                            <option>View by Date Range</option>
                            <option>View by Month</option>
                            <option>View by Year</option>
                        </select>
                        <input type="date" aria-label="Start date">
                        <input type="date" aria-label="End date">
                        <select aria-label="Month">
                            <option>February</option>
                            <option>January</option>
                            <option>March</option>
                            <option>April</option>
                        </select>
                        <select aria-label="Year">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="create.php">
                            <i class="fas fa-plus" style="margin-right: 6px;"></i>
                            Create New Sale
                        </a>
                        <button class="button-secondary" type="button">Export</button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Daily Sales Amount</h4>
                        <div class="metric-value">LKR 128,450</div>
                        <div class="metric-sub">86 transactions today</div>
                    </div>
                    <div class="metric-card">
                        <h4>Actual Sales (Cash + Card)</h4>
                        <div class="metric-value">LKR 92,600</div>
                        <div class="metric-sub">72% of daily total</div>
                    </div>
                    <div class="metric-card">
                        <h4>Credit Sales Amount</h4>
                        <div class="metric-value">LKR 35,850</div>
                        <div class="metric-sub">Pending collection</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Balance After Credit</h4>
                        <div class="metric-value">LKR 92,600</div>
                        <div class="metric-sub">Actual cash received</div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Weekly & Monthly Insights</h3>
                    </div>
                    <div class="insight-grid">
                        <div class="metric-card">
                            <h4>This Week</h4>
                            <div class="metric-value">LKR 612,300</div>
                            <div class="metric-sub">Average LKR 87,470 per day</div>
                        </div>
                        <div class="metric-card">
                            <h4>This Month</h4>
                            <div class="metric-value">LKR 2,485,900</div>
                            <div class="metric-sub">+6% vs last month</div>
                        </div>
                        <div class="metric-card">
                            <h4>Credit Collected (Month)</h4>
                            <div class="metric-value">LKR 410,200</div>
                            <div class="metric-sub">Collections to date</div>
                        </div>
                        <div class="metric-card">
                            <h4>Outstanding Credit</h4>
                            <div class="metric-value">LKR 188,450</div>
                            <div class="metric-sub">Requires follow-up</div>
                        </div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Sales by Day</h3>
                        <span class="view-all">View All →</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Sales Amount (LKR)</th>
                                <th>Transactions</th>
                                <th>Actual Sales</th>
                                <th>Credit Sales</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2026-02-23</td>
                                <td>LKR 128,450</td>
                                <td>86</td>
                                <td>LKR 92,600</td>
                                <td>LKR 35,850</td>
                                <td>LKR 92,600</td>
                            </tr>
                            <tr>
                                <td>2026-02-22</td>
                                <td>LKR 118,120</td>
                                <td>79</td>
                                <td>LKR 90,300</td>
                                <td>LKR 27,820</td>
                                <td>LKR 90,300</td>
                            </tr>
                            <tr>
                                <td>2026-02-21</td>
                                <td>LKR 101,400</td>
                                <td>73</td>
                                <td>LKR 78,900</td>
                                <td>LKR 22,500</td>
                                <td>LKR 78,900</td>
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
    </script>
</body>
</html>
