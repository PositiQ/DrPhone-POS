<?php
$activePage = 'expenses';
$basePath = '../';
$pageTitle = 'Expenses';
$pageSubtitle = 'Manage shop expenses and track spending.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#111111">
    <meta name="description" content="Manage shop expenses and spending">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Expenses</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .filter-card {
            background: #ffffff;
            border: 1px solid #eef1f6;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #eef1f6;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 18px;
            color: #111111;
        }

        .close-btn {
            border: none;
            background: transparent;
            font-size: 22px;
            color: #6a759d;
            cursor: pointer;
        }

        .status-badge.status-paid {
            background: #e8f5e9;
            color: #1b5e20;
        }

        .status-badge.status-pending {
            background: #fff8e1;
            color: #a05a00;
        }

        .status-badge.status-processing {
            background: #ffebee;
            color: #b71c1c;
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
                        <input type="text" id="searchExpense" placeholder="Search expenses..." style="min-width: 240px;">
                        <input type="date" id="filterStartDate">
                        <input type="date" id="filterEndDate">
                        <select id="filterCategory">
                            <option value="">All Categories</option>
                        </select>
                        <select id="filterStatus">
                            <option value="">All Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <select id="filterPayment">
                            <option value="">All Payment Methods</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="check">Check</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" id="addExpenseBtn" type="button">
                            <i class="fas fa-plus"></i>
                            Add Expense
                        </button>
                        <button class="button-secondary" id="exportExpensesBtn" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="cards-row">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Expenses</div>
                            <div class="metric-value" id="totalExpenses">LKR 0.00</div>
                            <div class="metric-change">All approved expenses</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Pending Expenses</div>
                            <div class="metric-value" id="pendingCount">0</div>
                            <div class="metric-change">Awaiting approval</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Monthly Average</div>
                            <div class="metric-value" id="monthlyAvg">LKR 0.00</div>
                            <div class="metric-change">Per expense</div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>All Expenses</h3>
                        <span id="expenseCount" style="font-size: 13px; color: #7a86ad;"></span>
                    </div>

                    <div id="expensesContainer">
                        <div style="text-align: center; padding: 40px; color: #999;">
                            <i class="fas fa-spinner fa-spin"></i> Loading expenses...
                        </div>
                    </div>

                    <div id="paginationContainer" style="display: flex; justify-content: center; gap: 6px; margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="addExpenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Expense</h2>
                <button class="close-btn" onclick="closeAddExpenseModal()">×</button>
            </div>

            <form id="addExpenseForm" onsubmit="saveExpense(event)" style="padding: 20px;">
                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Category</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <select id="expCategory" required style="flex: 1; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                            <option value="">Select Category</option>
                        </select>
                        <button type="button" class="button-secondary" id="addExpenseCategoryBtn" style="white-space: nowrap; padding: 8px 12px;">
                            <i class="fas fa-plus"></i> Category
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Amount (LKR)</label>
                    <input type="number" id="expAmount" step="0.01" min="0" required placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Date</label>
                    <input type="date" id="expDate" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Description</label>
                    <input type="text" id="expDescription" placeholder="Enter description" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Payment Method</label>
                    <select id="expPaymentMethod" style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="check">Check</option>
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 600; color: #7a86ad; text-transform: uppercase; margin-bottom: 6px; display: block;">Account</label>
                    <select id="expAccount" required style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                        <option value="">Select account...</option>
                    </select>
                    <div id="expAccountHint" style="margin-top: 6px; font-size: 12px; color: #7a86ad;">Cash requires a drawer account.</div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="button-primary" style="flex: 1; cursor: pointer;">
                        <i class="fas fa-save"></i> Save Expense
                    </button>
                    <button type="button" class="button-secondary" style="flex: 1; cursor: pointer;" onclick="closeAddExpenseModal()">
                        Cancel
                    </button>
                </div>
            </form>
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
        const API_BASE_URL = 'http://localhost:3000/api';
        const EXPENSE_API = `${API_BASE_URL}/expenses`;
        const EXPENSE_CATEGORY_API = `${EXPENSE_API}/categories`;
        const VAULT_ACCOUNTS_API = `${API_BASE_URL}/vault/accounts`;

        let currentPage = 1;
        let totalPages = 1;
        let currentRows = [];
        let vaultAccounts = [];

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) sidebar.classList.toggle('active');
        }

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function formatDate(dateValue) {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) return '-';
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
        }

        function getCategoryColor(category) {
            const colors = {
                rent: '#222222',
                utilities: '#ff9800',
                salary: '#d32f2f',
                supplies: '#2e7d32',
                maintenance: '#9c27b0',
                other: '#795548',
            };
            return colors[String(category || '').toLowerCase()] || '#999';
        }

        function getRequiredAccountTypeByPaymentMethod(paymentMethod) {
            const method = String(paymentMethod || '').toLowerCase();
            if (method === 'cash') return 'drawer';
            return 'bank';
        }

        async function requestJson(url, options = {}) {
            const response = await fetch(url, options);
            const result = await response.json().catch(() => ({}));
            if (!response.ok || result.success === false) {
                throw new Error(result.error || result.message || 'Request failed');
            }
            return result;
        }

        function showSuccess(message) {
            return Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                confirmButtonColor: '#111111',
            });
        }

        function showError(message) {
            return Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonColor: '#111111',
            });
        }

        function showWarning(message) {
            return Swal.fire({
                icon: 'warning',
                title: 'Notice',
                text: message,
                confirmButtonColor: '#111111',
            });
        }

        async function loadVaultAccounts() {
            const result = await requestJson(VAULT_ACCOUNTS_API);
            vaultAccounts = Array.isArray(result.accounts) ? result.accounts.map(account => ({
                id: account.account_id,
                type: String(account.account_type || '').toLowerCase(),
                label: account.display_name || account.account_id,
                balance: Number(account.available_balance || 0),
            })) : [];
        }

        function renderExpenseAccountOptions() {
            const method = document.getElementById('expPaymentMethod').value;
            const requiredType = getRequiredAccountTypeByPaymentMethod(method);
            const accountSelect = document.getElementById('expAccount');
            const accountHint = document.getElementById('expAccountHint');

            const matched = vaultAccounts.filter(account => account.type === requiredType);
            accountSelect.innerHTML = `<option value="">Select ${requiredType} account...</option>` + matched.map(account =>
                `<option value="${account.id}">${account.label} · ${formatLkr(account.balance)}</option>`
            ).join('');

            if (requiredType === 'drawer') {
                accountHint.textContent = 'Cash requires a drawer account.';
            } else {
                accountHint.textContent = 'Card, bank transfer, and check require a bank account.';
            }

            if (!matched.length) {
                accountHint.textContent += ` No ${requiredType} accounts available.`;
            }
        }

        async function loadExpenseCategories() {
            const result = await requestJson(EXPENSE_CATEGORY_API);
            const categories = Array.isArray(result.data) ? result.data : [];

            const filterCategory = document.getElementById('filterCategory');
            const expCategory = document.getElementById('expCategory');
            const selectedFilter = filterCategory.value;
            const selectedAdd = expCategory.value;

            const options = categories.map(category => {
                const code = String(category.code || '').trim();
                const name = String(category.name || code || '').trim();
                const label = name ? `${name.charAt(0).toUpperCase()}${name.slice(1)}` : code;
                return `<option value="${code}">${label}</option>`;
            }).join('');

            filterCategory.innerHTML = '<option value="">All Categories</option>' + options;
            expCategory.innerHTML = '<option value="">Select Category</option>' + options;

            if (selectedFilter) filterCategory.value = selectedFilter;
            if (selectedAdd) expCategory.value = selectedAdd;
        }

        async function promptAndCreateExpenseCategory() {
            const categoryName = prompt('Enter new expense category name');
            if (!categoryName || !categoryName.trim()) return;

            const result = await requestJson(EXPENSE_CATEGORY_API, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: categoryName.trim() }),
            });

            await loadExpenseCategories();
            const createdCode = String(result.data?.code || '').trim();
            if (createdCode) {
                document.getElementById('expCategory').value = createdCode;
            }

            showSuccess('Expense category added successfully.');
        }

        async function loadSummary() {
            try {
                const result = await requestJson(`${EXPENSE_API}/summary`);
                const summaryData = Array.isArray(result.data) ? result.data : [];

                let totalAmount = 0;
                let pendingCount = 0;
                let totalCount = 0;

                summaryData.forEach(item => {
                    const total = Number(item.total || 0);
                    const count = Number(item.count || 0);

                    if (String(item.status || '').toLowerCase() === 'approved') {
                        totalAmount += total;
                    }
                    if (String(item.status || '').toLowerCase() === 'pending') {
                        pendingCount += count;
                    }
                    totalCount += count;
                });

                document.getElementById('totalExpenses').textContent = formatLkr(totalAmount);
                document.getElementById('pendingCount').textContent = pendingCount.toLocaleString();
                document.getElementById('monthlyAvg').textContent = formatLkr(totalCount > 0 ? totalAmount / totalCount : 0);
            } catch (error) {
                console.error('Error loading summary:', error);
            }
        }

        function buildExpenseQuery(page = 1) {
            const startDate = document.getElementById('filterStartDate').value;
            const endDate = document.getElementById('filterEndDate').value;
            const category = document.getElementById('filterCategory').value;
            const status = document.getElementById('filterStatus').value;
            const payment = document.getElementById('filterPayment').value;
            const search = document.getElementById('searchExpense').value.trim();

            let url = `${EXPENSE_API}?page=${page}&limit=20`;
            if (startDate) url += `&startDate=${encodeURIComponent(startDate)}`;
            if (endDate) url += `&endDate=${encodeURIComponent(endDate)}`;
            if (category) url += `&category=${encodeURIComponent(category)}`;
            if (status) url += `&status=${encodeURIComponent(status)}`;
            if (payment) url += `&payment_method=${encodeURIComponent(payment)}`;
            if (search) url += `&query=${encodeURIComponent(search)}`;
            return url;
        }

        async function loadExpenses(page = 1) {
            try {
                const result = await requestJson(buildExpenseQuery(page));
                const expenses = Array.isArray(result.data) ? result.data : [];
                const pagination = result.pagination || { page: 1, pages: 1, total: 0 };

                currentRows = expenses;
                currentPage = pagination.page;
                totalPages = pagination.pages;

                const container = document.getElementById('expensesContainer');

                if (!expenses.length) {
                    container.innerHTML = '<div style="text-align: center; padding: 40px; color: #999; background: #f9f9f9; border-radius: 6px; border: 1px dashed #e0e0e0;"><i class="fas fa-inbox"></i> No expenses found</div>';
                } else {
                    const rows = expenses.map(exp => {
                        const category = String(exp.category || '').toLowerCase();
                        const categoryColor = getCategoryColor(category);
                        const categoryCode = category ? category.charAt(0).toUpperCase() : '?';

                        let statusClass = 'status-pending';
                        if (String(exp.status || '').toLowerCase() === 'approved') statusClass = 'status-paid';
                        else if (String(exp.status || '').toLowerCase() === 'rejected') statusClass = 'status-processing';

                        return `
                            <tr>
                                <td>${formatDate(exp.expense_date)}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: ${categoryColor}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px;">${categoryCode}</div>
                                        <div>
                                            <div style="font-weight: 600; color: #111111;">${String(category || 'other').toUpperCase()}</div>
                                            <div style="font-size: 12px; color: #999;">${exp.description || '-'}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${String(exp.payment_method || '-').replace(/_/g, ' ').toUpperCase()}</td>
                                <td style="color: #d32f2f; font-weight: 600;">-${formatLkr(exp.amount)}</td>
                                <td><span class="status-badge ${statusClass}">${String(exp.status || 'pending').toUpperCase()}</span></td>
                            </tr>
                        `;
                    }).join('');

                    container.innerHTML = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    `;
                }

                document.getElementById('expenseCount').textContent = `${Number(pagination.total || 0).toLocaleString()} expenses found`;
                updatePagination();
            } catch (error) {
                console.error('Error loading expenses:', error);
                document.getElementById('expensesContainer').innerHTML = `<div style="text-align: center; padding: 40px; color: #d32f2f; background: #ffebee; border-radius: 6px;"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
            }
        }

        function updatePagination() {
            const container = document.getElementById('paginationContainer');
            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '';
            if (currentPage > 1) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px;" onclick="loadExpenses(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
            }

            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                const activeStyle = i === currentPage ? 'background: #222222; color: white; border-color: #222222;' : '';
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px; ${activeStyle}" onclick="loadExpenses(${i})">${i}</button>`;
            }

            if (currentPage < totalPages) {
                html += `<button style="padding: 6px 12px; border: 1px solid #e0e0e0; background: white; cursor: pointer; border-radius: 4px; font-size: 12px;" onclick="loadExpenses(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
            }

            container.innerHTML = html;
        }

        function filterExpenses() {
            loadExpenses(1);
        }

        function resetFilters() {
            document.getElementById('searchExpense').value = '';
            document.getElementById('filterStartDate').value = '';
            document.getElementById('filterEndDate').value = '';
            document.getElementById('filterCategory').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterPayment').value = '';
            loadExpenses(1);
        }

        function exportCurrentExpenses() {
            if (!currentRows.length) {
                showWarning('No expense rows to export.');
                return;
            }

            const rows = [
                ['expense_id', 'date', 'category', 'description', 'payment_method', 'amount', 'status', 'account_id', 'transaction_id'],
                ...currentRows.map(item => [
                    item.expense_id || '',
                    item.expense_date || '',
                    item.category || '',
                    item.description || '',
                    item.payment_method || '',
                    Number(item.amount || 0),
                    item.status || '',
                    item.account_id || '',
                    item.transaction_id || '',
                ]),
            ];

            const csv = rows.map(row => row.map(value => {
                const cell = String(value || '');
                return /[",\n]/.test(cell) ? `"${cell.replace(/"/g, '""')}"` : cell;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'expenses-export.csv';
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        }

        function openAddExpenseModal() {
            document.getElementById('expDate').valueAsDate = new Date();
            document.getElementById('addExpenseModal').classList.add('active');
        }

        function closeAddExpenseModal() {
            document.getElementById('addExpenseModal').classList.remove('active');
            document.getElementById('addExpenseForm').reset();
            renderExpenseAccountOptions();
        }

        async function saveExpense(event) {
            event.preventDefault();

            const payload = {
                category: document.getElementById('expCategory').value,
                amount: Number(document.getElementById('expAmount').value),
                expense_date: document.getElementById('expDate').value,
                description: document.getElementById('expDescription').value,
                payment_method: document.getElementById('expPaymentMethod').value,
                account_id: document.getElementById('expAccount').value,
                status: 'approved',
            };

            if (!payload.account_id) {
                showWarning('Please select an account.');
                return;
            }

            try {
                await requestJson(EXPENSE_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                showSuccess('Expense saved successfully.');
                closeAddExpenseModal();
                await loadSummary();
                await loadExpenses(1);
            } catch (error) {
                console.error('Error saving expense:', error);
                showError(`Error: ${error.message}`);
            }
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
                if (event.target === searchOverlay) closeSearchModal();
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

        document.getElementById('addExpenseBtn')?.addEventListener('click', openAddExpenseModal);
        document.getElementById('exportExpensesBtn')?.addEventListener('click', exportCurrentExpenses);
        document.getElementById('addExpenseCategoryBtn')?.addEventListener('click', async function() {
            try {
                await promptAndCreateExpenseCategory();
            } catch (error) {
                showError(`Unable to add category: ${error.message}`);
            }
        });

        document.getElementById('expPaymentMethod')?.addEventListener('change', renderExpenseAccountOptions);
        document.getElementById('searchExpense')?.addEventListener('input', function() { loadExpenses(1); });
        document.getElementById('filterStartDate')?.addEventListener('change', function() { loadExpenses(1); });
        document.getElementById('filterEndDate')?.addEventListener('change', function() { loadExpenses(1); });
        document.getElementById('filterCategory')?.addEventListener('change', function() { loadExpenses(1); });
        document.getElementById('filterStatus')?.addEventListener('change', function() { loadExpenses(1); });
        document.getElementById('filterPayment')?.addEventListener('change', function() { loadExpenses(1); });

        document.getElementById('addExpenseModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeAddExpenseModal();
        });

        document.addEventListener('DOMContentLoaded', async function() {
            try {
                await Promise.all([loadExpenseCategories(), loadVaultAccounts()]);
                renderExpenseAccountOptions();
                await Promise.all([loadSummary(), loadExpenses(1)]);
            } catch (error) {
                console.error('Error initializing expenses page:', error);
            }
        });
    </script>
</body>
</html>
