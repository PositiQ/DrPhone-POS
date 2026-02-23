<?php
$activePage = 'products';
$basePath = '../';
$pageTitle = 'Products';
$pageSubtitle = 'Add and manage products, categories, and labels.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Products</title>
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
                        <input type="text" id="searchProducts" placeholder="Search products..." style="min-width: 280px;">
                        <select aria-label="Category">
                            <option>All Categories</option>
                            <option>Smartphones</option>
                            <option>Accessories</option>
                            <option>Tablets</option>
                        </select>
                        <select aria-label="Brand">
                            <option>All Brands</option>
                            <option>Apple</option>
                            <option>Samsung</option>
                            <option>Google</option>
                            <option>Xiaomi</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-secondary" href="../inventory/index.php">
                            <i class="fas fa-warehouse"></i>
                            View Inventory
                        </a>
                        <a class="button-primary" href="add-product.php">
                            <i class="fas fa-plus"></i>
                            Add Product
                        </a>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>In Stock</h4>
                        <div class="metric-value" style="color: #4caf50;">1,058</div>
                        <div class="metric-sub">Available for sale</div>
                    </div>
                    <div class="metric-card">
                        <h4>Low Stock</h4>
                        <div class="metric-value" style="color: #ff9800;">128</div>
                        <div class="metric-sub">Needs restocking</div>
                    </div>
                    <div class="metric-card">
                        <h4>Sold Out</h4>
                        <div class="metric-value" style="color: #f44336;">47</div>
                        <div class="metric-sub">Out of stock</div>
                    </div>
                    <div class="metric-card">
                        <h4>Issued</h4>
                        <div class="metric-value" style="color: #2196f3;">12</div>
                        <div class="metric-sub">To branches</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Product Catalog</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-status="all">All</button>
                            <button class="pill" type="button" data-status="in-stock">In Stock</button>
                            <button class="pill" type="button" data-status="low-stock">Low Stock</button>
                            <button class="pill" type="button" data-status="sold-out">Sold Out</button>
                            <button class="pill" type="button" data-status="issued">Issued</button>
                        </div>
                    </div>
                    <table style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 22%;">Product</th>
                                <th style="width: 10%;">Category</th>
                                <th style="width: 9%;">Brand</th>
                                <th style="width: 11%;">SKU</th>
                                <th style="width: 9%;">Cost Price (LKR)</th>
                                <th style="width: 9%;">Selling Price (LKR)</th>
                                <th style="width: 7%;">Stock Qty</th>
                                <th style="width: 11%;">Stock Status</th>
                                <th style="width: 12%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTable">
                            <tr data-status="in-stock">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">iPhone 14 Pro</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Space Black</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Smartphone</td>
                                <td>Apple</td>
                                <td><code>SKU-IP14P-256</code></td>
                                <td>LKR 260,000</td>
                                <td><strong>LKR 289,000</strong></td>
                                <td><strong style="color: #4caf50;">15</strong></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="low-stock">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Samsung S23 Ultra</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">512GB · Phantom Black</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Smartphone</td>
                                <td>Samsung</td>
                                <td><code>SKU-S23U-512</code></td>
                                <td>LKR 220,000</td>
                                <td><strong>LKR 245,000</strong></td>
                                <td><strong style="color: #ff9800;">4</strong></td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #b45f06;">Low Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="in-stock">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Google Pixel 7</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">128GB · Snow</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Smartphone</td>
                                <td>Google</td>
                                <td><code>SKU-GP7-128</code></td>
                                <td>LKR 165,000</td>
                                <td><strong>LKR 185,000</strong></td>
                                <td><strong style="color: #4caf50;">22</strong></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="sold-out">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-plug"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Fast Charger 25W</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">USB-C PD</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Accessory</td>
                                <td>Generic</td>
                                <td><code>SKU-CHG-25W</code></td>
                                <td>LKR 1,200</td>
                                <td><strong>LKR 1,500</strong></td>
                                <td><strong style="color: #f44336;">0</strong></td>
                                <td><span class="status-badge" style="background: #ffebee; color: #c62828;">Sold Out</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="issued">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Xiaomi 13</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Alpine Green</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Smartphone</td>
                                <td>Xiaomi</td>
                                <td><code>SKU-XM13-256</code></td>
                                <td>LKR 145,000</td>
                                <td><strong>LKR 165,000</strong></td>
                                <td><strong style="color: #2196f3;">1</strong></td>
                                <td><span class="status-badge" style="background: #e3f2fd; color: #1565c0;">Issued</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="in-stock">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-headphones"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Wireless Earbuds Pro</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">Bluetooth 5.2</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Accessory</td>
                                <td>Generic</td>
                                <td><code>SKU-EAR-PRO</code></td>
                                <td>LKR 3,500</td>
                                <td><strong>LKR 4,500</strong></td>
                                <td><strong style="color: #4caf50;">45</strong></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Duplicate">
                                            <i class="fas fa-copy"></i>
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

        // Product search functionality
        const searchProducts = document.getElementById('searchProducts');
        const productTable = document.getElementById('productTable');
        
        if (searchProducts && productTable) {
            searchProducts.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = productTable.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }

        // Pill filter functionality - Stock status based
        const pills = document.querySelectorAll('.pill');
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const statusFilter = this.getAttribute('data-status');
                const rows = productTable.querySelectorAll('tr');

                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');

                    if (statusFilter === 'all') {
                        row.style.display = '';
                    } else if (rowStatus === statusFilter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
