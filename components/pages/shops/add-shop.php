<?php
$activePage = 'shops';
$basePath = '../';
$pageTitle = 'Add Shop';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Add Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <style>
        .owner-autocomplete-wrap {
            position: relative;
        }

        .owner-suggestions {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 6px);
            background: #ffffff;
            border: 1px solid #dfe3ed;
            border-radius: 10px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            z-index: 50;
            max-height: 240px;
            overflow-y: auto;
            display: none;
        }

        .owner-suggestion-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eef1f6;
        }

        .owner-suggestion-item:last-child {
            border-bottom: none;
        }

        .owner-suggestion-item:hover,
        .owner-suggestion-item.active {
            background: #f5f8ff;
        }

        .owner-suggestion-name {
            font-weight: 600;
            color: #111111;
            font-size: 14px;
        }

        .owner-suggestion-meta {
            margin-top: 4px;
            color: #6a759d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <a class="button-secondary" href="index.php">
                            <i class="fas fa-arrow-left"></i>
                            Back to Shops
                        </a>
                    </div>
                </div>

                <form class="sale-form" id="addShopForm" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Shop Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="shopName">Shop Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="shopName" name="shopName" placeholder="e.g., Downtown Branch" required>
                            </div>
                            <div class="form-field">
                                <label for="shopID">Shop ID (Optional)</label>
                                <input type="text" id="shopID" name="shopID" placeholder="e.g., SHOP-00010">
                            </div>
                            <div class="form-field">
                                <label for="ownerName">Owner Name <span style="color: #f44336;">*</span></label>
                                <div class="owner-autocomplete-wrap">
                                    <input type="text" id="ownerName" name="ownerName" placeholder="Start typing customer name..." autocomplete="off" required>
                                    <div id="ownerSuggestions" class="owner-suggestions" role="listbox" aria-label="Owner suggestions"></div>
                                </div>
                            </div>
                            <div class="form-field">
                                <label for="ownerCustomerId">Owner Customer ID <span style="color: #f44336;">*</span></label>
                                <input type="text" id="ownerCustomerId" name="ownerCustomerId" placeholder="e.g., CUST-00001" required>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Location & Contact</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="location">Location <span style="color: #f44336;">*</span></label>
                                <input type="text" id="location" name="location" placeholder="e.g., Colombo 03" required>
                            </div>
                            <div class="form-field">
                                <label for="phone">Phone Number <span style="color: #f44336;">*</span></label>
                                <input type="tel" id="phone" name="phone" placeholder="+94 77 123 4567" required>
                            </div>
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <div class="form-hint">The API requires: <strong>name</strong>, <strong>location</strong>, <strong>contact_number</strong>, <strong>owner_name</strong>, <strong>owner_customer_id</strong>. The <strong>shop_id</strong> is optional and auto-generated when omitted.</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end; padding: 24px 0;">
                        <a href="index.php" class="button-secondary" style="text-decoration: none; padding: 12px 32px;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="reset" class="button-secondary" id="resetShopFormBtn">
                            <i class="fas fa-redo"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="button-primary" id="saveShopBtn">
                            <i class="fas fa-save"></i>
                            Save Shop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:3000/api/shops';
        const CUSTOMER_API_URL = 'http://localhost:3000/api/customers';

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        const addShopForm = document.getElementById('addShopForm');
        const saveShopBtn = document.getElementById('saveShopBtn');
        const ownerNameInput = document.getElementById('ownerName');
        const ownerCustomerIdInput = document.getElementById('ownerCustomerId');
        const ownerSuggestionsEl = document.getElementById('ownerSuggestions');

        let ownerSuggestionResults = [];
        let activeOwnerSuggestionIndex = -1;
        let ownerSearchDebounce;

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function hideOwnerSuggestions() {
            ownerSuggestionsEl.style.display = 'none';
            ownerSuggestionsEl.innerHTML = '';
            ownerSuggestionResults = [];
            activeOwnerSuggestionIndex = -1;
        }

        function selectOwnerSuggestion(customer) {
            ownerNameInput.value = customer.name || '';
            ownerCustomerIdInput.value = customer.customer_id || '';
            hideOwnerSuggestions();
        }

        function renderOwnerSuggestions(customers) {
            ownerSuggestionResults = customers;
            activeOwnerSuggestionIndex = -1;

            if (!customers.length) {
                ownerSuggestionsEl.innerHTML = '<div class="owner-suggestion-item">No matching customers found</div>';
                ownerSuggestionsEl.style.display = 'block';
                return;
            }

            ownerSuggestionsEl.innerHTML = customers.map((customer, index) => `
                <div class="owner-suggestion-item" data-index="${index}" role="option">
                    <div class="owner-suggestion-name">${escapeHtml(customer.name || 'Unnamed Customer')}</div>
                    <div class="owner-suggestion-meta">${escapeHtml(customer.customer_id || '')}${customer.phone_number ? ` • ${escapeHtml(customer.phone_number)}` : ''}</div>
                </div>
            `).join('');

            ownerSuggestionsEl.style.display = 'block';
        }

        async function fetchOwnerSuggestions(query) {
            try {
                const response = await fetch(`${CUSTOMER_API_URL}/search?query=${encodeURIComponent(query)}`);
                const result = await response.json().catch(() => ({}));

                if (!response.ok || result.success === false) {
                    throw new Error(result.message || 'Unable to search customers');
                }

                renderOwnerSuggestions(Array.isArray(result.data) ? result.data.slice(0, 8) : []);
            } catch (error) {
                ownerSuggestionsEl.innerHTML = `<div class="owner-suggestion-item">${escapeHtml(error.message)}</div>`;
                ownerSuggestionsEl.style.display = 'block';
            }
        }

        ownerNameInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (!query) {
                ownerCustomerIdInput.value = '';
                hideOwnerSuggestions();
                return;
            }

            clearTimeout(ownerSearchDebounce);
            ownerSearchDebounce = setTimeout(() => {
                fetchOwnerSuggestions(query);
            }, 250);
        });

        ownerNameInput.addEventListener('keydown', function(event) {
            if (ownerSuggestionsEl.style.display !== 'block' || !ownerSuggestionResults.length) {
                return;
            }

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                activeOwnerSuggestionIndex = Math.min(activeOwnerSuggestionIndex + 1, ownerSuggestionResults.length - 1);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                activeOwnerSuggestionIndex = Math.max(activeOwnerSuggestionIndex - 1, 0);
            } else if (event.key === 'Enter' && activeOwnerSuggestionIndex >= 0) {
                event.preventDefault();
                selectOwnerSuggestion(ownerSuggestionResults[activeOwnerSuggestionIndex]);
                return;
            } else if (event.key === 'Escape') {
                hideOwnerSuggestions();
                return;
            }

            ownerSuggestionsEl.querySelectorAll('.owner-suggestion-item').forEach((item, index) => {
                item.classList.toggle('active', index === activeOwnerSuggestionIndex);
            });
        });

        ownerSuggestionsEl.addEventListener('mousedown', function(event) {
            const target = event.target.closest('.owner-suggestion-item[data-index]');
            if (!target) {
                return;
            }

            event.preventDefault();
            const selected = ownerSuggestionResults[parseInt(target.dataset.index, 10)];
            if (selected) {
                selectOwnerSuggestion(selected);
            }
        });

        document.addEventListener('click', function(event) {
            const wrap = event.target.closest('.owner-autocomplete-wrap');
            if (!wrap) {
                hideOwnerSuggestions();
            }
        });

        addShopForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const payload = {
                name: document.getElementById('shopName').value.trim(),
                location: document.getElementById('location').value.trim(),
                contact_number: document.getElementById('phone').value.trim(),
                owner_name: document.getElementById('ownerName').value.trim(),
                owner_customer_id: document.getElementById('ownerCustomerId').value.trim(),
            };

            const customShopId = document.getElementById('shopID').value.trim();
            if (customShopId) {
                payload.shop_id = customShopId;
            }

            if (!payload.name || !payload.location || !payload.contact_number || !payload.owner_name || !payload.owner_customer_id) {
                alert('Please fill in all required fields.');
                return;
            }

            saveShopBtn.disabled = true;
            saveShopBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json().catch(() => ({}));

                if (!response.ok || result.success === false) {
                    throw new Error(result.message || 'Failed to create shop');
                }

                alert('Shop created successfully.');
                window.location.href = 'index.php';
            } catch (error) {
                alert(`Unable to create shop: ${error.message}`);
            } finally {
                saveShopBtn.disabled = false;
                saveShopBtn.innerHTML = '<i class="fas fa-save"></i> Save Shop';
            }
        });

        // Auto-format phone numbers
        document.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('blur', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.startsWith('94')) {
                    value = value.substring(2);
                }
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                if (value.length === 9) {
                    this.value = '+94 ' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5);
                }
            });
        });
    </script>
</body>
</html>
