<?php
$activePage = 'products';
$basePath = '../';
$pageTitle = 'Edit Product';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Edit Product</title>
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
                            <i class="fas fa-arrow-left"></i>
                            Back to Products
                        </a>
                    </div>
                </div>

                <form class="sale-form" id="editProductForm" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Product Information</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="productId">Product ID</label>
                                <input type="text" id="productId" readonly>
                            </div>
                            <div class="form-field">
                                <label for="productName">Product Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="productName" name="productName" required>
                            </div>
                            <div class="form-field">
                                <label for="product_type">Product Type <span style="color: #f44336;">*</span></label>
                                <select id="product_type" name="product_type" required>
                                    <option value="phone">Phone</option>
                                    <option value="accessory">Accessory</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="brand">Brand <span style="color: #f44336;">*</span></label>
                                <input type="text" id="brand" name="brand" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="price">Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="form-field">
                                <label for="model">Model</label>
                                <input type="text" id="model" name="model">
                            </div>
                            <div class="form-field">
                                <label for="color">Color</label>
                                <input type="text" id="color" name="color">
                            </div>
                        </div>

                        <div class="form-grid" id="phoneSpecificFields">
                            <div class="form-field">
                                <label for="capacity">Capacity</label>
                                <input type="text" id="capacity" name="capacity">
                            </div>
                            <div class="form-field">
                                <label for="condition">Condition</label>
                                <input type="text" id="condition" name="condition">
                            </div>
                            <div class="form-field">
                                <label for="warrenty">Warranty</label>
                                <input type="text" id="warrenty" name="warrenty">
                            </div>
                            <div class="form-field">
                                <label for="IMEI">IMEI <span id="imeiRequired"></span></label>
                                <input type="text" id="IMEI" name="IMEI">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="barcode">Barcode</label>
                                <input type="text" id="barcode" name="barcode">
                            </div>
                            <div class="form-field">
                                <label for="serialNumber">Serial Number</label>
                                <input type="text" id="serialNumber" name="serialNumber">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Pricing & SKU</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="sku">SKU (Stock Keeping Unit) <span style="color: #f44336;">*</span></label>
                                <input type="text" id="sku" name="sku" placeholder="e.g., SKU-IP14P-256" required>
                                <div class="form-hint">Unique product identifier</div>
                            </div>
                            <div class="form-field">
                                <label for="cost_price">Cost Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="cost_price" name="cost_price" placeholder="0.00" step="0.01" required>
                                <div class="form-hint">Purchase/wholesale price</div>
                            </div>
                            <div class="form-field">
                                <label for="selling_price">Selling Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="selling_price" name="selling_price" placeholder="0.00" step="0.01" required>
                                <div class="form-hint">Retail price for customers</div>
                            </div>
                            <div class="form-field">
                                <label for="profit_margin">Profit Margin</label>
                                <input type="text" id="profit_margin" name="profit_margin" placeholder="Auto-calculated" readonly>
                                <div class="form-hint">Calculated automatically</div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Stock Management</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="quantity_in_stock">Quantity in Stock</label>
                                <input type="number" id="quantity_in_stock" name="quantity_in_stock" placeholder="1" min="0">
                                <div class="form-hint">Available quantity for this product</div>
                            </div>
                            <div class="form-field">
                                <label for="minimum_stock_level">Minimum Stock Level</label>
                                <input type="number" id="minimum_stock_level" name="minimum_stock_level" placeholder="5" min="0">
                                <div class="form-hint">Alert when stock is below this level</div>
                            </div>
                            <div class="form-field">
                                <label for="supplier">Supplier</label>
                                <input type="text" id="supplier" name="supplier" placeholder="Supplier name">
                            </div>
                            <div class="form-field">
                                <label for="storage_location">Storage Location</label>
                                <input type="text" id="storage_location" name="storage_location" placeholder="e.g., Shelf A1">
                            </div>
                            <div class="form-field">
                                <label for="date_added">Date Added</label>
                                <input type="date" id="date_added" name="date_added">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Additional Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="status">Stock Status</label>
                                <select id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="discontinued">Discontinued</option>
                                    <option value="in_stock">In Stock</option>
                                    <option value="sold">Sold</option>
                                </select>
                                <div class="form-hint">Current stock status</div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-actions">
                        <a class="button-secondary" href="index.php">Cancel</a>
                        <button class="button-primary" type="submit" id="updateBtn">
                            <i class="fas fa-save"></i>
                            Save Changes
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
        const API_URL = 'http://localhost:3000/api/products';
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('id');

        const form = document.getElementById('editProductForm');
        const updateBtn = document.getElementById('updateBtn');

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

        function setLoading(isLoading) {
            updateBtn.disabled = isLoading;
            updateBtn.innerHTML = isLoading
                ? '<i class="fas fa-spinner fa-spin"></i> Saving...'
                : '<i class="fas fa-save"></i> Save Changes';
        }

        // Handle product type change
        const productTypeSelect = document.getElementById('product_type');
        const phoneSpecificFields = document.getElementById('phoneSpecificFields');
        const imeiRequired = document.getElementById('imeiRequired');
        const imeiInput = document.getElementById('IMEI');

        function togglePhoneFields() {
            const isPhone = productTypeSelect.value === 'phone';
            
            if (isPhone) {
                phoneSpecificFields.style.display = 'grid';
                imeiRequired.textContent = '*';
                imeiInput.required = true;
            } else {
                phoneSpecificFields.style.display = 'none';
                imeiRequired.textContent = '';
                imeiInput.required = false;
                imeiInput.value = '';
            }
        }

        if (productTypeSelect) {
            productTypeSelect.addEventListener('change', togglePhoneFields);
        }

        // Calculate profit margin
        const costPrice = document.getElementById('cost_price');
        const sellingPrice = document.getElementById('selling_price');
        const profitMargin = document.getElementById('profit_margin');

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

        function fillForm(product) {
            document.getElementById('productId').value = product.id || '';
            document.getElementById('productName').value = product.productName || '';
            document.getElementById('product_type').value = product.product_type || 'phone';
            document.getElementById('brand').value = product.brand || '';
            document.getElementById('price').value = product.price || '';
            document.getElementById('model').value = product.model || '';
            document.getElementById('color').value = product.color || '';
            document.getElementById('capacity').value = product.capacity || '';
            document.getElementById('condition').value = product.condition || '';
            document.getElementById('warrenty').value = product.warrenty || '';
            document.getElementById('IMEI').value = product.IMEI || '';
            document.getElementById('barcode').value = product.barcode || '';
            document.getElementById('serialNumber').value = product.serialNumber || '';
            document.getElementById('description').value = product.description || '';
            
            // Fill stock/pricing fields
            const stock = product.Product_Stock || {};
            document.getElementById('sku').value = stock.sku || '';
            document.getElementById('cost_price').value = stock.cost_price || '';
            document.getElementById('selling_price').value = stock.selling_price || '';
            document.getElementById('profit_margin').value = stock.profit_margin ? `${stock.profit_margin}%` : '';
            document.getElementById('quantity_in_stock').value = stock.quantity_in_stock || '';
            document.getElementById('minimum_stock_level').value = stock.minimum_stock_level || '';
            document.getElementById('supplier').value = stock.supplier || '';
            document.getElementById('storage_location').value = stock.storage_location || '';
            document.getElementById('date_added').value = stock.date_added || '';
            document.getElementById('status').value = stock.status || 'active';
            
            // Trigger the toggle to show/hide phone fields
            togglePhoneFields();
            
            // Calculate profit margin on load
            updateProfitMargin();
        }

        async function loadProduct() {
            if (!productId) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Invalid Request',
                    text: 'Product ID is missing in URL.'
                });
                window.location.href = 'index.php';
                return;
            }

            try {
                const response = await fetch(`${API_URL}/${productId}`);
                const result = await response.json();

                if (!response.ok || !result.success || !result.data) {
                    throw new Error(result.message || 'Product not found');
                }

                fillForm(result.data);
            } catch (error) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Failed to Load Product',
                    text: error.message || 'Unable to fetch product data.'
                });
                window.location.href = 'index.php';
            }
        }

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const payload = {
                // Product fields
                productName: document.getElementById('productName').value.trim(),
                brand: document.getElementById('brand').value.trim(),
                price: parseFloat(document.getElementById('price').value),
                product_type: document.getElementById('product_type').value,
                model: document.getElementById('model').value.trim() || null,
                color: document.getElementById('color').value.trim() || null,
                capacity: document.getElementById('capacity').value.trim() || null,
                condition: document.getElementById('condition').value.trim() || null,
                warrenty: document.getElementById('warrenty').value.trim() || null,
                IMEI: document.getElementById('IMEI').value.trim() || null,
                barcode: document.getElementById('barcode').value.trim() || null,
                serialNumber: document.getElementById('serialNumber').value.trim() || null,
                description: document.getElementById('description').value.trim() || null,
                
                // Stock/Pricing fields
                sku: document.getElementById('sku').value.trim() || null,
                cost_price: document.getElementById('cost_price').value ? parseFloat(document.getElementById('cost_price').value) : null,
                selling_price: document.getElementById('selling_price').value ? parseFloat(document.getElementById('selling_price').value) : null,
                quantity_in_stock: document.getElementById('quantity_in_stock').value ? parseInt(document.getElementById('quantity_in_stock').value) : null,
                minimum_stock_level: document.getElementById('minimum_stock_level').value ? parseInt(document.getElementById('minimum_stock_level').value) : null,
                supplier: document.getElementById('supplier').value.trim() || null,
                storage_location: document.getElementById('storage_location').value.trim() || null,
                date_added: document.getElementById('date_added').value || null,
                status: document.getElementById('status').value
            };

            if (!payload.productName || !payload.brand || Number.isNaN(payload.price)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Product Name, Brand and Price are required.'
                });
                return;
            }

            Object.keys(payload).forEach((key) => {
                if (payload[key] === null || payload[key] === '') {
                    delete payload[key];
                }
            });

            setLoading(true);

            try {
                const response = await fetch(`${API_URL}/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.error || result.message || 'Failed to update product');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Product Updated',
                    text: 'Changes were saved successfully.'
                });

                window.location.href = 'index.php';
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: error.message || 'An unexpected error occurred.'
                });
            } finally {
                setLoading(false);
            }
        });

        loadProduct();
    </script>
</body>
</html>
