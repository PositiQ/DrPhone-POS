<?php
$activePage = 'sales';
$basePath = '../';
$pageTitle = 'Create Sale';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Create Sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
                            Back to Sales
                        </a>
                    </div>
                </div>

                <form class="sale-form" id="createSaleForm" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Customer Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="customerName">Customer Name</label>
                                <div class="inline-field">
                                    <div class="autocomplete-wrapper" style="width: 100%;">
                                        <input type="text" id="customerName" name="customerName" class="table-input" placeholder="Walk-in Customer" autocomplete="off">
                                        <div class="autocomplete-dropdown" id="customerDropdown"></div>
                                    </div>
                                    <button class="button-secondary" type="button" id="clearCustomerBtn">Clear</button>
                                </div>
                                <input type="hidden" id="customerId" name="customerId">
                            </div>
                            <div class="form-field">
                                <label for="customerPhone">Phone Number</label>
                                <div class="autocomplete-wrapper">
                                    <input type="tel" id="customerPhone" name="customerPhone" placeholder="07X XXX XXXX" autocomplete="off">
                                    <div class="autocomplete-dropdown" id="customerPhoneDropdown"></div>
                                </div>
                                <div class="form-hint">Type name or phone to search customers</div>
                            </div>
                            <div class="form-field">
                                <label for="customerAddress">Address</label>
                                <textarea id="customerAddress" name="customerAddress" placeholder="Customer address"></textarea>
                            </div>
                            <div class="form-field">
                                <label for="saleDate">Date</label>
                                <input type="date" id="saleDate" name="saleDate">
                            </div>
                            <div class="form-field">
                                <label for="paymentMethod">Payment Method <span style="color: #f44336;">*</span></label>
                                <select id="paymentMethod" name="paymentMethod" required>
                                    <option value="cash" selected>Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="koko">Koko</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="saleAccount">Account <span style="color: #f44336;">*</span></label>
                                <select id="saleAccount" name="saleAccount" required>
                                    <option value="">Select account...</option>
                                </select>
                                <div class="form-hint" id="saleAccountHint">Cash requires a drawer account.</div>
                            </div>
                            <div class="form-field">
                                <label for="saleStatus">Sale Status</label>
                                <input type="text" id="saleStatus" name="saleStatus" value="Completed" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Add Device</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="productSearch">Search Product</label>
                                <div class="autocomplete-wrapper">
                                    <input type="text" id="productSearch" name="productSearch" placeholder="Type to search products..." autocomplete="off">
                                    <div class="autocomplete-dropdown" id="productDropdown"></div>
                                </div>
                                <div class="form-hint">Mock product list. Will be replaced with real inventory.</div>
                            </div>
                            <div class="form-field">
                                <label for="imeiSearch">Search by IMEI (last 4 digits)</label>
                                <input type="text" id="imeiSearch" name="imeiSearch" placeholder="Enter last 4 digits">
                                <div class="form-hint">Filters products by matching IMEI ending.</div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="brand">Brand</label>
                                <input type="text" id="brand" name="brand" placeholder="Auto-filled" readonly>
                            </div>
                            <div class="form-field">
                                <label for="model">Model</label>
                                <input type="text" id="model" name="model" placeholder="Auto-filled" readonly>
                            </div>
                            <div class="form-field">
                                <label for="storage">Storage</label>
                                <input type="text" id="storage" name="storage" placeholder="Auto-filled" readonly>
                            </div>
                            <div class="form-field">
                                <label for="color">Color</label>
                                <input type="text" id="color" name="color" placeholder="Auto-filled" readonly>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="imeiNumber">IMEI Number</label>
                                <input type="text" id="imeiNumber" name="imeiNumber" placeholder="Auto-filled" readonly>
                            </div>
                            <div class="form-field">
                                <label for="devicePrice">Price (LKR)</label>
                                <input type="number" id="devicePrice" name="devicePrice" placeholder="0.00" step="0.01" readonly>
                            </div>
                            <div class="form-field">
                                <label for="deviceDescription">Description (Optional)</label>
                                <textarea id="deviceDescription" name="deviceDescription" placeholder="Additional notes" rows="1" style="resize: vertical;"></textarea>
                            </div>
                            <div class="form-field">
                                <label>&nbsp;</label>
                                <div class="cart-actions">
                                    <button class="button-primary" type="button" id="addDeviceBtn">
                                        <i class="fas fa-plus" style="margin-right: 6px;"></i>
                                        Add to Cart
                                    </button>
                                    <button class="button-secondary" type="button" id="clearDeviceBtn">Clear</button>
                                </div>
                            </div>
                        </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Accessories</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="accessoriesSearch">Search Accessories</label>
                                <div class="autocomplete-wrapper">
                                    <input type="text" id="accessoriesSearch" name="accessoriesSearch" placeholder="Type to search accessories..." autocomplete="off">
                                    <div class="autocomplete-dropdown" id="accessoriesDropdown"></div>
                                </div>
                                <div class="form-hint">Start typing to search and select accessories.</div>
                            </div>
                            <div class="form-field">
                                <label for="accessoryBarcode">Barcode</label>
                                <input type="text" id="accessoryBarcode" name="accessoryBarcode" placeholder="Auto-filled or manual entry" readonly>
                            </div>
                            <div class="form-field">
                                <label for="accessoryPrice">Price (LKR)</label>
                                <input type="number" id="accessoryPrice" name="accessoryPrice" placeholder="0.00" step="0.01" readonly>
                            </div>
                            <div class="form-field">
                                <label>&nbsp;</label>
                                <div class="cart-actions">
                                    <button class="button-primary" type="button" id="addAccessoryBtn">
                                        <i class="fas fa-plus" style="margin-right: 6px;"></i>
                                        Add to Cart
                                    </button>
                                    <button class="button-secondary" type="button" id="clearAccessoryBtn">Clear</button>
                                </div>
                            </div>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Accessory</th>
                                    <th>Barcode</th>
                                    <th>Qty</th>
                                    <th>Price (LKR)</th>
                                    <th>Subtotal (LKR)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="accessoryCartBody">
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #7a86ad;">No accessories added yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <table>
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>IMEI</th>
                                <th>Qty</th>
                                <th>Price (LKR)</th>
                                <th>Subtotal (LKR)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                            <tr>
                                <td colspan="6" style="text-align: center; color: #7a86ad;">No items added yet.</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="sale-summary">
                        <div class="summary-card">
                            <span>Subtotal</span>
                            <strong id="subtotalValue">LKR 0.00</strong>
                        </div>
                        <div class="summary-card">
                            <span>Discount</span>
                            <input class="table-input" type="number" id="totalDiscount" min="0" step="0.01" value="0" style="margin-top: 6px;">
                        </div>
                        <div class="summary-card">
                            <span>Total</span>
                            <strong id="totalValue">LKR 0.00</strong>
                        </div>
                    </div>

                    </div>

                    <div class="form-actions">
                        <button class="button-secondary" type="reset">Clear</button>
                        <button class="button-primary" type="submit">Complete Sale</button>
                    </div>
                </form>
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

        const saleDateInput = document.getElementById('saleDate');
        if (saleDateInput && !saleDateInput.value) {
            const today = new Date();
            saleDateInput.value = today.toISOString().slice(0, 10);
        }

        const API_BASE_URL = 'http://localhost:3000/api';
        const PRODUCTS_API = `${API_BASE_URL}/products`;
        const CUSTOMERS_API = `${API_BASE_URL}/customers`;
        const SALES_API = `${API_BASE_URL}/sales`;
        const VAULT_ACCOUNTS_API = `${API_BASE_URL}/vault/accounts`;

        let products = [];
        let customers = [];
        let vaultAccounts = [];

        const productSearch = document.getElementById('productSearch');
        const productDropdown = document.getElementById('productDropdown');
        const customerNameInput = document.getElementById('customerName');
        const customerDropdown = document.getElementById('customerDropdown');
        const customerIdInput = document.getElementById('customerId');
        const customerPhoneInput = document.getElementById('customerPhone');
        const customerPhoneDropdown = document.getElementById('customerPhoneDropdown');
        const customerAddressInput = document.getElementById('customerAddress');
        const clearCustomerBtn = document.getElementById('clearCustomerBtn');
        const accessoriesSearch = document.getElementById('accessoriesSearch');
        const accessoriesDropdown = document.getElementById('accessoriesDropdown');
        const imeiSearch = document.getElementById('imeiSearch');
        const imeiInput = document.getElementById('imeiNumber');
        const brandInput = document.getElementById('brand');
        const modelInput = document.getElementById('model');
        const storageInput = document.getElementById('storage');
        const colorInput = document.getElementById('color');
        const devicePriceInput = document.getElementById('devicePrice');
        const deviceDescInput = document.getElementById('deviceDescription');
        const accessoryBarcodeInput = document.getElementById('accessoryBarcode');
        const accessoryPriceInput = document.getElementById('accessoryPrice');
        const cartBody = document.getElementById('cartBody');
        const accessoryCartBody = document.getElementById('accessoryCartBody');
        const addDeviceBtn = document.getElementById('addDeviceBtn');
        const clearDeviceBtn = document.getElementById('clearDeviceBtn');
        const addAccessoryBtn = document.getElementById('addAccessoryBtn');
        const clearAccessoryBtn = document.getElementById('clearAccessoryBtn');
        const subtotalValue = document.getElementById('subtotalValue');
        const totalValue = document.getElementById('totalValue');
        const totalDiscountInput = document.getElementById('totalDiscount');
        const paymentMethodInput = document.getElementById('paymentMethod');
        const saleAccountInput = document.getElementById('saleAccount');
        const saleAccountHint = document.getElementById('saleAccountHint');
        const saleStatusInput = document.getElementById('saleStatus');
        const saleForm = document.getElementById('createSaleForm');
        const submitButton = saleForm ? saleForm.querySelector('button[type="submit"]') : null;

        let selectedProduct = null;
        let selectedAccessory = null;
        let selectedCustomer = null;

        function formatLkr(amount) {
            return 'LKR ' + amount.toFixed(2);
        }

        function showAutocomplete(dropdown, items, onSelect) {
            if (!items || items.length === 0) {
                dropdown.innerHTML = '<div class="autocomplete-item autocomplete-empty">No results found</div>';
                dropdown.style.display = 'block';
                return;
            }

            dropdown.innerHTML = items.map(item => {
                if (item.type === 'customer') {
                    return `
                        <div class="autocomplete-item" data-id="${item.id}">
                            <div class="autocomplete-main">
                                <strong>${item.name}</strong>
                                <span class="autocomplete-meta">${item.id}</span>
                            </div>
                            <div class="autocomplete-secondary">
                                <span class="autocomplete-brand">${item.phone || '-'}</span>
                            </div>
                        </div>
                    `;
                }

                if (item.brand) {
                    // Product item
                    return `
                        <div class="autocomplete-item" data-id="${item.id}">
                            <div class="autocomplete-main">
                                <strong>${item.name}</strong>
                                <span class="autocomplete-meta">${item.storage} · ${item.color}</span>
                            </div>
                            <div class="autocomplete-secondary">
                                <span class="autocomplete-brand">${item.brand}</span>
                                <span class="autocomplete-price">${formatLkr(item.price)}${Number.isFinite(item.stock) ? ` · Stock ${item.stock}` : ''}</span>
                            </div>
                        </div>
                    `;
                } else {
                    // Accessory item
                    return `
                        <div class="autocomplete-item" data-id="${item.id}">
                            <div class="autocomplete-main">
                                <strong>${item.name}</strong>
                            </div>
                            <div class="autocomplete-secondary">
                                <span class="autocomplete-price">${formatLkr(item.price)}</span>
                            </div>
                        </div>
                    `;
                }
            }).join('');

            dropdown.style.display = 'block';

            dropdown.querySelectorAll('.autocomplete-item[data-id]').forEach(element => {
                element.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const item = items.find(i => i.id === itemId);
                    if (item) {
                        onSelect(item);
                    }
                });
            });
        }

        function hideAutocomplete(dropdown) {
            dropdown.style.display = 'none';
            dropdown.innerHTML = '';
        }

        function filterProducts(query) {
            const search = query.toLowerCase().trim();
            if (!search) return [];

            return products.filter(p => {
                return p.name.toLowerCase().includes(search) ||
                       p.brand.toLowerCase().includes(search) ||
                       p.model.toLowerCase().includes(search) ||
                       p.storage.toLowerCase().includes(search) ||
                       p.color.toLowerCase().includes(search) ||
                       p.id.toLowerCase().includes(search) ||
                       p.imei.includes(search);
            });
        }

        function filterCustomers(query) {
            const search = query.toLowerCase().trim();
            if (!search) return [];

            return customers.filter(c => {
                return c.name.toLowerCase().includes(search) ||
                    c.id.toLowerCase().includes(search) ||
                    (c.phone || '').toLowerCase().includes(search);
            });
        }

        function normalizePhone(phone) {
            return String(phone || '').replace(/\D/g, '');
        }

        function filterCustomersByPhone(query) {
            const normalizedQuery = normalizePhone(query);
            if (!normalizedQuery) {
                return [];
            }

            return customers.filter(c => normalizePhone(c.phone).includes(normalizedQuery));
        }

        function filterAccessories(query) {
            return filterProducts(query);
        }

        function selectProduct(product) {
            selectedProduct = product;
            productSearch.value = product.name;
            brandInput.value = product.brand;
            modelInput.value = product.model;
            storageInput.value = product.storage;
            colorInput.value = product.color;
            imeiInput.value = product.imei;
            devicePriceInput.value = product.price;
            deviceDescInput.value = product.description;
            hideAutocomplete(productDropdown);
        }

        function selectAccessory(accessory) {
            selectedAccessory = accessory;
            accessoriesSearch.value = accessory.name;
            accessoryBarcodeInput.value = accessory.barcode || '';
            accessoryPriceInput.value = accessory.price;
            hideAutocomplete(accessoriesDropdown);
        }

        function selectCustomer(customerData) {
            selectedCustomer = customerData;
            customerNameInput.value = customerData.name;
            customerIdInput.value = customerData.id;
            customerPhoneInput.value = customerData.phone || '';
            customerAddressInput.value = customerData.address || '';
            hideAutocomplete(customerDropdown);
        }

        function clearCustomerSelection() {
            selectedCustomer = null;
            customerIdInput.value = '';
            customerNameInput.value = '';
            customerPhoneInput.value = '';
            customerAddressInput.value = '';
            hideAutocomplete(customerDropdown);
            hideAutocomplete(customerPhoneDropdown);
        }

        function normalizeProduct(product) {
            const stock = Number(product.Product_Stock?.quantity_in_stock ?? 0);
            const defaultPrice = Number(product.Product_Stock?.selling_price ?? product.price ?? 0);

            return {
                id: product.id,
                name: product.productName || '',
                brand: product.brand || '',
                model: product.model || '',
                storage: product.capacity || '',
                color: product.color || '',
                price: Number.isFinite(defaultPrice) ? defaultPrice : 0,
                imei: product.IMEI || '',
                barcode: product.barcode || '',
                description: product.description || '',
                stock,
            };
        }

        function normalizeCustomer(customerData) {
            return {
                type: 'customer',
                id: customerData.customer_id,
                name: customerData.name || '',
                phone: customerData.phone_number || '',
                address: customerData.address || '',
            };
        }

        function normalizeVaultAccount(accountData) {
            return {
                id: accountData.account_id,
                type: String(accountData.account_type || '').toLowerCase(),
                display: accountData.display_name || accountData.account_id || 'Account',
                balance: Number(accountData.available_balance || 0),
            };
        }

        function getRequiredAccountType(paymentMethod) {
            const method = String(paymentMethod || '').toLowerCase();
            if (method === 'cash') return 'drawer';
            if (method === 'bank_transfer' || method === 'card' || method === 'koko') return 'bank';
            return null;
        }

        function renderSaleAccountOptions() {
            if (!saleAccountInput) return;

            const requiredType = getRequiredAccountType(paymentMethodInput?.value);
            const available = requiredType
                ? vaultAccounts.filter(acc => acc.type === requiredType)
                : [...vaultAccounts];

            const previousValue = saleAccountInput.value;

            const placeholder = requiredType
                ? `Select ${requiredType} account...`
                : 'Select account...';

            saleAccountInput.innerHTML = `<option value="">${placeholder}</option>` + available.map(acc => {
                return `<option value="${acc.id}">${acc.display} · LKR ${acc.balance.toLocaleString()}</option>`;
            }).join('');

            if (available.some(acc => acc.id === previousValue)) {
                saleAccountInput.value = previousValue;
            }

            if (saleAccountHint) {
                if (requiredType === 'drawer') {
                    saleAccountHint.textContent = 'Cash requires a drawer account.';
                } else if (requiredType === 'bank') {
                    saleAccountHint.textContent = 'Card, Bank Transfer, and Koko require a bank account.';
                } else {
                    saleAccountHint.textContent = 'Select account for transaction.';
                }
            }
        }

        async function loadInitialData() {
            try {
                const [productsResponse, customersResponse, accountsResponse] = await Promise.all([
                    fetch(PRODUCTS_API),
                    fetch(CUSTOMERS_API),
                    fetch(VAULT_ACCOUNTS_API),
                ]);

                const productsResult = await productsResponse.json();
                const customersResult = await customersResponse.json();
                const accountsResult = await accountsResponse.json();

                if (!productsResponse.ok || !productsResult.success) {
                    throw new Error(productsResult.message || productsResult.error || 'Failed to load products');
                }

                if (!customersResponse.ok || !customersResult.success) {
                    throw new Error(customersResult.message || customersResult.error || 'Failed to load customers');
                }

                if (!accountsResponse.ok || !accountsResult.success) {
                    throw new Error(accountsResult.message || accountsResult.error || 'Failed to load vault accounts');
                }

                products = (productsResult.data || []).map(normalizeProduct);
                customers = (customersResult.data || []).map(normalizeCustomer);
                vaultAccounts = (accountsResult.accounts || []).map(normalizeVaultAccount);
                renderSaleAccountOptions();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Load Error',
                    html: `Unable to load products/customers/accounts.<br><br><small>${error.message}</small>`,
                });
            }
        }

        if (paymentMethodInput) {
            paymentMethodInput.addEventListener('change', renderSaleAccountOptions);
        }

        // Product search autocomplete
        if (productSearch) {
            productSearch.addEventListener('input', function() {
                const query = this.value;
                selectedProduct = null;
                if (query.length === 0) {
                    hideAutocomplete(productDropdown);
                    return;
                }

                const filtered = filterProducts(query);
                showAutocomplete(productDropdown, filtered, selectProduct);
            });

            productSearch.addEventListener('focus', function() {
                if (this.value.length > 0) {
                    const filtered = filterProducts(this.value);
                    showAutocomplete(productDropdown, filtered, selectProduct);
                }
            });

            productSearch.addEventListener('blur', function() {
                setTimeout(() => hideAutocomplete(productDropdown), 200);
            });
        }

        if (customerNameInput) {
            customerNameInput.addEventListener('input', function() {
                customerIdInput.value = '';
                selectedCustomer = null;

                const query = this.value;
                if (query.length === 0) {
                    hideAutocomplete(customerDropdown);
                    return;
                }

                const filtered = filterCustomers(query);
                showAutocomplete(customerDropdown, filtered, selectCustomer);
            });

            customerNameInput.addEventListener('focus', function() {
                if (this.value.length > 0) {
                    const filtered = filterCustomers(this.value);
                    showAutocomplete(customerDropdown, filtered, selectCustomer);
                }
            });

            customerNameInput.addEventListener('blur', function() {
                setTimeout(() => hideAutocomplete(customerDropdown), 200);
            });
        }

        if (customerPhoneInput) {
            customerPhoneInput.addEventListener('input', function() {
                customerIdInput.value = '';
                selectedCustomer = null;

                const query = this.value;
                if (query.length === 0) {
                    hideAutocomplete(customerPhoneDropdown);
                    return;
                }

                const filtered = filterCustomersByPhone(query);
                showAutocomplete(customerPhoneDropdown, filtered, selectCustomer);
            });

            customerPhoneInput.addEventListener('focus', function() {
                if (this.value.length > 0) {
                    const filtered = filterCustomersByPhone(this.value);
                    showAutocomplete(customerPhoneDropdown, filtered, selectCustomer);
                }
            });

            customerPhoneInput.addEventListener('blur', function() {
                setTimeout(() => hideAutocomplete(customerPhoneDropdown), 200);
            });
        }

        if (clearCustomerBtn) {
            clearCustomerBtn.addEventListener('click', clearCustomerSelection);
        }

        // Accessories search autocomplete
        if (accessoriesSearch) {
            accessoriesSearch.addEventListener('input', function() {
                const query = this.value;
                selectedAccessory = null;
                if (query.length === 0) {
                    hideAutocomplete(accessoriesDropdown);
                    return;
                }

                const filtered = filterAccessories(query);
                showAutocomplete(accessoriesDropdown, filtered, selectAccessory);
            });

            accessoriesSearch.addEventListener('focus', function() {
                if (this.value.length > 0) {
                    const filtered = filterAccessories(this.value);
                    showAutocomplete(accessoriesDropdown, filtered, selectAccessory);
                }
            });

            accessoriesSearch.addEventListener('blur', function() {
                setTimeout(() => hideAutocomplete(accessoriesDropdown), 200);
            });
        }

        // IMEI search filter
        if (imeiSearch) {
            imeiSearch.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length < 4) return;

                const last4 = query.slice(-4);
                const found = products.find(p => p.imei.endsWith(last4));

                if (found) {
                    selectProduct(found);
                }
            });
        }

        function updateTotals() {
            const deviceRows = cartBody.querySelectorAll('tr[data-item]');
            const accessoryRows = accessoryCartBody.querySelectorAll('tr[data-item]');
            let subtotal = 0;

            deviceRows.forEach(row => {
                const qty = Number(row.querySelector('[data-qty]').value || 0);
                const price = Number(row.querySelector('[data-price]').value || 0);
                const lineTotal = qty * price;
                row.querySelector('[data-total]').value = lineTotal.toFixed(2);
                subtotal += lineTotal;
            });

            accessoryRows.forEach(row => {
                const qty = Number(row.querySelector('[data-qty]').value || 0);
                const price = Number(row.querySelector('[data-price]').value || 0);
                const lineTotal = qty * price;
                row.querySelector('[data-total]').value = lineTotal.toFixed(2);
                subtotal += lineTotal;
            });

            const discount = Number(totalDiscountInput?.value || 0);
            const total = Math.max(0, subtotal - discount);

            subtotalValue.textContent = formatLkr(subtotal);
            totalValue.textContent = formatLkr(total);
        }

        function attachRowEvents(row, container, emptyMessage, trackStock = false) {
            row.querySelector('[data-remove]').addEventListener('click', function() {
                row.remove();
                if (!container.querySelector('tr[data-item]')) {
                    container.innerHTML = `<tr><td colspan="6" style="text-align: center; color: #7a86ad;">${emptyMessage}</td></tr>`;
                }
                updateTotals();
            });

            row.querySelectorAll('[data-qty], [data-price]').forEach(input => {
                input.addEventListener('input', function() {
                    if (input.hasAttribute('data-qty')) {
                        const quantity = Number(input.value || 1);
                        if (quantity < 1) {
                            input.value = '1';
                        }

                        if (trackStock) {
                            const max = Number(row.getAttribute('data-stock') || 0);
                            if (max > 0 && Number(input.value) > max) {
                                input.value = String(max);
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Stock Limit',
                                    text: `Only ${max} item(s) available in stock.`,
                                });
                            }
                        }
                    }

                    updateTotals();
                });
            });
        }

        function addRow(productData, isAccessory = false) {
            if (!productData || !productData.id) {
                return;
            }

            if (Number(productData.stock) <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Out of Stock',
                    text: `${productData.name} is currently out of stock.`,
                });
                return;
            }

            const targetBody = isAccessory ? accessoryCartBody : cartBody;
            const emptyMessage = isAccessory ? 'No accessories added yet.' : 'No items added yet.';
            const price = Number(productData.price || 0);

            const existingRow = targetBody.querySelector(`tr[data-product-id="${productData.id}"]`);
            if (existingRow) {
                const qtyInput = existingRow.querySelector('[data-qty]');
                const currentQty = Number(qtyInput.value || 1);
                const maxStock = Number(existingRow.getAttribute('data-stock') || 0);
                qtyInput.value = String(Math.min(currentQty + 1, maxStock || currentQty + 1));
                updateTotals();
                return;
            }

            const emptyRow = targetBody.querySelector('tr:not([data-item])');
            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.setAttribute('data-item', productData.name);
            row.setAttribute('data-product-id', productData.id);
            row.setAttribute('data-stock', String(productData.stock || 0));

            const secondColumnValue = isAccessory
                ? (productData.barcode || '')
                : (productData.imei || '');
            const secondColumnPlaceholder = isAccessory ? 'Barcode' : 'IMEI';
            const secondColumnKey = isAccessory ? 'data-barcode' : 'data-imei';

            row.innerHTML = `
                <td>${productData.name}</td>
                <td><input class="table-input" ${secondColumnKey} type="text" value="${secondColumnValue}" placeholder="${secondColumnPlaceholder}"></td>
                <td><input class="table-input" data-qty type="number" min="1" value="1"></td>
                <td><input class="table-input" data-price type="number" min="0" step="0.01" value="${price}"></td>
                <td><input class="table-input" data-total type="number" min="0" step="0.01" value="${price}" readonly></td>
                <td><button class="button-secondary" type="button" data-remove>Remove</button></td>
            `;

            targetBody.appendChild(row);
            attachRowEvents(row, targetBody, emptyMessage, true);
            updateTotals();
        }

        if (addDeviceBtn) {
            addDeviceBtn.addEventListener('click', function() {
                if (!selectedProduct) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Product',
                        text: 'Please select a product first.',
                    });
                    return;
                }

                addRow(selectedProduct);
            });
        }

        if (clearDeviceBtn) {
            clearDeviceBtn.addEventListener('click', function() {
                selectedProduct = null;
                productSearch.value = '';
                brandInput.value = '';
                modelInput.value = '';
                storageInput.value = '';
                colorInput.value = '';
                imeiInput.value = '';
                devicePriceInput.value = '';
                deviceDescInput.value = '';
                if (imeiSearch) {
                    imeiSearch.value = '';
                }
                hideAutocomplete(productDropdown);
            });
        }

        if (addAccessoryBtn) {
            addAccessoryBtn.addEventListener('click', function() {
                if (!selectedAccessory) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Accessory',
                        text: 'Please select an accessory first.',
                    });
                    return;
                }

                addRow(selectedAccessory, true);
            });
        }

        if (clearAccessoryBtn) {
            clearAccessoryBtn.addEventListener('click', function() {
                selectedAccessory = null;
                accessoriesSearch.value = '';
                accessoryBarcodeInput.value = '';
                accessoryPriceInput.value = '';
                hideAutocomplete(accessoriesDropdown);
            });
        }

        if (totalDiscountInput) {
            totalDiscountInput.addEventListener('input', updateTotals);
        }

        function collectSaleItems() {
            const rows = [
                ...cartBody.querySelectorAll('tr[data-product-id]'),
                ...accessoryCartBody.querySelectorAll('tr[data-product-id]'),
            ];

            return rows.map(row => {
                const quantity = Number(row.querySelector('[data-qty]')?.value || 0);
                const unitPrice = Number(row.querySelector('[data-price]')?.value || 0);

                return {
                    product_id: row.getAttribute('data-product-id'),
                    quantity,
                    unit_price: unitPrice,
                    discount: 0,
                };
            }).filter(item => item.product_id && item.quantity > 0 && item.unit_price >= 0);
        }

        function setSubmittingState(isSubmitting) {
            if (!submitButton) {
                return;
            }

            submitButton.disabled = isSubmitting;
            submitButton.innerHTML = isSubmitting
                ? '<i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i>Saving Sale...'
                : 'Complete Sale';
        }

        if (saleForm) {
            saleForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                const items = collectSaleItems();
                if (items.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items',
                        text: 'Add at least one item to create a sale.',
                    });
                    return;
                }

                if (!paymentMethodInput?.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Payment Method Required',
                        text: 'Please select a payment method.',
                    });
                    return;
                }

                if (!saleAccountInput?.value) {
                    const requiredType = getRequiredAccountType(paymentMethodInput?.value);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Account Required',
                        text: requiredType
                            ? `Please select a ${requiredType} account for this payment method.`
                            : 'Please select an account.',
                    });
                    return;
                }

                const payload = {
                    items,
                    payment_method: paymentMethodInput.value,
                    account_id: saleAccountInput.value,
                    status: saleStatusInput?.value || 'completed',
                    total_discount: Number(totalDiscountInput?.value || 0),
                };

                const customerId = customerIdInput?.value?.trim();
                if (customerId) {
                    payload.customer_id = customerId;
                }

                try {
                    setSubmittingState(true);

                    const response = await fetch(SALES_API, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.error || result.message || 'Failed to create sale');
                    }

                    const saleId = result.sale?.sales_id || result.data?.sales_id;
                    const invoiceNo = result.sale?.id || result.data?.id;

                    await Swal.fire({
                        icon: 'success',
                        title: 'Sale Created Successfully',
                        html: `<strong>Invoice #:</strong> ${saleId || 'N/A'}<br><small>Redirecting to print invoice...</small>`,
                        timer: 2000,
                        timerProgressBar: true,
                    });

                    // Redirect to print invoice page
                    window.location.href = `print-invoice.php?id=${encodeURIComponent(saleId || '')}`;

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Create Sale Failed',
                        html: `<small>${error.message}</small>`,
                    });
                } finally {
                    setSubmittingState(false);
                }
            });
        }

        loadInitialData();
    </script>
</body>
</html>
