<?php
$activePage = 'inventory';
$basePath = '../';
$pageTitle = 'Inventory';
$pageSubtitle = 'Manage stocks, show low stocks and out of stocks.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage stock inventory levels">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Inventory</title>
    <!-- PWA Manifest and Icons -->
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
</head>
<body>
    <!-- PWA Client Library -->
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
                        <input type="text" id="searchProducts" placeholder="Search by product, IMEI, location..." style="min-width: 300px;">
                        <select id="locationFilter" aria-label="Location">
                            <option>All Locations</option>
                            <option>Main Shop</option>
                            <option>Colombo Branch</option>
                            <option>Kandy Branch</option>
                            <option>Galle Branch</option>
                        </select>
                        <select id="statusFilter" aria-label="Status">
                            <option>All Status</option>
                            <option>In Stock</option>
                            <option>Issued - Pending Sale</option>
                            <option>Issued - Pending Payment</option>
                            <option>Sale Completed</option>
                        </select>
                        <select id="categoryFilter" aria-label="Category">
                            <option>All Categories</option>
                            <option>Smartphones</option>
                            <option>Accessories</option>
                            <option>Tablets</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-secondary" type="button" onclick="openTransferDialog()">
                            <i class="fas fa-exchange-alt"></i>
                            Transfer Stock
                        </button>
                        <a class="button-secondary" href="../products/index.php">
                            <i class="fas fa-box"></i>
                            Products
                        </a>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Main Shop Stock</h4>
                        <div class="metric-value">856</div>
                        <div class="metric-sub">Items in main location</div>
                    </div>
                    <div class="metric-card">
                        <h4>Issued to Branches</h4>
                        <div class="metric-value" style="color: #2196f3;">389</div>
                        <div class="metric-sub">Items at other locations</div>
                    </div>
                    <div class="metric-card">
                        <h4>Pending Sale</h4>
                        <div class="metric-value" style="color: #ff9800;">45</div>
                        <div class="metric-sub">Awaiting completion</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Inventory</h4>
                        <div class="metric-value">1,245</div>
                        <div class="metric-sub">All tracked items</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Stock Tracking</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-location="all">All Locations</button>
                            <button class="pill" type="button" data-location="main">Main Shop</button>
                            <button class="pill" type="button" data-location="branches">Branches</button>
                            <button class="pill" type="button" data-location="pending">Pending</button>
                        </div>
                    </div>
                    <table style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Product</th>
                                <th style="width: 15%;">IMEI Number</th>
                                <th style="width: 12%;">Location</th>
                                <th style="width: 13%;">Issued To</th>
                                <th style="width: 10%;">Issued Date</th>
                                <th style="width: 12%;">Status</th>
                                <th style="width: 13%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTable">
                            <tr data-location="main" data-status="in-stock" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">iPhone 14 Pro</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Space Black · LKR 289,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913547821</code></td>
                                <td><strong style="color: #1a237e;">Main Shop</strong></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Transfer Stock" onclick="openTransferDialog('352913547821', 'iPhone 14 Pro', '256GB · Space Black')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="colombo" data-status="pending-sale" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Samsung S23 Ultra</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">512GB · Phantom Black · LKR 245,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913547945</code></td>
                                <td><span style="color: #7a86ad;">Issued</span></td>
                                <td><strong style="color: #2196f3;">Colombo Branch</strong></td>
                                <td><span style="font-size: 12px;">2026-02-20</span></td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #b45f06;">Pending Sale</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="main" data-status="in-stock" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Google Pixel 7</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">128GB · Snow · LKR 185,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913547233</code></td>
                                <td><strong style="color: #1a237e;">Main Shop</strong></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Transfer Stock" onclick="openTransferDialog('352913547233', 'Google Pixel 7', '128GB · Snow')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="kandy" data-status="pending-payment" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">iPhone 13</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">128GB · Midnight · LKR 215,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913548765</code></td>
                                <td><span style="color: #7a86ad;">Issued</span></td>
                                <td><strong style="color: #2196f3;">Kandy Branch</strong></td>
                                <td><span style="font-size: 12px;">2026-02-18</span></td>
                                <td><span class="status-badge" style="background: #fff8e1; color: #c77700;">Pending Payment</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="galle" data-status="sale-completed" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Xiaomi 13</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Alpine Green · LKR 165,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913547108</code></td>
                                <td><span style="color: #7a86ad;">Issued</span></td>
                                <td><strong style="color: #2196f3;">Galle Branch</strong></td>
                                <td><span style="font-size: 12px;">2026-02-15</span></td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Sale Completed</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="main" data-status="in-stock" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">OnePlus 11</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Eternal Green · LKR 198,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913549876</code></td>
                                <td><strong style="color: #1a237e;">Main Shop</strong></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Transfer Stock" onclick="openTransferDialog('352913549876', 'OnePlus 11', '256GB · Eternal Green')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="colombo" data-status="pending-sale" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Samsung A54</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Awesome Violet · LKR 125,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913549123</code></td>
                                <td><span style="color: #7a86ad;">Issued</span></td>
                                <td><strong style="color: #2196f3;">Colombo Branch</strong></td>
                                <td><span style="font-size: 12px;">2026-02-22</span></td>
                                <td><span class="status-badge" style="background: #fff3e0; color: #b45f06;">Pending Sale</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-location="main" data-status="in-stock" data-category="smartphone">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="display: block; color: #1a237e;">Vivo V27 Pro</strong>
                                            <span style="font-size: 12px; color: #7a86ad;">256GB · Magic Blue · LKR 145,000</span>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">352913549456</code></td>
                                <td><strong style="color: #1a237e;">Main Shop</strong></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span style="color: #7a86ad;">—</span></td>
                                <td><span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Transfer Stock" onclick="openTransferDialog('352913549456', 'Vivo V27 Pro', '256GB · Magic Blue')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                                            <i class="fas fa-eye"></i>
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

    <!-- Stock Transfer Dialog -->
    <div class="search-overlay" id="transferDialog" role="dialog" aria-modal="true" aria-label="Stock Transfer">
        <div class="search-dialog" role="document" style="max-width: 550px; padding: 0;">
            <div class="search-dialog-header" style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-exchange-alt" style="font-size: 20px;"></i>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Transfer Stock</h3>
                </div>
                <button class="search-close" type="button" onclick="closeTransferDialog()" aria-label="Close dialog" style="color: white;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div style="padding: 24px;">
                <form id="transferForm" onsubmit="handleTransferSubmit(event)">
                    <!-- Transfer Location -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-map-marker-alt" style="margin-right: 6px; color: #7a86ad;"></i>
                            Transfer Location
                        </label>
                        <select id="transferLocation" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="">Select destination shop...</option>
                            <option value="main">Main Shop</option>
                            <option value="colombo">Colombo Branch</option>
                            <option value="kandy">Kandy Branch</option>
                            <option value="galle">Galle Branch</option>
                        </select>
                    </div>

                    <!-- Transfer Item with Search -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-mobile-alt" style="margin-right: 6px; color: #7a86ad;"></i>
                            Transfer Item
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="productSearch" placeholder="Search by product name, IMEI last 4 digits, or full IMEI..." autocomplete="off" style="width: 100%; padding: 12px 40px 12px 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'; showProductDropdown()" oninput="filterProducts()">
                            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #7a86ad; pointer-events: none;"></i>
                            <input type="hidden" id="selectedProductId" required>
                        </div>
                        <div id="productDropdown" style="display: none; position: absolute; z-index: 1000; background: white; border: 2px solid #e0e7ff; border-radius: 8px; margin-top: 4px; max-height: 250px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: calc(100% - 48px);">
                            <!-- Product options will be populated here -->
                        </div>
                    </div>

                    <!-- Current Stock Info -->
                    <div id="stockInfo" style="display: none; margin-bottom: 20px; padding: 12px; background: #f4f7fc; border-radius: 8px; border-left: 4px solid #2196f3;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; color: #7a86ad;">Current Stock</span>
                            <span id="currentStock" style="font-size: 16px; font-weight: 700; color: #1a237e;">0</span>
                        </div>
                    </div>

                    <!-- Transfer Quantity -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-boxes" style="margin-right: 6px; color: #7a86ad;"></i>
                            Transfer Quantity
                        </label>
                        <input type="number" id="transferQuantity" min="1" required placeholder="Enter quantity" style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closeTransferDialog()" style="padding: 12px 24px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                            Cancel
                        </button>
                        <button type="submit" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <i class="fas fa-check" style="margin-right: 6px;"></i>
                            Transfer Stock
                        </button>
                    </div>
                </form>
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
        // Sample product data with stock information
        const productsData = [
            { id: 'P001', name: 'iPhone 14 Pro', variant: '256GB · Space Black', imei: '352913547821', stock: 5, price: 'LKR 289,000' },
            { id: 'P002', name: 'Samsung S23 Ultra', variant: '512GB · Phantom Black', imei: '352913547945', stock: 3, price: 'LKR 245,000' },
            { id: 'P003', name: 'Google Pixel 7', variant: '128GB · Snow', imei: '352913547233', stock: 8, price: 'LKR 185,000' },
            { id: 'P004', name: 'iPhone 13', variant: '128GB · Midnight', imei: '352913548765', stock: 12, price: 'LKR 215,000' },
            { id: 'P005', name: 'Xiaomi 13', variant: '256GB · Alpine Green', imei: '352913547108', stock: 15, price: 'LKR 165,000' },
            { id: 'P006', name: 'OnePlus 11', variant: '256GB · Eternal Green', imei: '352913549876', stock: 6, price: 'LKR 198,000' },
            { id: 'P007', name: 'Samsung A54', variant: '256GB · Awesome Violet', imei: '352913549123', stock: 20, price: 'LKR 125,000' },
            { id: 'P008', name: 'Vivo V27 Pro', variant: '256GB · Magic Blue', imei: '352913549456', stock: 10, price: 'LKR 145,000' }
        ];

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

        if (searchTrigger) { - Location 
        const pills = document.querySelectorAll('.pill');
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const locationFilter = this.getAttribute('data-location');
                const rows = inventoryTable.querySelectorAll('tr');

                rows.forEach(row => {
                    const rowLocation = row.getAttribute('data-location');
                    const rowStatus = row.getAttribute('data-status');

                    if (locationFilter === 'all') {
                        row.style.display = '';
                    } else if (locationFilter === 'main') {
                        row.style.display = rowLocation === 'main' ? '' : 'none';
                    } else if (locationFilter === 'branches') {
                        row.style.display = (rowLocation !== 'main' && rowLocation) ? '' : 'none';
                    } else if (locationFilter === 'pending') {
                        row.style.display = (rowStatus === 'pending-sale' || rowStatus === 'pending-payment') ? '' : 'none';
                    }
                });
            });
        });

        // Dropdown filters
        const locationFilter = document.getElementById('locationFilter');
        const statusFilter = document.getElementById('statusFilter');
        const categoryFilter = document.getElementById('categoryFilter');

        function applyFilters() {
            const location = locationFilter.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();
            const category = categoryFilter.value.toLowerCase();
            const rows = inventoryTable.querySelectorAll('tr');

            rows.forEach(row => {
                const rowLocation = row.getAttribute('data-location') || '';
                const rowStatus = row.getAttribute('data-status') || '';
                const rowCategory = row.getAttribute('data-category') || '';

                let showRow = true;

                // Location filter
                if (location !== 'all locations') {
                    if (location === 'main shop' && rowLocation !== 'main') showRow = false;
                    if (location === 'colombo branch' && rowLocation !== 'colombo') showRow = false;
                    if (location === 'kandy branch' && rowLocation !== 'kandy') showRow = false;
                    if (location === 'galle branch' && rowLocation !== 'galle') showRow = false;
                }

                // Status filter
                if (status !== 'all status') {
                    if (status === 'in stock' && rowStatus !== 'in-stock') showRow = false;
                    if (status === 'issued - pending sale' && rowStatus !== 'pending-sale') showRow = false;
                    if (status === 'issued - pending payment' && rowStatus !== 'pending-payment') showRow = false;
                    if (status === 'sale completed' && rowStatus !== 'sale-completed') showRow = false;
                }

                // Category filter
                if (category !== 'all categories' && !rowCategory.includes(category.replace(' ', ''))) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        if (locationFilter) locationFilter.addEventListener('change', applyFilters);
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
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
        const inventoryTable = document.getElementById('inventoryTable');
        
        if (searchProducts && inventoryTable) {
            searchProducts.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = inventoryTable.querySelectorAll('tr');
                
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
            });
        });

        // Stock Transfer Dialog Functions
        function openTransferDialog(imei = '', productName = '', variant = '') {
            const dialog = document.getElementById('transferDialog');
            const productSearch = document.getElementById('productSearch');
            const selectedProductId = document.getElementById('selectedProductId');
            
            dialog.classList.add('active');
            
            // If product details are provided, pre-fill the search
            if (imei && productName) {
                const product = productsData.find(p => p.imei === imei);
                if (product) {
                    productSearch.value = `${product.name} - ${product.variant} (IMEI: ${product.imei})`;
                    selectedProductId.value = product.id;
                    updateStockInfo(product);
                }
            }
            
            // Populate product dropdown initially
            populateProductDropdown(productsData);
        }

        function closeTransferDialog() {
            const dialog = document.getElementById('transferDialog');
            const form = document.getElementById('transferForm');
            const productDropdown = document.getElementById('productDropdown');
            
            dialog.classList.remove('active');
            form.reset();
            document.getElementById('selectedProductId').value = '';
            document.getElementById('stockInfo').style.display = 'none';
            productDropdown.style.display = 'none';
        }

        function showProductDropdown() {
            const dropdown = document.getElementById('productDropdown');
            dropdown.style.display = 'block';
            populateProductDropdown(productsData);
        }

        function filterProducts() {
            const searchTerm = document.getElementById('productSearch').value.toLowerCase();
            
            if (searchTerm.length === 0) {
                populateProductDropdown(productsData);
                return;
            }
            
            const filtered = productsData.filter(product => {
                const last4Digits = product.imei.slice(-4);
                return product.name.toLowerCase().includes(searchTerm) ||
                       product.variant.toLowerCase().includes(searchTerm) ||
                       product.imei.includes(searchTerm) ||
                       last4Digits.includes(searchTerm);
            });
            
            populateProductDropdown(filtered);
        }

        function populateProductDropdown(products) {
            const dropdown = document.getElementById('productDropdown');
            
            if (products.length === 0) {
                dropdown.innerHTML = '<div style="padding: 16px; text-align: center; color: #7a86ad; font-size: 14px;"><i class="fas fa-inbox" style="margin-right: 8px;"></i>No products found</div>';
                return;
            }
            
            dropdown.innerHTML = products.map(product => `
                <div class="product-option" onclick="selectProduct('${product.id}')" style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #f4f7fc; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-weight: 600; color: #1a237e; margin-bottom: 4px;">${product.name}</div>
                            <div style="font-size: 12px; color: #7a86ad; margin-bottom: 4px;">${product.variant}</div>
                            <div style="font-size: 11px; color: #7a86ad;">IMEI: <code style="background: #f4f7fc; padding: 2px 6px; border-radius: 4px; font-weight: 600;">${product.imei}</code></div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 12px; color: #7a86ad; margin-bottom: 4px;">Stock</div>
                            <div style="font-weight: 700; color: ${product.stock > 5 ? '#0d6832' : '#b45f06'}; font-size: 16px;">${product.stock}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function selectProduct(productId) {
            const product = productsData.find(p => p.id === productId);
            if (!product) return;
            
            const productSearch = document.getElementById('productSearch');
            const selectedProductId = document.getElementById('selectedProductId');
            const productDropdown = document.getElementById('productDropdown');
            const transferQuantity = document.getElementById('transferQuantity');
            
            productSearch.value = `${product.name} - ${product.variant} (IMEI: ${product.imei})`;
            selectedProductId.value = product.id;
            productDropdown.style.display = 'none';
            
            // Update stock info and set default quantity
            updateStockInfo(product);
            transferQuantity.value = product.stock;
            transferQuantity.max = product.stock;
        }

        function updateStockInfo(product) {
            const stockInfo = document.getElementById('stockInfo');
            const currentStock = document.getElementById('currentStock');
            
            currentStock.textContent = product.stock;
            stockInfo.style.display = 'block';
        }

        function handleTransferSubmit(event) {
            event.preventDefault();
            
            const location = document.getElementById('transferLocation').value;
            const productId = document.getElementById('selectedProductId').value;
            const quantity = document.getElementById('transferQuantity').value;
            
            const product = productsData.find(p => p.id === productId);
            const locationText = document.getElementById('transferLocation').selectedOptions[0].text;
            
            // Validate quantity
            if (parseInt(quantity) > product.stock) {
                alert('Transfer quantity cannot exceed available stock!');
                return;
            }
            
            // Here you would typically make an API call to process the transfer
            console.log('Transfer Details:', {
                location,
                locationText,
                product,
                quantity
            });
            
            alert(`Stock transfer initiated!\n\nProduct: ${product.name}\nQuantity: ${quantity}\nDestination: ${locationText}\n\nTransfer will be processed shortly.`);
            
            closeTransferDialog();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const productSearch = document.getElementById('productSearch');
            const productDropdown = document.getElementById('productDropdown');
            const transferDialog = document.getElementById('transferDialog');
            
            if (transferDialog && transferDialog.classList.contains('active')) {
                if (!productSearch.contains(event.target) && !productDropdown.contains(event.target)) {
                    productDropdown.style.display = 'none';
                }
            }
        });

        // Close dialog on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const transferDialog = document.getElementById('transferDialog');
                if (transferDialog && transferDialog.classList.contains('active')) {
                    closeTransferDialog();
                }
            }
        });
    </script>
</body>
</html>
