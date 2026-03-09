<?php
$activePage = 'vault-balance';
$basePath = '../';
$pageTitle = 'Vault & Balance';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .vault-header {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3f51b5;
        }

        .stat-card.outgoing {
            border-left-color: #d32f2f;
        }

        .stat-card.balance {
            border-left-color: #2e7d32;
        }

        .stat-card h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: #7a86ad;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-card .amount {
            font-size: 28px;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 8px;
        }

        .stat-card .stat-label {
            font-size: 12px;
            color: #999;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #1a237e;
        }

        .btn-primary {
            background: #3f51b5;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #1a237e;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #bdbdbd;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-row.last {
            margin-bottom: 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #7a86ad;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3f51b5;
        }

        .transactions-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .transactions-table thead {
            background: #f5f7fa;
            border-top: 2px solid #e0e0e0;
            border-bottom: 2px solid #e0e0e0;
        }

        .transactions-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #1a237e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .transactions-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
            color: #22315b;
        }

        .transactions-table tbody tr:hover {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge.in {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge.out {
            background: #ffebee;
            color: #c62828;
        }

        .badge.pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .badge.completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .amount-in {
            color: #2e7d32;
            font-weight: 600;
        }

        .amount-out {
            color: #c62828;
            font-weight: 600;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 18px;
            color: #1a237e;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #333;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px dashed #e0e0e0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination button {
            padding: 6px 12px;
            border: 1px solid #e0e0e0;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 12px;
            transition: all 0.3s;
        }

        .pagination button.active {
            background: #3f51b5;
            color: white;
            border-color: #3f51b5;
        }

        .pagination button:hover:not(.disabled) {
            border-color: #3f51b5;
        }

        .pagination button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="header-left">
                <i class="fas fa-bars menu-toggle" id="menuToggle" onclick="toggleSidebar()"></i>
                <h1 class="page-title">Vault & Balance</h1>
            </div>

            <div class="header-center">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." readonly>
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

        <!-- Content Area -->
        <div class="content-area">
            <!-- Page Header -->
            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <h2 style="margin: 0; font-size: 24px; color: #1a237e; font-weight: 700;"></h2>
                    <div style="display: flex; gap: 10px;">
                        <button class="button-secondary" id="addVaultBtn" style="cursor: pointer;">
                            <i class="fas fa-landmark"></i> Add Vault Account
                        </button>
                        <button class="button-primary" id="addTransactionBtn" style="cursor: pointer;">
                            <i class="fas fa-plus"></i> Add Manual Transaction
                        </button>
                    </div>
                </div>
                <p style="margin: 0; font-size: 13px; color: #7a86ad;">Track all financial transactions and balance</p>
            </div>

            <!-- Balance Cards -->
            <div class="cards-row" id="balanceCards">
                <div class="metric-card">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Total Incoming</div>
                        <div class="metric-value" id="totalIncoming">LKR 0.00</div>
                        <div class="metric-change">Money received from all sources</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Total Outgoing</div>
                        <div class="metric-value" id="totalOutgoing">LKR 0.00</div>
                        <div class="metric-change">Money spent and withdrawn</div>
                    </div>
                </div>

                <div class="metric-card" id="currentBalanceCard" style="cursor: pointer;" title="Click to manage vault accounts">
                    <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-label">Current Balance</div>
                        <div class="metric-value" id="currentBalance">LKR 0.00</div>
                        <div class="metric-change">Net available cash</div>
                    </div>
                </div>
            </div>

            <br>

            <!-- Filter Section -->
            <div class="filter-card">
                <div style="margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">From Date</label>
                            <input type="date" id="filterStartDate" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">To Date</label>
                            <input type="date" id="filterEndDate" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Transaction Type</label>
                            <select id="filterTransactionType" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All Types</option>
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Direction</label>
                            <select id="filterDirection" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All</option>
                                <option value="in">Money In</option>
                                <option value="out">Money Out</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account</label>
                            <select id="filterAccountId" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All Accounts</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: flex-end;">
                            <button class="button-primary" onclick="filterTransactions()" style="flex: 1; cursor: pointer;">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <button class="button-secondary" onclick="resetFilters()" style="flex: 1; cursor: pointer;">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <!-- Transactions Section -->
            <div class="recent-orders">
                <div class="section-header">
                    <h3>All Transactions</h3>
                    <span id="transactionCount" style="font-size: 13px; color: #7a86ad;"></span>
                </div>

                <div id="transactionsContainer">
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <i class="fas fa-spinner fa-spin"></i> Loading transactions...
                    </div>
                </div>

                <div id="paginationContainer" style="display: flex; justify-content: center; gap: 5px; margin-top: 20px;"></div>
            </div>
        </div>
    </div>

    <!-- Manage Account Modal -->
    <div id="manageAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Manage Vault Account</h2>
                <button class="close-btn" onclick="closeManageAccountModal()">×</button>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Select Account</label>
                <select id="manageAccountSelect" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    <option value="">Select Account</option>
                </select>
            </div>

            <div id="manageAccountDetails" style="margin-bottom: 20px; background: #f8faff; border: 1px solid #e3e8ff; border-radius: 8px; padding: 14px; color: #22315b; font-size: 13px;">
                Select an account to view balance and actions.
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" id="editAccountBtn" class="button-primary" style="flex: 1; cursor: pointer;" onclick="openEditAccountModal()" disabled>
                    <i class="fas fa-pen"></i> Edit Account
                </button>
                <button type="button" id="deleteAccountBtn" class="button-secondary" style="flex: 1; cursor: pointer; background: #ffebee; color: #c62828;" onclick="deleteSelectedAccount()" disabled>
                    <i class="fas fa-trash"></i> Delete Account
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Account Modal -->
    <div id="editAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Account</h2>
                <button class="close-btn" onclick="closeEditAccountModal()">×</button>
            </div>

            <form id="editAccountForm" onsubmit="saveAccountEdit(event)">
                <div id="editBankFields" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Bank Name</label>
                        <input type="text" id="editBankName" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Branch Name</label>
                        <input type="text" id="editBranchName" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account Number</label>
                        <input type="text" id="editAccountNumber" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account Holder Name</label>
                        <input type="text" id="editAccountHolderName" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div id="editDrawerFields" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Drawer Name</label>
                        <input type="text" id="editDrawerName" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Location</label>
                        <input type="text" id="editDrawerLocation" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="button-primary" style="flex: 1; cursor: pointer;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="button" class="button-secondary" style="flex: 1; cursor: pointer;" onclick="closeEditAccountModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Add Vault Account Modal -->
    <div id="addVaultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Vault Account</h2>
                <button class="close-btn" onclick="closeAddVaultModal()">×</button>
            </div>

            <form id="addVaultForm" onsubmit="saveVaultAccount(event)">
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Vault Type</label>
                    <select id="vaultType" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        <option value="bank">Bank</option>
                        <option value="drawer">Drawer</option>
                    </select>
                </div>

                <div id="bankFields">
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Bank Name</label>
                        <input type="text" id="vaultBankName" placeholder="ABC Bank" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Branch Name</label>
                        <input type="text" id="vaultBranchName" placeholder="Main Branch" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account Number</label>
                        <input type="text" id="vaultAccountNumber" placeholder="1234567890" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account Holder Name</label>
                        <input type="text" id="vaultAccountHolder" placeholder="John Doe" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div id="drawerFields" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Drawer Name</label>
                        <input type="text" id="vaultDrawerName" placeholder="Cash Counter 1" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Drawer Location</label>
                        <input type="text" id="vaultDrawerLocation" placeholder="Front Desk" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="button-primary" style="flex: 1; cursor: pointer;">
                        <i class="fas fa-save"></i> Save Vault
                    </button>
                    <button type="button" class="button-secondary" style="flex: 1; cursor: pointer;" onclick="closeAddVaultModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div id="addTransactionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Manual Transaction</h2>
                <button class="close-btn" onclick="closeAddTransactionModal()">×</button>
            </div>

            <form id="addTransactionForm" onsubmit="saveManualTransaction(event)">
                <div style="margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account</label>
                        <select id="txnAccountId" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                            <option value="">Select Account</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Transaction Type</label>
                        <select id="txnType" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                            <option value="credit">Credit (Money In)</option>
                            <option value="debit">Debit (Money Out)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Amount (LKR)</label>
                        <input type="number" id="txnAmount" step="0.01" min="0" required placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Description</label>
                        <input type="text" id="txnDescription" placeholder="Enter description" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Notes</label>
                        <textarea id="txnNotes" rows="3" placeholder="Additional notes..." style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px; font-family: 'Inter', sans-serif;"></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="button-primary" style="flex: 1; cursor: pointer;">
                        <i class="fas fa-save"></i> Save Transaction
                    </button>
                    <button type="button" class="button-secondary" style="flex: 1; cursor: pointer;" onclick="closeAddTransactionModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .filter-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 18px;
            color: #1a237e;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #333;
        }

        @media print {
            .top-header,
            .button-primary,
            .button-secondary,
            .filter-card,
            #addTransactionBtn,
            #addVaultBtn {
                display: none !important;
            }
        }
    </style>

    <script>
        const API_BASE_URL = 'http://localhost:3000/api';
        const VAULT_API = `${API_BASE_URL}/vault`;
        let currentPage = 1;
        let totalPages = 1;
        let vaultAccounts = [];
        let selectedManageAccount = null;

        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                confirmButtonColor: '#3f51b5',
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonColor: '#d32f2f',
            });
        }

        // Format currency
        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        // Format date
        function formatDate(dateValue) {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) {
                return '-';
            }
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
        }

        // Get transaction type badge color
        function getTransactionTypeBadgeColor(type) {
            const colors = {
                'credit': '#2e7d32',
                'debit': '#c62828',
            };
            return colors[type] || '#999';
        }

        function buildAccountOptionLabel(accountItem) {
            const typeLabel = accountItem.account_type === 'bank' ? 'BANK' : 'DRAWER';
            const balanceLabel = formatLkr(accountItem.available_balance);
            const name = accountItem.display_name || typeLabel;
            return `${accountItem.account_id} - ${name} | ${balanceLabel}`;
        }

        function populateAccountDropdowns() {
            const filterSelect = document.getElementById('filterAccountId');
            const transactionSelect = document.getElementById('txnAccountId');
            const manageSelect = document.getElementById('manageAccountSelect');
            const previousFilter = filterSelect?.value || '';
            const previousTxn = transactionSelect?.value || '';
            const previousManage = manageSelect?.value || '';

            if (filterSelect) {
                filterSelect.innerHTML = '<option value="">All Accounts</option>';
            }
            if (transactionSelect) {
                transactionSelect.innerHTML = '<option value="">Select Account</option>';
            }
            if (manageSelect) {
                manageSelect.innerHTML = '<option value="">Select Account</option>';
            }

            vaultAccounts.forEach((item) => {
                const label = buildAccountOptionLabel(item);
                const filterOption = `<option value="${item.account_id}">${label}</option>`;
                if (filterSelect) filterSelect.insertAdjacentHTML('beforeend', filterOption);
                if (transactionSelect) transactionSelect.insertAdjacentHTML('beforeend', `<option value="${item.account_id}">${label}</option>`);
                if (manageSelect) manageSelect.insertAdjacentHTML('beforeend', `<option value="${item.account_id}">${label}</option>`);
            });

            if (filterSelect) filterSelect.value = previousFilter;
            if (transactionSelect) transactionSelect.value = previousTxn;
            if (manageSelect) manageSelect.value = previousManage;

            if (manageSelect && manageSelect.value) {
                updateManageAccountDetails(manageSelect.value);
            }
        }

        function getAccountById(accountId) {
            return vaultAccounts.find((item) => item.account_id === accountId) || null;
        }

        function updateManageAccountDetails(accountId) {
            const details = document.getElementById('manageAccountDetails');
            const editBtn = document.getElementById('editAccountBtn');
            const deleteBtn = document.getElementById('deleteAccountBtn');

            selectedManageAccount = getAccountById(accountId);

            if (!selectedManageAccount) {
                if (details) details.innerHTML = 'Select an account to view balance and actions.';
                if (editBtn) editBtn.disabled = true;
                if (deleteBtn) deleteBtn.disabled = true;
                return;
            }

            if (editBtn) editBtn.disabled = false;
            if (deleteBtn) deleteBtn.disabled = false;

            if (selectedManageAccount.account_type === 'bank') {
                details.innerHTML = `
                    <div><strong>Type:</strong> BANK</div>
                    <div><strong>Balance:</strong> ${formatLkr(selectedManageAccount.available_balance)}</div>
                    <div><strong>Bank:</strong> ${selectedManageAccount.bank_name || '-'}</div>
                    <div><strong>Branch:</strong> ${selectedManageAccount.branch_name || '-'}</div>
                    <div><strong>Account Number:</strong> ${selectedManageAccount.account_number || '-'}</div>
                    <div><strong>Holder:</strong> ${selectedManageAccount.account_holder_name || '-'}</div>
                `;
            } else {
                details.innerHTML = `
                    <div><strong>Type:</strong> DRAWER</div>
                    <div><strong>Balance:</strong> ${formatLkr(selectedManageAccount.available_balance)}</div>
                    <div><strong>Drawer Name:</strong> ${selectedManageAccount.name || '-'}</div>
                    <div><strong>Location:</strong> ${selectedManageAccount.location || '-'}</div>
                `;
            }
        }

        function openManageAccountModal() {
            document.getElementById('manageAccountModal').classList.add('active');
            const select = document.getElementById('manageAccountSelect');
            updateManageAccountDetails(select?.value || '');
        }

        function closeManageAccountModal() {
            document.getElementById('manageAccountModal').classList.remove('active');
        }

        function openEditAccountModal() {
            if (!selectedManageAccount) {
                showErrorAlert('Please select an account first');
                return;
            }

            const bankFields = document.getElementById('editBankFields');
            const drawerFields = document.getElementById('editDrawerFields');

            if (selectedManageAccount.account_type === 'bank') {
                if (bankFields) bankFields.style.display = 'block';
                if (drawerFields) drawerFields.style.display = 'none';

                document.getElementById('editBankName').value = selectedManageAccount.bank_name || '';
                document.getElementById('editBranchName').value = selectedManageAccount.branch_name || '';
                document.getElementById('editAccountNumber').value = selectedManageAccount.account_number || '';
                document.getElementById('editAccountHolderName').value = selectedManageAccount.account_holder_name || '';
            } else {
                if (bankFields) bankFields.style.display = 'none';
                if (drawerFields) drawerFields.style.display = 'block';

                document.getElementById('editDrawerName').value = selectedManageAccount.name || '';
                document.getElementById('editDrawerLocation').value = selectedManageAccount.location || '';
            }

            document.getElementById('editAccountModal').classList.add('active');
        }

        function closeEditAccountModal() {
            document.getElementById('editAccountModal').classList.remove('active');
            document.getElementById('editAccountForm').reset();
        }

        async function saveAccountEdit(event) {
            event.preventDefault();

            if (!selectedManageAccount) {
                showErrorAlert('No account selected');
                return;
            }

            try {
                let endpoint = '';
                let payload = {};

                if (selectedManageAccount.account_type === 'bank') {
                    endpoint = `${VAULT_API}/bank/${encodeURIComponent(selectedManageAccount.bank_acc_id)}`;
                    payload = {
                        bank_name: document.getElementById('editBankName').value.trim(),
                        branch_name: document.getElementById('editBranchName').value.trim(),
                        account_number: document.getElementById('editAccountNumber').value.trim(),
                        account_holder_name: document.getElementById('editAccountHolderName').value.trim(),
                    };
                } else {
                    endpoint = `${VAULT_API}/drawer/${encodeURIComponent(selectedManageAccount.drawer_acc_id)}`;
                    payload = {
                        name: document.getElementById('editDrawerName').value.trim(),
                        location: document.getElementById('editDrawerLocation').value.trim(),
                    };
                }

                const response = await fetch(endpoint, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to update account');
                }

                showSuccessAlert(result.message || 'Account updated successfully');
                closeEditAccountModal();
                await loadVaultAccounts();
                loadBalance();
                loadTransactions(currentPage);
            } catch (error) {
                console.error('Error updating account:', error);
                showErrorAlert(error.message || 'Failed to update account');
            }
        }

        async function deleteSelectedAccount() {
            if (!selectedManageAccount) {
                showErrorAlert('Please select an account first');
                return;
            }

            const confirmation = await Swal.fire({
                icon: 'warning',
                title: 'Delete Account?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#d32f2f',
                cancelButtonText: 'Cancel',
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            try {
                const endpoint = selectedManageAccount.account_type === 'bank'
                    ? `${VAULT_API}/bank/${encodeURIComponent(selectedManageAccount.bank_acc_id)}`
                    : `${VAULT_API}/drawer/${encodeURIComponent(selectedManageAccount.drawer_acc_id)}`;

                const response = await fetch(endpoint, { method: 'DELETE' });
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to delete account');
                }

                showSuccessAlert(result.message || 'Account deleted successfully');
                await loadVaultAccounts();
                loadBalance();
                loadTransactions(1);

                const select = document.getElementById('manageAccountSelect');
                if (select) {
                    select.value = '';
                }
                updateManageAccountDetails('');
            } catch (error) {
                console.error('Error deleting account:', error);
                showErrorAlert(error.message || 'Failed to delete account');
            }
        }

        async function loadVaultAccounts() {
            try {
                const response = await fetch(`${VAULT_API}/accounts`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load vault accounts');
                }

                vaultAccounts = Array.isArray(result.accounts) ? result.accounts : [];
                populateAccountDropdowns();
            } catch (error) {
                console.error('Error loading vault accounts:', error);
            }
        }

        // Load balance summary
        async function loadBalance() {
            try {
                const response = await fetch(`${VAULT_API}/balance`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load balance');
                }

                const totalIncoming = Number(result.totalCredit || 0);
                const totalOutgoing = Number(result.totalDebit || 0);
                const currentBalance = Number(result.totalBalance || 0);

                document.getElementById('totalIncoming').textContent = formatLkr(totalIncoming);
                document.getElementById('totalOutgoing').textContent = formatLkr(totalOutgoing);
                document.getElementById('currentBalance').textContent = formatLkr(currentBalance);
            } catch (error) {
                console.error('Error loading balance:', error);
            }
        }

        // Load transactions
        async function loadTransactions(page = 1) {
            try {
                const startDate = document.getElementById('filterStartDate').value;
                const endDate = document.getElementById('filterEndDate').value;
                const transactionType = document.getElementById('filterTransactionType').value;
                const direction = document.getElementById('filterDirection').value;
                const accountId = document.getElementById('filterAccountId').value;

                let url = `${VAULT_API}/transactions?page=${page}`;
                if (accountId) {
                    url = `${VAULT_API}/transactions/account/${encodeURIComponent(accountId)}?page=${page}`;
                }

                const response = await fetch(url);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load transactions');
                }

                const transactions = Array.isArray(result.transactions) ? result.transactions : [];
                currentPage = Number(result.currentPage || page);
                totalPages = Number(result.totalPages || 1);

                const filteredTransactions = transactions.filter((txn) => {
                    const txnDate = new Date(txn.transaction_date);
                    if (startDate) {
                        const start = new Date(startDate);
                        start.setHours(0, 0, 0, 0);
                        if (txnDate < start) return false;
                    }
                    if (endDate) {
                        const end = new Date(endDate);
                        end.setHours(23, 59, 59, 999);
                        if (txnDate > end) return false;
                    }
                    if (transactionType && txn.type !== transactionType) {
                        return false;
                    }
                    if (direction) {
                        const txnDirection = txn.type === 'credit' ? 'in' : 'out';
                        if (txnDirection !== direction) return false;
                    }
                    return true;
                });

                const container = document.getElementById('transactionsContainer');

                if (!filteredTransactions.length) {
                    container.innerHTML = '<div style="text-align: center; padding: 40px; color: #999; background: #f9f9f9; border-radius: 6px; border: 1px dashed #e0e0e0;"><i class="fas fa-inbox"></i> No transactions found</div>';
                } else {
                    const rows = filteredTransactions.map(txn => {
                        const txnDirection = txn.type === 'credit' ? 'in' : 'out';
                        const amountSign = txnDirection === 'in' ? '+' : '-';
                        const typeColor = getTransactionTypeBadgeColor(txn.type);
                        const formattedType = String(txn.type || '').toUpperCase();
                        const canDelete = Boolean(txn.transaction_id);

                        return `
                            <tr>
                                <td>${formatDate(txn.transaction_date)}</td>
                                <td>${txn.account_id || '-'}</td>
                                <td><div style="display: flex; align-items: center; gap: 8px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: ${typeColor};"></div><span>${formattedType}</span></div></td>
                                <td>${txn.description || '-'}</td>
                                <td><span class="status-badge" style="background: ${txnDirection === 'in' ? '#e8f5e9' : '#ffebee'}; color: ${txnDirection === 'in' ? '#2e7d32' : '#c62828'};">${txnDirection.toUpperCase()}</span></td>
                                <td style="color: ${txnDirection === 'in' ? '#2e7d32' : '#c62828'}; font-weight: 600;">${amountSign}${formatLkr(txn.amount)}</td>
                                <td>
                                    <button
                                        type="button"
                                        onclick="deleteTransaction('${txn.transaction_id || ''}')"
                                        ${canDelete ? '' : 'disabled'}
                                        style="padding: 6px 10px; border: 1px solid #ffcdd2; background: #ffebee; color: #c62828; border-radius: 6px; font-size: 12px; cursor: ${canDelete ? 'pointer' : 'not-allowed'};">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');

                    container.innerHTML = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Direction</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${rows}
                            </tbody>
                        </table>
                    `;
                }

                // Update transaction count
                const totalRecords = Number(result.totalRecords || 0);
                document.getElementById('transactionCount').textContent = `Showing ${filteredTransactions.length} of ${totalRecords} transactions`;

                // Update pagination
                updatePagination();
            } catch (error) {
                console.error('Error loading transactions:', error);
                document.getElementById('transactionsContainer').innerHTML = `<div style="text-align: center; padding: 40px; color: #d32f2f; background: #ffebee; border-radius: 6px;"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
            }
        }

        // Update pagination
        function updatePagination() {
            const container = document.getElementById('paginationContainer');
            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '';
            
            // Previous button
            if (currentPage > 1) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px; transition: all 0.3s;" onclick="loadTransactions(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
            }

            // Page buttons
            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                const activeStyle = i === currentPage ? 'background: #3f51b5; color: white; border-color: #3f51b5;' : '';
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px; transition: all 0.3s; ${activeStyle}" onclick="loadTransactions(${i})">${i}</button>`;
            }

            // Next button
            if (currentPage < totalPages) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px; transition: all 0.3s;" onclick="loadTransactions(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
            }

            container.innerHTML = html;
        }

        // Filter transactions
        function filterTransactions() {
            loadTransactions(1);
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            document.getElementById('filterTransactionType').value = '';
            document.getElementById('filterDirection').value = '';
            document.getElementById('filterAccountId').value = '';
            loadTransactions(1);
        }

        // Open add vault modal
        document.getElementById('addVaultBtn')?.addEventListener('click', function() {
            document.getElementById('addVaultModal').classList.add('active');
            updateVaultTypeFields();
        });

        document.getElementById('currentBalanceCard')?.addEventListener('click', function() {
            openManageAccountModal();
        });

        // Card may be initialized after content loads, so delegate fallback.
        document.addEventListener('click', function(event) {
            const card = event.target.closest('#currentBalanceCard');
            if (card) {
                openManageAccountModal();
            }
        });

        // Open add transaction modal
        document.getElementById('addTransactionBtn')?.addEventListener('click', function() {
            document.getElementById('addTransactionModal').classList.add('active');
        });

        function updateVaultTypeFields() {
            const selectedType = document.getElementById('vaultType')?.value || 'bank';
            const bankFields = document.getElementById('bankFields');
            const drawerFields = document.getElementById('drawerFields');

            if (bankFields) bankFields.style.display = selectedType === 'bank' ? 'block' : 'none';
            if (drawerFields) drawerFields.style.display = selectedType === 'drawer' ? 'block' : 'none';
        }

        // Close add vault modal
        function closeAddVaultModal() {
            document.getElementById('addVaultModal').classList.remove('active');
            document.getElementById('addVaultForm').reset();
            updateVaultTypeFields();
        }

        // Save vault account
        async function saveVaultAccount(event) {
            event.preventDefault();

            try {
                const vaultType = document.getElementById('vaultType').value;
                const payload = { type: vaultType };

                if (vaultType === 'bank') {
                    payload.bank_name = document.getElementById('vaultBankName').value.trim();
                    payload.branch_name = document.getElementById('vaultBranchName').value.trim();
                    payload.account_number = document.getElementById('vaultAccountNumber').value.trim();
                    payload.account_holder_name = document.getElementById('vaultAccountHolder').value.trim();

                    if (!payload.bank_name || !payload.branch_name || !payload.account_number || !payload.account_holder_name) {
                        throw new Error('Please fill all bank account fields');
                    }
                } else {
                    payload.drawer_name = document.getElementById('vaultDrawerName').value.trim();
                    payload.drawer_location = document.getElementById('vaultDrawerLocation').value.trim();

                    if (!payload.drawer_name || !payload.drawer_location) {
                        throw new Error('Please fill all drawer account fields');
                    }
                }

                const response = await fetch(`${VAULT_API}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to create vault account');
                }

                showSuccessAlert(result.message || 'Vault account created successfully');
                closeAddVaultModal();
                await loadVaultAccounts();
                loadBalance();
                loadTransactions(1);
            } catch (error) {
                console.error('Error creating vault account:', error);
                showErrorAlert(error.message || 'Failed to create vault account');
            }
        }

        // Close add transaction modal
        function closeAddTransactionModal() {
            document.getElementById('addTransactionModal').classList.remove('active');
            document.getElementById('addTransactionForm').reset();
        }

        // Save manual transaction
        async function saveManualTransaction(event) {
            event.preventDefault();

            try {
                const transactionType = document.getElementById('txnType').value;
                const accountId = document.getElementById('txnAccountId').value.trim();
                const amount = parseFloat(document.getElementById('txnAmount').value);
                const description = document.getElementById('txnDescription').value;
                const notes = document.getElementById('txnNotes').value;

                if (!accountId) {
                    throw new Error('Account ID is required');
                }

                if (!Number.isFinite(amount) || amount <= 0) {
                    throw new Error('Amount must be greater than 0');
                }

                const payload = {
                    account_id: accountId,
                    type: transactionType,
                    amount,
                    description: notes ? `${description || ''} ${description ? '|' : ''} Notes: ${notes}`.trim() : description,
                };

                const response = await fetch(`${VAULT_API}/transactions`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to save transaction');
                }

                showSuccessAlert('Transaction recorded successfully!');
                closeAddTransactionModal();
                loadBalance();
                loadTransactions(1);
            } catch (error) {
                console.error('Error saving transaction:', error);
                showErrorAlert(error.message || 'Failed to save transaction');
            }
        }

        async function deleteTransaction(transactionId) {
            if (!transactionId) {
                showErrorAlert('Invalid transaction ID');
                return;
            }

            const confirmation = await Swal.fire({
                icon: 'warning',
                title: 'Delete Transaction?',
                text: 'This will reverse the transaction effect on account balance.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#d32f2f',
                cancelButtonText: 'Cancel',
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            try {
                const response = await fetch(`${VAULT_API}/transactions/${encodeURIComponent(transactionId)}`, {
                    method: 'DELETE',
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to delete transaction');
                }

                showSuccessAlert(result.message || 'Transaction deleted successfully');
                loadBalance();
                loadTransactions(currentPage);
            } catch (error) {
                console.error('Error deleting transaction:', error);
                showErrorAlert(error.message || 'Failed to delete transaction');
            }
        }

        // Close modal on outside click
        document.getElementById('addTransactionModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAddTransactionModal();
            }
        });

        document.getElementById('addVaultModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAddVaultModal();
            }
        });

        document.getElementById('manageAccountModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeManageAccountModal();
            }
        });

        document.getElementById('editAccountModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditAccountModal();
            }
        });

        document.getElementById('vaultType')?.addEventListener('change', updateVaultTypeFields);
        document.getElementById('manageAccountSelect')?.addEventListener('change', function(event) {
            updateManageAccountDetails(event.target.value);
        });

        // Load page
        document.addEventListener('DOMContentLoaded', async function() {
            updateVaultTypeFields();
            await loadVaultAccounts();
            loadBalance();
            loadTransactions(1);

            // Refresh every 30 seconds
            setInterval(loadBalance, 30000);
        });

        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
        }
    </script>
</body>
</html>
