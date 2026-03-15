<?php
$activePage = 'inventory';
$basePath = '../';
$pageTitle = 'Inventory';
$pageSubtitle = 'Manage stocks, show low stocks and out of stocks.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- PWA Client Library -->
    <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <input type="text" id="searchProducts" placeholder="Search by product, IMEI, location..." style="min-width: 300px;">
                        <select id="locationFilter" aria-label="Location">
                            <option value="all">All Locations</option>
                        </select>
                        <select id="statusFilter" aria-label="Status">
                            <option value="all">All Status</option>
                            <option value="in_stock">In Stock</option>
                            <option value="pending_payment">Pending Payment</option>
                            <option value="sold">Sold</option>
                        </select>
                        <select id="categoryFilter" aria-label="Category">
                            <option value="all">All Categories</option>
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
                        <button class="button-secondary" type="button" id="exportInventoryBtn">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Main Shop Stock</h4>
                        <div class="metric-value" id="metricMainShopStock">0</div>
                        <div class="metric-sub">Items in main location</div>
                    </div>
                    <div class="metric-card">
                        <h4>Issued to Shops</h4>
                        <div class="metric-value" style="color: #2196f3;" id="metricIssuedToBranches">0</div>
                        <div class="metric-sub">Items at other locations</div>
                    </div>
                    <div class="metric-card">
                        <h4>Pending Sale</h4>
                        <div class="metric-value" style="color: #ff9800;" id="metricPendingSale">0</div>
                        <div class="metric-sub">Awaiting completion</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Inventory</h4>
                        <div class="metric-value" id="metricTotalInventory">0</div>
                        <div class="metric-sub">All tracked items</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Stock Tracking</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-location="all">All Locations</button>
                            <button class="pill" type="button" data-location="main">Main Shop</button>
                            <button class="pill" type="button" data-location="branches">Shops</button>
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
                            <tr>
                                <td colspan="7" style="text-align:center; padding: 28px; color: #7a86ad;">Loading inventory...</td>
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
                <form id="transferForm">
                    <!-- Transfer Location -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-map-marker-alt" style="margin-right: 6px; color: #7a86ad;"></i>
                            Transfer Location
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="transferLocationSearch" placeholder="Type shop name or shop ID..." autocomplete="off" style="width: 100%; padding: 12px 40px 12px 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'; showShopDropdown()" oninput="filterShops()">
                            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #7a86ad; pointer-events: none;"></i>
                            <input type="hidden" id="selectedShopId" required>
                        </div>
                        <div id="shopDropdown" style="display: none; position: absolute; z-index: 1000; background: white; border: 2px solid #e0e7ff; border-radius: 8px; margin-top: 4px; max-height: 250px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: calc(100% - 48px);">
                            <!-- Shop options will be populated here -->
                        </div>
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

                    <!-- Transfer Item Price -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-money-bill" style="margin-right: 6px; color: #7a86ad;"></i>
                            Price
                        </label>
                        <div style="position: relative;">
                            <input type="text" id="productPrice" placeholder="Item Price" style="width: 100%; padding: 12px 40px 12px 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e';">
                            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #7a86ad; pointer-events: none;"></i>
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


                    <!-- Payment Status -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">
                            <i class="fas fa-money-check-dollar" style="margin-right: 6px; color: #7a86ad;"></i>
                            Payment Status
                        </label>
                        <select id="paymentStatus" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="">Select payment status...</option>
                            <option value="sold">Sold / Completed</option>
                            <option value="pending_payment">Pending Payment</option>
                        </select>
                    </div>

                    <!-- Sold Payment Details -->
                    <div id="soldPaymentFields" style="display: none; margin-bottom: 20px; padding: 12px; background: #f4f7fc; border-radius: 8px; border-left: 4px solid #1a237e;">
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">Payment Method</label>
                            <select id="soldPaymentMethod" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                                <option value="cash" selected>Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="koko">Koko</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">Account</label>
                            <select id="soldPaymentAccount" style="width: 100%; padding: 10px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                                <option value="">Select account...</option>
                            </select>
                            <div id="soldPaymentAccountHint" style="margin-top: 6px; font-size: 12px; color: #7a86ad;">Cash requires a drawer account.</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closeTransferDialog()" style="padding: 12px 24px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                            Cancel
                        </button>
                        <button type="submit" id="transferSubmitBtn" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
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

    <!-- Complete Sale Dialog -->
    <div class="search-overlay" id="completeSaleDialog" role="dialog" aria-modal="true" aria-label="Complete Sale">
        <div class="search-dialog" role="document" style="max-width: 520px; padding: 0;">
            <div class="search-dialog-header" style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Complete Sale</h3>
                </div>
                <button class="search-close" type="button" onclick="closeCompleteSaleDialog()" aria-label="Close dialog" style="color: white;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div style="padding: 24px;">
                <form id="completeSaleForm">
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">Payment Method</label>
                        <select id="completeSalePaymentMethod" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="cash" selected>Cash</option>
                            <option value="card">Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="koko">Koko</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a237e; font-size: 14px;">Account</label>
                        <select id="completeSaleAccount" required style="width: 100%; padding: 12px; border: 2px solid #e0e7ff; border-radius: 8px; font-size: 14px; color: #1a237e; background: white; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#1a237e'" onblur="this.style.borderColor='#e0e7ff'">
                            <option value="">Select account...</option>
                        </select>
                        <div id="completeSaleAccountHint" style="margin-top: 6px; font-size: 12px; color: #7a86ad;">Cash requires a drawer account.</div>
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closeCompleteSaleDialog()" style="padding: 12px 24px; border: 2px solid #e0e7ff; background: white; color: #1a237e; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">Cancel</button>
                        <button type="submit" id="completeSaleSubmitBtn" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <i class="fas fa-check" style="margin-right: 6px;"></i>Complete Sale
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = 'http://localhost:3000/api';
        const PRODUCTS_API = `${API_BASE}/products`;
        const SHOPS_API = `${API_BASE}/shops`;
        const INVENTORY_API = `${API_BASE}/inventory`;
        const VAULT_ACCOUNTS_API = `${API_BASE}/vault/accounts`;

        let allProducts = [];
        let allShops = [];
        let allIssues = [];
        let combinedRows = [];
        let filteredRows = [];
        let transferProducts = [];
        let transferShops = [];
        let vaultAccounts = [];
        let pendingCompleteIssueId = null;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function toNumber(value) {
            const cleaned = String(value ?? 0).replace(/,/g, '');
            const parsed = parseFloat(cleaned);
            return Number.isNaN(parsed) ? 0 : parsed;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatCurrency(value) {
            return `LKR ${toNumber(value).toLocaleString(undefined, { maximumFractionDigits: 2 })}`;
        }

        async function requestJson(url, options = {}) {
            const response = await fetch(url, options);
            const data = await response.json().catch(() => ({}));

            if (!response.ok || data.success === false) {
                const errorMessage = [data.message, data.error].filter(Boolean).join(': ');
                throw new Error(errorMessage || 'Request failed');
            }

            return data;
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

        function showWarning(message) {
            return Swal.fire({
                icon: 'warning',
                title: 'Notice',
                text: message,
                confirmButtonColor: '#1a237e',
            });
        }

        function getProductCategory(productName) {
            const text = String(productName || '').toLowerCase();
            if (text.includes('iphone') || text.includes('samsung') || text.includes('pixel') || text.includes('vivo') || text.includes('xiaomi') || text.includes('oneplus')) return 'smartphones';
            if (text.includes('ipad') || text.includes('tablet')) return 'tablets';
            if (text.includes('case') || text.includes('charger') || text.includes('airpods') || text.includes('accessor')) return 'accessories';
            return 'smartphones';
        }

        function rebuildCombinedRows() {
            const inStockRows = allProducts
                .filter(product => toNumber(product?.Product_Stock?.quantity_in_stock) > 0)
                .map(product => {
                    const stock = product.Product_Stock || {};
                    return {
                        type: 'stock',
                        productId: product.id,
                        productName: product.productName || 'Unknown Product',
                        productDetails: [product.capacity, product.color].filter(Boolean).join(' · '),
                        imei: product.IMEI || '-',
                        // Quantity in Product_Stock is the remaining balance at main shop.
                        location: 'Main Shop',
                        issuedTo: '-',
                        issuedDate: '-',
                        status: 'in_stock',
                        category: getProductCategory(product.productName),
                    };
                });

            const issueRows = allIssues.flatMap(issue => {
                const issuedUnits = Math.max(1, Math.floor(toNumber(issue.issued_stock)));
                const details = [issue.capacity, issue.color].filter(Boolean).join(' · ');

                return Array.from({ length: issuedUnits }, (_, index) => ({
                    type: 'issue',
                    issueId: issue.id,
                    issueUnitIndex: index + 1,
                    issueUnitTotal: issuedUnits,
                    isIssuePrimary: index === 0,
                    productId: null,
                    productName: issue.product_name || 'Unknown Product',
                    productDetails: issuedUnits > 1
                        ? [details, `Unit ${index + 1}/${issuedUnits}`].filter(Boolean).join(' · ')
                        : details,
                    imei: issue.IMEI || '-',
                    location: issue.issued_to || issue.storage_location || '-',
                    issuedTo: issue.issued_to || '-',
                    issuedDate: issue.issued_date ? new Date(issue.issued_date).toISOString().slice(0, 10) : '-',
                    status: issue.issue_status || 'pending_payment',
                    category: getProductCategory(issue.product_name),
                }));
            });

            combinedRows = [...issueRows, ...inStockRows];
            filteredRows = [...combinedRows];
        }

        function updateMetrics() {
            // Product_Stock.quantity_in_stock represents current main-shop balance.
            const mainShopStock = allProducts.reduce((sum, product) => {
                const stock = product.Product_Stock || {};
                return sum + toNumber(stock.quantity_in_stock);
            }, 0);

            const issuedToBranches = allIssues.reduce(
                (sum, issue) => sum + Math.max(1, Math.floor(toNumber(issue.issued_stock))),
                0
            );
            const pendingSale = allIssues.reduce((sum, issue) => {
                if (String(issue.issue_status || '').toLowerCase() === 'pending_payment') {
                    return sum + Math.max(1, Math.floor(toNumber(issue.issued_stock)));
                }
                return sum;
            }, 0);
            const totalInventory = allProducts.reduce((sum, product) => sum + toNumber(product?.Product_Stock?.quantity_in_stock), 0);

            document.getElementById('metricMainShopStock').textContent = mainShopStock.toLocaleString();
            document.getElementById('metricIssuedToBranches').textContent = issuedToBranches.toLocaleString();
            document.getElementById('metricPendingSale').textContent = pendingSale.toLocaleString();
            document.getElementById('metricTotalInventory').textContent = totalInventory.toLocaleString();
        }

        function getStatusBadge(status) {
            const normalized = String(status || '').toLowerCase();
            if (normalized === 'in_stock') {
                return '<span class="status-badge" style="background: #e1f7e3; color: #0d6832;">In Stock</span>';
            }
            if (normalized === 'pending_payment') {
                return '<span class="status-badge" style="background: #fff8e1; color: #c77700;">Pending Payment</span>';
            }
            if (normalized === 'sold') {
                return '<span class="status-badge" style="background: #e3f2fd; color: #0d47a1;">Sold</span>';
            }
            return '<span class="status-badge" style="background: #f4f7fc; color: #6a759d;">Unknown</span>';
        }

        function renderInventoryTable(rows) {
            const inventoryTable = document.getElementById('inventoryTable');

            if (!rows.length) {
                inventoryTable.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 28px; color: #7a86ad;">No inventory records found</td></tr>';
                return;
            }

            inventoryTable.innerHTML = rows.map(row => `
                <tr data-location="${escapeHtml(String(row.location || '').toLowerCase())}" data-status="${escapeHtml(row.status)}" data-category="${escapeHtml(row.category)}">
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div>
                                <strong style="display: block; color: #1a237e;">${escapeHtml(row.productName)}</strong>
                                <span style="font-size: 12px; color: #7a86ad;">${escapeHtml(row.productDetails || '')}</span>
                            </div>
                        </div>
                    </td>
                    <td><code style="font-size: 11px; background: #f4f7fc; padding: 4px 8px; border-radius: 4px; font-weight: 600;">${escapeHtml(row.imei)}</code></td>
                    <td><strong style="color: #1a237e;">${escapeHtml(row.location || '-')}</strong></td>
                    <td><strong style="color: #2196f3;">${escapeHtml(row.issuedTo || '-')}</strong></td>
                    <td><span style="font-size: 12px; color: #7a86ad;">${escapeHtml(row.issuedDate || '-')}</span></td>
                    <td>${getStatusBadge(row.status)}</td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            ${row.type === 'stock' ? `<button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Transfer Stock" onclick="openTransferDialogByProduct('${escapeHtml(row.productId)}')"><i class="fas fa-exchange-alt"></i></button>` : ''}
                            ${row.type === 'issue' && row.status === 'pending_payment' && row.isIssuePrimary ? `<button class="button-secondary" style="padding: 6px 10px; font-size: 12px; background: #e8f5e9; color: #1b5e20;" title="Complete Sale" onclick="completeIssueSale(${Number(row.issueId)})"><i class="fas fa-check-circle"></i></button>` : ''}
                            <button class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Product" onclick="window.location.href='../products/index.php'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function updateLocationOptions() {
            const locationFilter = document.getElementById('locationFilter');
            const locations = new Set(['all', 'Main Shop']);

            allShops.forEach(shop => {
                if (shop.name) locations.add(shop.name);
            });

            combinedRows.forEach(row => {
                if (row.location && row.location !== '-') locations.add(row.location);
            });

            locationFilter.innerHTML = '';
            Array.from(locations).forEach(location => {
                const option = document.createElement('option');
                option.value = location === 'all' ? 'all' : String(location).toLowerCase();
                option.textContent = location === 'all' ? 'All Locations' : location;
                locationFilter.appendChild(option);
            });
        }

        function applyFilters() {
            const searchQuery = (document.getElementById('searchProducts').value || '').toLowerCase();
            const locationValue = document.getElementById('locationFilter').value;
            const statusValue = document.getElementById('statusFilter').value;
            const categoryValue = (document.getElementById('categoryFilter').value || 'all').toLowerCase();
            const activePill = document.querySelector('.pill.active')?.dataset.location || 'all';

            filteredRows = combinedRows.filter(row => {
                const searchable = [row.productName, row.productDetails, row.imei, row.location, row.issuedTo].join(' ').toLowerCase();
                if (searchQuery && !searchable.includes(searchQuery)) return false;

                if (locationValue !== 'all' && String(row.location || '').toLowerCase() !== locationValue) return false;
                if (statusValue !== 'all' && String(row.status || '').toLowerCase() !== statusValue) return false;
                if (categoryValue !== 'all' && String(row.category || '').toLowerCase() !== categoryValue) return false;

                if (activePill === 'main' && !String(row.location || '').toLowerCase().includes('main')) return false;
                if (activePill === 'branches' && String(row.location || '').toLowerCase().includes('main')) return false;
                if (activePill === 'pending' && String(row.status || '').toLowerCase() !== 'pending_payment') return false;

                return true;
            });

            renderInventoryTable(filteredRows);
        }

        async function loadInitialData() {
            const [productsResult, shopsResult, issuesResult, accountsResult] = await Promise.allSettled([
                requestJson(`${PRODUCTS_API}?limit=500`),
                requestJson(`${SHOPS_API}?limit=500`),
                requestJson(`${INVENTORY_API}/issues?page=1`),
                requestJson(VAULT_ACCOUNTS_API),
            ]);

            allProducts = productsResult.status === 'fulfilled' && Array.isArray(productsResult.value.data)
                ? productsResult.value.data
                : [];

            allShops = shopsResult.status === 'fulfilled' && Array.isArray(shopsResult.value.data)
                ? shopsResult.value.data
                : [];

            allIssues = issuesResult.status === 'fulfilled' && Array.isArray(issuesResult.value.data)
                ? issuesResult.value.data
                : [];

            vaultAccounts = accountsResult.status === 'fulfilled' && Array.isArray(accountsResult.value.accounts)
                ? accountsResult.value.accounts.map(account => ({
                    id: account.account_id,
                    type: String(account.account_type || '').toLowerCase(),
                    displayName: account.display_name || account.account_id,
                    balance: toNumber(account.available_balance),
                }))
                : [];

            // Keep transfer product suggestions available even when quantity is missing/null.
            transferProducts = allProducts
                .filter(product => product && product.id)
                .map(product => ({
                    id: product.id,
                    name: product.productName || 'Unknown Product',
                    variant: [product.capacity, product.color].filter(Boolean).join(' · '),
                    imei: product.IMEI || '',
                    stock: toNumber(product?.Product_Stock?.quantity_in_stock),
                    price: toNumber(product?.Product_Stock?.wholesale_price || product?.Product_Stock?.selling_price || product.price),
                }));

            transferShops = allShops
                .filter(shop => shop && shop.shop_id)
                .map(shop => ({
                    id: shop.shop_id,
                    name: shop.name || 'Unnamed Shop',
                    location: shop.location || '',
                }));

            rebuildCombinedRows();
            updateLocationOptions();
            updateMetrics();
            renderInventoryTable(combinedRows);
            populateShopDropdown(transferShops);
            populateProductDropdown(transferProducts);

            if (productsResult.status === 'rejected' || shopsResult.status === 'rejected') {
                const failedParts = [
                    productsResult.status === 'rejected' ? 'products' : null,
                    shopsResult.status === 'rejected' ? 'shops' : null,
                    accountsResult.status === 'rejected' ? 'vault accounts' : null,
                ].filter(Boolean).join(', ');

                document.getElementById('inventoryTable').insertAdjacentHTML('afterbegin', `
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 10px; color: #c77700; background:#fff8e1;">
                            Partial load warning: unable to fetch ${escapeHtml(failedParts)} API data.
                        </td>
                    </tr>
                `);
            }
        }

        function showShopDropdown() {
            document.getElementById('shopDropdown').style.display = 'block';
            filterShops();
        }

        function filterShops() {
            const searchTerm = document.getElementById('transferLocationSearch').value.toLowerCase().trim();
            document.getElementById('selectedShopId').value = '';

            const filtered = transferShops.filter(shop => {
                const text = `${shop.name} ${shop.id} ${shop.location}`.toLowerCase();
                return text.includes(searchTerm);
            });

            populateShopDropdown(filtered);
        }

        function populateShopDropdown(shops) {
            const dropdown = document.getElementById('shopDropdown');

            if (!shops.length) {
                dropdown.innerHTML = '<div style="padding: 16px; text-align: center; color: #7a86ad; font-size: 14px;"><i class="fas fa-store-slash" style="margin-right: 8px;"></i>No shops found</div>';
                return;
            }

            dropdown.innerHTML = shops.map(shop => `
                <div class="shop-option" onclick="selectShop('${escapeHtml(shop.id)}')" style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #f4f7fc; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                    <div style="font-weight: 600; color: #1a237e; margin-bottom: 4px;">${escapeHtml(shop.name)}</div>
                    <div style="font-size: 12px; color: #7a86ad;">${escapeHtml(shop.id)}${shop.location ? ` • ${escapeHtml(shop.location)}` : ''}</div>
                </div>
            `).join('');
        }

        function selectShop(shopId) {
            const shop = transferShops.find(item => item.id === shopId);
            if (!shop) return;

            document.getElementById('transferLocationSearch').value = `${shop.name} (${shop.id})`;
            document.getElementById('selectedShopId').value = shop.id;
            document.getElementById('shopDropdown').style.display = 'none';
        }

        function openTransferDialogByProduct(productId) {
            openTransferDialog();
            const product = transferProducts.find(p => p.id === productId);
            if (product) {
                selectProduct(product.id);
            }
        }

        function openTransferDialog() {
            document.getElementById('transferDialog').classList.add('active');
            document.getElementById('transferLocationSearch').focus();
        }

        function closeTransferDialog() {
            document.getElementById('transferDialog').classList.remove('active');
            document.getElementById('transferForm').reset();
            document.getElementById('selectedShopId').value = '';
            document.getElementById('selectedProductId').value = '';
            document.getElementById('stockInfo').style.display = 'none';
            document.getElementById('shopDropdown').style.display = 'none';
            document.getElementById('productDropdown').style.display = 'none';
            document.getElementById('soldPaymentFields').style.display = 'none';
        }

        function showProductDropdown() {
            document.getElementById('productDropdown').style.display = 'block';
            filterProducts();
        }

        function filterProducts() {
            const searchTerm = document.getElementById('productSearch').value.toLowerCase();
            const filtered = transferProducts.filter(product => {
                const last4Digits = String(product.imei || '').slice(-4);
                return product.name.toLowerCase().includes(searchTerm)
                    || product.variant.toLowerCase().includes(searchTerm)
                    || String(product.imei).toLowerCase().includes(searchTerm)
                    || last4Digits.includes(searchTerm);
            });
            populateProductDropdown(filtered);
        }

        function populateProductDropdown(products) {
            const dropdown = document.getElementById('productDropdown');

            if (!products.length) {
                dropdown.innerHTML = '<div style="padding: 16px; text-align: center; color: #7a86ad; font-size: 14px;"><i class="fas fa-inbox" style="margin-right: 8px;"></i>No products found</div>';
                return;
            }

            dropdown.innerHTML = products.map(product => `
                <div class="product-option" onclick="selectProduct('${escapeHtml(product.id)}')" style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #f4f7fc; transition: all 0.2s;" onmouseover="this.style.background='#f4f7fc'" onmouseout="this.style.background='white'">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-weight: 600; color: #1a237e; margin-bottom: 4px;">${escapeHtml(product.name)}</div>
                            <div style="font-size: 12px; color: #7a86ad; margin-bottom: 4px;">${escapeHtml(product.variant || '-')}</div>
                            <div style="font-size: 11px; color: #7a86ad;">IMEI: <code style="background: #f4f7fc; padding: 2px 6px; border-radius: 4px; font-weight: 600;">${escapeHtml(product.imei || '-')}</code></div>
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
            const product = transferProducts.find(p => p.id === productId);
            if (!product) return;

            document.getElementById('productSearch').value = `${product.name} - ${product.variant} (IMEI: ${product.imei})`;
            document.getElementById('selectedProductId').value = product.id;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productDropdown').style.display = 'none';

            updateStockInfo(product);

            const transferQuantity = document.getElementById('transferQuantity');
            transferQuantity.value = 1;
            transferQuantity.max = product.stock;
        }

        function updateStockInfo(product) {
            document.getElementById('currentStock').textContent = product.stock;
            document.getElementById('stockInfo').style.display = 'block';
        }

        async function handleTransferSubmit(event) {
            event.preventDefault();

            const issuedShopId = document.getElementById('selectedShopId').value;
            const productId = document.getElementById('selectedProductId').value;
            const issuedStock = parseInt(document.getElementById('transferQuantity').value, 10);
            const sellingPrice = toNumber(document.getElementById('productPrice').value);
            const paymentStatus = document.getElementById('paymentStatus').value;
            const soldPaymentMethod = document.getElementById('soldPaymentMethod').value;
            const soldPaymentAccount = document.getElementById('soldPaymentAccount').value;

            const product = transferProducts.find(p => p.id === productId);

            if (!transferShops.length) {
                showWarning('No shops are available yet. Create a shop first, then try transfer.');
                return;
            }

            if (!transferProducts.length) {
                showWarning('No products are available for transfer yet. Add products first.');
                return;
            }

            if (!product) {
                showWarning('Please select a valid product.');
                return;
            }

            if (!issuedShopId) {
                showWarning('Please select destination shop.');
                return;
            }

            if (!issuedStock || issuedStock < 1) {
                showWarning('Please enter a valid quantity.');
                return;
            }

            if (product.stock <= 0) {
                showWarning('Selected product has no available stock quantity.');
                return;
            }

            if (issuedStock > product.stock) {
                showWarning('Transfer quantity cannot exceed available stock.');
                return;
            }

            if (!sellingPrice || sellingPrice <= 0) {
                showWarning('Please enter a valid selling price.');
                return;
            }

            if (paymentStatus === 'sold') {
                if (!soldPaymentMethod) {
                    showWarning('Please select payment method for sold/completed transfer.');
                    return;
                }
                if (!soldPaymentAccount) {
                    showWarning('Please select account for sold/completed transfer.');
                    return;
                }
            }

            const transferSubmitBtn = document.getElementById('transferSubmitBtn');
            transferSubmitBtn.disabled = true;
            transferSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i> Processing...';

            try {
                await requestJson(`${INVENTORY_API}/issue`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        issued_shop_id: issuedShopId,
                        issued_stock: issuedStock,
                        selling_price: sellingPrice,
                        payment_status: paymentStatus,
                        payment_method: paymentStatus === 'sold' ? soldPaymentMethod : undefined,
                        account_id: paymentStatus === 'sold' ? soldPaymentAccount : undefined,
                    }),
                });

                showSuccess('Stock issued successfully.');
                closeTransferDialog();
                await loadInitialData();
            } catch (error) {
                showError(`Unable to issue stock: ${error.message}`);
            } finally {
                transferSubmitBtn.disabled = false;
                transferSubmitBtn.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i> Transfer Stock';
            }
        }

        async function completeIssueSale(issueId) {
            if (!issueId) {
                showWarning('Invalid issue selected.');
                return;
            }

            pendingCompleteIssueId = issueId;
            if (!vaultAccounts.length) {
                showWarning('No vault accounts found. Create at least one vault account first.');
                return;
            }

            const paymentMethodSelect = document.getElementById('completeSalePaymentMethod');
            paymentMethodSelect.value = 'cash';
            renderCompleteSaleAccountOptions();
            document.getElementById('completeSaleDialog').classList.add('active');
        }

        function getRequiredAccountTypeByPaymentMethod(paymentMethod) {
            const method = String(paymentMethod || '').toLowerCase();
            if (method === 'cash') return 'drawer';
            if (method === 'card' || method === 'bank_transfer' || method === 'koko') return 'bank';
            return null;
        }

        function renderSoldPaymentAccountOptions() {
            const paymentMethod = document.getElementById('soldPaymentMethod').value;
            const accountSelect = document.getElementById('soldPaymentAccount');
            const hint = document.getElementById('soldPaymentAccountHint');
            const requiredType = getRequiredAccountTypeByPaymentMethod(paymentMethod);

            const matchingAccounts = vaultAccounts.filter(account => account.type === requiredType);

            accountSelect.innerHTML = `<option value="">Select ${requiredType || ''} account...</option>` + matchingAccounts.map(account =>
                `<option value="${escapeHtml(account.id)}">${escapeHtml(account.displayName)} · LKR ${toNumber(account.balance).toLocaleString()}</option>`
            ).join('');

            if (requiredType === 'drawer') {
                hint.textContent = 'Cash requires a drawer account.';
            } else {
                hint.textContent = 'Card, Bank Transfer, and Koko require a bank account.';
            }

            if (!matchingAccounts.length) {
                hint.textContent += ` No ${requiredType} accounts available.`;
            }
        }

        function toggleTransferSoldPaymentFields() {
            const status = document.getElementById('paymentStatus').value;
            const container = document.getElementById('soldPaymentFields');
            if (status === 'sold') {
                container.style.display = 'block';
                renderSoldPaymentAccountOptions();
            } else {
                container.style.display = 'none';
            }
        }

        function renderCompleteSaleAccountOptions() {
            const paymentMethod = document.getElementById('completeSalePaymentMethod').value;
            const accountSelect = document.getElementById('completeSaleAccount');
            const hint = document.getElementById('completeSaleAccountHint');
            const requiredType = getRequiredAccountTypeByPaymentMethod(paymentMethod);

            const matchingAccounts = vaultAccounts.filter(account => account.type === requiredType);

            accountSelect.innerHTML = `<option value="">Select ${requiredType || ''} account...</option>` + matchingAccounts.map(account =>
                `<option value="${escapeHtml(account.id)}">${escapeHtml(account.displayName)} · LKR ${toNumber(account.balance).toLocaleString()}</option>`
            ).join('');

            if (requiredType === 'drawer') {
                hint.textContent = 'Cash requires a drawer account.';
            } else {
                hint.textContent = 'Card, Bank Transfer, and Koko require a bank account.';
            }

            if (!matchingAccounts.length) {
                hint.textContent += ` No ${requiredType} accounts available.`;
            }
        }

        function closeCompleteSaleDialog() {
            document.getElementById('completeSaleDialog').classList.remove('active');
            document.getElementById('completeSaleForm').reset();
            pendingCompleteIssueId = null;
        }

        async function handleCompleteSaleSubmit(event) {
            event.preventDefault();

            if (!pendingCompleteIssueId) {
                showWarning('No issue selected.');
                return;
            }

            const paymentMethod = document.getElementById('completeSalePaymentMethod').value;
            const accountId = document.getElementById('completeSaleAccount').value;

            if (!accountId) {
                showWarning('Please select an account.');
                return;
            }

            const submitBtn = document.getElementById('completeSaleSubmitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i> Processing...';

            try {
                await requestJson(`${INVENTORY_API}/issues/${pendingCompleteIssueId}/complete`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        account_id: accountId,
                        payment_method: paymentMethod,
                    }),
                });

                showSuccess('Sale completed successfully.');
                closeCompleteSaleDialog();
                await loadInitialData();
            } catch (error) {
                showError(`Unable to complete sale: ${error.message}`);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i>Complete Sale';
            }
        }

        function exportRowsToCsv() {
            if (!filteredRows.length) {
                showWarning('No rows to export.');
                return;
            }

            const csvRows = [
                ['product_name', 'product_details', 'imei', 'location', 'issued_to', 'issued_date', 'status'],
                ...filteredRows.map(row => [
                    row.productName,
                    row.productDetails,
                    row.imei,
                    row.location,
                    row.issuedTo,
                    row.issuedDate,
                    row.status,
                ]),
            ];

            const csvText = csvRows.map(row => row.map(value => {
                const cell = String(value || '');
                return /[",\n]/.test(cell) ? `"${cell.replace(/"/g, '""')}"` : cell;
            }).join(',')).join('\n');

            const blob = new Blob([csvText], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'inventory-stock-issues.csv';
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        }

        const searchOverlay = document.getElementById('searchOverlay');
        const searchModalInput = document.getElementById('globalSearchModal');
        const searchTrigger = document.getElementById('searchTrigger');
        const searchClose = document.getElementById('searchClose');

        function openSearchModal() {
            if (!searchOverlay || !searchModalInput) return;
            searchOverlay.classList.add('active');
            searchModalInput.focus();
            searchModalInput.select();
        }

        function closeSearchModal() {
            if (!searchOverlay) return;
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

        document.getElementById('searchProducts').addEventListener('input', applyFilters);
        document.getElementById('locationFilter').addEventListener('change', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);
        document.getElementById('transferForm').addEventListener('submit', handleTransferSubmit);
        document.getElementById('paymentStatus').addEventListener('change', toggleTransferSoldPaymentFields);
        document.getElementById('soldPaymentMethod').addEventListener('change', renderSoldPaymentAccountOptions);
        document.getElementById('completeSaleForm').addEventListener('submit', handleCompleteSaleSubmit);
        document.getElementById('completeSalePaymentMethod').addEventListener('change', renderCompleteSaleAccountOptions);
        document.getElementById('exportInventoryBtn').addEventListener('click', exportRowsToCsv);

        document.querySelectorAll('.pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.pill').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        document.addEventListener('click', function(event) {
            const transferLocationSearch = document.getElementById('transferLocationSearch');
            const shopDropdown = document.getElementById('shopDropdown');
            const productSearch = document.getElementById('productSearch');
            const productDropdown = document.getElementById('productDropdown');
            const transferDialog = document.getElementById('transferDialog');

            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const menuToggle = document.getElementById('menuToggle');
                if (sidebar && menuToggle && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }

            if (transferDialog && transferDialog.classList.contains('active')) {
                if (!transferLocationSearch.contains(event.target) && !shopDropdown.contains(event.target)) {
                    shopDropdown.style.display = 'none';
                }
                if (!productSearch.contains(event.target) && !productDropdown.contains(event.target)) {
                    productDropdown.style.display = 'none';
                }
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const transferDialog = document.getElementById('transferDialog');
                if (transferDialog && transferDialog.classList.contains('active')) {
                    closeTransferDialog();
                }
            }
        });

        loadInitialData();
    </script>
</body>

</html>