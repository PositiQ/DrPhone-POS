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
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage suppliers, bills, credits, and shipments">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Suppliers</title>
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
                                <th style="width: 16%;">Supplier Name</th>
                                <th style="width: 13%;">Contact Person</th>
                                <th style="width: 11%;">Phone</th>
                                <th style="width: 14%;">Email</th>
                                <th style="width: 10%;">Total Orders</th>
                                <th style="width: 11%;">Outstanding</th>
                                <th style="width: 9%;">Status</th>
                                <th style="width: 16%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="supplierTableBody">
                            <tr data-status="active" data-payment="overdue" data-supplier-id="SUP001" data-supplier-name="Tech World Distributors" data-outstanding="850000">
                                <td><strong>Tech World Distributors</strong></td>
                                <td>Ranil Fernando</td>
                                <td>+94 77 345 6789</td>
                                <td>info@techworld.lk</td>
                                <td>145 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 850,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="Settle Payment" onclick="openPaymentDialog('SUP001', 'Tech World Distributors', 850000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Pay</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP001', 'Tech World Distributors', 850000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="paid" data-supplier-id="SUP002" data-supplier-name="Smart Mobile Solutions" data-outstanding="0">
                                <td><strong>Smart Mobile Solutions</strong></td>
                                <td>Dilshan Perera</td>
                                <td>+94 71 234 5678</td>
                                <td>contact@smartmobile.lk</td>
                                <td>98 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP002', 'Smart Mobile Solutions', 0)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="pending" data-supplier-id="SUP003" data-supplier-name="Global Electronics Ltd" data-outstanding="450000">
                                <td><strong>Global Electronics Ltd</strong></td>
                                <td>Kumari Silva</td>
                                <td>+94 77 987 6543</td>
                                <td>orders@globalelec.lk</td>
                                <td>87 orders</td>
                                <td style="color: #ff9800; font-weight: 600;">LKR 450,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="Settle Payment" onclick="openPaymentDialog('SUP003', 'Global Electronics Ltd', 450000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Pay</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP003', 'Global Electronics Ltd', 450000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="overdue" data-supplier-id="SUP004" data-supplier-name="Mobile Kingdom" data-outstanding="680000">
                                <td><strong>Mobile Kingdom</strong></td>
                                <td>Chaminda Jayawardena</td>
                                <td>+94 76 543 2109</td>
                                <td>sales@mobilekingdom.lk</td>
                                <td>124 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 680,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="Settle Payment" onclick="openPaymentDialog('SUP004', 'Mobile Kingdom', 680000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Pay</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP004', 'Mobile Kingdom', 680000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="inactive" data-payment="paid" data-supplier-id="SUP005" data-supplier-name="ValueTech Imports" data-outstanding="0">
                                <td><strong>ValueTech Imports</strong></td>
                                <td>Nimal Rodrigo</td>
                                <td>+94 75 678 9012</td>
                                <td>info@valuetech.lk</td>
                                <td>34 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #f5f5f5; color: #616161;">Inactive</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP005', 'ValueTech Imports', 0)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="pending" data-supplier-id="SUP006" data-supplier-name="Premium Accessories Co." data-outstanding="285000">
                                <td><strong>Premium Accessories Co.</strong></td>
                                <td>Thilini Gunasekara</td>
                                <td>+94 77 456 7890</td>
                                <td>orders@premiumacc.lk</td>
                                <td>156 orders</td>
                                <td style="color: #ff9800; font-weight: 600;">LKR 285,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="Settle Payment" onclick="openPaymentDialog('SUP006', 'Premium Accessories Co.', 285000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Pay</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP006', 'Premium Accessories Co.', 285000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="overdue" data-supplier-id="SUP007" data-supplier-name="Digital Source LK" data-outstanding="920000">
                                <td><strong>Digital Source LK</strong></td>
                                <td>Sandun Wijesinghe</td>
                                <td>+94 71 890 1234</td>
                                <td>contact@digitalsource.lk</td>
                                <td>67 orders</td>
                                <td style="color: #f44336; font-weight: 600;">LKR 920,000</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="Settle Payment" onclick="openPaymentDialog('SUP007', 'Digital Source LK', 920000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Pay</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP007', 'Digital Source LK', 920000)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="active" data-payment="paid" data-supplier-id="SUP008" data-supplier-name="Phone Parts Hub" data-outstanding="0">
                                <td><strong>Phone Parts Hub</strong></td>
                                <td>Anusha Fernando</td>
                                <td>+94 76 234 5678</td>
                                <td>info@phonepartshub.lk</td>
                                <td>89 orders</td>
                                <td style="color: #4caf50; font-weight: 600;">LKR 0</td>
                                <td><span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('SUP008', 'Phone Parts Hub', 0)" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Stock</span>
                                        </button>
                                        <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onmouseover="this.style.background='#f4f7fc'; this.style.borderColor='#1a237e'" onmouseout="this.style.background='white'; this.style.borderColor='#e0e7ff'">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
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

    <!-- Payment Settlement Dialog -->
    <div class="search-overlay" id="paymentDialog" role="dialog" aria-modal="true" aria-label="Settle Payment">
        <div class="search-dialog" role="document" style="max-width: 600px; padding: 0;">
            <div class="search-dialog-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-money-bill-wave" style="font-size: 20px;"></i>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Settle Payment</h3>
                </div>
                <button class="search-close" type="button" onclick="closePaymentDialog()" aria-label="Close dialog" style="color: white;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div style="padding: 24px;">
                <!-- Supplier Info -->
                <div style="background: #f4f7fc; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #43e97b;">
                    <div style="font-size: 14px; color: #7a86ad; margin-bottom: 8px;">Supplier</div>
                    <div id="paymentSupplierName" style="font-size: 18px; font-weight: 700; color: #1a237e; margin-bottom: 12px;">-</div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 12px; color: #7a86ad;">Outstanding Balance</div>
                            <div id="paymentOutstanding" style="font-size: 24px; font-weight: 800; color: #f44336; margin-top: 4px;">LKR 0</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 12px; color: #7a86ad;">Supplier ID</div>
                            <div id="paymentSupplierId" style="font-size: 14px; font-weight: 600; color: #1a237e; margin-top: 4px;">-</div>
                        </div>
                    </div>
                </div>

                <form id="paymentForm" onsubmit="handlePaymentSubmit(event)">
                    <!-- Payment Amount -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-dollar-sign" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Amount (LKR)
                        </label>
                        <input type="number" id="paymentAmount" min="1" step="0.01" required placeholder="Enter payment amount" style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" oninput="calculateRemaining()">
                        <div style="display: flex; gap: 8px; margin-top: 8px;">
                            <button type="button" onclick="setPartialPayment()" style="padding: 6px 12px; border: 1px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">50%</button>
                            <button type="button" onclick="setFullPayment()" style="padding: 6px 12px; border: 1px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">Full Amount</button>
                        </div>
                    </div>

                    <!-- Remaining Balance Display -->
                    <div id="remainingBalance" style="display: none; margin-bottom: 20px; padding: 12px; background: #fff8e1; border-radius: 8px; border-left: 4px solid #ff9800;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; color: #7a86ad;">Remaining Balance</span>
                            <span id="remainingAmount" style="font-size: 16px; font-weight: 700; color: #ff9800;">LKR 0</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-credit-card" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Method
                        </label>
                        <select id="paymentMethod" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" onchange="toggleChequeFields()">
                            <option value="">Select payment method...</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>

                    <!-- Cheque Details (conditional) -->
                    <div id="chequeFields" style="display: none; margin-bottom: 20px; padding: 16px; background: #f4f7fc; border-radius: 8px;">
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Cheque Number</label>
                            <input type="text" id="chequeNumber" placeholder="Enter cheque number" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Bank Name</label>
                            <input type="text" id="bankName" placeholder="Enter bank name" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Cheque Date</label>
                            <input type="date" id="chequeDate" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                    </div>

                    <!-- Payment Note -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-sticky-note" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Note (Optional)
                        </label>
                        <textarea id="paymentNote" rows="3" placeholder="Add any notes about this payment..." style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; resize: vertical; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closePaymentDialog()" style="padding: 12px 24px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                            Cancel
                        </button>
                        <button type="submit" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <i class="fas fa-check" style="margin-right: 6px;"></i>
                            Process Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stock Purchase Dialog -->
    <div class="search-overlay" id="stockPurchaseDialog" role="dialog" aria-modal="true" aria-label="New Stock Purchase">
        <div class="search-dialog" role="document" style="max-width: 700px; padding: 0; max-height: 90vh; overflow-y: auto;">
            <div class="search-dialog-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 12px 12px 0 0; position: sticky; top: 0; z-index: 10;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">New Stock Purchase</h3>
                </div>
                <button class="search-close" type="button" onclick="closeStockPurchaseDialog()" aria-label="Close dialog" style="color: white;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div style="padding: 24px;">
                <!-- Supplier Info -->
                <div style="background: #f4f7fc; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #667eea;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 12px; color: #7a86ad; margin-bottom: 4px;">Supplier</div>
                            <div id="stockSupplierName" style="font-size: 18px; font-weight: 700; color: #1a237e;">-</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 12px; color: #7a86ad; margin-bottom: 4px;">Current Outstanding</div>
                            <div id="stockOutstanding" style="font-size: 16px; font-weight: 700; color: #f44336;">LKR 0</div>
                        </div>
                    </div>
                </div>

                <form id="stockPurchaseForm" onsubmit="handleStockPurchaseSubmit(event)">
                    <!-- Purchase Details -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-box" style="margin-right: 6px; color: #7a86ad;"></i>
                            Product/Item Description
                        </label>
                        <textarea id="productDescription" rows="2" required placeholder="Enter product details (e.g., iPhone 14 Pro 256GB x 10 units)" style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; resize: vertical; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'"></textarea>
                    </div>

                    <!-- Purchase Amount -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-dollar-sign" style="margin-right: 6px; color: #7a86ad;"></i>
                            Total Purchase Amount (LKR)
                        </label>
                        <input type="number" id="purchaseAmount" min="1" step="0.01" required placeholder="Enter total amount" style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" oninput="calculatePurchasePayment()">
                    </div>

                    <!-- Payment Type -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-hand-holding-usd" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Type
                        </label>
                        <select id="purchasePaymentType" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" onchange="togglePurchasePaymentFields()">
                            <option value="">Select payment type...</option>
                            <option value="full">Full Settlement</option>
                            <option value="partial">Partial Settlement</option>
                            <option value="credit">Credit (Pay Later)</option>
                            <option value="cheque">Cheque Payment</option>
                        </select>
                    </div>

                    <!-- Partial Payment Field -->
                    <div id="partialPaymentField" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-coins" style="margin-right: 6px; color: #7a86ad;"></i>
                            Amount Paying Now (LKR)
                        </label>
                        <input type="number" id="partialAmount" min="1" step="0.01" placeholder="Enter amount to pay now" style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" oninput="calculatePurchasePayment()">
                    </div>

                    <!-- Cheque Details for Purchase -->
                    <div id="purchaseChequeFields" style="display: none; margin-bottom: 20px; padding: 16px; background: #f4f7fc; border-radius: 8px;">
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Cheque Number</label>
                            <input type="text" id="purchaseChequeNumber" placeholder="Enter cheque number" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Bank Name</label>
                            <input type="text" id="purchaseBankName" placeholder="Enter bank name" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Cheque Date</label>
                            <input type="date" id="purchaseChequeDate" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 6px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div id="purchasePaymentSummary" style="display: none; margin-bottom: 20px; padding: 16px; background: linear-gradient(135deg, #f4f7fc 0%, #e8f5e9 100%); border-radius: 8px; border: 2px solid #43e97b;">
                        <div style="font-weight: 700; color: #1a237e; margin-bottom: 12px; font-size: 16px;">Payment Summary</div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #7a86ad;">Total Purchase:</span>
                            <span id="summaryTotal" style="font-weight: 600; color: #1a237e;">LKR 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #7a86ad;">Paying Now:</span>
                            <span id="summaryPaying" style="font-weight: 600; color: #43e97b;">LKR 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 8px; border-top: 2px solid #e0e7ff;">
                            <span style="color: #7a86ad; font-weight: 600;">New Outstanding:</span>
                            <span id="summaryOutstanding" style="font-weight: 700; color: #f44336; font-size: 18px;">LKR 0</span>
                        </div>
                    </div>

                    <!-- Purchase Note -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-sticky-note" style="margin-right: 6px; color: #7a86ad;"></i>
                            Additional Notes (Optional)
                        </label>
                        <textarea id="purchaseNote" rows="2" placeholder="Add any notes about this purchase..." style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; resize: vertical; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closeStockPurchaseDialog()" style="padding: 12px 24px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                            Cancel
                        </button>
                        <button type="submit" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <i class="fas fa-check" style="margin-right: 6px;"></i>
                            Complete Purchase
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
        // Store current supplier data for payment/purchase dialogs
        let currentSupplier = {
            id: '',
            name: '',
            outstanding: 0
        };

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

        // Payment Dialog Functions
        function openPaymentDialog(supplierId, supplierName, outstanding) {
            currentSupplier = { id: supplierId, name: supplierName, outstanding: outstanding };
            
            const dialog = document.getElementById('paymentDialog');
            document.getElementById('paymentSupplierId').textContent = supplierId;
            document.getElementById('paymentSupplierName').textContent = supplierName;
            document.getElementById('paymentOutstanding').textContent = 'LKR ' + outstanding.toLocaleString();
            
            dialog.classList.add('active');
        }

        function closePaymentDialog() {
            const dialog = document.getElementById('paymentDialog');
            const form = document.getElementById('paymentForm');
            
            dialog.classList.remove('active');
            form.reset();
            document.getElementById('chequeFields').style.display = 'none';
            document.getElementById('remainingBalance').style.display = 'none';
        }

        function setPartialPayment() {
            const outstanding = currentSupplier.outstanding;
            document.getElementById('paymentAmount').value = (outstanding * 0.5).toFixed(2);
            calculateRemaining();
        }

        function setFullPayment() {
            document.getElementById('paymentAmount').value = currentSupplier.outstanding.toFixed(2);
            calculateRemaining();
        }

        function calculateRemaining() {
            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const outstanding = currentSupplier.outstanding;
            const remaining = outstanding - paymentAmount;
            
            const remainingDiv = document.getElementById('remainingBalance');
            const remainingAmountSpan = document.getElementById('remainingAmount');
            
            if (paymentAmount > 0 && paymentAmount < outstanding) {
                remainingDiv.style.display = 'block';
                remainingAmountSpan.textContent = 'LKR ' + remaining.toLocaleString();
            } else {
                remainingDiv.style.display = 'none';
            }
        }

        function toggleChequeFields() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const chequeFields = document.getElementById('chequeFields');
            
            if (paymentMethod === 'cheque') {
                chequeFields.style.display = 'block';
                document.getElementById('chequeNumber').required = true;
                document.getElementById('bankName').required = true;
                document.getElementById('chequeDate').required = true;
            } else {
                chequeFields.style.display = 'none';
                document.getElementById('chequeNumber').required = false;
                document.getElementById('bankName').required = false;
                document.getElementById('chequeDate').required = false;
            }
        }

        function handlePaymentSubmit(event) {
            event.preventDefault();
            
            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value);
            const paymentMethod = document.getElementById('paymentMethod').value;
            const paymentNote = document.getElementById('paymentNote').value;
            
            if (paymentAmount > currentSupplier.outstanding) {
                alert('Payment amount cannot exceed outstanding balance!');
                return;
            }
            
            const paymentData = {
                supplierId: currentSupplier.id,
                supplierName: currentSupplier.name,
                amount: paymentAmount,
                method: paymentMethod,
                note: paymentNote,
                remainingBalance: currentSupplier.outstanding - paymentAmount
            };
            
            if (paymentMethod === 'cheque') {
                paymentData.chequeNumber = document.getElementById('chequeNumber').value;
                paymentData.bankName = document.getElementById('bankName').value;
                paymentData.chequeDate = document.getElementById('chequeDate').value;
            }
            
            console.log('Payment Data:', paymentData);
            
            const methodText = paymentMethod === 'cash' ? 'Cash' : 
                              paymentMethod === 'bank_transfer' ? 'Bank Transfer' : 'Cheque';
            
            alert(`Payment processed successfully!\n\nSupplier: ${currentSupplier.name}\nAmount: LKR ${paymentAmount.toLocaleString()}\nMethod: ${methodText}\nRemaining Balance: LKR ${paymentData.remainingBalance.toLocaleString()}`);
            
            closePaymentDialog();
        }

        // Stock Purchase Dialog Functions
        function openStockPurchaseDialog(supplierId, supplierName, outstanding) {
            currentSupplier = { id: supplierId, name: supplierName, outstanding: outstanding };
            
            const dialog = document.getElementById('stockPurchaseDialog');
            document.getElementById('stockSupplierName').textContent = supplierName;
            document.getElementById('stockOutstanding').textContent = 'LKR ' + outstanding.toLocaleString();
            
            dialog.classList.add('active');
        }

        function closeStockPurchaseDialog() {
            const dialog = document.getElementById('stockPurchaseDialog');
            const form = document.getElementById('stockPurchaseForm');
            
            dialog.classList.remove('active');
            form.reset();
            document.getElementById('partialPaymentField').style.display = 'none';
            document.getElementById('purchaseChequeFields').style.display = 'none';
            document.getElementById('purchasePaymentSummary').style.display = 'none';
        }

        function togglePurchasePaymentFields() {
            const paymentType = document.getElementById('purchasePaymentType').value;
            const partialField = document.getElementById('partialPaymentField');
            const chequeFields = document.getElementById('purchaseChequeFields');
            
            // Reset fields
            partialField.style.display = 'none';
            chequeFields.style.display = 'none';
            document.getElementById('partialAmount').required = false;
            document.getElementById('purchaseChequeNumber').required = false;
            document.getElementById('purchaseBankName').required = false;
            document.getElementById('purchaseChequeDate').required = false;
            
            if (paymentType === 'partial') {
                partialField.style.display = 'block';
                document.getElementById('partialAmount').required = true;
            } else if (paymentType === 'cheque') {
                chequeFields.style.display = 'block';
                document.getElementById('purchaseChequeNumber').required = true;
                document.getElementById('purchaseBankName').required = true;
                document.getElementById('purchaseChequeDate').required = true;
            }
            
            calculatePurchasePayment();
        }

        function calculatePurchasePayment() {
            const purchaseAmount = parseFloat(document.getElementById('purchaseAmount').value) || 0;
            const paymentType = document.getElementById('purchasePaymentType').value;
            const partialAmount = parseFloat(document.getElementById('partialAmount').value) || 0;
            
            if (purchaseAmount <= 0) {
                document.getElementById('purchasePaymentSummary').style.display = 'none';
                return;
            }
            
            let payingNow = 0;
            let newOutstanding = 0;
            
            switch(paymentType) {
                case 'full':
                case 'cheque':
                    payingNow = purchaseAmount;
                    newOutstanding = currentSupplier.outstanding;
                    break;
                case 'partial':
                    payingNow = partialAmount;
                    newOutstanding = currentSupplier.outstanding + (purchaseAmount - partialAmount);
                    break;
                case 'credit':
                    payingNow = 0;
                    newOutstanding = currentSupplier.outstanding + purchaseAmount;
                    break;
            }
            
            if (paymentType) {
                document.getElementById('purchasePaymentSummary').style.display = 'block';
                document.getElementById('summaryTotal').textContent = 'LKR ' + purchaseAmount.toLocaleString();
                document.getElementById('summaryPaying').textContent = 'LKR ' + payingNow.toLocaleString();
                document.getElementById('summaryOutstanding').textContent = 'LKR ' + newOutstanding.toLocaleString();
            }
        }

        function handleStockPurchaseSubmit(event) {
            event.preventDefault();
            
            const purchaseAmount = parseFloat(document.getElementById('purchaseAmount').value);
            const paymentType = document.getElementById('purchasePaymentType').value;
            const productDescription = document.getElementById('productDescription').value;
            const purchaseNote = document.getElementById('purchaseNote').value;
            
            let payingNow = 0;
            
            switch(paymentType) {
                case 'full':
                case 'cheque':
                    payingNow = purchaseAmount;
                    break;
                case 'partial':
                    payingNow = parseFloat(document.getElementById('partialAmount').value);
                    if (payingNow > purchaseAmount) {
                        alert('Partial payment cannot exceed total purchase amount!');
                        return;
                    }
                    break;
                case 'credit':
                    payingNow = 0;
                    break;
            }
            
            const newOutstanding = currentSupplier.outstanding + (purchaseAmount - payingNow);
            
            const purchaseData = {
                supplierId: currentSupplier.id,
                supplierName: currentSupplier.name,
                productDescription: productDescription,
                totalAmount: purchaseAmount,
                paymentType: paymentType,
                amountPaid: payingNow,
                newOutstanding: newOutstanding,
                note: purchaseNote
            };
            
            if (paymentType === 'cheque') {
                purchaseData.chequeNumber = document.getElementById('purchaseChequeNumber').value;
                purchaseData.bankName = document.getElementById('purchaseBankName').value;
                purchaseData.chequeDate = document.getElementById('purchaseChequeDate').value;
            }
            
            console.log('Stock Purchase Data:', purchaseData);
            
            const paymentTypeText = paymentType === 'full' ? 'Full Settlement' :
                                   paymentType === 'partial' ? 'Partial Settlement' :
                                   paymentType === 'credit' ? 'Credit' : 'Cheque Payment';
            
            alert(`Stock purchase completed!\n\nSupplier: ${currentSupplier.name}\nTotal Amount: LKR ${purchaseAmount.toLocaleString()}\nPayment Type: ${paymentTypeText}\nAmount Paid: LKR ${payingNow.toLocaleString()}\nNew Outstanding: LKR ${newOutstanding.toLocaleString()}`);
            
            closeStockPurchaseDialog();
        }

        // Close dialogs on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const paymentDialog = document.getElementById('paymentDialog');
                const stockDialog = document.getElementById('stockPurchaseDialog');
                
                if (paymentDialog && paymentDialog.classList.contains('active')) {
                    closePaymentDialog();
                }
                if (stockDialog && stockDialog.classList.contains('active')) {
                    closeStockPurchaseDialog();
                }
            }
        });
    </script>
</body>
</html>
