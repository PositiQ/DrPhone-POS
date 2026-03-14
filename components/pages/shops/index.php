<?php
$activePage = 'shops';
$basePath = '../';
$pageTitle = 'Shops';
$pageSubtitle = 'Manage shops, track devices, and settlements.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage shops, devices, and settlements">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Shops</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .shop-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .shop-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f3f8;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .shop-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #1a237e 0%, #2196f3 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .shop-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
            border-color: #1a237e;
        }

        .shop-card:hover::before {
            transform: scaleX(1);
        }

        .shop-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .shop-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1a237e 0%, #2196f3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 24px;
        }

        .shop-name {
            flex: 1;
            margin-left: 16px;
        }

        .shop-name h3 {
            color: #1a237e;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .shop-name p {
            color: #6a759d;
            font-size: 13px;
            margin: 0;
        }

        .shop-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
        }

        .shop-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 20px;
        }

        .shop-stat {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 14px;
            text-align: center;
        }

        .shop-stat-label {
            font-size: 12px;
            color: #6a759d;
            font-weight: 500;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .shop-stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a237e;
        }

        .shop-stat-value.outstanding {
            color: #ff9800;
        }

        .shop-stat-value.active {
            color: #4caf50;
        }

        .shop-stat-value.sold {
            color: #2196f3;
        }

        .shop-card-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eef1f6;
            display: flex;
            gap: 8px;
        }

        .shop-action-btn {
            flex: 1;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .shop-action-btn.primary {
            background: linear-gradient(135deg, #1a237e 0%, #2196f3 100%);
            color: #ffffff;
        }

        .shop-action-btn.primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .shop-action-btn.secondary {
            background: #f8f9fc;
            color: #1a237e;
        }

        .shop-action-btn.secondary:hover {
            background: #eef1f6;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: #ffffff;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid #eef1f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            color: #1a237e;
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: #f8f9fc;
            color: #1a237e;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background: #eef1f6;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-section {
            margin-bottom: 24px;
        }

        .modal-section:last-child {
            margin-bottom: 0;
        }

        .modal-section h3 {
            color: #1a237e;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 16px 0;
        }

        .settlement-options {
            display: grid;
            gap: 12px;
        }

        .settlement-option {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 16px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .settlement-option:hover {
            border-color: #1a237e;
            background: #ffffff;
        }

        .settlement-option input[type="radio"] {
            margin-right: 12px;
        }

        .settlement-option label {
            font-weight: 600;
            color: #1a237e;
            cursor: pointer;
        }

        .form-group {
            margin-top: 16px;
        }

        .form-group label {
            display: block;
            color: #1a237e;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #dfe3ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #dfe3ed;
            border-radius: 8px;
            font-size: 14px;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1a237e;
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
        }

        .form-group select:focus {
            outline: none;
            border-color: #1a237e;
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .modal-btn {
            flex: 1;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-btn.primary {
            background: linear-gradient(135deg, #1a237e 0%, #2196f3 100%);
            color: #ffffff;
        }

        .modal-btn.primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .modal-btn.secondary {
            background: #f8f9fc;
            color: #1a237e;
        }

        .modal-btn.secondary:hover {
            background: #eef1f6;
        }

        .details-grid {
            display: grid;
            gap: 16px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9fc;
            border-radius: 8px;
        }

        .detail-label {
            color: #6a759d;
            font-weight: 500;
        }

        .detail-value {
            color: #1a237e;
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #dfe3ed;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #1a237e;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .empty-state p {
            color: #6a759d;
            margin: 0 0 24px 0;
        }
    </style>
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
                        <input type="text" id="searchShops" placeholder="Search by ID, name, location, owner, or contact..." style="min-width: 320px;">
                        <input type="text" id="ownerFilter" placeholder="Filter by Owner Customer ID" style="min-width: 220px;">
                        <select id="statusFilter" aria-label="Status">
                            <option value="all">All Shops</option>
                            <option value="active">Has Active Devices</option>
                            <option value="outstanding">Has Outstanding</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="add-shop.php">
                            <i class="fas fa-plus"></i>
                            Add Shop
                        </a>
                        <button class="button-secondary" type="button" id="exportShopsBtn">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Total Shops</h4>
                        <div class="metric-value" id="metricTotalShops">0</div>
                        <div class="metric-sub">Registered shops</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Outstanding</h4>
                        <div class="metric-value" style="color: #ff9800;" id="metricOutstanding">LKR 0</div>
                        <div class="metric-sub">Pending settlements</div>
                    </div>
                    <div class="metric-card">
                        <h4>Active Devices</h4>
                        <div class="metric-value" style="color: #4caf50;" id="metricActiveDevices">0</div>
                        <div class="metric-sub">Currently in shops</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Sales</h4>
                        <div class="metric-value" style="color: #2196f3;" id="metricTotalSales">0</div>
                        <div class="metric-sub">Recorded entries</div>
                    </div>
                </div>

                <div class="shop-cards-container" id="shopCardsContainer">
                    <div class="empty-state">
                        <i class="fas fa-store-slash"></i>
                        <h3>Loading shops...</h3>
                        <p>Please wait while we fetch data from the API.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Details Modal -->
    <div class="modal-overlay" id="shopDetailsModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="detailsShopName">Shop Details</h2>
                <button class="modal-close" onclick="closeModal('shopDetailsModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-section">
                    <h3>Shop Details</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">Shop ID</span>
                            <span class="detail-value" id="detailsShopId">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location</span>
                            <span class="detail-value" id="detailsLocation">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact</span>
                            <span class="detail-value" id="detailsContact">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Owner</span>
                            <span class="detail-value" id="detailsOwner">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Owner Customer ID</span>
                            <span class="detail-value" id="detailsOwnerCustomerId">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Outstanding Balance</span>
                            <span class="detail-value" style="color: #ff9800;" id="detailsOutstanding">LKR 0</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Active Devices</span>
                            <span class="detail-value" style="color: #4caf50;" id="detailsActiveDevices">0</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Sold Devices</span>
                            <span class="detail-value" style="color: #2196f3;" id="detailsSoldDevices">0</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Devices</span>
                            <span class="detail-value" id="detailsTotalDevices">0</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Sales Entries</span>
                            <span class="detail-value" id="detailsTotalSales">0</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Paid</span>
                            <span class="detail-value" id="detailsTotalPaid">LKR 0</span>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn secondary" id="detailsRefreshSummaryBtn">
                        <i class="fas fa-sync"></i>
                        Refresh Summary
                    </button>
                    <button class="modal-btn secondary" id="detailsPrintInvoiceBtn">
                        <i class="fas fa-print"></i>
                        Print Invoice
                    </button>
                    <button class="modal-btn secondary" id="detailsSettleBtn">
                        <i class="fas fa-money-check-dollar"></i>
                        Settle Payment
                    </button>
                    <button class="modal-btn secondary" id="detailsEditBtn">
                        <i class="fas fa-edit"></i>
                        Edit Shop
                    </button>
                    <button class="modal-btn primary" id="detailsDeleteBtn" style="background: linear-gradient(135deg, #d32f2f 0%, #f57c00 100%);">
                        <i class="fas fa-trash"></i>
                        Delete Shop
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Shop Modal -->
    <div class="modal-overlay" id="editShopModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Edit Shop</h2>
                <button class="modal-close" onclick="closeModal('editShopModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editShopForm">
                    <div class="form-group">
                        <label for="editShopName">Shop Name</label>
                        <input type="text" id="editShopName" required>
                    </div>
                    <div class="form-group">
                        <label for="editLocation">Location</label>
                        <input type="text" id="editLocation" required>
                    </div>
                    <div class="form-group">
                        <label for="editContact">Contact Number</label>
                        <input type="text" id="editContact" required>
                    </div>
                    <div class="form-group">
                        <label for="editOwnerName">Owner Name</label>
                        <input type="text" id="editOwnerName" required>
                    </div>
                    <div class="form-group">
                        <label for="editOwnerCustomerId">Owner Customer ID</label>
                        <input type="text" id="editOwnerCustomerId" required>
                    </div>
                    <div class="modal-actions">
                        <button class="modal-btn secondary" type="button" onclick="closeModal('editShopModal')">Cancel</button>
                        <button class="modal-btn primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Settle Payment Modal -->
    <div class="modal-overlay" id="settlePaymentModal">
        <div class="modal" style="max-width: 520px;">
            <div class="modal-header">
                <h2>Settle Shop Payment</h2>
                <button class="modal-close" onclick="closeModal('settlePaymentModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="details-grid" style="margin-bottom: 16px;">
                    <div class="detail-item">
                        <span class="detail-label">Shop</span>
                        <span class="detail-value" id="settleShopName">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Current Outstanding</span>
                        <span class="detail-value" style="color:#ff9800;" id="settleOutstanding">LKR 0</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Pending Issues</span>
                        <span class="detail-value" id="settlePendingCount">0</span>
                    </div>
                </div>

                <div class="settlement-options">
                    <div class="settlement-option">
                        <label>
                            <input type="radio" name="settlementType" value="full" checked>
                            Full Settlement (clear all pending issued products)
                        </label>
                    </div>
                    <div class="settlement-option">
                        <label>
                            <input type="radio" name="settlementType" value="half">
                            Half Settlement (auto-settle about half of outstanding)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="settlePaymentMethod">Payment Method</label>
                    <select id="settlePaymentMethod" required>
                        <option value="cash" selected>Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="koko">Koko</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="settleAccount">Account</label>
                    <select id="settleAccount" required>
                        <option value="">Select account...</option>
                    </select>
                    <div id="settleAccountHint" style="margin-top: 6px; font-size: 12px; color: #6a759d;">
                        Cash requires a drawer account.
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn secondary" type="button" onclick="closeModal('settlePaymentModal')">Cancel</button>
                    <button class="modal-btn primary" type="button" id="confirmSettleBtn">
                        <i class="fas fa-money-bill-wave"></i>
                        Confirm Settlement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const SHOPS_API_URL = 'http://localhost:3000/api/shops';
        const INVENTORY_API_URL = 'http://localhost:3000/api/inventory';
        const VAULT_ACCOUNTS_API_URL = 'http://localhost:3000/api/vault/accounts';
        let allShops = [];
        let filteredShops = [];
        let selectedShopId = null;
        let selectedShopDetails = null;
        let selectedShopIssues = [];
        let vaultAccounts = [];

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function toNumber(value) {
            const parsed = parseFloat(value || 0);
            return Number.isNaN(parsed) ? 0 : parsed;
        }

        function formatCurrency(value) {
            return 'LKR ' + toNumber(value).toLocaleString(undefined, { maximumFractionDigits: 2 });
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        async function apiRequest(url, options = {}) {
            const response = await fetch(url, options);
            const data = await response.json().catch(() => ({}));

            if (!response.ok || data.success === false) {
                throw new Error(data.message || 'Request failed');
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

        async function showConfirm(message) {
            const result = await Swal.fire({
                icon: 'question',
                title: 'Please Confirm',
                text: message,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1a237e',
                cancelButtonColor: '#9e9e9e',
            });

            return result.isConfirmed;
        }

        function getShopStatusClass(sales) {
            if (toNumber(sales?.total_outstanding) > 0) return 'outstanding';
            if (toNumber(sales?.active_devices) > 0) return 'active';
            return 'sold';
        }

        function getRequiredAccountTypeByPaymentMethod(paymentMethod) {
            const method = String(paymentMethod || '').toLowerCase();
            if (method === 'cash') return 'drawer';
            if (method === 'card' || method === 'bank_transfer' || method === 'koko') return 'bank';
            return null;
        }

        async function loadVaultAccounts() {
            const response = await apiRequest(VAULT_ACCOUNTS_API_URL);
            const accounts = Array.isArray(response.accounts) ? response.accounts : [];

            vaultAccounts = accounts.map(account => ({
                id: account.account_id,
                type: String(account.account_type || '').toLowerCase(),
                displayName: account.display_name || account.account_id,
                balance: toNumber(account.available_balance),
            }));
        }

        function renderSettleAccountOptions() {
            const paymentMethod = document.getElementById('settlePaymentMethod').value;
            const accountSelect = document.getElementById('settleAccount');
            const hint = document.getElementById('settleAccountHint');

            const requiredType = getRequiredAccountTypeByPaymentMethod(paymentMethod);
            const matchingAccounts = vaultAccounts.filter(account => account.type === requiredType);

            accountSelect.innerHTML = `<option value="">Select ${requiredType || ''} account...</option>` + matchingAccounts.map(account =>
                `<option value="${escapeHtml(account.id)}">${escapeHtml(account.displayName)} · ${formatCurrency(account.balance)}</option>`
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

        function renderShops(shops) {
            const container = document.getElementById('shopCardsContainer');
            if (!container) return;

            if (!shops.length) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-store-slash"></i>
                        <h3>No shops found</h3>
                        <p>Try adjusting search or filters, or add a new shop.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = shops.map(shop => {
                const sales = shop.sales || {};
                const statusClass = getShopStatusClass(sales);
                const statusColor = statusClass === 'outstanding' ? '#ff9800' : '#4caf50';
                const created = shop.createdAt ? new Date(shop.createdAt).toISOString().slice(0, 10) : 'N/A';

                return `
                    <div class="shop-card" data-shop-id="${escapeHtml(shop.shop_id)}">
                        <div class="shop-card-header">
                            <div class="shop-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="shop-name">
                                <h3>${escapeHtml(shop.name)}</h3>
                                <p>ID: ${escapeHtml(shop.shop_id)} • Since ${created}</p>
                            </div>
                            <div class="shop-status" style="background: ${statusColor}; box-shadow: 0 0 0 3px ${statusColor}33;"></div>
                        </div>
                        <div class="shop-stats">
                            <div class="shop-stat">
                                <div class="shop-stat-label">Outstanding</div>
                                <div class="shop-stat-value outstanding">${formatCurrency(sales.total_outstanding)}</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Active Devices</div>
                                <div class="shop-stat-value active">${toNumber(sales.active_devices).toLocaleString()}</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Sold Devices</div>
                                <div class="shop-stat-value sold">${toNumber(sales.sold_devices).toLocaleString()}</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Total Devices</div>
                                <div class="shop-stat-value">${toNumber(sales.total_devices).toLocaleString()}</div>
                            </div>
                        </div>
                        <div class="shop-card-footer">
                            <button class="shop-action-btn secondary" type="button" onclick="openShopDetails('${escapeHtml(shop.shop_id)}')">
                                <i class="fas fa-eye"></i>
                                Details
                            </button>
                            <button class="shop-action-btn primary" type="button" onclick="openEditModal('${escapeHtml(shop.shop_id)}')">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function updateMetrics(stats) {
            const computed = stats || filteredShops.reduce((acc, currentShop) => {
                const sales = currentShop.sales || {};
                acc.total_shops += 1;
                acc.total_outstanding += toNumber(sales.total_outstanding);
                acc.total_devices += toNumber(sales.active_devices);
                acc.total_sales += toNumber(sales.total_sales);
                return acc;
            }, {
                total_shops: 0,
                total_outstanding: 0,
                total_devices: 0,
                total_sales: 0,
            });

            document.getElementById('metricTotalShops').textContent = toNumber(computed.total_shops).toLocaleString();
            document.getElementById('metricOutstanding').textContent = formatCurrency(computed.total_outstanding);
            document.getElementById('metricActiveDevices').textContent = toNumber(computed.total_devices).toLocaleString();
            document.getElementById('metricTotalSales').textContent = toNumber(computed.total_sales).toLocaleString();
        }

        function applyLocalFilters() {
            const ownerFilter = document.getElementById('ownerFilter').value.trim().toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            filteredShops = allShops.filter(shop => {
                const sales = shop.sales || {};

                if (ownerFilter && !String(shop.owner_customer_id || '').toLowerCase().includes(ownerFilter)) {
                    return false;
                }

                if (statusFilter === 'active' && toNumber(sales.active_devices) <= 0) {
                    return false;
                }

                if (statusFilter === 'outstanding' && toNumber(sales.total_outstanding) <= 0) {
                    return false;
                }

                return true;
            });

            renderShops(filteredShops);
            updateMetrics(null);
        }

        async function loadShops() {
            try {
                const response = await apiRequest(`${SHOPS_API_URL}?limit=200`);
                allShops = Array.isArray(response.data) ? response.data : [];
                filteredShops = [...allShops];
                renderShops(filteredShops);
                updateMetrics(response.stats || null);
            } catch (error) {
                document.getElementById('shopCardsContainer').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-triangle-exclamation" style="color:#f57c00"></i>
                        <h3>Failed to load shops</h3>
                        <p>${escapeHtml(error.message)}</p>
                    </div>
                `;
            }
        }

        async function searchShops(query) {
            if (!query.trim()) {
                await loadShops();
                return;
            }

            try {
                const response = await apiRequest(`${SHOPS_API_URL}/search?query=${encodeURIComponent(query.trim())}`);
                allShops = Array.isArray(response.data) ? response.data : [];
                applyLocalFilters();
            } catch (error) {
                document.getElementById('shopCardsContainer').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-triangle-exclamation" style="color:#f57c00"></i>
                        <h3>Search failed</h3>
                        <p>${escapeHtml(error.message)}</p>
                    </div>
                `;
            }
        }

        async function openShopDetails(shopId) {
            try {
                selectedShopId = shopId;
                const detailResponse = await apiRequest(`${SHOPS_API_URL}/${encodeURIComponent(shopId)}`);
                const summaryResponse = await apiRequest(`${SHOPS_API_URL}/${encodeURIComponent(shopId)}/sales-summary`);

                const shopData = detailResponse.data || {};
                const sales = summaryResponse.data?.summary?.recorded_sales_row || shopData.sales || {};

                document.getElementById('detailsShopName').textContent = shopData.name || 'Shop Details';
                document.getElementById('detailsShopId').textContent = shopData.shop_id || '-';
                document.getElementById('detailsLocation').textContent = shopData.location || '-';
                document.getElementById('detailsContact').textContent = shopData.contact_number || '-';
                document.getElementById('detailsOwner').textContent = shopData.owner_name || '-';
                document.getElementById('detailsOwnerCustomerId').textContent = shopData.owner_customer_id || '-';
                document.getElementById('detailsOutstanding').textContent = formatCurrency(sales.total_outstanding);
                document.getElementById('detailsActiveDevices').textContent = toNumber(sales.active_devices).toLocaleString();
                document.getElementById('detailsSoldDevices').textContent = toNumber(sales.sold_devices).toLocaleString();
                document.getElementById('detailsTotalDevices').textContent = toNumber(sales.total_devices).toLocaleString();
                document.getElementById('detailsTotalSales').textContent = toNumber(sales.total_sales).toLocaleString();
                document.getElementById('detailsTotalPaid').textContent = formatCurrency(sales.total_paid);

                selectedShopDetails = shopData;

                try {
                    const issuesResponse = await apiRequest(`${INVENTORY_API_URL}/issues/shop/${encodeURIComponent(shopId)}?status=pending_payment`);
                    selectedShopIssues = Array.isArray(issuesResponse.data) ? issuesResponse.data : [];
                } catch (issuesError) {
                    selectedShopIssues = [];
                }

                openModal('shopDetailsModal');
            } catch (error) {
                showError(`Unable to load shop details: ${error.message}`);
            }
        }

        async function printShopInvoice() {
            if (!selectedShopId) {
                showWarning('No shop selected.');
                return;
            }

            try {
                const detailResponse = await apiRequest(`${SHOPS_API_URL}/${encodeURIComponent(selectedShopId)}`);
                const issuesResponse = await apiRequest(`${INVENTORY_API_URL}/issues/shop/${encodeURIComponent(selectedShopId)}?status=pending_payment`);

                const shopData = detailResponse.data || {};
                const issues = Array.isArray(issuesResponse.data) ? issuesResponse.data : [];

                if (!issues.length) {
                    showWarning('No pending issued products found for invoice.');
                    return;
                }

                const now = new Date();
                const invoiceNumber = `${shopData.shop_id || 'SHOP'}-${now.getTime().toString().slice(-6)}`;
                const total = issues.reduce((sum, item) => sum + toNumber(item.issue_amount), 0);

                const invoicePayload = {
                    invoiceNumber,
                    dateTime: now.toLocaleString(),
                    shop: {
                        id: shopData.shop_id || '-',
                        name: shopData.name || '-',
                        ownerName: shopData.owner_name || '-',
                        contact: shopData.contact_number || '-',
                        ownerCustomerId: shopData.owner_customer_id || '-',
                    },
                    items: issues.map(item => ({
                        product_name: item.product_name || 'Product',
                        imei: item.IMEI || '-',
                        color: item.color || '-',
                        capacity: item.capacity || '-',
                        qty: toNumber(item.issued_stock) || 1,
                        unit_price: toNumber(item.selling_price),
                        amount: toNumber(item.issue_amount),
                    })),
                    summary: {
                        itemCount: issues.length,
                        pieceCount: issues.reduce((sum, item) => sum + (toNumber(item.issued_stock) || 1), 0),
                        subtotal: total,
                        discount: 0,
                        netAmount: total,
                        outstanding: total,
                    },
                };

                localStorage.setItem('shopInvoicePayload', JSON.stringify(invoicePayload));

                const printWindow = window.open(`shop-invoice.html?autoprint=1&t=${Date.now()}`, '_blank');
                if (!printWindow) {
                    showWarning('Please allow popups to print invoice.');
                    return;
                }
            } catch (error) {
                showError(`Invoice print failed: ${error.message}`);
            }
        }

        async function openSettlePaymentModal() {
            if (!selectedShopDetails || !selectedShopId) {
                showWarning('Open shop details first.');
                return;
            }

            const currentOutstanding = selectedShopIssues.reduce((sum, item) => sum + toNumber(item.issue_amount), 0);

            if (currentOutstanding <= 0) {
                showWarning('This shop has no pending outstanding balance to settle.');
                return;
            }

            document.getElementById('settleShopName').textContent = selectedShopDetails.name || selectedShopId;
            document.getElementById('settleOutstanding').textContent = formatCurrency(currentOutstanding);
            document.getElementById('settlePendingCount').textContent = selectedShopIssues.length.toLocaleString();
            const selectedTypeElement = document.querySelector('input[name="settlementType"][value="full"]');
            if (selectedTypeElement) selectedTypeElement.checked = true;

            try {
                await loadVaultAccounts();
            } catch (error) {
                showError(`Unable to load vault accounts: ${error.message}`);
                return;
            }

            if (!vaultAccounts.length) {
                showWarning('No vault accounts found. Create at least one vault account first.');
                return;
            }

            document.getElementById('settlePaymentMethod').value = 'cash';
            renderSettleAccountOptions();
            openModal('settlePaymentModal');
        }

        async function confirmSettlement() {
            if (!selectedShopId) {
                showWarning('No shop selected.');
                return;
            }

            const selectedTypeElement = document.querySelector('input[name="settlementType"]:checked');
            const type = selectedTypeElement ? selectedTypeElement.value : 'full';
            const paymentMethod = document.getElementById('settlePaymentMethod').value;
            const accountId = document.getElementById('settleAccount').value;

            if (!paymentMethod) {
                showWarning('Please select payment method.');
                return;
            }

            if (!accountId) {
                showWarning('Please select account.');
                return;
            }

            const confirmed = await showConfirm(`Proceed with ${type} settlement for shop ${selectedShopId}?`);
            if (!confirmed) return;

            const settleBtn = document.getElementById('confirmSettleBtn');
            const previous = settleBtn.innerHTML;
            settleBtn.disabled = true;
            settleBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Settling...';

            try {
                const response = await apiRequest(`${INVENTORY_API_URL}/issues/shop/${encodeURIComponent(selectedShopId)}/settle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        type,
                        payment_method: paymentMethod,
                        account_id: accountId,
                    }),
                });

                const settledAmount = toNumber(response?.data?.amount_settled);
                closeModal('settlePaymentModal');
                await loadShops();
                await openShopDetails(selectedShopId);

                showSuccess(`${type === 'full' ? 'Full' : 'Half'} settlement completed. Amount settled: ${formatCurrency(settledAmount)}`);
            } catch (error) {
                showError(`Settlement failed: ${error.message}`);
            } finally {
                settleBtn.disabled = false;
                settleBtn.innerHTML = previous;
            }
        }

        function openEditModal(shopId) {
            const shopData = allShops.find(item => item.shop_id === shopId);
            if (!shopData) {
                showWarning('Shop not found in the current list. Please refresh.');
                return;
            }

            selectedShopId = shopId;
            document.getElementById('editShopName').value = shopData.name || '';
            document.getElementById('editLocation').value = shopData.location || '';
            document.getElementById('editContact').value = shopData.contact_number || '';
            document.getElementById('editOwnerName').value = shopData.owner_name || '';
            document.getElementById('editOwnerCustomerId').value = shopData.owner_customer_id || '';

            openModal('editShopModal');
        }

        async function deleteSelectedShop() {
            if (!selectedShopId) return;

            const confirmed = await showConfirm(`Delete shop ${selectedShopId}? This cannot be undone.`);
            if (!confirmed) return;

            try {
                await apiRequest(`${SHOPS_API_URL}/${encodeURIComponent(selectedShopId)}`, {
                    method: 'DELETE',
                });

                closeModal('shopDetailsModal');
                await loadShops();
                showSuccess('Shop deleted successfully.');
            } catch (error) {
                showError(`Delete failed: ${error.message}`);
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function exportCurrentShops() {
            if (!filteredShops.length) {
                showWarning('No shop data to export.');
                return;
            }

            const rows = [
                ['shop_id', 'name', 'location', 'contact_number', 'owner_name', 'owner_customer_id', 'total_sales', 'total_paid', 'total_outstanding', 'total_devices', 'active_devices', 'sold_devices'],
                ...filteredShops.map(shop => {
                    const sales = shop.sales || {};
                    return [
                        shop.shop_id || '',
                        shop.name || '',
                        shop.location || '',
                        shop.contact_number || '',
                        shop.owner_name || '',
                        shop.owner_customer_id || '',
                        toNumber(sales.total_sales),
                        toNumber(sales.total_paid),
                        toNumber(sales.total_outstanding),
                        toNumber(sales.total_devices),
                        toNumber(sales.active_devices),
                        toNumber(sales.sold_devices),
                    ];
                }),
            ];

            const csv = rows.map(row => row.map(value => {
                const cell = String(value);
                return /[",\n]/.test(cell) ? `"${cell.replace(/"/g, '""')}"` : cell;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'shops-export.csv';
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        }

        // Keep searches responsive without spamming API calls.
        let searchDebounce;

        document.getElementById('searchShops').addEventListener('input', function(e) {
            clearTimeout(searchDebounce);
            searchDebounce = setTimeout(() => {
                searchShops(e.target.value || '');
            }, 350);
        });

        document.getElementById('ownerFilter').addEventListener('input', applyLocalFilters);
        document.getElementById('statusFilter').addEventListener('change', applyLocalFilters);
        document.getElementById('exportShopsBtn').addEventListener('click', exportCurrentShops);

        document.getElementById('detailsRefreshSummaryBtn').addEventListener('click', function() {
            if (selectedShopId) {
                openShopDetails(selectedShopId);
            }
        });

        document.getElementById('detailsEditBtn').addEventListener('click', function() {
            closeModal('shopDetailsModal');
            if (selectedShopId) {
                openEditModal(selectedShopId);
            }
        });

        document.getElementById('detailsPrintInvoiceBtn').addEventListener('click', printShopInvoice);
        document.getElementById('detailsSettleBtn').addEventListener('click', openSettlePaymentModal);
        document.getElementById('settlePaymentMethod').addEventListener('change', renderSettleAccountOptions);
        document.getElementById('confirmSettleBtn').addEventListener('click', confirmSettlement);

        document.getElementById('detailsDeleteBtn').addEventListener('click', deleteSelectedShop);

        document.getElementById('editShopForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            if (!selectedShopId) {
                showWarning('No shop selected for update.');
                return;
            }

            const payload = {
                name: document.getElementById('editShopName').value.trim(),
                location: document.getElementById('editLocation').value.trim(),
                contact_number: document.getElementById('editContact').value.trim(),
                owner_name: document.getElementById('editOwnerName').value.trim(),
                owner_customer_id: document.getElementById('editOwnerCustomerId').value.trim(),
            };

            try {
                await apiRequest(`${SHOPS_API_URL}/${encodeURIComponent(selectedShopId)}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                closeModal('editShopModal');
                await loadShops();
                showSuccess('Shop updated successfully.');
            } catch (error) {
                showError(`Update failed: ${error.message}`);
            }
        });

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        loadShops();
    </script>
</body>
</html>
