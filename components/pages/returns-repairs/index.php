<?php
$activePage = 'returns-repairs';
$basePath = '../';
$pageTitle = 'Returns & Repairs';
$pageSubtitle = 'Manage return products and mobile phone repairs.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#111111">
    <meta name="description" content="Manage return products and repairs">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Returns & Repairs</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%23111111' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .ticket-modal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
        }
        .ticket-section {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 14px;
            background: #f9fbff;
        }
        .ticket-section h4 {
            margin: 0 0 10px 0;
            color: #111111;
            font-size: 14px;
            font-weight: 700;
        }
        .ticket-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .ticket-field label {
            font-size: 12px;
            color: #42507a;
            font-weight: 600;
        }
        .ticket-field input,
        .ticket-field select,
        .ticket-field textarea {
            border: 2px solid #dbe2ff;
            border-radius: 8px;
            padding: 9px;
            font-size: 13px;
            color: #111111;
            background: white;
            outline: none;
        }
        .ticket-field textarea {
            min-height: 68px;
            resize: vertical;
        }
        .parts-list {
            display: grid;
            gap: 8px;
        }
        .part-row {
            display: grid;
            grid-template-columns: 1.8fr 0.7fr 1fr auto;
            gap: 8px;
            align-items: center;
        }
        .part-row button {
            border: 1px solid #ffcdd2;
            background: #fff5f5;
            color: #d32f2f;
            border-radius: 8px;
            padding: 8px;
            cursor: pointer;
        }
        .section-title {
            margin: 14px 0 10px 0;
            color: #111111;
            font-size: 15px;
            font-weight: 700;
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
                        <input type="text" class="search-input" placeholder="Search by customer, device, or ticket..." id="searchRepair" style="width: 300px;">
                        <select class="filter-select" id="filterType">
                            <option value="">All Types</option>
                            <option value="return">Return</option>
                            <option value="repair">Repair</option>
                        </select>
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button" id="newTicketBtn">
                            <i class="fas fa-plus"></i>
                            New Ticket
                        </button>
                        <button class="button-secondary" type="button" id="exportTicketsBtn">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="cards-row">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #222222 0%, #444444 100%);">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Tickets</div>
                            <div class="metric-value" id="metricTotal">0</div>
                            <div class="metric-change positive">Live count</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">In Progress</div>
                            <div class="metric-value" id="metricInProgress">0</div>
                            <div class="metric-change">Pending repair</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Pending</div>
                            <div class="metric-value" id="metricPending">0</div>
                            <div class="metric-change" style="color: #ff9800;">Customer action needed</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Completed (Month)</div>
                            <div class="metric-value" id="metricCompletedMonth">0</div>
                            <div class="metric-change positive">Current month</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills">
                    <button class="pill active" data-filter="all">All Tickets</button>
                    <button class="pill" data-filter="pending_repair">Pending Repair</button>
                    <button class="pill" data-filter="customer_action_needed">Customer Action Needed</button>
                    <button class="pill" data-filter="repair_completed_pending_pickup">Repair Done (Pickup)</button>
                    <button class="pill" data-filter="completed">Completed</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Ticket #</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 15%;">Customer</th>
                                <th style="width: 15%;">Device</th>
                                <th style="width: 15%;">Device Details</th>
                                <th style="width: 15%;">Issue / Reason</th>
                                <th style="width: 10%;">Date Received</th>
                                <th style="width: 10%;">Est. Completion</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="repairTableBody"></tbody>
                    </table>
                </div>

                <h3 class="section-title">Not Usable Returns (Send Back to Supplier)</h3>
                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Device</th>
                                <th>IMEI / Barcode</th>
                                <th>Reason</th>
                                <th>Supplier</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="unusableTableBody"></tbody>
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
        const API_BASE_URL = 'http://localhost:3000/api';
        const RETURNS_API = `${API_BASE_URL}/returns-repairs`;
        const PRODUCTS_API = `${API_BASE_URL}/products`;
        const SUPPLIERS_API = `${API_BASE_URL}/suppliers`;

        const STATUS_LABELS = {
            pending_repair: 'Pending Repair',
            customer_action_needed: 'Customer Action Needed',
            repair_completed_pending_pickup: 'Repair Completed (Pending Customer Pickup)',
            returned_to_supplier_pending_arrival: 'Returned to Supplier (Pending Arrival)',
            came_from_supplier_pending_pickup: 'Came from Supplier (Pending Customer Pickup)',
            cannot_repair: 'Cannot Repair',
            completed: 'Completed',
        };

        let statuses = [];
        let ticketsCache = [];
        let activePill = 'all';
        let productsCache = [];
        let suppliersCache = [];

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function formatDate(value) {
            const date = new Date(value);
            if (Number.isNaN(date.getTime())) return '-';
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
        }

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function titleCase(value) {
            return String(value || '').replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function getStatusStyle(status) {
            const styles = {
                pending_repair: 'background:#fff3e0;color:#ef6c00;',
                customer_action_needed: 'background:#ffebee;color:#c62828;',
                repair_completed_pending_pickup: 'background:#e8f5e9;color:#2e7d32;',
                returned_to_supplier_pending_arrival: 'background:#ede7f6;color:#5e35b1;',
                came_from_supplier_pending_pickup: 'background:#e0f2f1;color:#00695c;',
                cannot_repair: 'background:#eceff1;color:#455a64;',
                completed: 'background:#e8f5e9;color:#1b5e20;',
            };
            return styles[status] || 'background:#eceff1;color:#455a64;';
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

        function showNotice(message) {
            return Swal.fire({
                icon: 'info',
                title: 'Notice',
                text: message,
                confirmButtonColor: '#111111',
            });
        }

        async function loadStatusOptions() {
            const result = await requestJson(`${RETURNS_API}/statuses`);
            statuses = Array.isArray(result.data) ? result.data : [];

            const statusFilter = document.getElementById('filterStatus');
            statusFilter.innerHTML = '<option value="">All Status</option>' + statuses.map((status) =>
                `<option value="${status}">${escapeHtml(STATUS_LABELS[status] || titleCase(status))}</option>`
            ).join('');
        }

        async function loadReferenceData() {
            const [productsRes, suppliersRes] = await Promise.all([
                requestJson(`${PRODUCTS_API}?limit=1000`).catch(() => ({ data: [] })),
                requestJson(SUPPLIERS_API).catch(() => ({ data: [] })),
            ]);

            productsCache = Array.isArray(productsRes.data) ? productsRes.data : [];
            suppliersCache = Array.isArray(suppliersRes.data) ? suppliersRes.data : [];
        }

        function renderTickets(rows) {
            const tableBody = document.getElementById('repairTableBody');

            if (!rows.length) {
                tableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 18px; color:#7a86ad;">No tickets found.</td></tr>';
                return;
            }

            tableBody.innerHTML = rows.map((ticket) => `
                <tr data-type="${escapeHtml(ticket.ticket_type)}" data-status="${escapeHtml(ticket.status)}">
                    <td><strong>${escapeHtml(ticket.ticket_id)}</strong></td>
                    <td><span class="status-badge" style="${ticket.ticket_type === 'return' ? 'background:#e8f5e9;color:#2e7d32;' : 'background:#f3f4f6;color:#1976d2;'}">${escapeHtml(titleCase(ticket.ticket_type))}</span></td>
                    <td>${escapeHtml(ticket.customer_name || '-')}</td>
                    <td>${escapeHtml(ticket.device_name || '-')}</td>
                    <td>
                        <div><strong>IMEI:</strong> ${escapeHtml(ticket.imei || '-')}</div>
                        <div><strong>Barcode:</strong> ${escapeHtml(ticket.barcode || '-')}</div>
                        <div><strong>Serial:</strong> ${escapeHtml(ticket.serial_number || '-')}</div>
                    </td>
                    <td>${escapeHtml(ticket.ticket_type === 'return' ? (ticket.return_reason || '-') : (ticket.issue_description || '-'))}</td>
                    <td>${formatDate(ticket.received_date)}</td>
                    <td>${formatDate(ticket.estimated_completion_date)}</td>
                    <td><span class="status-badge" style="${getStatusStyle(ticket.status)}">${escapeHtml(STATUS_LABELS[ticket.status] || titleCase(ticket.status))}</span></td>
                    <td>
                        <button class="icon-btn" title="View Details" onclick="openTicketDetailsModal('${escapeHtml(ticket.ticket_id)}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="icon-btn" title="Edit Ticket" onclick="openEditTicketDialog('${escapeHtml(ticket.ticket_id)}')">
                            <i class="fas fa-pen"></i>
                        </button>
                        ${ticket.ticket_type === 'repair' ? `
                            <button class="icon-btn" title="Print Sticker" onclick="printRepairSticker('${escapeHtml(ticket.ticket_id)}')">
                                <i class="fas fa-tag"></i>
                            </button>
                            <button class="icon-btn" title="Print Repair Ticket" onclick="printRepairCustomerTicket('${escapeHtml(ticket.ticket_id)}')">
                                <i class="fas fa-print"></i>
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');
        }

        function getTicketById(ticketId) {
            return ticketsCache.find((ticket) => String(ticket.ticket_id) === String(ticketId)) || null;
        }

        function openTicketDetailsModal(ticketId) {
            const ticket = getTicketById(ticketId);
            if (!ticket) {
                showError('Ticket not found.');
                return;
            }

            const issueOrReason = ticket.ticket_type === 'return'
                ? (ticket.return_reason || '-')
                : (ticket.issue_description || '-');

            const repairParts = Array.isArray(ticket.parts) ? ticket.parts : [];
            const partsHtml = repairParts.length
                ? `
                    <div style="margin-top:12px; border-top:1px solid #e5e9f5; padding-top:10px;">
                        <div style="font-weight:700; color:#111111; margin-bottom:8px;">Repair Parts</div>
                        <table style="width:100%; border-collapse:collapse; font-size:12px;">
                            <thead>
                                <tr>
                                    <th style="text-align:left; border-bottom:1px solid #d9dff2; padding:6px 4px;">Part</th>
                                    <th style="text-align:left; border-bottom:1px solid #d9dff2; padding:6px 4px;">Qty</th>
                                    <th style="text-align:left; border-bottom:1px solid #d9dff2; padding:6px 4px;">Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${repairParts.map((part) => `
                                    <tr>
                                        <td style="border-bottom:1px solid #eef2ff; padding:6px 4px;">${escapeHtml(part.part_name || '-')}</td>
                                        <td style="border-bottom:1px solid #eef2ff; padding:6px 4px;">${escapeHtml(part.quantity || 0)}</td>
                                        <td style="border-bottom:1px solid #eef2ff; padding:6px 4px;">${escapeHtml(formatLkr(part.part_cost || 0))}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `
                : '';

            const html = `
                <div style="text-align:left; font-size:13px; color:#243257; line-height:1.45;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px 14px;">
                        <div><strong>Ticket #:</strong> ${escapeHtml(ticket.ticket_id || '-')}</div>
                        <div><strong>Type:</strong> ${escapeHtml(titleCase(ticket.ticket_type || '-'))}</div>
                        <div><strong>Status:</strong> ${escapeHtml(STATUS_LABELS[ticket.status] || titleCase(ticket.status))}</div>
                        <div><strong>Date Received:</strong> ${escapeHtml(formatDate(ticket.received_date))}</div>
                        <div><strong>Estimated Completion:</strong> ${escapeHtml(formatDate(ticket.estimated_completion_date))}</div>
                        <div><strong>Customer:</strong> ${escapeHtml(ticket.customer_name || '-')}</div>
                        <div><strong>Phone:</strong> ${escapeHtml(ticket.customer_phone || '-')}</div>
                        <div><strong>Email:</strong> ${escapeHtml(ticket.customer_email || '-')}</div>
                        <div><strong>Device:</strong> ${escapeHtml(ticket.device_name || '-')}</div>
                        <div><strong>IMEI:</strong> ${escapeHtml(ticket.imei || '-')}</div>
                        <div><strong>Barcode:</strong> ${escapeHtml(ticket.barcode || '-')}</div>
                        <div><strong>Serial Number:</strong> ${escapeHtml(ticket.serial_number || '-')}</div>
                        <div style="grid-column:1 / -1;"><strong>Issue / Reason:</strong> ${escapeHtml(issueOrReason)}</div>
                    </div>

                    ${ticket.ticket_type === 'return' ? `
                        <div style="margin-top:12px; border-top:1px solid #e5e9f5; padding-top:10px;">
                            <div style="font-weight:700; color:#111111; margin-bottom:8px;">Return Details</div>
                            <div><strong>Can Return to Stock:</strong> ${ticket.can_return_to_stock ? 'Yes' : 'No'}</div>
                            <div><strong>Return Stock Qty:</strong> ${escapeHtml(ticket.return_stock_qty || 0)}</div>
                            <div><strong>Usable Product:</strong> ${ticket.is_usable_product ? 'Yes' : 'No'}</div>
                            <div><strong>Send Back to Supplier:</strong> ${ticket.send_back_to_supplier ? 'Yes' : 'No'}</div>
                            <div><strong>Supplier:</strong> ${escapeHtml(ticket.supplier_name || '-')}</div>
                        </div>
                    ` : ''}

                    ${ticket.ticket_type === 'repair' ? `
                        <div style="margin-top:12px; border-top:1px solid #e5e9f5; padding-top:10px;">
                            <div style="font-weight:700; color:#111111; margin-bottom:8px;">Repair Details</div>
                            <div><strong>Repair Mode:</strong> ${escapeHtml(titleCase(ticket.repair_mode || '-'))}</div>
                            <div><strong>Repair Timeline:</strong> ${escapeHtml(ticket.repair_timeline || '-')}</div>
                            <div><strong>Repair Cost:</strong> ${escapeHtml(formatLkr(ticket.repair_cost || 0))}</div>
                            <div><strong>External Shop:</strong> ${escapeHtml(ticket.external_shop_name || '-')}</div>
                            <div><strong>External Shop Location:</strong> ${escapeHtml(ticket.external_shop_location || '-')}</div>
                            <div><strong>Action Note:</strong> ${escapeHtml(ticket.action_note || '-')}</div>
                        </div>
                        ${partsHtml}
                    ` : ''}
                </div>
            `;

            Swal.fire({
                title: `Ticket Details (${escapeHtml(ticket.ticket_id)})`,
                html,
                width: 900,
                confirmButtonText: 'Close',
                confirmButtonColor: '#111111',
            });
        }

        function createPrintWindow(title, bodyHtml, extraStyles = '') {
            const printWindow = window.open('', '_blank', 'width=900,height=700');
            if (!printWindow) {
                showError('Popup blocked. Please allow popups to print.');
                return null;
            }

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>${escapeHtml(title)}</title>
                    <style>
                        * { box-sizing: border-box; }
                        body {
                            margin: 0;
                            padding: 16px;
                            font-family: Arial, sans-serif;
                            color: #111;
                            background: #fff;
                        }
                        .print-card {
                            border: 2px solid #111;
                            border-radius: 8px;
                            padding: 12px;
                            width: 100%;
                        }
                        .print-title {
                            font-size: 18px;
                            font-weight: 700;
                            margin: 0 0 8px 0;
                        }
                        .print-subtitle {
                            font-size: 12px;
                            margin: 0 0 12px 0;
                            color: #333;
                        }
                        .print-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 8px 14px;
                        }
                        .print-item {
                            border-bottom: 1px dashed #bbb;
                            padding-bottom: 4px;
                        }
                        .print-label {
                            font-size: 11px;
                            color: #444;
                            margin-bottom: 2px;
                            text-transform: uppercase;
                            letter-spacing: 0.4px;
                        }
                        .print-value {
                            font-size: 13px;
                            font-weight: 600;
                            word-break: break-word;
                        }
                        .print-row-full {
                            grid-column: 1 / -1;
                        }
                        .cut-line {
                            margin-top: 18px;
                            border-top: 1px dashed #777;
                            padding-top: 8px;
                            font-size: 11px;
                            color: #555;
                            text-align: center;
                        }
                        ${extraStyles}
                        @media print {
                            body { padding: 0; }
                            .no-print { display: none !important; }
                        }
                    </style>
                </head>
                <body onload="window.print()">
                    ${bodyHtml}
                </body>
                </html>
            `);
            printWindow.document.close();
            return printWindow;
        }

        function printRepairSticker(ticketId) {
            const ticket = getTicketById(ticketId);
            if (!ticket || ticket.ticket_type !== 'repair') {
                showError('Repair ticket not found.');
                return;
            }

            const issueText = ticket.issue_description || ticket.return_reason || '-';
            const imeiOrBarcode = ticket.imei || ticket.barcode || '-';
            const bodyHtml = `
                <div class="print-card sticker-card">
                    <h1 class="print-title">Repair Device Sticker</h1>
                    <p class="print-subtitle">Attach this sticker to the repair device</p>
                    <div class="print-grid">
                        <div class="print-item"><div class="print-label">Ticket Number</div><div class="print-value">${escapeHtml(ticket.ticket_id || '-')}</div></div>
                        <div class="print-item"><div class="print-label">Date Received</div><div class="print-value">${escapeHtml(formatDate(ticket.received_date))}</div></div>
                        <div class="print-item"><div class="print-label">Customer Name</div><div class="print-value">${escapeHtml(ticket.customer_name || '-')}</div></div>
                        <div class="print-item"><div class="print-label">Customer Phone</div><div class="print-value">${escapeHtml(ticket.customer_phone || '-')}</div></div>
                        <div class="print-item"><div class="print-label">IMEI / Barcode</div><div class="print-value">${escapeHtml(imeiOrBarcode)}</div></div>
                        <div class="print-item"><div class="print-label">Estimated Completion</div><div class="print-value">${escapeHtml(formatDate(ticket.estimated_completion_date))}</div></div>
                        <div class="print-item print-row-full"><div class="print-label">Issue / Reason</div><div class="print-value">${escapeHtml(issueText)}</div></div>
                    </div>
                </div>
            `;

            createPrintWindow('Repair Device Sticker', bodyHtml, `
                @page { size: 100mm 70mm; margin: 4mm; }
                body { padding: 0; }
                .sticker-card { border-width: 1.5px; border-radius: 6px; padding: 8px; }
                .print-title { font-size: 14px; margin-bottom: 4px; }
                .print-subtitle { font-size: 10px; margin-bottom: 8px; }
                .print-label { font-size: 9px; }
                .print-value { font-size: 11px; }
                .print-grid { gap: 6px 8px; }
            `);
        }

        function printRepairCustomerTicket(ticketId) {
            const ticket = getTicketById(ticketId);
            if (!ticket || ticket.ticket_type !== 'repair') {
                showError('Repair ticket not found.');
                return;
            }

            const issueText = ticket.issue_description || ticket.return_reason || '-';
            const imeiOrBarcode = ticket.imei || ticket.barcode || '-';

            const bodyHtml = `
                <div class="print-card">
                    <h1 class="print-title">Repair Collection Slip</h1>
                    <p class="print-subtitle">Customer copy - keep this ticket for device collection</p>
                    <div class="print-grid">
                        <div class="print-item"><div class="print-label">Ticket Number</div><div class="print-value">${escapeHtml(ticket.ticket_id || '-')}</div></div>
                        <div class="print-item"><div class="print-label">Date Received</div><div class="print-value">${escapeHtml(formatDate(ticket.received_date))}</div></div>
                        <div class="print-item"><div class="print-label">Customer Name</div><div class="print-value">${escapeHtml(ticket.customer_name || '-')}</div></div>
                        <div class="print-item"><div class="print-label">Customer Phone</div><div class="print-value">${escapeHtml(ticket.customer_phone || '-')}</div></div>
                        <div class="print-item"><div class="print-label">Device Name</div><div class="print-value">${escapeHtml(ticket.device_name || '-')}</div></div>
                        <div class="print-item"><div class="print-label">IMEI / Barcode</div><div class="print-value">${escapeHtml(imeiOrBarcode)}</div></div>
                        <div class="print-item"><div class="print-label">Estimated Completion</div><div class="print-value">${escapeHtml(formatDate(ticket.estimated_completion_date))}</div></div>
                        <div class="print-item"><div class="print-label">Current Status</div><div class="print-value">${escapeHtml(STATUS_LABELS[ticket.status] || titleCase(ticket.status))}</div></div>
                        <div class="print-item print-row-full"><div class="print-label">Issue / Reason</div><div class="print-value">${escapeHtml(issueText)}</div></div>
                    </div>
                    <div class="cut-line">Present this ticket number when collecting your device.</div>
                </div>
            `;

            createPrintWindow('Repair Collection Slip', bodyHtml, '@page { size: A5 portrait; margin: 10mm; }');
        }

        function applyTicketFilters() {
            const searchInput = document.getElementById('searchRepair').value.toLowerCase();
            const filterType = document.getElementById('filterType').value;
            const filterStatus = document.getElementById('filterStatus').value;

            const filtered = ticketsCache.filter((ticket) => {
                const fullText = `${ticket.ticket_id} ${ticket.customer_name || ''} ${ticket.device_name || ''} ${ticket.imei || ''} ${ticket.barcode || ''} ${ticket.issue_description || ''} ${ticket.return_reason || ''}`.toLowerCase();
                const bySearch = !searchInput || fullText.includes(searchInput);
                const byType = !filterType || ticket.ticket_type === filterType;
                const byStatus = !filterStatus || ticket.status === filterStatus;
                const byPill = activePill === 'all' || ticket.status === activePill;
                return bySearch && byType && byStatus && byPill;
            });

            renderTickets(filtered);
        }

        async function loadTickets() {
            const result = await requestJson(RETURNS_API);
            ticketsCache = Array.isArray(result.data) ? result.data : [];
            applyTicketFilters();
        }

        async function loadSummary() {
            const result = await requestJson(`${RETURNS_API}/summary`);
            const data = result.data || {};

            document.getElementById('metricTotal').textContent = Number(data.total_tickets || 0).toLocaleString();
            document.getElementById('metricInProgress').textContent = Number(data.in_progress || 0).toLocaleString();
            document.getElementById('metricPending').textContent = Number(data.pending || 0).toLocaleString();
            document.getElementById('metricCompletedMonth').textContent = Number(data.completed_month || 0).toLocaleString();
        }

        async function loadUnusableReturns() {
            const result = await requestJson(`${RETURNS_API}/unusable-returns`);
            const rows = Array.isArray(result.data) ? result.data : [];
            const tbody = document.getElementById('unusableTableBody');

            if (!rows.length) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 18px; color:#7a86ad;">No unusable returns.</td></tr>';
                return;
            }

            tbody.innerHTML = rows.map((row) => `
                <tr>
                    <td>${escapeHtml(row.ticket_id)}</td>
                    <td>${escapeHtml(row.device_name || '-')}</td>
                    <td>${escapeHtml(row.imei || row.barcode || '-')}</td>
                    <td>${escapeHtml(row.return_reason || '-')}</td>
                    <td>${escapeHtml(row.supplier_name || '-')}</td>
                    <td><span class="status-badge" style="${getStatusStyle(row.status)}">${escapeHtml(STATUS_LABELS[row.status] || titleCase(row.status))}</span></td>
                </tr>
            `).join('');
        }

        function addPartRow() {
            const wrapper = document.getElementById('partsList');
            if (!wrapper) return;

            const row = document.createElement('div');
            row.className = 'part-row';
            row.innerHTML = `
                <input type="text" class="part-name" placeholder="Part name">
                <input type="number" class="part-qty" min="1" value="1">
                <input type="number" class="part-cost" min="0" step="0.01" placeholder="Cost">
                <button type="button" onclick="this.parentElement.remove()"><i class="fas fa-trash"></i></button>
            `;
            wrapper.appendChild(row);
        }

        function collectParts() {
            const rows = Array.from(document.querySelectorAll('#partsList .part-row'));
            return rows
                .map((row) => ({
                    part_name: row.querySelector('.part-name')?.value?.trim(),
                    quantity: parseInt(row.querySelector('.part-qty')?.value, 10) || 1,
                    part_cost: parseFloat(row.querySelector('.part-cost')?.value) || 0,
                }))
                .filter((part) => part.part_name);
        }

        function buildTicketModalHtml() {
            const statusOptions = statuses.map((status) => `<option value="${status}">${escapeHtml(STATUS_LABELS[status] || titleCase(status))}</option>`).join('');
            const supplierOptions = suppliersCache.map((supplier) =>
                `<option value="${escapeHtml(supplier.name || '')}">${escapeHtml(supplier.name || '')}</option>`
            ).join('');

            return `
                <div class="ticket-section">
                    <h4>Ticket Type</h4>
                    <div class="ticket-field">
                        <label>Choose Type</label>
                        <select id="ticketTypeSelect">
                            <option value="">Select...</option>
                            <option value="return">Return</option>
                            <option value="repair">Repair</option>
                        </select>
                    </div>
                </div>

                <div class="ticket-section">
                    <h4>Common Details</h4>
                    <div class="ticket-modal-grid">
                        <div class="ticket-field"><label>Status</label><select id="ticketStatus">${statusOptions}</select></div>
                        <div class="ticket-field"><label>Customer Name</label><input type="text" id="ticketCustomerName"></div>
                        <div class="ticket-field"><label>Customer Phone</label><input type="text" id="ticketCustomerPhone"></div>
                        <div class="ticket-field"><label>Customer Email</label><input type="text" id="ticketCustomerEmail"></div>
                        <div class="ticket-field"><label>Device Name</label><input type="text" id="ticketDeviceName"></div>
                        <div class="ticket-field"><label>IMEI</label><input type="text" id="ticketImei"></div>
                        <div class="ticket-field"><label>Barcode</label><input type="text" id="ticketBarcode"></div>
                        <div class="ticket-field"><label>Matched Product</label><select id="ticketProductSelect"><option value="">No product selected</option></select></div>
                        <div class="ticket-field"><label>Serial Number</label><input type="text" id="ticketSerial"></div>
                        <div class="ticket-field"><label>Received Date</label><input type="date" id="ticketReceivedDate"></div>
                        <div class="ticket-field"><label>Estimated Completion Date</label><input type="date" id="ticketEstimatedDate"></div>
                    </div>
                </div>

                <div class="ticket-section" id="returnSection" style="display:none;">
                    <h4>Return Details</h4>
                    <div class="ticket-modal-grid">
                        <div class="ticket-field" style="grid-column: span 2;"><label>Return Reason</label><textarea id="returnReason"></textarea></div>
                        <div class="ticket-field"><label>Can Return to Stock?</label><select id="canReturnToStock"><option value="no">No</option><option value="yes">Yes</option></select></div>
                        <div class="ticket-field"><label>Return Stock Qty</label><input type="number" id="returnStockQty" min="1" value="1"></div>
                        <div class="ticket-field"><label>Usable Product?</label><select id="isUsableProduct"><option value="yes">Yes</option><option value="no">No</option></select></div>
                        <div class="ticket-field"><label>Send Back to Supplier?</label><select id="sendBackSupplier"><option value="no">No</option><option value="yes">Yes</option></select></div>
                        <div class="ticket-field"><label>Supplier</label><select id="returnSupplierSelect"><option value="">Select supplier...</option>${supplierOptions}</select></div>
                    </div>
                </div>

                <div class="ticket-section" id="repairSection" style="display:none;">
                    <h4>Repair Details</h4>
                    <div class="ticket-modal-grid">
                        <div class="ticket-field"><label>Repair Location</label>
                            <select id="repairMode">
                                <option value="">Select...</option>
                                <option value="in_shop">Repair in Shop</option>
                                <option value="external_shop">Repair in Different Shop</option>
                                <option value="supplier_return">Return to Supplier for Repair</option>
                            </select>
                        </div>
                        <div class="ticket-field"><label>Repair Timeline</label><input type="text" id="repairTimeline" placeholder="e.g. 3 days"></div>
                        <div class="ticket-field"><label>Repair Cost (LKR)</label><input type="number" id="repairCost" min="0" step="0.01"></div>
                        <div class="ticket-field" id="externalShopNameWrap" style="display:none;"><label>Repair Shop Name</label><input type="text" id="externalShopName"></div>
                        <div class="ticket-field" id="externalShopLocationWrap" style="display:none;"><label>Repair Shop Location</label><input type="text" id="externalShopLocation"></div>
                        <div class="ticket-field" style="grid-column: span 2;"><label>Issue Description</label><textarea id="issueDescription"></textarea></div>
                        <div class="ticket-field" style="grid-column: span 2;"><label>Action Note (required only for Customer Action Needed)</label><textarea id="actionNote"></textarea></div>
                    </div>

                    <h4 style="margin-top: 14px;">Replace Parts</h4>
                    <div id="partsList" class="parts-list"></div>
                    <button type="button" class="button-secondary" style="margin-top:10px;" id="addPartBtn"><i class="fas fa-plus"></i> Add Part</button>
                </div>
            `;
        }

        function getProductStock(product) {
            return product?.Product_Stock || product?.product_stock || product?.productStock || null;
        }

        function getProductOptionLabel(product) {
            const stock = getProductStock(product);
            const name = product?.productName || product?.name || 'Unnamed Product';
            const brand = product?.brand || '-';
            const model = product?.model || '-';
            const imei = product?.IMEI || '-';
            const sku = stock?.sku || '-';
            return `${name} | ${brand} ${model} | IMEI: ${imei} | SKU: ${sku}`;
        }

        function findMatchingProductsByIdentity(identityText) {
            const identity = String(identityText || '').trim().toLowerCase();
            if (!identity) return [];

            return productsCache.filter((product) => {
                const imei = String(product?.IMEI || '').toLowerCase();
                const barcode = String(product?.barcode || '').toLowerCase();
                return imei.includes(identity) || barcode.includes(identity);
            }).slice(0, 30);
        }

        function renderProductSuggestions(identityText) {
            const select = document.getElementById('ticketProductSelect');
            if (!select) return;

            const matches = findMatchingProductsByIdentity(identityText);
            if (!matches.length) {
                select.innerHTML = '<option value="">No matching products</option>';
                return;
            }

            select.innerHTML = '<option value="">Select matching product...</option>' + matches.map((product) =>
                `<option value="${escapeHtml(product.id)}">${escapeHtml(getProductOptionLabel(product))}</option>`
            ).join('');
        }

        function applySelectedProduct(productId) {
            if (!productId) return;

            const product = productsCache.find((item) => String(item.id) === String(productId));
            if (!product) return;

            const nameInput = document.getElementById('ticketDeviceName');
            const imeiInput = document.getElementById('ticketImei');
            const barcodeInput = document.getElementById('ticketBarcode');

            if (nameInput) nameInput.value = product.productName || '';
            if (imeiInput && product.IMEI) imeiInput.value = product.IMEI;
            if (barcodeInput && product.barcode) barcodeInput.value = product.barcode;
        }

        function bindTicketModalEvents() {
            const ticketType = document.getElementById('ticketTypeSelect');
            const returnSection = document.getElementById('returnSection');
            const repairSection = document.getElementById('repairSection');
            const ticketStatus = document.getElementById('ticketStatus');
            const repairMode = document.getElementById('repairMode');
            const imeiInput = document.getElementById('ticketImei');
            const barcodeInput = document.getElementById('ticketBarcode');
            const productSelect = document.getElementById('ticketProductSelect');

            ticketType.addEventListener('change', () => {
                const type = ticketType.value;
                returnSection.style.display = type === 'return' ? 'block' : 'none';
                repairSection.style.display = type === 'repair' ? 'block' : 'none';
                if (type === 'return') {
                    ticketStatus.value = 'completed';
                } else if (type === 'repair') {
                    ticketStatus.value = 'pending_repair';
                }
            });

            repairMode.addEventListener('change', () => {
                const mode = repairMode.value;
                document.getElementById('externalShopNameWrap').style.display = mode === 'external_shop' ? 'flex' : 'none';
                document.getElementById('externalShopLocationWrap').style.display = mode === 'external_shop' ? 'flex' : 'none';
            });

            if (imeiInput) {
                imeiInput.addEventListener('input', () => renderProductSuggestions(imeiInput.value));
            }

            if (barcodeInput) {
                barcodeInput.addEventListener('input', () => {
                    if (!String(imeiInput?.value || '').trim()) {
                        renderProductSuggestions(barcodeInput.value);
                    }
                });
            }

            if (productSelect) {
                productSelect.addEventListener('change', () => applySelectedProduct(productSelect.value));
            }

            const addPartBtn = document.getElementById('addPartBtn');
            if (addPartBtn) {
                addPartBtn.addEventListener('click', addPartRow);
            }
        }

        async function openNewTicketDialog() {
            const result = await Swal.fire({
                title: 'New Return / Repair Ticket',
                html: buildTicketModalHtml(),
                width: 980,
                showCancelButton: true,
                confirmButtonText: 'Create Ticket',
                confirmButtonColor: '#111111',
                cancelButtonColor: '#7a86ad',
                didOpen: () => {
                    bindTicketModalEvents();
                },
                preConfirm: () => {
                    const ticketType = document.getElementById('ticketTypeSelect').value;
                    if (!ticketType) {
                        Swal.showValidationMessage('Select ticket type');
                        return false;
                    }

                    const payload = {
                        ticket_type: ticketType,
                        status: document.getElementById('ticketStatus').value,
                        customer_name: document.getElementById('ticketCustomerName').value.trim() || null,
                        customer_phone: document.getElementById('ticketCustomerPhone').value.trim() || null,
                        customer_email: document.getElementById('ticketCustomerEmail').value.trim() || null,
                        device_name: document.getElementById('ticketDeviceName').value.trim() || null,
                        imei: document.getElementById('ticketImei').value.trim() || null,
                        barcode: document.getElementById('ticketBarcode').value.trim() || null,
                        serial_number: document.getElementById('ticketSerial').value.trim() || null,
                        received_date: document.getElementById('ticketReceivedDate').value || null,
                        estimated_completion_date: document.getElementById('ticketEstimatedDate').value || null,
                    };

                    if (ticketType === 'return') {
                        payload.return_reason = document.getElementById('returnReason').value.trim();
                        payload.can_return_to_stock = document.getElementById('canReturnToStock').value === 'yes';
                        payload.return_stock_qty = parseInt(document.getElementById('returnStockQty').value, 10) || 0;
                        payload.is_usable_product = document.getElementById('isUsableProduct').value === 'yes';
                        payload.send_back_to_supplier = document.getElementById('sendBackSupplier').value === 'yes';
                        payload.supplier_name = document.getElementById('returnSupplierSelect').value || null;

                        if (!payload.imei && !payload.barcode) {
                            Swal.showValidationMessage('IMEI or barcode is required for returns');
                            return false;
                        }
                        if (!payload.return_reason) {
                            Swal.showValidationMessage('Return reason is required');
                            return false;
                        }
                        if (payload.can_return_to_stock && payload.return_stock_qty <= 0) {
                            Swal.showValidationMessage('Return stock qty is required when returning to stock');
                            return false;
                        }
                    }

                    if (ticketType === 'repair') {
                        payload.repair_mode = document.getElementById('repairMode').value;
                        payload.repair_timeline = document.getElementById('repairTimeline').value.trim() || null;
                        payload.repair_cost = parseFloat(document.getElementById('repairCost').value) || 0;
                        payload.external_shop_name = document.getElementById('externalShopName').value.trim() || null;
                        payload.external_shop_location = document.getElementById('externalShopLocation').value.trim() || null;
                        payload.issue_description = document.getElementById('issueDescription').value.trim() || null;
                        payload.action_note = document.getElementById('actionNote').value.trim() || null;
                        payload.parts = collectParts();

                        if (!payload.repair_mode) {
                            Swal.showValidationMessage('Repair mode is required');
                            return false;
                        }
                        if (payload.repair_mode === 'external_shop' && (!payload.external_shop_name || !payload.external_shop_location)) {
                            Swal.showValidationMessage('External shop name and location are required');
                            return false;
                        }
                        if (payload.status === 'customer_action_needed' && !payload.action_note) {
                            Swal.showValidationMessage('Action note is required for Customer Action Needed status');
                            return false;
                        }
                    }

                    return payload;
                }
            });

            if (!result.isConfirmed || !result.value) {
                return;
            }

            try {
                await requestJson(RETURNS_API, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result.value),
                });

                await showSuccess('Ticket created successfully');
                await Promise.all([loadTickets(), loadSummary(), loadUnusableReturns()]);
            } catch (error) {
                showError(`Failed to create ticket: ${error.message}`);
            }
        }

        async function openUpdateStatusModal(ticketId) {
            const options = statuses.reduce((acc, status) => {
                acc[status] = STATUS_LABELS[status] || titleCase(status);
                return acc;
            }, {});

            const result = await Swal.fire({
                title: `Update Status (${ticketId})`,
                input: 'select',
                inputOptions: options,
                inputPlaceholder: 'Select status',
                showCancelButton: true,
                confirmButtonColor: '#111111',
                preConfirm: async (status) => {
                    if (!status) {
                        Swal.showValidationMessage('Status is required');
                        return false;
                    }

                    let actionNote = null;
                    if (status === 'customer_action_needed') {
                        const noteRes = await Swal.fire({
                            title: 'Action Note Required',
                            input: 'textarea',
                            inputPlaceholder: 'Enter customer action note',
                            showCancelButton: true,
                            confirmButtonColor: '#111111',
                            inputValidator: (value) => {
                                if (!String(value || '').trim()) {
                                    return 'Action note is required';
                                }
                                return undefined;
                            }
                        });

                        if (!noteRes.isConfirmed) {
                            return false;
                        }

                        actionNote = String(noteRes.value || '').trim();
                    }

                    return { status, action_note: actionNote };
                }
            });

            if (!result.isConfirmed || !result.value) {
                return;
            }

            try {
                await requestJson(`${RETURNS_API}/${encodeURIComponent(ticketId)}/status`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result.value),
                });

                await showSuccess('Ticket status updated');
                await Promise.all([loadTickets(), loadSummary(), loadUnusableReturns()]);
            } catch (error) {
                showError(`Failed to update status: ${error.message}`);
            }
        }

        function setEditFormValues(ticket) {
            document.getElementById('ticketTypeSelect').value = ticket.ticket_type || '';
            document.getElementById('ticketTypeSelect').disabled = true;
            document.getElementById('ticketStatus').value = ticket.status || '';
            document.getElementById('ticketCustomerName').value = ticket.customer_name || '';
            document.getElementById('ticketCustomerPhone').value = ticket.customer_phone || '';
            document.getElementById('ticketCustomerEmail').value = ticket.customer_email || '';
            document.getElementById('ticketDeviceName').value = ticket.device_name || '';
            document.getElementById('ticketImei').value = ticket.imei || '';
            document.getElementById('ticketBarcode').value = ticket.barcode || '';
            document.getElementById('ticketSerial').value = ticket.serial_number || '';
            document.getElementById('ticketReceivedDate').value = ticket.received_date ? new Date(ticket.received_date).toISOString().slice(0, 10) : '';
            document.getElementById('ticketEstimatedDate').value = ticket.estimated_completion_date ? new Date(ticket.estimated_completion_date).toISOString().slice(0, 10) : '';

            const returnSection = document.getElementById('returnSection');
            const repairSection = document.getElementById('repairSection');
            returnSection.style.display = ticket.ticket_type === 'return' ? 'block' : 'none';
            repairSection.style.display = ticket.ticket_type === 'repair' ? 'block' : 'none';

            if (ticket.ticket_type === 'return') {
                document.getElementById('returnReason').value = ticket.return_reason || '';
                document.getElementById('canReturnToStock').value = ticket.can_return_to_stock ? 'yes' : 'no';
                document.getElementById('returnStockQty').value = ticket.return_stock_qty || 0;
                document.getElementById('isUsableProduct').value = ticket.is_usable_product ? 'yes' : 'no';
                document.getElementById('sendBackSupplier').value = ticket.send_back_to_supplier ? 'yes' : 'no';
                document.getElementById('returnSupplierSelect').value = ticket.supplier_name || '';
            }

            if (ticket.ticket_type === 'repair') {
                document.getElementById('repairMode').value = ticket.repair_mode || '';
                document.getElementById('repairTimeline').value = ticket.repair_timeline || '';
                document.getElementById('repairCost').value = ticket.repair_cost || 0;
                document.getElementById('externalShopName').value = ticket.external_shop_name || '';
                document.getElementById('externalShopLocation').value = ticket.external_shop_location || '';
                document.getElementById('issueDescription').value = ticket.issue_description || '';
                document.getElementById('actionNote').value = ticket.action_note || '';

                const mode = ticket.repair_mode || '';
                document.getElementById('externalShopNameWrap').style.display = mode === 'external_shop' ? 'flex' : 'none';
                document.getElementById('externalShopLocationWrap').style.display = mode === 'external_shop' ? 'flex' : 'none';

                const partsList = document.getElementById('partsList');
                if (partsList) {
                    partsList.innerHTML = '';
                    const parts = Array.isArray(ticket.parts) ? ticket.parts : [];
                    parts.forEach((part) => {
                        const row = document.createElement('div');
                        row.className = 'part-row';
                        row.innerHTML = `
                            <input type="text" class="part-name" placeholder="Part name" value="${escapeHtml(part.part_name || '')}">
                            <input type="number" class="part-qty" min="1" value="${escapeHtml(part.quantity || 1)}">
                            <input type="number" class="part-cost" min="0" step="0.01" placeholder="Cost" value="${escapeHtml(part.part_cost || 0)}">
                            <button type="button" onclick="this.parentElement.remove()"><i class="fas fa-trash"></i></button>
                        `;
                        partsList.appendChild(row);
                    });
                }
            }

            renderProductSuggestions(ticket.imei || ticket.barcode || '');
        }

        async function openEditTicketDialog(ticketId) {
            const ticket = getTicketById(ticketId);
            if (!ticket) {
                showError('Ticket not found.');
                return;
            }

            const result = await Swal.fire({
                title: `Edit Ticket (${ticket.ticket_id})`,
                html: buildTicketModalHtml(),
                width: 980,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                confirmButtonColor: '#111111',
                cancelButtonColor: '#7a86ad',
                didOpen: () => {
                    bindTicketModalEvents();
                    setEditFormValues(ticket);
                },
                preConfirm: () => {
                    const ticketType = document.getElementById('ticketTypeSelect').value;
                    if (!ticketType) {
                        Swal.showValidationMessage('Ticket type is missing');
                        return false;
                    }

                    const payload = {
                        status: document.getElementById('ticketStatus').value,
                        customer_name: document.getElementById('ticketCustomerName').value.trim() || null,
                        customer_phone: document.getElementById('ticketCustomerPhone').value.trim() || null,
                        customer_email: document.getElementById('ticketCustomerEmail').value.trim() || null,
                        device_name: document.getElementById('ticketDeviceName').value.trim() || null,
                        imei: document.getElementById('ticketImei').value.trim() || null,
                        barcode: document.getElementById('ticketBarcode').value.trim() || null,
                        serial_number: document.getElementById('ticketSerial').value.trim() || null,
                        received_date: document.getElementById('ticketReceivedDate').value || null,
                        estimated_completion_date: document.getElementById('ticketEstimatedDate').value || null,
                    };

                    if (ticketType === 'return') {
                        payload.return_reason = document.getElementById('returnReason').value.trim();
                        payload.can_return_to_stock = document.getElementById('canReturnToStock').value === 'yes';
                        payload.return_stock_qty = parseInt(document.getElementById('returnStockQty').value, 10) || 0;
                        payload.is_usable_product = document.getElementById('isUsableProduct').value === 'yes';
                        payload.send_back_to_supplier = document.getElementById('sendBackSupplier').value === 'yes';
                        payload.supplier_name = document.getElementById('returnSupplierSelect').value || null;

                        if (!payload.imei && !payload.barcode) {
                            Swal.showValidationMessage('IMEI or barcode is required for returns');
                            return false;
                        }
                        if (!payload.return_reason) {
                            Swal.showValidationMessage('Return reason is required');
                            return false;
                        }
                        if (payload.can_return_to_stock && payload.return_stock_qty <= 0) {
                            Swal.showValidationMessage('Return stock qty is required when returning to stock');
                            return false;
                        }
                    }

                    if (ticketType === 'repair') {
                        payload.repair_mode = document.getElementById('repairMode').value;
                        payload.repair_timeline = document.getElementById('repairTimeline').value.trim() || null;
                        payload.repair_cost = parseFloat(document.getElementById('repairCost').value) || 0;
                        payload.external_shop_name = document.getElementById('externalShopName').value.trim() || null;
                        payload.external_shop_location = document.getElementById('externalShopLocation').value.trim() || null;
                        payload.issue_description = document.getElementById('issueDescription').value.trim() || null;
                        payload.action_note = document.getElementById('actionNote').value.trim() || null;
                        payload.parts = collectParts();

                        if (!payload.repair_mode) {
                            Swal.showValidationMessage('Repair mode is required');
                            return false;
                        }
                        if (payload.repair_mode === 'external_shop' && (!payload.external_shop_name || !payload.external_shop_location)) {
                            Swal.showValidationMessage('External shop name and location are required');
                            return false;
                        }
                        if (payload.status === 'customer_action_needed' && !payload.action_note) {
                            Swal.showValidationMessage('Action note is required for Customer Action Needed status');
                            return false;
                        }
                    }

                    return payload;
                }
            });

            if (!result.isConfirmed || !result.value) {
                return;
            }

            try {
                await requestJson(`${RETURNS_API}/${encodeURIComponent(ticketId)}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result.value),
                });

                await showSuccess('Ticket updated successfully');
                await Promise.all([loadTickets(), loadSummary(), loadUnusableReturns()]);
            } catch (error) {
                showError(`Failed to update ticket: ${error.message}`);
            }
        }

        function exportTickets() {
            const rows = ticketsCache;
            if (!rows.length) {
                showNotice('No ticket rows to export.');
                return;
            }

            const csvRows = [
                ['Ticket ID', 'Type', 'Status', 'Customer', 'Phone', 'Device', 'IMEI', 'Barcode', 'Issue/Reason', 'Received Date', 'Estimated Completion', 'Repair Cost'].join(','),
            ];

            rows.forEach((ticket) => {
                const row = [
                    ticket.ticket_id,
                    ticket.ticket_type,
                    STATUS_LABELS[ticket.status] || ticket.status,
                    ticket.customer_name || '',
                    ticket.customer_phone || '',
                    ticket.device_name || '',
                    ticket.imei || '',
                    ticket.barcode || '',
                    ticket.ticket_type === 'return' ? (ticket.return_reason || '') : (ticket.issue_description || ''),
                    formatDate(ticket.received_date),
                    formatDate(ticket.estimated_completion_date),
                    ticket.repair_cost || 0,
                ].map((value) => `"${String(value).replace(/"/g, '""')}"`).join(',');

                csvRows.push(row);
            });

            const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `returns-repairs-${new Date().toISOString().slice(0, 10)}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        function wireGlobalSearchModal() {
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
                searchTrigger.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openSearchModal();
                    }
                });
            }

            if (searchClose) searchClose.addEventListener('click', closeSearchModal);
            if (searchOverlay) {
                searchOverlay.addEventListener('click', (event) => {
                    if (event.target === searchOverlay) closeSearchModal();
                });
            }

            document.addEventListener('keydown', (event) => {
                if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    openSearchModal();
                }
                if (event.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                    closeSearchModal();
                }
            });
        }

        function setupFilters() {
            document.getElementById('searchRepair').addEventListener('input', applyTicketFilters);
            document.getElementById('filterType').addEventListener('change', applyTicketFilters);
            document.getElementById('filterStatus').addEventListener('change', applyTicketFilters);

            const pills = document.querySelectorAll('.pill');
            pills.forEach((pill) => {
                pill.addEventListener('click', function() {
                    pills.forEach((node) => node.classList.remove('active'));
                    this.classList.add('active');
                    activePill = this.dataset.filter;
                    applyTicketFilters();
                });
            });
        }

        function setupToolbarActions() {
            const newTicketBtn = document.getElementById('newTicketBtn');
            const exportTicketsBtn = document.getElementById('exportTicketsBtn');

            if (newTicketBtn) {
                newTicketBtn.addEventListener('click', openNewTicketDialog);
            }
            if (exportTicketsBtn) {
                exportTicketsBtn.addEventListener('click', exportTickets);
            }
        }

        async function initializePage() {
            try {
                setupFilters();
                setupToolbarActions();
                wireGlobalSearchModal();
                await loadStatusOptions();
                await loadReferenceData();
                await Promise.all([loadTickets(), loadSummary(), loadUnusableReturns()]);
            } catch (error) {
                console.error('Failed to initialize returns & repairs page:', error);
                showError(`Failed to initialize page: ${error.message}`);
            }
        }

        initializePage();
    </script>
</body>
</html>
