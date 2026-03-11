<?php
$activePage = 'customers';
$basePath = '../';
$pageTitle = 'Customers';
$pageSubtitle = 'Manage customers, invoices, and credit sales.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Customers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>
        <?php include __DIR__ . '/../../UI/custom-dialog.php'; ?>

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
                        <input type="text" id="searchCustomers" placeholder="Search by name, phone, email..." style="min-width: 300px;">
                        <select id="statusFilter" aria-label="Status">
                            <option>All Customers</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                        <select id="creditFilter" aria-label="Credit Status">
                            <option>All Credit Status</option>
                            <option>Has Outstanding</option>
                            <option>Fully Paid</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="add-customer.php">
                            <i class="fas fa-plus"></i>
                            Add Customer
                        </a>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Total Customers</h4>
                        <div class="metric-value" id="metricTotal">0</div>
                        <div class="metric-sub">Registered customers</div>
                    </div>
                    <div class="metric-card">
                        <h4>Active Customers</h4>
                        <div class="metric-value" id="metricActive" style="color: #4caf50;">0</div>
                        <div class="metric-sub">Recent purchases</div>
                    </div>
                    <div class="metric-card">
                        <h4>Outstanding Credit</h4>
                        <div class="metric-value" id="metricOutstanding" style="color: #ff9800;">LKR 0</div>
                        <div class="metric-sub">Pending payments</div>
                    </div>
                    <div class="metric-card">
                        <h4>Wholesale</h4>
                        <div class="metric-value" id="metricWholesale" style="color: #2196f3;">0</div>
                        <div class="metric-sub">Wholesale customers</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Customer Directory</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-filter="all">All</button>
                            <button class="pill" type="button" data-filter="active">Active</button>
                            <button class="pill" type="button" data-filter="wholesale">Wholesale</button>
                            <button class="pill" type="button" data-filter="credit">Has Credit</button>
                        </div>
                    </div>
                    <table style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Customer Name</th>
                                <th style="width: 12%;">Phone</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 12%;">Total Purchases</th>
                                <th style="width: 10%;">Credit Balance</th>
                                <th style="width: 10%;">Last Purchase</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 11%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customerTable">
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #1a237e;"></i>
                                    <p style="margin-top: 10px; color: #7a86ad;">Loading customers...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        const API_URL = 'http://localhost:3000/api/customers';
        let allCustomers = [];
        let filteredCustomers = [];
        let activePill = 'all';

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

        function getInitials(name) {
            if (!name) return 'CU';
            return name
                .split(' ')
                .filter(Boolean)
                .slice(0, 2)
                .map(part => part[0].toUpperCase())
                .join('');
        }

        function calculateSummary(customer) {
            const customerSales = Array.isArray(customer.customer_sales) ? customer.customer_sales : [];
            const salesHistory = Array.isArray(customer.sales) ? customer.sales : [];

            // Prefer sales table values for purchase timeline; ignore cancelled sales.
            const validSales = salesHistory.filter(sale => String(sale.status || '').toLowerCase() !== 'cancelled');
            const totalPurchases = validSales.reduce((sum, sale) => sum + parseFloat(sale.total_amount || 0), 0);

            const due = customerSales.reduce((sum, sale) => {
                if (sale.is_due_available && ['pending', 'overdue'].includes(String(sale.payment_status || '').toLowerCase())) {
                    return sum + (parseFloat(sale.total_sales_amount || 0) - parseFloat(sale.paid_amount || 0));
                }
                return sum;
            }, 0);

            const lastPurchase = validSales.length > 0
                ? validSales
                    .map(sale => sale.sales_date)
                    .filter(Boolean)
                    .sort()
                    .reverse()[0]
                : null;

            return {
                totalPurchases,
                due: Math.max(due, 0),
                lastPurchase
            };
        }

        function updateMetrics(stats) {
            const totalEl = document.getElementById('metricTotal');
            const activeEl = document.getElementById('metricActive');
            const outstandingEl = document.getElementById('metricOutstanding');
            const wholesaleEl = document.getElementById('metricWholesale');

            if (totalEl) totalEl.textContent = (stats?.total || 0).toLocaleString();
            if (activeEl) activeEl.textContent = (stats?.active || 0).toLocaleString();
            if (outstandingEl) outstandingEl.textContent = 'LKR ' + (stats?.totalOutstandingDues || 0).toLocaleString();
            if (wholesaleEl) wholesaleEl.textContent = (stats?.wholesale || 0).toLocaleString();
        }

        function renderCustomers(customers) {
            const tbody = document.getElementById('customerTable');
            if (!tbody) return;

            if (!customers.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            <i class="fas fa-user-slash" style="font-size: 42px; color: #c0c8df;"></i>
                            <p style="margin-top: 10px; color: #7a86ad;">No customers found</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = customers.map(customer => {
                const summary = calculateSummary(customer);
                const status = (customer.status || 'inactive').toLowerCase();
                const type = (customer.type || 'regular').toLowerCase();
                const hasCredit = summary.due > 0;

                const statusStyle = status === 'active'
                    ? 'background: #e1f7e3; color: #0d6832;'
                    : 'background: #f5f5f5; color: #757575;';

                const badgeText = type === 'wholesale' ? 'Wholesale' : (status === 'active' ? 'Active' : 'Inactive');

                const lastPurchase = summary.lastPurchase
                    ? new Date(summary.lastPurchase).toISOString().slice(0, 10)
                    : 'N/A';

                return `
                    <tr data-status="${status}" data-type="${type}" data-credit="${hasCredit ? 'has' : 'none'}">
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 600;">
                                    ${getInitials(customer.name)}
                                </div>
                                <div>
                                    <strong style="display: block; color: #1a237e;">${customer.name || 'Unknown'}</strong>
                                    <span style="font-size: 12px; color: #7a86ad;">Customer #${customer.customer_id || 'N/A'}</span>
                                </div>
                            </div>
                        </td>
                        <td>${customer.phone_number || 'N/A'}</td>
                        <td>${customer.email || 'N/A'}</td>
                        <td><strong>LKR ${summary.totalPurchases.toLocaleString()}</strong></td>
                        <td><strong style="color: ${hasCredit ? '#ff9800' : '#4caf50'};">LKR ${summary.due.toLocaleString()}</strong></td>
                        <td>${lastPurchase}</td>
                        <td><span class="status-badge" style="${statusStyle}">${badgeText}</span></td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="button-secondary view-btn" style="padding: 6px 10px; font-size: 12px;" title="View Details" data-id="${customer.customer_id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="button-secondary edit-btn" style="padding: 6px 10px; font-size: 12px;" title="Edit" data-id="${customer.customer_id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="button-secondary delete-btn" style="padding: 6px 10px; font-size: 12px; background: #ffebee; color: #c62828;" title="Delete" data-id="${customer.customer_id}" data-name="${customer.name || 'Customer'}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async function fetchCustomers() {
            try {
                const response = await fetch(API_URL);
                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.error || result.message || 'Failed to fetch customers');
                }

                allCustomers = result.data || [];
                filteredCustomers = [...allCustomers];
                updateMetrics(result.stats || {});
                applyFilters();
            } catch (error) {
                const table = document.getElementById('customerTable');
                if (table) {
                    table.innerHTML = `
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 42px; color: #f44336;"></i>
                                <p style="margin-top: 10px; color: #f44336;">${error.message}</p>
                            </td>
                        </tr>
                    `;
                }
            }
        }

        function applyFilters() {
            const searchValue = (document.getElementById('searchCustomers')?.value || '').toLowerCase();
            const statusValue = (document.getElementById('statusFilter')?.value || 'All Customers').toLowerCase();
            const creditValue = (document.getElementById('creditFilter')?.value || 'All Credit Status').toLowerCase();

            const result = allCustomers.filter(customer => {
                const summary = calculateSummary(customer);
                const status = (customer.status || '').toLowerCase();
                const type = (customer.type || '').toLowerCase();
                const hasCredit = summary.due > 0;

                const matchesSearch = !searchValue || [
                    customer.customer_id,
                    customer.name,
                    customer.email,
                    customer.phone_number,
                    customer.atlernative_phone_number,
                    customer.nic_or_passport_number,
                ].filter(Boolean).some(value => value.toLowerCase().includes(searchValue));

                let matchesPill = true;
                if (activePill === 'active') matchesPill = status === 'active';
                if (activePill === 'wholesale') matchesPill = type === 'wholesale';
                if (activePill === 'credit') matchesPill = hasCredit;

                let matchesStatus = true;
                if (statusValue === 'active') matchesStatus = status === 'active';
                if (statusValue === 'inactive') matchesStatus = status === 'inactive';

                let matchesCredit = true;
                if (creditValue === 'has outstanding') matchesCredit = hasCredit;
                if (creditValue === 'fully paid') matchesCredit = !hasCredit;

                return matchesSearch && matchesPill && matchesStatus && matchesCredit;
            });

            filteredCustomers = result;
            renderCustomers(filteredCustomers);
        }

        document.addEventListener('click', async function(event) {
            const viewBtn = event.target.closest('.view-btn');
            if (viewBtn) {
                const customerId = viewBtn.dataset.id;
                const customer = allCustomers.find(c => c.customer_id === customerId);
                if (!customer || !window.AppDialog) return;

                const summary = calculateSummary(customer);
                const detailsHtml = `
                    <div class="app-dialog-section">
                        <div class="app-dialog-section-title">PROFILE</div>
                        <div class="app-dialog-row"><strong>ID:</strong> <code>${customer.customer_id}</code></div>
                        <div class="app-dialog-row"><strong>Name:</strong> ${customer.name || 'N/A'}</div>
                        <div class="app-dialog-row"><strong>Type:</strong> ${customer.type || 'N/A'}</div>
                        <div class="app-dialog-row"><strong>Status:</strong> <span class="app-dialog-pill">${customer.status || 'N/A'}</span></div>
                    </div>
                    <div class="app-dialog-section">
                        <div class="app-dialog-section-title">CONTACT</div>
                        <div class="app-dialog-row"><strong>Phone:</strong> ${customer.phone_number || 'N/A'}</div>
                        <div class="app-dialog-row"><strong>Alt Phone:</strong> ${customer.atlernative_phone_number || 'N/A'}</div>
                        <div class="app-dialog-row"><strong>Email:</strong> ${customer.email || 'N/A'}</div>
                        <div class="app-dialog-row"><strong>NIC/Passport:</strong> ${customer.nic_or_passport_number || 'N/A'}</div>
                    </div>
                    <div class="app-dialog-section">
                        <div class="app-dialog-section-title">FINANCIAL</div>
                        <div class="app-dialog-row"><strong>Total Purchases:</strong> LKR ${summary.totalPurchases.toLocaleString()}</div>
                        <div class="app-dialog-row"><strong>Credit Balance:</strong> LKR ${summary.due.toLocaleString()}</div>
                        <div class="app-dialog-row"><strong>Last Purchase:</strong> ${summary.lastPurchase ? new Date(summary.lastPurchase).toISOString().slice(0, 10) : 'N/A'}</div>
                        <div class="app-dialog-row"><strong>Credit Limit:</strong> LKR ${parseFloat(customer.credit_limit || 0).toLocaleString()}</div>
                        <div class="app-dialog-row"><strong>Credit Days:</strong> ${customer.credit_days || 0}</div>
                    </div>
                    <div class="app-dialog-section">
                        <div class="app-dialog-section-title">ADDRESS</div>
                        <div class="app-dialog-row">${[customer.address, customer.city, customer.district, customer.postal_code, customer.country].filter(Boolean).join(', ') || 'N/A'}</div>
                    </div>
                `;

                window.AppDialog.open({
                    title: customer.name || 'Customer Details',
                    html: detailsHtml
                });
                return;
            }

            const editBtn = event.target.closest('.edit-btn');
            if (editBtn) {
                window.location.href = `edit-customer.php?id=${encodeURIComponent(editBtn.dataset.id)}`;
                return;
            }

            const deleteBtn = event.target.closest('.delete-btn');
            if (deleteBtn) {
                const customerId = deleteBtn.dataset.id;
                const customerName = deleteBtn.dataset.name;

                const confirmation = await Swal.fire({
                    icon: 'warning',
                    title: 'Delete Customer?',
                    html: `Delete <strong>${customerName}</strong> (${customerId})?<br><br><small style="color:#f44336;">This will also remove related sales records.</small>`,
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33'
                });

                if (!confirmation.isConfirmed) return;

                try {
                    const response = await fetch(`${API_URL}/${customerId}`, { method: 'DELETE' });
                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.error || result.message || 'Failed to delete customer');
                    }

                    await Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Customer deleted successfully.'
                    });

                    fetchCustomers();
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: error.message
                    });
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetchCustomers();

            const searchInput = document.getElementById('searchCustomers');
            if (searchInput) searchInput.addEventListener('input', applyFilters);

            const statusFilter = document.getElementById('statusFilter');
            const creditFilter = document.getElementById('creditFilter');
            if (statusFilter) statusFilter.addEventListener('change', applyFilters);
            if (creditFilter) creditFilter.addEventListener('change', applyFilters);

            const pills = document.querySelectorAll('.pill[data-filter]');
            pills.forEach(pill => {
                pill.addEventListener('click', function() {
                    pills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    activePill = this.dataset.filter;
                    applyFilters();
                });
            });
        });
    </script>
</body>
</html>
