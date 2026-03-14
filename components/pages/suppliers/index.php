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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <option value="due_soon">Cheque Due Soon</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button" id="addSupplierBtn">
                            <i class="fas fa-plus"></i>
                            Add Supplier
                        </button>
                        <button class="button-secondary" type="button" id="exportSuppliersBtn">
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
                            <div class="metric-value" id="metricTotalSuppliers">0</div>
                            <div class="metric-change positive">+2 new this month</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Active Suppliers</div>
                            <div class="metric-value" id="metricActiveSuppliers">0</div>
                            <div class="metric-change">Currently trading</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Payable</div>
                            <div class="metric-value" id="metricTotalPayable">LKR 0.00</div>
                            <div class="metric-change" style="color: #f44336;">Outstanding balance</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Overdue Payments</div>
                            <div class="metric-value" id="metricOverduePayments">0</div>
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

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-vault" style="margin-right: 6px; color: #7a86ad;"></i>
                            Account
                        </label>
                        <select id="paymentAccount" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="">Select account...</option>
                        </select>
                        <div id="paymentAccountHint" style="font-size: 12px; color: #7a86ad; margin-top: 6px;">Select payment method first.</div>
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
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                            <label style="display: block; font-weight: 600; color: #1a237e; font-size: 14px; margin: 0;">
                                <i class="fas fa-layer-group" style="margin-right: 6px; color: #7a86ad;"></i>
                                Products for This Purchase
                            </label>
                            <button type="button" onclick="addPurchaseProduct()" style="padding: 10px 16px; border: none; background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.opacity='0.92'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </button>
                        </div>

                        <div id="purchaseProductsContainer" style="display: grid; gap: 16px;"></div>
                    </div>

                    <!-- Purchase Amount -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-dollar-sign" style="margin-right: 6px; color: #7a86ad;"></i>
                            Total Purchase Amount (LKR)
                        </label>
                        <input type="number" id="purchaseAmount" min="0" step="0.01" required readonly placeholder="Calculated from product cost prices" style="width: 100%; padding: 12px; border: 2px solid #d7def7; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s; background: #f7f9ff; font-weight: 700;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#d7def7'">
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
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-credit-card" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Method
                        </label>
                        <select id="purchasePaymentMethod" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'" onchange="togglePurchasePaymentFields()">
                            <option value="">Select payment method...</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>

                    <div id="purchaseAccountWrap" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-vault" style="margin-right: 6px; color: #7a86ad;"></i>
                            Account
                        </label>
                        <select id="purchaseAccount" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="">Select account...</option>
                        </select>
                        <div id="purchaseAccountHint" style="font-size: 12px; color: #7a86ad; margin-top: 6px;">Select payment method first.</div>
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

        let purchaseProductCounter = 0;
        let suppliersCache = [];
        let vaultAccounts = [];
        let activePillFilter = 'all';

        const API_BASE_URL = 'http://localhost:3000/api';
        const SUPPLIERS_API = `${API_BASE_URL}/suppliers`;
        const SUPPLIER_SUMMARY_API = `${SUPPLIERS_API}/summary`;
        const SUPPLIER_PURCHASE_API = `${SUPPLIERS_API}/purchases`;
        const SUPPLIER_PAYMENT_API = `${SUPPLIERS_API}/payments`;
        const VAULT_ACCOUNTS_API = `${API_BASE_URL}/vault/accounts`;

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function showNotice(message) {
            return Swal.fire({
                icon: 'info',
                title: 'Notice',
                text: message,
                confirmButtonColor: '#1a237e',
            });
        }

        function showSuccess(message) {
            return Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                confirmButtonColor: '#1a237e',
            });
        }

        function showError(message) {
            return Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonColor: '#1a237e',
            });
        }

        async function promptText({ title, placeholder = '', required = false }) {
            const { value, isDismissed } = await Swal.fire({
                title,
                input: 'text',
                inputPlaceholder: placeholder,
                showCancelButton: true,
                confirmButtonColor: '#1a237e',
                cancelButtonColor: '#7a86ad',
                inputValidator: (inputValue) => {
                    if (required && !String(inputValue || '').trim()) {
                        return 'This field is required';
                    }
                    return undefined;
                },
            });

            if (isDismissed) {
                return null;
            }

            return String(value || '').trim();
        }

        async function requestJson(url, options = {}) {
            const response = await fetch(url, options);
            const result = await response.json().catch(() => ({}));
            if (!response.ok || result.success === false) {
                throw new Error(result.error || result.message || 'Request failed');
            }
            return result;
        }

        function getRequiredAccountTypeByPaymentMethod(paymentMethod) {
            return String(paymentMethod || '').toLowerCase() === 'cash' ? 'drawer' : 'bank';
        }

        function getOutstandingStyle(outstanding, paymentStatus) {
            if (paymentStatus === 'overdue') {
                return 'color: #f44336; font-weight: 700;';
            }
            if (Number(outstanding || 0) > 0) {
                return 'color: #ff9800; font-weight: 700;';
            }
            return 'color: #4caf50; font-weight: 700;';
        }

        function getStatusBadgeStyle(status) {
            if (String(status).toLowerCase() === 'active') {
                return 'background: #e8f5e9; color: #2e7d32;';
            }
            return 'background: #f5f5f5; color: #616161;';
        }

        function getPaymentBadge(paymentStatus, dueSoonCount, overdueCount) {
            if (paymentStatus === 'overdue') {
                return { text: `Overdue (${overdueCount || 0} chq)`, style: 'background:#ffebee;color:#c62828;' };
            }
            if (paymentStatus === 'due_soon') {
                return { text: `Due Soon (${dueSoonCount || 0} chq)`, style: 'background:#fff8e1;color:#ef6c00;' };
            }
            if (paymentStatus === 'pending') {
                return { text: 'Pending', style: 'background:#fff3e0;color:#f57c00;' };
            }
            return { text: 'Paid', style: 'background:#e8f5e9;color:#2e7d32;' };
        }

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

        function renderSupplierTable(data) {
            if (!Array.isArray(data) || !data.length) {
                tableBody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 18px; color:#7a86ad;">No suppliers found.</td></tr>';
                return;
            }

            tableBody.innerHTML = data.map(row => {
                const paymentBadge = getPaymentBadge(row.payment_status, row.cheque_due_soon_count, row.cheque_overdue_count);
                const outstandingValue = Number(row.outstanding_balance || 0);
                const canPay = outstandingValue > 0;
                const supplierStatus = String(row.status || '').toLowerCase();
                const displayBadge = supplierStatus === 'inactive'
                    ? { text: 'Inactive', style: getStatusBadgeStyle('inactive') }
                    : paymentBadge;

                return `
                    <tr data-status="${escapeHtml(row.status)}" data-payment="${escapeHtml(row.payment_status)}" data-supplier-id="${escapeHtml(row.supplier_id)}" data-supplier-name="${escapeHtml(row.name)}" data-outstanding="${outstandingValue}">
                        <td><strong>${escapeHtml(row.name)}</strong></td>
                        <td>${escapeHtml(row.contact_person || '-')}</td>
                        <td>${escapeHtml(row.phone || '-')}</td>
                        <td>${escapeHtml(row.email || '-')}</td>
                        <td>${Number(row.total_orders || 0).toLocaleString()} orders</td>
                        <td style="${getOutstandingStyle(outstandingValue, row.payment_status)}">${formatLkr(outstandingValue)}</td>
                        <td>
                            <span class="status-badge" style="${displayBadge.style}">${escapeHtml(displayBadge.text)}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px; ${canPay ? '' : 'opacity:0.45;'}" title="Settle Payment" ${canPay ? `onclick="openPaymentDialog('${escapeHtml(row.supplier_id)}', '${escapeHtml(row.name)}', ${outstandingValue})"` : 'disabled'}>
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Pay</span>
                                </button>
                                <button style="padding: 8px 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="New Stock Purchase" onclick="openStockPurchaseDialog('${escapeHtml(row.supplier_id)}', '${escapeHtml(row.name)}', ${outstandingValue})">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Stock</span>
                                </button>
                                <button style="padding: 8px 12px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" title="View Details" onclick="openSupplierDetails('${escapeHtml(row.supplier_id)}')">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async function loadSuppliers() {
            const result = await requestJson(SUPPLIERS_API);
            suppliersCache = Array.isArray(result.data) ? result.data : [];
            renderSupplierTable(suppliersCache);
            applyAllTableFilters();
        }

        async function loadSupplierSummary() {
            const result = await requestJson(SUPPLIER_SUMMARY_API);
            const summary = result.data || {};

            document.getElementById('metricTotalSuppliers').textContent = Number(summary.total_suppliers || 0).toLocaleString();
            document.getElementById('metricActiveSuppliers').textContent = Number(summary.active_suppliers || 0).toLocaleString();
            document.getElementById('metricTotalPayable').textContent = formatLkr(summary.total_payable || 0);
            document.getElementById('metricOverduePayments').textContent = Number(summary.overdue_payments || 0).toLocaleString();
        }

        function applyAllTableFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            const paymentValue = paymentFilter.value;
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                if (!row.dataset.supplierId) {
                    row.style.display = '';
                    return;
                }

                const text = row.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                const matchesStatus = !statusValue || row.dataset.status === statusValue;
                const matchesPayment = !paymentValue || row.dataset.payment === paymentValue;

                let matchesPill = true;
                if (activePillFilter !== 'all') {
                    if (activePillFilter === 'overdue') {
                        matchesPill = row.dataset.payment === 'overdue';
                    } else {
                        matchesPill = row.dataset.status === activePillFilter;
                    }
                }

                row.style.display = matchesSearch && matchesStatus && matchesPayment && matchesPill ? '' : 'none';
            });
        }

        function searchSuppliers() {
            applyAllTableFilters();
        }

        searchInput.addEventListener('input', searchSuppliers);
        statusFilter.addEventListener('change', searchSuppliers);
        paymentFilter.addEventListener('change', searchSuppliers);

        // Pill filters
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                activePillFilter = this.dataset.filter;
                applyAllTableFilters();
            });
        });

        async function loadVaultAccounts() {
            const result = await requestJson(VAULT_ACCOUNTS_API);
            vaultAccounts = Array.isArray(result.accounts)
                ? result.accounts.map(item => ({
                    id: item.account_id,
                    type: String(item.account_type || '').toLowerCase(),
                    label: item.display_name || item.account_id,
                    balance: Number(item.available_balance || 0),
                }))
                : [];
        }

        function renderAccountOptions(selectId, hintId, paymentMethod, isOptional = false) {
            const select = document.getElementById(selectId);
            const hint = document.getElementById(hintId);
            if (!select || !hint) {
                return;
            }

            if (!paymentMethod) {
                select.innerHTML = '<option value="">Select payment method first...</option>';
                select.required = !isOptional;
                hint.textContent = 'Select payment method first.';
                return;
            }

            const requiredType = getRequiredAccountTypeByPaymentMethod(paymentMethod);
            const matched = vaultAccounts.filter(account => account.type === requiredType);

            select.innerHTML = `<option value="">Select ${requiredType} account...</option>` + matched.map(account =>
                `<option value="${account.id}">${escapeHtml(account.label)} · ${formatLkr(account.balance)}</option>`
            ).join('');

            select.required = !isOptional;
            hint.textContent = requiredType === 'drawer'
                ? 'Cash requires a drawer account.'
                : 'Bank transfer and cheque require a bank account.';

            if (!matched.length) {
                hint.textContent += ` No ${requiredType} account found.`;
            }
        }

        // Payment Dialog Functions
        function openPaymentDialog(supplierId, supplierName, outstanding) {
            currentSupplier = { id: supplierId, name: supplierName, outstanding: outstanding };
            
            const dialog = document.getElementById('paymentDialog');
            document.getElementById('paymentSupplierId').textContent = supplierId;
            document.getElementById('paymentSupplierName').textContent = supplierName;
            document.getElementById('paymentOutstanding').textContent = 'LKR ' + outstanding.toLocaleString();
            renderAccountOptions('paymentAccount', 'paymentAccountHint', document.getElementById('paymentMethod').value);
            
            dialog.classList.add('active');
        }

        function closePaymentDialog() {
            const dialog = document.getElementById('paymentDialog');
            const form = document.getElementById('paymentForm');
            
            dialog.classList.remove('active');
            form.reset();
            document.getElementById('chequeFields').style.display = 'none';
            document.getElementById('remainingBalance').style.display = 'none';
            renderAccountOptions('paymentAccount', 'paymentAccountHint', '');
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
            renderAccountOptions('paymentAccount', 'paymentAccountHint', paymentMethod);
            
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

        async function handlePaymentSubmit(event) {
            event.preventDefault();
            
            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value);
            const paymentMethod = document.getElementById('paymentMethod').value;
            const paymentAccount = document.getElementById('paymentAccount').value;
            const paymentNote = document.getElementById('paymentNote').value;
            
            if (paymentAmount > currentSupplier.outstanding) {
                showNotice('Payment amount cannot exceed outstanding balance!');
                return;
            }

            const payload = {
                supplier_id: currentSupplier.id,
                amount: paymentAmount,
                payment_method: paymentMethod,
                account_id: paymentAccount,
                note: paymentNote,
            };

            if (paymentMethod === 'cheque') {
                payload.cheque_number = document.getElementById('chequeNumber').value;
                payload.bank_name = document.getElementById('bankName').value;
                payload.cheque_date = document.getElementById('chequeDate').value;
            }

            try {
                await requestJson(SUPPLIER_PAYMENT_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const remaining = Math.max(currentSupplier.outstanding - paymentAmount, 0);
                showSuccess(`Payment recorded successfully. Remaining balance: ${formatLkr(remaining)}`);
                closePaymentDialog();
                await Promise.all([loadSuppliers(), loadSupplierSummary()]);
            } catch (error) {
                showError(`Failed to process payment: ${error.message}`);
            }
        }

        function generateSku() {
            const token = Math.floor(1000 + Math.random() * 9000);
            return `SKU-PRODU-${token}`;
        }

        function getPurchaseProductsContainer() {
            return document.getElementById('purchaseProductsContainer');
        }

        function getProductCardTitle(index) {
            return `Product ${index}`;
        }

        function createPurchaseProductCard(productId) {
            return `
                <div class="purchase-product-card" data-product-id="${productId}" style="background: white; border: 2px solid #e0e7ff; border-radius: 14px; padding: 18px; box-shadow: 0 10px 24px rgba(26, 35, 126, 0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;">
                        <div>
                            <div class="purchase-product-title" style="font-size: 16px; font-weight: 700; color: #1a237e;">${getProductCardTitle(productId)}</div>
                            <div style="font-size: 12px; color: #7a86ad; margin-top: 4px;">Enter item details to build the supplier purchase preview.</div>
                        </div>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <button type="button" class="purchase-regenerate-sku" style="padding: 8px 12px; border: 1px solid #d7def7; background: #f7f9ff; color: #1a237e; border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-rotate"></i>
                                New SKU
                            </button>
                            <button type="button" class="purchase-remove-product" style="padding: 8px 12px; border: 1px solid #ffd7d7; background: #fff5f5; color: #d32f2f; border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px;">
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Product Name</label>
                            <input type="text" class="purchase-product-name" required placeholder="e.g. iPhone 15 Pro" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Product Type</label>
                            <select class="purchase-product-type" required style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none;">
                                <option value="">Select type...</option>
                                <option value="Phone">Phone</option>
                                <option value="Accessory">Accessory</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Brand</label>
                            <input type="text" class="purchase-product-brand" required placeholder="e.g. Apple" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Model</label>
                            <input type="text" class="purchase-product-model" placeholder="e.g. A3101" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Storage/Capacity</label>
                            <input type="text" class="purchase-product-capacity" placeholder="e.g. 256GB" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Color</label>
                            <input type="text" class="purchase-product-color" placeholder="e.g. Titanium Blue" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Condition</label>
                            <input type="text" class="purchase-product-condition" placeholder="e.g. Brand New" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">SKU</label>
                            <input type="text" class="purchase-product-sku" readonly style="width: 100%; padding: 10px; border: 2px solid #d7def7; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; background: #f7f9ff; font-weight: 700;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">IMEI Number</label>
                            <input type="text" class="purchase-product-imei" placeholder="Required for phone items" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Barcode</label>
                            <input type="text" class="purchase-product-barcode" placeholder="Enter barcode" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Serial Number</label>
                            <input type="text" class="purchase-product-serial" placeholder="Enter serial number" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Cost Price (LKR)</label>
                            <input type="number" class="purchase-product-cost" min="0" step="0.01" required placeholder="0.00" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Selling Price (LKR)</label>
                            <input type="number" class="purchase-product-selling" min="0" step="0.01" placeholder="0.00" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Quantity in Stock</label>
                            <input type="number" class="purchase-product-quantity" min="1" step="1" value="1" required style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a237e; font-size: 13px;">Supplier</label>
                            <input type="text" class="purchase-product-supplier" readonly style="width: 100%; padding: 10px; border: 2px solid #d7def7; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; background: #f7f9ff;">
                        </div>
                    </div>

                    <div style="margin-top: 14px; padding: 12px 14px; border-radius: 10px; background: linear-gradient(135deg, #f7f9ff 0%, #eef3ff 100%); display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <div style="font-size: 13px; color: #7a86ad;">Line Total = Cost Price × Quantity</div>
                        <div class="purchase-product-line-total" style="font-size: 18px; font-weight: 800; color: #1a237e;">LKR 0</div>
                    </div>
                </div>
            `;
        }

        function refreshPurchaseProductTitles() {
            const cards = getProductCardList();
            cards.forEach((card, index) => {
                const title = card.querySelector('.purchase-product-title');
                if (title) {
                    title.textContent = getProductCardTitle(index + 1);
                }
            });
        }

        function getProductCardList() {
            return Array.from(document.querySelectorAll('.purchase-product-card'));
        }

        function updateProductLineTotal(card) {
            const cost = parseFloat(card.querySelector('.purchase-product-cost').value) || 0;
            const quantity = parseInt(card.querySelector('.purchase-product-quantity').value, 10) || 0;
            const total = cost * quantity;
            card.querySelector('.purchase-product-line-total').textContent = 'LKR ' + total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function updatePhoneFieldRequirements(card) {
            const type = card.querySelector('.purchase-product-type').value;
            const imeiInput = card.querySelector('.purchase-product-imei');
            const isPhone = type === 'Phone';

            imeiInput.required = isPhone;
            imeiInput.placeholder = isPhone ? 'Required for phone items' : 'Optional for accessories';
        }

        function updateSupplierFields() {
            getProductCardList().forEach(card => {
                const supplierInput = card.querySelector('.purchase-product-supplier');
                if (supplierInput) {
                    supplierInput.value = currentSupplier.name || '';
                }
            });
        }

        function addPurchaseProduct() {
            purchaseProductCounter += 1;
            const container = getPurchaseProductsContainer();
            container.insertAdjacentHTML('beforeend', createPurchaseProductCard(purchaseProductCounter));

            const card = container.lastElementChild;
            card.querySelector('.purchase-product-sku').value = generateSku();
            card.querySelector('.purchase-product-supplier').value = currentSupplier.name || '';

            refreshPurchaseProductTitles();
            updatePhoneFieldRequirements(card);
            updateProductLineTotal(card);
            calculatePurchasePayment();
        }

        function resetPurchaseProducts() {
            const container = getPurchaseProductsContainer();
            if (!container) {
                return;
            }

            container.innerHTML = '';
            addPurchaseProduct();
        }

        function collectPurchaseProducts() {
            return getProductCardList().map(card => {
                const quantity = parseInt(card.querySelector('.purchase-product-quantity').value, 10) || 0;
                const costPrice = parseFloat(card.querySelector('.purchase-product-cost').value) || 0;

                return {
                    productName: card.querySelector('.purchase-product-name').value.trim(),
                    productType: card.querySelector('.purchase-product-type').value,
                    brand: card.querySelector('.purchase-product-brand').value.trim(),
                    model: card.querySelector('.purchase-product-model').value.trim(),
                    storageCapacity: card.querySelector('.purchase-product-capacity').value.trim(),
                    color: card.querySelector('.purchase-product-color').value.trim(),
                    condition: card.querySelector('.purchase-product-condition').value.trim(),
                    sku: card.querySelector('.purchase-product-sku').value,
                    imeiNumber: card.querySelector('.purchase-product-imei').value.trim(),
                    barcode: card.querySelector('.purchase-product-barcode').value.trim(),
                    serialNumber: card.querySelector('.purchase-product-serial').value.trim(),
                    costPrice: costPrice,
                    sellingPrice: parseFloat(card.querySelector('.purchase-product-selling').value) || 0,
                    quantityInStock: quantity,
                    supplier: card.querySelector('.purchase-product-supplier').value,
                    lineTotal: costPrice * quantity
                };
            });
        }

        function syncPurchaseAmountFromProducts() {
            const products = collectPurchaseProducts();
            const total = products.reduce((sum, product) => sum + product.lineTotal, 0);
            document.getElementById('purchaseAmount').value = total.toFixed(2);
            return total;
        }

        // Stock Purchase Dialog Functions
        function openStockPurchaseDialog(supplierId, supplierName, outstanding) {
            currentSupplier = { id: supplierId, name: supplierName, outstanding: outstanding };
            
            const dialog = document.getElementById('stockPurchaseDialog');
            document.getElementById('stockSupplierName').textContent = supplierName;
            document.getElementById('stockOutstanding').textContent = 'LKR ' + outstanding.toLocaleString();
            updateSupplierFields();
            if (getProductCardList().length === 0) {
                resetPurchaseProducts();
            } else {
                updateSupplierFields();
                calculatePurchasePayment();
            }
            togglePurchasePaymentFields();
            
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
            renderAccountOptions('purchaseAccount', 'purchaseAccountHint', '');
            resetPurchaseProducts();
        }

        function togglePurchasePaymentFields() {
            const paymentType = document.getElementById('purchasePaymentType').value;
            const paymentMethod = document.getElementById('purchasePaymentMethod').value;
            const partialField = document.getElementById('partialPaymentField');
            const chequeFields = document.getElementById('purchaseChequeFields');
            const accountWrap = document.getElementById('purchaseAccountWrap');
            const paymentMethodSelect = document.getElementById('purchasePaymentMethod');
            const purchaseAccount = document.getElementById('purchaseAccount');
            
            // Reset fields
            partialField.style.display = 'none';
            chequeFields.style.display = 'none';
            document.getElementById('partialAmount').required = false;
            document.getElementById('purchaseChequeNumber').required = false;
            document.getElementById('purchaseBankName').required = false;
            document.getElementById('purchaseChequeDate').required = false;

            const isCredit = paymentType === 'credit';
            paymentMethodSelect.required = !isCredit;
            paymentMethodSelect.disabled = isCredit;
            purchaseAccount.required = !isCredit;
            purchaseAccount.disabled = isCredit;
            accountWrap.style.display = isCredit ? 'none' : 'block';
            
            if (paymentType === 'partial') {
                partialField.style.display = 'block';
                document.getElementById('partialAmount').required = true;
            }

            if (!isCredit && paymentMethod === 'cheque') {
                chequeFields.style.display = 'block';
                document.getElementById('purchaseChequeNumber').required = true;
                document.getElementById('purchaseBankName').required = true;
                document.getElementById('purchaseChequeDate').required = true;
            }

            renderAccountOptions('purchaseAccount', 'purchaseAccountHint', isCredit ? '' : paymentMethod, isCredit);
            
            calculatePurchasePayment();
        }

        function calculatePurchasePayment() {
            const purchaseAmount = syncPurchaseAmountFromProducts();
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

        async function handleStockPurchaseSubmit(event) {
            event.preventDefault();
            
            const purchaseAmount = syncPurchaseAmountFromProducts();
            const paymentType = document.getElementById('purchasePaymentType').value;
            const paymentMethod = document.getElementById('purchasePaymentMethod').value;
            const purchaseAccount = document.getElementById('purchaseAccount').value;
            const purchaseNote = document.getElementById('purchaseNote').value;
            const purchaseProducts = collectPurchaseProducts();

            if (!event.target.reportValidity()) {
                return;
            }

            if (!purchaseProducts.length || purchaseAmount <= 0) {
                showNotice('Add at least one product with cost price and quantity.');
                return;
            }
            
            let payingNow = 0;
            
            switch(paymentType) {
                case 'full':
                    payingNow = purchaseAmount;
                    break;
                case 'partial':
                    payingNow = parseFloat(document.getElementById('partialAmount').value);
                    if (payingNow > purchaseAmount) {
                        showNotice('Partial payment cannot exceed total purchase amount!');
                        return;
                    }
                    break;
                case 'credit':
                    payingNow = 0;
                    break;
            }
            
            const newOutstanding = currentSupplier.outstanding + (purchaseAmount - payingNow);
            
            const payload = {
                supplier_id: currentSupplier.id,
                products: purchaseProducts,
                payment_type: paymentType,
                payment_method: paymentType === 'credit' ? 'cash' : paymentMethod,
                amount_paid: payingNow,
                account_id: paymentType === 'credit' ? null : purchaseAccount,
                note: purchaseNote,
            };
            
            if (paymentType !== 'credit' && paymentMethod === 'cheque') {
                payload.cheque_number = document.getElementById('purchaseChequeNumber').value;
                payload.bank_name = document.getElementById('purchaseBankName').value;
                payload.cheque_date = document.getElementById('purchaseChequeDate').value;
            }

            try {
                await requestJson(SUPPLIER_PURCHASE_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                showSuccess(`Stock purchase recorded successfully. New outstanding: ${formatLkr(newOutstanding)}`);
                closeStockPurchaseDialog();
                await Promise.all([loadSuppliers(), loadSupplierSummary()]);
            } catch (error) {
                showError(`Failed to save stock purchase: ${error.message}`);
            }
        }

        async function openSupplierDetails(supplierId) {
            try {
                const result = await requestJson(`${SUPPLIERS_API}/${encodeURIComponent(supplierId)}`);
                const payload = result.data || {};
                const supplierData = payload.supplier || {};
                const purchases = Array.isArray(payload.purchases) ? payload.purchases : [];
                const payments = Array.isArray(payload.payments) ? payload.payments : [];
                const cheques = Array.isArray(payload.cheques) ? payload.cheques : [];

                const dueSoon = cheques.filter(item => item.flag === 'due_soon').length;
                const overdue = cheques.filter(item => item.flag === 'overdue').length;

                showNotice(
                    `Supplier: ${supplierData.name || supplierId}\n` +
                    `Outstanding: ${formatLkr(supplierData.outstanding_balance)}\n` +
                    `Purchases: ${purchases.length}\n` +
                    `Payments: ${payments.length}\n` +
                    `Cheques Due Soon: ${dueSoon}\n` +
                    `Cheques Overdue: ${overdue}`
                );
            } catch (error) {
                showError(`Failed to load supplier details: ${error.message}`);
            }
        }

        async function promptAndCreateSupplier() {
            const name = await promptText({ title: 'Supplier Name', placeholder: 'Enter supplier name', required: true });
            if (name === null) return;

            const contactPerson = await promptText({ title: 'Contact Person', placeholder: 'Enter contact person', required: true });
            if (contactPerson === null) return;

            const phone = await promptText({ title: 'Phone Number', placeholder: 'Enter phone number', required: true });
            if (phone === null) return;

            const email = await promptText({ title: 'Email (Optional)', placeholder: 'Enter email address', required: false });
            if (email === null) return;

            try {
                await requestJson(SUPPLIERS_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: name.trim(),
                        contact_person: contactPerson.trim(),
                        phone: phone.trim(),
                        email: email.trim(),
                        status: 'active',
                    }),
                });

                showSuccess('Supplier added successfully.');
                await Promise.all([loadSuppliers(), loadSupplierSummary()]);
            } catch (error) {
                showError(`Failed to add supplier: ${error.message}`);
            }
        }

        function exportSuppliersCsv() {
            const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => row.style.display !== 'none' && row.dataset.supplierId);
            if (!rows.length) {
                showNotice('No supplier rows to export.');
                return;
            }

            const csvRows = [
                ['Supplier ID', 'Supplier Name', 'Contact Person', 'Phone', 'Email', 'Total Orders', 'Outstanding', 'Status', 'Payment Status'].join(','),
            ];

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const value = [
                    row.dataset.supplierId,
                    (cells[0]?.textContent || '').trim(),
                    (cells[1]?.textContent || '').trim(),
                    (cells[2]?.textContent || '').trim(),
                    (cells[3]?.textContent || '').trim(),
                    (cells[4]?.textContent || '').trim(),
                    (cells[5]?.textContent || '').trim(),
                    row.dataset.status || '',
                    row.dataset.payment || '',
                ].map(item => `"${String(item).replace(/"/g, '""')}"`).join(',');

                csvRows.push(value);
            });

            const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `suppliers-export-${new Date().toISOString().slice(0, 10)}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        document.addEventListener('click', function(event) {
            if (event.target.closest('.purchase-remove-product')) {
                const card = event.target.closest('.purchase-product-card');
                if (!card) {
                    return;
                }

                const cards = getProductCardList();
                if (cards.length === 1) {
                    showNotice('At least one product row is required.');
                    return;
                }

                card.remove();
                refreshPurchaseProductTitles();
                calculatePurchasePayment();
            }

            if (event.target.closest('.purchase-regenerate-sku')) {
                const card = event.target.closest('.purchase-product-card');
                if (!card) {
                    return;
                }

                card.querySelector('.purchase-product-sku').value = generateSku();
            }
        });

        document.addEventListener('input', function(event) {
            const card = event.target.closest('.purchase-product-card');
            if (!card) {
                return;
            }

            if (event.target.classList.contains('purchase-product-cost') || event.target.classList.contains('purchase-product-quantity')) {
                updateProductLineTotal(card);
                calculatePurchasePayment();
            }
        });

        document.addEventListener('change', function(event) {
            const card = event.target.closest('.purchase-product-card');
            if (!card) {
                return;
            }

            if (event.target.classList.contains('purchase-product-type')) {
                updatePhoneFieldRequirements(card);
            }
        });

        resetPurchaseProducts();

        const addSupplierBtn = document.getElementById('addSupplierBtn');
        if (addSupplierBtn) {
            addSupplierBtn.addEventListener('click', promptAndCreateSupplier);
        }

        const exportSuppliersBtn = document.getElementById('exportSuppliersBtn');
        if (exportSuppliersBtn) {
            exportSuppliersBtn.addEventListener('click', exportSuppliersCsv);
        }

        Promise.all([loadVaultAccounts(), loadSuppliers(), loadSupplierSummary()])
            .catch((error) => {
                console.error('Failed to initialize suppliers page:', error);
                showError(`Failed to initialize suppliers page: ${error.message}`);
            });

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
