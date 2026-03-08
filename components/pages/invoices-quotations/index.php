<?php
$activePage = 'invoices-quotations';
$basePath = '../';
$pageTitle = 'Invoices';
$pageSubtitle = 'View, manage, and re-print invoices from sales records.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Invoices</title>
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
                        <input type="text" class="search-input" placeholder="Search by invoice number, customer, or payment method..." id="searchInvoice" style="width: 360px;">
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <select class="filter-select" id="filterPayment">
                            <option value="">All Payments</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="mobile">Mobile</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                        <input type="date" id="startDate" aria-label="Start date">
                        <input type="date" id="endDate" aria-label="End date">
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="../sales/create.php">
                            <i class="fas fa-plus"></i>
                            New Invoice
                        </a>
                        <button class="button-secondary" type="button" id="exportBtn">
                            <i class="fas fa-download"></i>
                            Export CSV
                        </button>
                    </div>
                </div>

                <div class="cards-row">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #3f51b5 0%, #1a237e 100%);">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Invoices</div>
                            <div class="metric-value" id="totalInvoicesValue">0</div>
                            <div class="metric-change" id="totalInvoicesSub">In selected range</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Completed Invoices</div>
                            <div class="metric-value" id="completedInvoicesValue">0</div>
                            <div class="metric-change" id="completedInvoicesSub">Ready for printing</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Revenue (Invoiced)</div>
                            <div class="metric-value" id="totalRevenueValue">LKR 0.00</div>
                            <div class="metric-change" id="totalRevenueSub">From filtered invoices</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Pending / Cancelled</div>
                            <div class="metric-value" id="attentionInvoicesValue">0</div>
                            <div class="metric-change" id="attentionInvoicesSub" style="color: #f44336;">Needs action</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All</button>
                    <button class="pill" data-filter="completed">Completed</button>
                    <button class="pill" data-filter="pending">Pending</button>
                    <button class="pill" data-filter="cancelled">Cancelled</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 14%;">Invoice No.</th>
                                <th style="width: 18%;">Customer</th>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 12%;">Amount</th>
                                <th style="width: 10%;">Discount</th>
                                <th style="width: 10%;">Payment</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 16%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                            <tr>
                                <td colspan="8" style="text-align: center; color: #7a86ad;">Loading invoices...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="search-overlay" id="invoiceDetailModal" role="dialog" aria-modal="true" aria-label="Invoice details">
        <div class="search-dialog" role="document" style="max-width: 980px; width: min(980px, 96vw);">
            <div class="search-dialog-header">
                <i class="fas fa-file-invoice"></i>
                <button class="search-close" type="button" id="invoiceDetailClose" aria-label="Close invoice details">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="invoiceDetailContent" style="max-height: 70vh; overflow: auto; color: #22315b;"></div>
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

        const API_BASE_URL = 'http://localhost:3000/api';
        const SALES_API = `${API_BASE_URL}/sales`;

        const searchInput = document.getElementById('searchInvoice');
        const statusFilter = document.getElementById('filterStatus');
        const paymentFilter = document.getElementById('filterPayment');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const tableBody = document.getElementById('invoiceTableBody');
        const pills = document.querySelectorAll('.pill');
        const exportBtn = document.getElementById('exportBtn');

        const totalInvoicesValue = document.getElementById('totalInvoicesValue');
        const totalInvoicesSub = document.getElementById('totalInvoicesSub');
        const completedInvoicesValue = document.getElementById('completedInvoicesValue');
        const completedInvoicesSub = document.getElementById('completedInvoicesSub');
        const totalRevenueValue = document.getElementById('totalRevenueValue');
        const totalRevenueSub = document.getElementById('totalRevenueSub');
        const attentionInvoicesValue = document.getElementById('attentionInvoicesValue');
        const attentionInvoicesSub = document.getElementById('attentionInvoicesSub');

        const invoiceDetailModal = document.getElementById('invoiceDetailModal');
        const invoiceDetailClose = document.getElementById('invoiceDetailClose');
        const invoiceDetailContent = document.getElementById('invoiceDetailContent');

        let invoices = [];
        let activePill = 'all';

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function formatDate(dateValue) {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) {
                return '-';
            }
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
        }

        function statusBadge(status) {
            const current = (status || '').toLowerCase();
            if (current === 'completed') {
                return '<span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Completed</span>';
            }
            if (current === 'pending') {
                return '<span class="status-badge" style="background: #fff3e0; color: #ef6c00;">Pending</span>';
            }
            if (current === 'cancelled') {
                return '<span class="status-badge" style="background: #ffebee; color: #c62828;">Cancelled</span>';
            }
            return `<span class="status-badge" style="background: #eceff1; color: #455a64;">${status || 'Unknown'}</span>`;
        }

        function buildDateQuery() {
            const params = new URLSearchParams();
            params.set('page', '1');
            params.set('limit', '300');

            if (startDateInput.value) {
                params.set('start_date', startDateInput.value);
            }
            if (endDateInput.value) {
                params.set('end_date', endDateInput.value);
            }

            return params;
        }

        async function loadInvoices() {
            try {
                tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: #7a86ad;">Loading invoices...</td></tr>';
                const response = await fetch(`${SALES_API}?${buildDateQuery().toString()}`);
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || result.message || 'Failed to load invoices');
                }

                invoices = result.sales || [];
                renderInvoices();
            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: #d32f2f;">${error.message}</td></tr>`;
            }
        }

        function getFilteredInvoices() {
            const searchTerm = (searchInput.value || '').toLowerCase().trim();
            const statusValue = (statusFilter.value || '').toLowerCase().trim();
            const paymentValue = (paymentFilter.value || '').toLowerCase().trim();

            return invoices.filter(invoice => {
                const invoiceNo = (invoice.sales_id || '').toLowerCase();
                const customerName = (invoice.customer?.name || 'Walk-in Customer').toLowerCase();
                const paymentMethod = (invoice.payment_method || '').toLowerCase();
                const invoiceStatus = (invoice.status || '').toLowerCase();

                const matchesSearch =
                    !searchTerm ||
                    invoiceNo.includes(searchTerm) ||
                    customerName.includes(searchTerm) ||
                    paymentMethod.includes(searchTerm);

                const matchesStatusDropdown = !statusValue || invoiceStatus === statusValue;
                const matchesPayment = !paymentValue || paymentMethod === paymentValue;
                const matchesPill = activePill === 'all' || invoiceStatus === activePill;

                return matchesSearch && matchesStatusDropdown && matchesPayment && matchesPill;
            });
        }

        function renderMetrics(filteredInvoices) {
            const totalInvoices = filteredInvoices.length;
            const completedInvoices = filteredInvoices.filter(inv => (inv.status || '').toLowerCase() === 'completed').length;
            const pendingOrCancelled = filteredInvoices.filter(inv => {
                const status = (inv.status || '').toLowerCase();
                return status === 'pending' || status === 'cancelled';
            }).length;
            const totalRevenue = filteredInvoices.reduce((sum, inv) => sum + Number(inv.total_amount || 0), 0);

            totalInvoicesValue.textContent = totalInvoices.toLocaleString();
            totalInvoicesSub.textContent = `Showing ${totalInvoices.toLocaleString()} invoice(s)`;
            completedInvoicesValue.textContent = completedInvoices.toLocaleString();
            completedInvoicesSub.textContent = `${totalInvoices > 0 ? ((completedInvoices / totalInvoices) * 100).toFixed(1) : '0.0'}% completion`;
            totalRevenueValue.textContent = formatLkr(totalRevenue);
            totalRevenueSub.textContent = 'From current filters';
            attentionInvoicesValue.textContent = pendingOrCancelled.toLocaleString();
            attentionInvoicesSub.textContent = `${pendingOrCancelled.toLocaleString()} invoice(s) need action`;
        }

        function renderInvoiceTable(filteredInvoices) {
            if (!filteredInvoices.length) {
                tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: #7a86ad;">No invoices found for selected filters.</td></tr>';
                return;
            }

            tableBody.innerHTML = filteredInvoices.map(invoice => {
                const invoiceNo = invoice.sales_id || '-';
                const customerName = invoice.customer?.name || 'Walk-in Customer';
                const amount = Number(invoice.total_amount || 0);
                const discount = Number(invoice.total_discount || 0);
                const paymentMethod = invoice.payment_method || '-';
                const status = invoice.status || 'unknown';
                const itemCount = Array.isArray(invoice.items) ? invoice.items.length : 0;

                return `
                    <tr data-status="${status.toLowerCase()}">
                        <td><strong>${invoiceNo}</strong><br><small style="color:#7a86ad;">${itemCount} item(s)</small></td>
                        <td>${customerName}</td>
                        <td>${formatDate(invoice.sales_date)}</td>
                        <td><strong>${formatLkr(amount)}</strong></td>
                        <td>${formatLkr(discount)}</td>
                        <td style="text-transform: capitalize;">${paymentMethod.replace('_', ' ')}</td>
                        <td>${statusBadge(status)}</td>
                        <td>
                            <button class="icon-btn" type="button" title="View" data-action="view" data-id="${invoiceNo}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="icon-btn" type="button" title="Print" data-action="print" data-id="${invoiceNo}">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderInvoices() {
            const filteredInvoices = getFilteredInvoices();
            renderMetrics(filteredInvoices);
            renderInvoiceTable(filteredInvoices);
        }

        function openInvoiceDetails(invoiceId) {
            const invoice = invoices.find(item => item.sales_id === invoiceId);
            if (!invoice) {
                return;
            }

            const customerName = invoice.customer?.name || 'Walk-in Customer';
            const customerPhone = invoice.customer?.phone_number || '-';
            const items = Array.isArray(invoice.items) ? invoice.items : [];

            const itemsHtml = items.length
                ? items.map(item => `
                    <tr>
                        <td>${item.product?.productName || item.product_id || '-'}</td>
                        <td>${item.quantity || 0}</td>
                        <td>${formatLkr(item.unit_price || 0)}</td>
                        <td>${formatLkr(item.discount || 0)}</td>
                        <td>${formatLkr(item.total_price || 0)}</td>
                    </tr>
                `).join('')
                : '<tr><td colspan="5" style="text-align:center; color:#7a86ad;">No item details available.</td></tr>';

            invoiceDetailContent.innerHTML = `
                <div style="display:grid; gap: 14px;">
                    <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap: 12px;">
                        <div>
                            <h3 style="margin:0; color:#1e2f5c;">Invoice ${invoice.sales_id || '-'}</h3>
                            <small style="color:#6074a6;">${formatDate(invoice.sales_date)}</small>
                        </div>
                        <div>${statusBadge(invoice.status || 'unknown')}</div>
                    </div>
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 8px;">
                        <div><strong>Customer:</strong> ${customerName}</div>
                        <div><strong>Phone:</strong> ${customerPhone}</div>
                        <div><strong>Payment:</strong> ${(invoice.payment_method || '-').replace('_', ' ')}</div>
                        <div><strong>Total Discount:</strong> ${formatLkr(invoice.total_discount || 0)}</div>
                    </div>
                    <div style="overflow:auto; border:1px solid #d7dff3; border-radius:10px;">
                        <table style="width:100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background:#f7f9ff;">
                                    <th style="text-align:left; padding:10px;">Item</th>
                                    <th style="text-align:left; padding:10px;">Qty</th>
                                    <th style="text-align:left; padding:10px;">Unit Price</th>
                                    <th style="text-align:left; padding:10px;">Discount</th>
                                    <th style="text-align:left; padding:10px;">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>${itemsHtml}</tbody>
                        </table>
                    </div>
                    <div style="display:flex; justify-content:flex-end; font-size:1.1rem; color:#1e2f5c;">
                        <strong>Invoice Total: ${formatLkr(invoice.total_amount || 0)}</strong>
                    </div>
                </div>
            `;

            invoiceDetailModal.classList.add('active');
        }

        function closeInvoiceDetails() {
            invoiceDetailModal.classList.remove('active');
        }

        function exportCsv() {
            const filteredInvoices = getFilteredInvoices();
            if (!filteredInvoices.length) {
                return;
            }

            const headers = ['Invoice No', 'Customer', 'Date', 'Amount', 'Discount', 'Payment Method', 'Status'];
            const rows = filteredInvoices.map(inv => [
                inv.sales_id || '',
                inv.customer?.name || 'Walk-in Customer',
                formatDate(inv.sales_date),
                Number(inv.total_amount || 0).toFixed(2),
                Number(inv.total_discount || 0).toFixed(2),
                inv.payment_method || '',
                inv.status || '',
            ]);

            const csvText = [headers, ...rows]
                .map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(','))
                .join('\n');

            const blob = new Blob([csvText], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `invoices-${new Date().toISOString().slice(0, 10)}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);
        }

        searchInput.addEventListener('input', renderInvoices);
        statusFilter.addEventListener('change', renderInvoices);
        paymentFilter.addEventListener('change', renderInvoices);
        startDateInput.addEventListener('change', loadInvoices);
        endDateInput.addEventListener('change', loadInvoices);

        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                activePill = this.dataset.filter || 'all';
                renderInvoices();
            });
        });

        tableBody.addEventListener('click', function(event) {
            const button = event.target.closest('button[data-action]');
            if (!button) {
                return;
            }

            const action = button.getAttribute('data-action');
            const invoiceId = button.getAttribute('data-id');

            if (action === 'view') {
                openInvoiceDetails(invoiceId);
                return;
            }

            if (action === 'print') {
                openInvoiceDetails(invoiceId);
                setTimeout(() => window.print(), 200);
            }
        });

        if (invoiceDetailClose) {
            invoiceDetailClose.addEventListener('click', closeInvoiceDetails);
        }

        if (invoiceDetailModal) {
            invoiceDetailModal.addEventListener('click', function(event) {
                if (event.target === invoiceDetailModal) {
                    closeInvoiceDetails();
                }
            });
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', exportCsv);
        }

        const today = new Date();
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() - 7);
        const toDateString = (d) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
        startDateInput.value = toDateString(weekStart);
        endDateInput.value = toDateString(today);

        loadInvoices();
    </script>
</body>
</html>
