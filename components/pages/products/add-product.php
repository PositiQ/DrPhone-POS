<?php
$activePage = 'products';
$basePath = '../';
$pageTitle = 'Add Product';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Add Product</title>
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
                            <i class="fas fa-arrow-left"></i>
                            Back to Products
                        </a>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-secondary" href="../inventory/index.php">
                            <i class="fas fa-warehouse"></i>
                            View Inventory
                        </a>
                    </div>
                </div>

                <form class="sale-form" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Basic Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="productName">Product Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="productName" name="productName" placeholder="e.g., iPhone 14 Pro" required>
                            </div>
                            <div class="form-field">
                                <label for="category">Category <span style="color: #f44336;">*</span></label>
                                <select id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option>Smartphone</option>
                                    <option>Accessory</option>
                                    <option>Tablet</option>
                                    <option>Smartwatch</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="brand">Brand <span style="color: #f44336;">*</span></label>
                                <input type="text" id="brand" name="brand" placeholder="e.g., Apple" required>
                            </div>
                            <div class="form-field">
                                <label for="model">Model</label>
                                <input type="text" id="model" name="model" placeholder="e.g., A2649">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="storage">Storage/Capacity</label>
                                <input type="text" id="storage" name="storage" placeholder="e.g., 256GB">
                            </div>
                            <div class="form-field">
                                <label for="color">Color</label>
                                <input type="text" id="color" name="color" placeholder="e.g., Space Black">
                            </div>
                            <div class="form-field">
                                <label for="condition">Condition</label>
                                <select id="condition" name="condition">
                                    <option>Brand New</option>
                                    <option>Used - Like New</option>
                                    <option>Used - Good</option>
                                    <option>Used - Fair</option>
                                    <option>Refurbished</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="warranty">Warranty Period</label>
                                <input type="text" id="warranty" name="warranty" placeholder="e.g., 1 Year">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Identifiers & SKU</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="sku">SKU (Stock Keeping Unit) <span style="color: #f44336;">*</span></label>
                                <input type="text" id="sku" name="sku" placeholder="e.g., SKU-IP14P-256" required>
                                <div class="form-hint">Unique product identifier</div>
                            </div>
                            <div class="form-field">
                                <label for="imei">IMEI Number</label>
                                <input type="text" id="imei" name="imei" placeholder="15 digits for phones">
                            </div>
                            <div class="form-field">
                                <label for="barcode">Barcode</label>
                                <input type="text" id="barcode" name="barcode" placeholder="Product barcode">
                            </div>
                            <div class="form-field">
                                <label for="serialNumber">Serial Number</label>
                                <input type="text" id="serialNumber" name="serialNumber" placeholder="Unique serial">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Pricing</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="costPrice">Cost Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="costPrice" name="costPrice" placeholder="0.00" step="0.01" required>
                                <div class="form-hint">Purchase/wholesale price</div>
                            </div>
                            <div class="form-field">
                                <label for="sellingPrice">Selling Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="sellingPrice" name="sellingPrice" placeholder="0.00" step="0.01" required>
                                <div class="form-hint">Retail price for customers</div>
                            </div>
                            <div class="form-field">
                                <label for="profitMargin">Profit Margin</label>
                                <input type="text" id="profitMargin" name="profitMargin" placeholder="Auto-calculated" readonly>
                                <div class="form-hint">Calculated automatically</div>
                            </div>
                            <div class="form-field">
                                <label for="taxRate">Tax Rate (%)</label>
                                <input type="number" id="taxRate" name="taxRate" placeholder="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Stock Management</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="quantity">Opening Stock <span style="color: #f44336;">*</span></label>
                                <input type="number" id="quantity" name="quantity" placeholder="0" min="0" required>
                                <div class="form-hint">Initial quantity in stock</div>
                            </div>
                            <div class="form-field">
                                <label for="minStock">Minimum Stock Level</label>
                                <input type="number" id="minStock" name="minStock" placeholder="5" min="0">
                                <div class="form-hint">Alert when stock is below</div>
                            </div>
                            <div class="form-field">
                                <label for="supplier">Supplier</label>
                                <select id="supplier" name="supplier">
                                    <option value="">Select Supplier</option>
                                    <option>Main Distributor Ltd</option>
                                    <option>Tech Imports</option>
                                    <option>Mobile Wholesale</option>
                                    <option>Direct from Manufacturer</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="location">Storage Location</label>
                                <input type="text" id="location" name="location" placeholder="e.g., Shelf A1">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Additional Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="dateAdded">Date Added</label>
                                <input type="date" id="dateAdded" name="dateAdded">
                            </div>
                            <div class="form-field">
                                <label for="status">Product Status</label>
                                <select id="status" name="status">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>Discontinued</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="featured">Featured Product</label>
                                <select id="featured" name="featured">
                                    <option>No</option>
                                    <option>Yes</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label>&nbsp;</label>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                    <input type="checkbox" id="trackInventory" name="trackInventory" checked style="width: auto;">
                                    <label for="trackInventory" style="margin: 0; font-size: 13px;">Track inventory for this product</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="description">Product Description</label>
                                <textarea id="description" name="description" placeholder="Detailed product description, features, specifications..." rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="notes">Internal Notes</label>
                                <textarea id="notes" name="notes" placeholder="Notes for staff only (not visible to customers)" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="button-secondary" href="index.php">Cancel</a>
                        <button class="button-secondary" type="button" onclick="document.getElementById('status').value = 'Inactive'; this.form.submit();">
                            Save as Draft
                        </button>
                        <button class="button-primary" type="submit">
                            <i class="fas fa-check"></i>
                            Add Product
                        </button>
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

        // Auto-set date added to today
        const dateAddedInput = document.getElementById('dateAdded');
        if (dateAddedInput && !dateAddedInput.value) {
            const today = new Date();
            dateAddedInput.value = today.toISOString().slice(0, 10);
        }

        // Auto-generate SKU
        const productName = document.getElementById('productName');
        const storage = document.getElementById('storage');
        const skuInput = document.getElementById('sku');

        function generateSKU() {
            if (productName.value && !skuInput.value) {
                const name = productName.value.substring(0, 5).toUpperCase().replace(/\s/g, '');
                const storageVal = storage.value ? '-' + storage.value.replace(/\s/g, '') : '';
                const random = Math.floor(Math.random() * 1000);
                skuInput.value = `SKU-${name}${storageVal}-${random}`;
            }
        }

        if (productName && skuInput) {
            productName.addEventListener('blur', generateSKU);
            storage.addEventListener('blur', generateSKU);
        }

        // Calculate profit margin
        const costPrice = document.getElementById('costPrice');
        const sellingPrice = document.getElementById('sellingPrice');
        const profitMargin = document.getElementById('profitMargin');

        function updateProfitMargin() {
            const cost = parseFloat(costPrice.value) || 0;
            const selling = parseFloat(sellingPrice.value) || 0;
            
            if (cost > 0 && selling > 0) {
                const profit = selling - cost;
                const margin = ((profit / selling) * 100).toFixed(2);
                profitMargin.value = `${margin}% (LKR ${profit.toFixed(2)})`;
            } else {
                profitMargin.value = '';
            }
        }

        if (costPrice && sellingPrice && profitMargin) {
            costPrice.addEventListener('input', updateProfitMargin);
            sellingPrice.addEventListener('input', updateProfitMargin);
        }
    </script>
</body>
</html>
