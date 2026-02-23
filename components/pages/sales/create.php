<?php
$activePage = 'sales';
$basePath = '../';
$pageTitle = 'Create Sale';
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
                        <a class="button-secondary" href="index.php">
                            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
                            Back to Sales
                        </a>
                    </div>
                </div>

                <form class="sale-form" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Customer Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="customerName">Customer Name</label>
                                <div class="inline-field">
                                    <input type="text" id="customerName" name="customerName" class="table-input" placeholder="Walk-in Customer">
                                    <button class="button-secondary" type="button">Quick Add Customer</button>
                                </div>
                            </div>
                            <div class="form-field">
                                <label for="customerPhone">Phone Number</label>
                                <input type="tel" id="customerPhone" name="customerPhone" placeholder="07X XXX XXXX">
                            </div>
                            <div class="form-field">
                                <label for="customerAddress">Address</label>
                                <textarea id="customerAddress" name="customerAddress" placeholder="Customer address"></textarea>
                            </div>
                            <div class="form-field">
                                <label for="saleDate">Date</label>
                                <input type="date" id="saleDate" name="saleDate">
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
                            <strong>LKR 0.00</strong>
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

        // Mock product data
        const products = [
            {
                id: 'iphone14',
                name: 'iPhone 14 Pro',
                brand: 'Apple',
                model: 'iPhone 14 Pro',
                storage: '256GB',
                color: 'Space Black',
                price: 289000,
                imei: '352913547821',
                description: 'Latest iPhone with A16 Bionic chip'
            },
            {
                id: 's23ultra',
                name: 'Samsung S23 Ultra',
                brand: 'Samsung',
                model: 'Galaxy S23 Ultra',
                storage: '512GB',
                color: 'Phantom Black',
                price: 245000,
                imei: '352913547945',
                description: 'Flagship Samsung with S Pen'
            },
            {
                id: 'pixel7',
                name: 'Google Pixel 7',
                brand: 'Google',
                model: 'Pixel 7',
                storage: '128GB',
                color: 'Snow',
                price: 185000,
                imei: '352913547233',
                description: 'Pure Android experience'
            },
            {
                id: 'xiaomi13',
                name: 'Xiaomi 13',
                brand: 'Xiaomi',
                model: 'Xiaomi 13',
                storage: '256GB',
                color: 'Alpine Green',
                price: 165000,
                imei: '352913547108',
                description: 'Flagship performance at great value'
            }
        ];

        // Mock accessories data
        const accessories = [
            { id: 'charger25w', name: 'Fast Charger 25W', price: 1500, barcode: 'ACC001234567' },
            { id: 'typec', name: 'Type-C Cable', price: 800, barcode: 'ACC001234568' },
            { id: 'wireless', name: 'Wireless Charger', price: 3500, barcode: 'ACC001234569' },
            { id: 'protector', name: 'Screen Protector', price: 500, barcode: 'ACC001234570' },
            { id: 'case', name: 'Phone Case', price: 1200, barcode: 'ACC001234571' },
            { id: 'earbuds', name: 'Earbuds', price: 4500, barcode: 'ACC001234572' }
        ];

        const productSearch = document.getElementById('productSearch');
        const productDropdown = document.getElementById('productDropdown');
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

        let selectedProduct = null;
        let selectedAccessory = null;

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
                                <span class="autocomplete-price">${formatLkr(item.price)}</span>
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
                       p.imei.includes(search);
            });
        }

        function filterAccessories(query) {
            const search = query.toLowerCase().trim();
            if (!search) return [];

            return accessories.filter(a => {
                return a.name.toLowerCase().includes(search);
            });
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
            accessoryBarcodeInput.value = accessory.barcode;
            accessoryPriceInput.value = accessory.price;
            hideAutocomplete(accessoriesDropdown);
        }

        // Product search autocomplete
        if (productSearch) {
            productSearch.addEventListener('input', function() {
                const query = this.value;
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

        // Accessories search autocomplete
        if (accessoriesSearch) {
            accessoriesSearch.addEventListener('input', function() {
                const query = this.value;
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

            subtotalValue.textContent = formatLkr(subtotal);
            totalValue.textContent = formatLkr(subtotal);
        }

        function addRow(name, imei, price) {
            if (!name) {
                return;
            }

            const emptyRow = cartBody.querySelector('tr:not([data-item])');
            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.setAttribute('data-item', name);
            row.innerHTML = `
                <td>${name}</td>
                <td><input class="table-input" data-imei type="text" value="${imei || ''}" placeholder="IMEI"></td>
                <td><input class="table-input" data-qty type="number" min="1" value="1"></td>
                <td><input class="table-input" data-price type="number" min="0" step="0.01" value="${price}"></td>
                <td><input class="table-input" data-total type="number" min="0" step="0.01" value="${price}" readonly></td>
                <td><button class="button-secondary" type="button" data-remove>Remove</button></td>
            `;

            cartBody.appendChild(row);

            row.querySelector('[data-remove]').addEventListener('click', function() {
                row.remove();
                if (!cartBody.querySelector('tr[data-item]')) {
                    cartBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #7a86ad;">No items added yet.</td></tr>';
                }
                updateTotals();
            });

            row.querySelectorAll('[data-qty], [data-price]').forEach(input => {
                input.addEventListener('input', updateTotals);
            });

            updateTotals();
        }

        function addAccessoryRow(name, barcode, price) {
            if (!name) {
                return;
            }

            const emptyRow = accessoryCartBody.querySelector('tr:not([data-item])');
            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.setAttribute('data-item', name);
            row.innerHTML = `
                <td>${name}</td>
                <td><input class="table-input" data-barcode type="text" value="${barcode || ''}" placeholder="Barcode"></td>
                <td><input class="table-input" data-qty type="number" min="1" value="1"></td>
                <td><input class="table-input" data-price type="number" min="0" step="0.01" value="${price}"></td>
                <td><input class="table-input" data-total type="number" min="0" step="0.01" value="${price}" readonly></td>
                <td><button class="button-secondary" type="button" data-remove>Remove</button></td>
            `;

            accessoryCartBody.appendChild(row);

            row.querySelector('[data-remove]').addEventListener('click', function() {
                row.remove();
                if (!accessoryCartBody.querySelector('tr[data-item]')) {
                    accessoryCartBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #7a86ad;">No accessories added yet.</td></tr>';
                }
                updateTotals();
            });

            row.querySelectorAll('[data-qty], [data-price]').forEach(input => {
                input.addEventListener('input', updateTotals);
            });

            updateTotals();
        }

        if (addDeviceBtn) {
            addDeviceBtn.addEventListener('click', function() {
                if (!selectedProduct) {
                    alert('Please select a product first');
                    return;
                }

                const name = selectedProduct.name;
                const price = selectedProduct.price;
                const imei = imeiInput.value.trim();

                addRow(name, imei, price);
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
                    alert('Please select an accessory first');
                    return;
                }

                const name = selectedAccessory.name;
                const price = selectedAccessory.price;
                const barcode = accessoryBarcodeInput.value.trim();

                addAccessoryRow(name, barcode, price);
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
    </script>
</body>
</html>
