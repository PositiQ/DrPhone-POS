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
                    <h2 style="margin: 0; font-size: 24px; color: #1a237e; font-weight: 700;">Vault & Balance</h2>
                    <button class="button-primary" id="addTransactionBtn" style="cursor: pointer;">
                        <i class="fas fa-plus"></i> Add Manual Transaction
                    </button>
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

                <div class="metric-card">
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
                                <option value="sale">Sale</option>
                                <option value="expense">Expense</option>
                                <option value="shop_sale">Shop Sale</option>
                                <option value="cash_in">Cash In</option>
                                <option value="cash_out">Cash Out</option>
                                <option value="adjustment">Adjustment</option>
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
                            <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Status</label>
                            <select id="filterStatus" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                                <option value="">All</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
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
                        <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Transaction Type</label>
                        <select id="txnType" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                            <option value="cash_in">Cash In</option>
                            <option value="cash_out">Cash Out</option>
                            <option value="adjustment">Adjustment</option>
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
            #addTransactionBtn {
                display: none !important;
            }
        }
    </style>

    <script>
        const API_BASE_URL = 'http://localhost:3000/api';
        const VAULT_API = `${API_BASE_URL}/vault`;
        let currentPage = 1;
        let totalPages = 1;

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
                'sale': '#3f51b5',
                'expense': '#d32f2f',
                'shop_sale': '#ff9800',
                'cash_in': '#2e7d32',
                'cash_out': '#c62828',
                'adjustment': '#9c27b0',
            };
            return colors[type] || '#999';
        }

        // Load balance summary
        async function loadBalance() {
            try {
                const response = await fetch(`${VAULT_API}/balance`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load balance');
                }

                const { totalIncoming, totalOutgoing, currentBalance } = result.data;

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
                const status = document.getElementById('filterStatus').value;

                let url = `${VAULT_API}/transactions?page=${page}&limit=20`;
                if (startDate) url += `&startDate=${startDate}`;
                if (endDate) url += `&endDate=${endDate}`;
                if (transactionType) url += `&transactionType=${transactionType}`;
                if (direction) url += `&transactionDirection=${direction}`;
                if (status) url += `&status=${status}`;

                const response = await fetch(url);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load transactions');
                }

                const transactions = result.data;
                const pagination = result.pagination;
                currentPage = pagination.page;
                totalPages = pagination.pages;

                const container = document.getElementById('transactionsContainer');

                if (!transactions.length) {
                    container.innerHTML = '<div style="text-align: center; padding: 40px; color: #999; background: #f9f9f9; border-radius: 6px; border: 1px dashed #e0e0e0;"><i class="fas fa-inbox"></i> No transactions found</div>';
                } else {
                    const rows = transactions.map(txn => {
                        const amountClass = txn.transaction_direction === 'in' ? 'status-paid' : 'status-processing';
                        const amountSign = txn.transaction_direction === 'in' ? '+' : '-';
                        const typeColor = getTransactionTypeBadgeColor(txn.transaction_type);
                        const formattedType = txn.transaction_type.replace(/_/g, ' ').toUpperCase();

                        return `
                            <tr>
                                <td>${formatDate(txn.transaction_date)}</td>
                                <td><div style="display: flex; align-items: center; gap: 8px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: ${typeColor};"></div><span>${formattedType}</span></div></td>
                                <td>${txn.description || '-'}</td>
                                <td><span class="status-badge" style="background: ${txn.transaction_direction === 'in' ? '#e8f5e9' : '#ffebee'}; color: ${txn.transaction_direction === 'in' ? '#2e7d32' : '#c62828'};">${txn.transaction_direction.toUpperCase()}</span></td>
                                <td style="color: ${txn.transaction_direction === 'in' ? '#2e7d32' : '#c62828'}; font-weight: 600;">${amountSign}${formatLkr(txn.amount)}</td>
                                <td><span class="status-badge ${amountClass}">${txn.status.toUpperCase()}</span></td>
                            </tr>
                        `;
                    }).join('');

                    container.innerHTML = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Direction</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${rows}
                            </tbody>
                        </table>
                    `;
                }

                // Update transaction count
                document.getElementById('transactionCount').textContent = `${pagination.total} transactions found`;

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
            document.getElementById('filterStatus').value = '';
            loadTransactions(1);
        }

        // Open add transaction modal
        document.getElementById('addTransactionBtn')?.addEventListener('click', function() {
            document.getElementById('addTransactionModal').classList.add('active');
        });

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
                const amount = parseFloat(document.getElementById('txnAmount').value);
                const description = document.getElementById('txnDescription').value;
                const notes = document.getElementById('txnNotes').value;

                // Determine direction based on type
                let direction = 'in';
                if (transactionType === 'cash_out') {
                    direction = 'out';
                }

                const payload = {
                    transactionType,
                    transactionDirection: direction,
                    amount,
                    description,
                    notes,
                };

                const response = await fetch(`${VAULT_API}/transactions/manual`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to save transaction');
                }

                alert('Transaction recorded successfully!');
                closeAddTransactionModal();
                loadBalance();
                loadTransactions(1);
            } catch (error) {
                console.error('Error saving transaction:', error);
                alert('Error: ' + error.message);
            }
        }

        // Close modal on outside click
        document.getElementById('addTransactionModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAddTransactionModal();
            }
        });

        // Load page
        document.addEventListener('DOMContentLoaded', function() {
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
