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
    <title>PositiQ POS System · Shops</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
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

        .form-group input:focus {
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
                        <input type="text" id="searchShops" placeholder="Search shops..." style="min-width: 300px;">
                        <select id="statusFilter" aria-label="Status">
                            <option>All Shops</option>
                            <option>Active</option>
                            <option>Has Outstanding</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="add-shop.php">
                            <i class="fas fa-plus"></i>
                            Add Shop
                        </a>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Total Shops</h4>
                        <div class="metric-value">24</div>
                        <div class="metric-sub">Registered shops</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Outstanding</h4>
                        <div class="metric-value" style="color: #ff9800;">LKR 1.2M</div>
                        <div class="metric-sub">Pending settlements</div>
                    </div>
                    <div class="metric-card">
                        <h4>Active Devices</h4>
                        <div class="metric-value" style="color: #4caf50;">186</div>
                        <div class="metric-sub">Currently in shops</div>
                    </div>
                    <div class="metric-card">
                        <h4>Sold This Month</h4>
                        <div class="metric-value" style="color: #2196f3;">42</div>
                        <div class="metric-sub">Devices sold</div>
                    </div>
                </div>

                <div class="shop-cards-container" id="shopCardsContainer">
                    <!-- Sample Shop Cards -->
                    <div class="shop-card" onclick="openShopDetails(1)">
                        <div class="shop-card-header">
                            <div class="shop-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="shop-name">
                                <h3>Tech Haven - Colombo</h3>
                                <p>ID: SH-001 • Since Jan 2025</p>
                            </div>
                            <div class="shop-status"></div>
                        </div>
                        <div class="shop-stats">
                            <div class="shop-stat">
                                <div class="shop-stat-label">Outstanding</div>
                                <div class="shop-stat-value outstanding">LKR 125K</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Active Devices</div>
                                <div class="shop-stat-value active">18</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Sold Devices</div>
                                <div class="shop-stat-value sold">42</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Total Devices</div>
                                <div class="shop-stat-value">60</div>
                            </div>
                        </div>
                    </div>

                    <div class="shop-card" onclick="openShopDetails(2)">
                        <div class="shop-card-header">
                            <div class="shop-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="shop-name">
                                <h3>Mobile World - Kandy</h3>
                                <p>ID: SH-002 • Since Feb 2025</p>
                            </div>
                            <div class="shop-status"></div>
                        </div>
                        <div class="shop-stats">
                            <div class="shop-stat">
                                <div class="shop-stat-label">Outstanding</div>
                                <div class="shop-stat-value outstanding">LKR 85K</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Active Devices</div>
                                <div class="shop-stat-value active">12</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Sold Devices</div>
                                <div class="shop-stat-value sold">28</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Total Devices</div>
                                <div class="shop-stat-value">40</div>
                            </div>
                        </div>
                    </div>

                    <div class="shop-card" onclick="openShopDetails(3)">
                        <div class="shop-card-header">
                            <div class="shop-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="shop-name">
                                <h3>Phone Center - Galle</h3>
                                <p>ID: SH-003 • Since Jan 2025</p>
                            </div>
                            <div class="shop-status"></div>
                        </div>
                        <div class="shop-stats">
                            <div class="shop-stat">
                                <div class="shop-stat-label">Outstanding</div>
                                <div class="shop-stat-value outstanding">LKR 0</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Active Devices</div>
                                <div class="shop-stat-value active">8</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Sold Devices</div>
                                <div class="shop-stat-value sold">15</div>
                            </div>
                            <div class="shop-stat">
                                <div class="shop-stat-label">Total Devices</div>
                                <div class="shop-stat-value">23</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Details Modal -->
    <div class="modal-overlay" id="shopDetailsModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Tech Haven - Colombo</h2>
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
                            <span class="detail-value">SH-001</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location</span>
                            <span class="detail-value">Colombo, Sri Lanka</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact</span>
                            <span class="detail-value">+94 77 123 4567</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Owner</span>
                            <span class="detail-value">John Doe</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Outstanding Balance</span>
                            <span class="detail-value" style="color: #ff9800;">LKR 125,000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Active Devices</span>
                            <span class="detail-value" style="color: #4caf50;">18</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Sold Devices</span>
                            <span class="detail-value" style="color: #2196f3;">42</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Devices</span>
                            <span class="detail-value">60</span>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn secondary" onclick="closeModal('shopDetailsModal'); openModal('settleOutstandingModal')">
                        <i class="fas fa-money-bill-wave"></i>
                        Settle Outstanding
                    </button>
                    <button class="modal-btn secondary" onclick="printShopInvoice()">
                        <i class="fas fa-print"></i>
                        Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settle Outstanding Modal -->
    <div class="modal-overlay" id="settleOutstandingModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Settle Outstanding</h2>
                <button class="modal-close" onclick="closeModal('settleOutstandingModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-section">
                    <h3>Outstanding Amount: LKR 125,000</h3>
                    <div class="settlement-options">
                        <div class="settlement-option" onclick="selectSettlementOption('full')">
                            <input type="radio" name="settlement" id="fullSettlement" value="full">
                            <label for="fullSettlement">Full Settlement</label>
                            <p style="margin: 8px 0 0 28px; color: #6a759d; font-size: 13px;">Pay the complete outstanding amount</p>
                        </div>
                        <div class="settlement-option" onclick="selectSettlementOption('partial')">
                            <input type="radio" name="settlement" id="partialSettlement" value="partial">
                            <label for="partialSettlement">Partial Payment / Installment</label>
                            <p style="margin: 8px 0 0 28px; color: #6a759d; font-size: 13px;">Pay a portion of the outstanding amount</p>
                        </div>
                    </div>

                    <div class="form-group" id="partialAmountGroup" style="display: none;">
                        <label>Payment Amount (LKR)</label>
                        <input type="number" id="partialAmount" placeholder="Enter amount to pay">
                    </div>

                    <div class="form-group">
                        <label>Payment Method</label>
                        <select style="width: 100%; padding: 12px 16px; border: 1px solid #dfe3ed; border-radius: 8px; font-size: 14px;">
                            <option>Cash</option>
                            <option>Bank Transfer</option>
                            <option>Cheque</option>
                            <option>Online Payment</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes (Optional)</label>
                        <textarea style="width: 100%; padding: 12px 16px; border: 1px solid #dfe3ed; border-radius: 8px; font-size: 14px; min-height: 80px; resize: vertical;" placeholder="Add any notes..."></textarea>
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn secondary" onclick="closeModal('settleOutstandingModal')">Cancel</button>
                    <button class="modal-btn primary" onclick="processSettlement()">Process Payment</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function openShopDetails(shopId) {
            openModal('shopDetailsModal');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function selectSettlementOption(option) {
            const fullRadio = document.getElementById('fullSettlement');
            const partialRadio = document.getElementById('partialSettlement');
            const partialAmountGroup = document.getElementById('partialAmountGroup');

            if (option === 'full') {
                fullRadio.checked = true;
                partialAmountGroup.style.display = 'none';
            } else {
                partialRadio.checked = true;
                partialAmountGroup.style.display = 'block';
            }
        }

        function processSettlement() {
            alert('Payment processed successfully!');
            closeModal('settleOutstandingModal');
        }

        function printShopInvoice() {
            alert('Printing invoice...');
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Search functionality
        document.getElementById('searchShops').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const shopCards = document.querySelectorAll('.shop-card');

            shopCards.forEach(card => {
                const shopName = card.querySelector('.shop-name h3').textContent.toLowerCase();
                if (shopName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
