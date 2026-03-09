<?php
$activePage = 'sales';
$basePath = '../';
$pageTitle = 'Print Invoice';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Print Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .invoice-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                page-break-after: always;
            }
            .page-break {
                page-break-after: always;
            }
        }

        .invoice-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 40px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            color: #22315b;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3f51b5;
        }

        .shop-info h1 {
            margin: 0;
            font-size: 28px;
            color: #1a237e;
            font-weight: 700;
        }

        .shop-info p {
            margin: 4px 0;
            font-size: 13px;
            color: #666;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 24px;
            color: #1a237e;
            font-weight: 700;
        }

        .invoice-title p {
            margin: 4px 0;
            font-size: 13px;
            color: #666;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .detail-section h3 {
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #7a86ad;
            letter-spacing: 0.5px;
        }

        .detail-section p {
            margin: 6px 0;
            font-size: 13px;
            color: #22315b;
        }

        .items-section {
            margin-bottom: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table thead {
            background: #f5f7fa;
            border-top: 2px solid #3f51b5;
            border-bottom: 2px solid #3f51b5;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #1a237e;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 12px;
            font-size: 13px;
            color: #22315b;
            border-bottom: 1px solid #e0e0e0;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #3f51b5;
        }

        .amount-right {
            text-align: right;
        }

        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .summary-box {
            width: 300px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 13px;
            color: #22315b;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-row.total {
            font-size: 16px;
            font-weight: 700;
            color: #1a237e;
            border-bottom: none;
            padding: 12px 0;
            margin-top: 8px;
        }

        .payment-status {
            margin-top: 40px;
            padding: 20px;
            background: #f5f7fa;
            border-radius: 6px;
            text-align: center;
        }

        .payment-status p {
            margin: 8px 0;
            font-size: 13px;
            color: #666;
        }

        .payment-status .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 8px;
        }

        .footer-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        .toolbar-print {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .toolbar-print button {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-print {
            background: #3f51b5;
            color: white;
        }

        .btn-print:hover {
            background: #1a237e;
        }

        .btn-back {
            background: #e0e0e0;
            color: #333;
        }

        .btn-back:hover {
            background: #bdbdbd;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .error {
            text-align: center;
            padding: 40px;
            color: #d32f2f;
            background: #ffebee;
            border-radius: 6px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="toolbar-print no-print">
        <button class="btn-print" type="button" id="printBtn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Invoice
        </button>
        <button class="btn-back" type="button" id="backBtn" onclick="history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div id="invoiceContainer" class="loading">
        <i class="fas fa-spinner fa-spin"></i> Loading invoice...
    </div>

    <script>
        const API_BASE_URL = 'http://localhost:3000/api';
        const SALES_API = `${API_BASE_URL}/sales`;
        const container = document.getElementById('invoiceContainer');

        // Get invoice ID from URL
        const params = new URLSearchParams(window.location.search);
        const invoiceId = params.get('id');

        function formatLkr(value) {
            return `LKR ${Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function formatDate(dateValue) {
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) {
                return '-';
            }
            return date.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: '2-digit' });
        }

        function getStatusBadgeStyle(status) {
            const current = (status || '').toLowerCase();
            if (current === 'completed') {
                return 'background: #e8f5e9; color: #2e7d32;';
            }
            if (current === 'pending') {
                return 'background: #fff3e0; color: #ef6c00;';
            }
            if (current === 'cancelled') {
                return 'background: #ffebee; color: #c62828;';
            }
            return 'background: #eceff1; color: #455a64;';
        }

        async function loadInvoice() {
            if (!invoiceId) {
                container.innerHTML = '<div class="error"><i class="fas fa-exclamation-circle"></i> Invoice ID not found in URL.</div>';
                return;
            }

            try {
                console.log('Loading invoice with ID:', invoiceId);
                const response = await fetch(`${SALES_API}/${invoiceId}`);
                const result = await response.json();

                console.log('API Response:', result);

                if (!response.ok) {
                    throw new Error(result.message || result.error || `HTTP ${response.status}`);
                }

                // Handle different API response structures
                let invoice = null;
                if (result.success && result.data) {
                    invoice = result.data;
                } else if (result.data) {
                    invoice = result.data;
                } else if (result.sales) {
                    invoice = result.sales;
                } else if (result.sale) {
                    invoice = result.sale;
                } else {
                    // If none of the above, try to use the result directly
                    invoice = result;
                }

                if (!invoice || !invoice.sales_id) {
                    throw new Error('Invalid invoice data structure - missing sales_id');
                }

                console.log('Invoice data:', invoice);
                renderInvoice(invoice);
            } catch (error) {
                console.error('Error loading invoice:', error);
                container.innerHTML = `<div class="error"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
            }
        }

        async function loadTemplate() {
            try {
                const response = await fetch('invoice-template.html');
                if (!response.ok) throw new Error('Failed to load template');
                return await response.text();
            } catch (error) {
                console.error('Error loading template:', error);
                throw error;
            }
        }

        function renderInvoice(invoice) {
            const customerName = invoice.customer?.name || 'Walk-in Customer';
            const customerPhone = invoice.customer?.phone_number || invoice.customer?.phone || '-';
            const customerAddress = invoice.customer?.address || '-';
            const items = Array.isArray(invoice.items) ? invoice.items : [];
            const invoiceDate = formatDate(invoice.sales_date || invoice.createdAt);
            const status = (invoice.status || 'unknown').toLowerCase();
            const paymentMethod = (invoice.payment_method || '-').replace('_', ' ');
            const totalAmount = Number(invoice.total_amount || 0);
            const totalDiscount = Number(invoice.total_discount || 0);
            const subtotal = totalAmount + totalDiscount;

            // Load template and populate
            loadTemplate().then(templateHtml => {
                container.innerHTML = templateHtml;

                // Populate customer info
                document.getElementById('tpl-invoice-number').textContent = invoice.sales_id || '-';
                document.getElementById('tpl-invoice-date').textContent = invoiceDate;
                document.getElementById('tpl-customer-name').textContent = customerName;
                document.getElementById('tpl-customer-phone').textContent = customerPhone;
                document.getElementById('tpl-customer-address').textContent = customerAddress;

                // Populate payment info
                document.getElementById('tpl-payment-method').textContent = paymentMethod;
                const statusBadge = `<div class="status-badge" style="${getStatusBadgeStyle(status)}">${status.toUpperCase()}</div>`;
                document.getElementById('tpl-status-badge').innerHTML = statusBadge;

                // Populate items
                const itemsBody = document.getElementById('tpl-items-body');
                if (items.length) {
                    itemsBody.innerHTML = items.map(item => {
                        const productName = item.product?.productName || item.productName || item.product_id || '-';
                        const quantity = item.quantity || 0;
                        const unitPrice = item.unit_price || item.price || 0;
                        const discount = item.discount || 0;
                        const totalPrice = item.total_price || (quantity * unitPrice);
                        
                        return `
                            <tr>
                                <td>${productName}</td>
                                <td class="amount-right">${quantity}</td>
                                <td class="amount-right">${formatLkr(unitPrice)}</td>
                                <td class="amount-right">${formatLkr(discount)}</td>
                                <td class="amount-right"><strong>${formatLkr(totalPrice)}</strong></td>
                            </tr>
                        `;
                    }).join('');
                } else {
                    itemsBody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#7a86ad;">No items</td></tr>';
                }

                // Populate summary
                document.getElementById('tpl-subtotal').textContent = formatLkr(subtotal);
                document.getElementById('tpl-discount').textContent = `-${formatLkr(totalDiscount)}`;
                document.getElementById('tpl-total').textContent = formatLkr(totalAmount);

                // Populate footer
                document.getElementById('tpl-footer').textContent = `PositiQ POS System - Invoice printed on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}`;
            }).catch(error => {
                console.error('Error rendering invoice:', error);
                container.innerHTML = `<div class="error"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
            });
        }

        // Load invoice on page load
        loadInvoice();
    </script>
</body>
</html>
