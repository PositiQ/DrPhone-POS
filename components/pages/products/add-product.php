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
                    <div class="toolbar-actions">
                        <a class="button-secondary" href="../inventory/index.php">
                            <i class="fas fa-warehouse"></i>
                            View Inventory
                        </a>
                    </div>
                </div>

                <form class="sale-form" id="productForm" action="#" method="post">
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
                                <label for="product_type">Product Type <span style="color: #f44336;">*</span></label>
                                <select id="product_type" name="product_type" required>
                                    <option value="phone">Phone</option>
                                    <option value="accessory">Accessory</option>
                                </select>
                                <div class="form-hint">Select product type to show relevant fields</div>
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

                        <div class="form-grid" id="phoneSpecificFields">
                            <div class="form-field">
                                <label for="capacity">Storage/Capacity</label>
                                <input type="text" id="capacity" name="capacity" placeholder="e.g., 256GB">
                            </div>
                            <div class="form-field">
                                <label for="color">Color</label>
                                <input type="text" id="color" name="color" placeholder="e.g., Space Black">
                            </div>
                            <div class="form-field">
                                <label for="condition">Condition</label>
                                <select id="condition" name="condition">
                                    <option value="">Select Condition</option>
                                    <option>Brand New</option>
                                    <option>Used - Like New</option>
                                    <option>Used - Good</option>
                                    <option>Used - Fair</option>
                                    <option>Refurbished</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="warrenty">Warranty Period</label>
                                <input type="text" id="warrenty" name="warrenty" placeholder="e.g., 1 Year">
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
                            <div class="form-field" id="imeiField">
                                <label for="IMEI">IMEI Number <span id="imeiRequired" style="color: #f44336;"></span></label>
                                <input type="text" id="IMEI" name="IMEI" placeholder="15 digits for phones" maxlength="15">
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
                            <div class="form-field">
                                <label for="wholesale_price">Wholesale Price (LKR)</label>
                                <input type="number" id="wholesale_price" name="wholesale_price" placeholder="0.00" step="0.01">
                                <div class="form-hint">Optional: wholesale price for bulk purchases</div>
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
                                <input type="number" id="quantity_in_stock" name="quantity_in_stock" placeholder="1" min="0" value="1">
                                <div class="form-hint">Initial available quantity for this product</div>
                            </div>
                            <div class="form-field">
                                <label for="minimum_stock_level">Minimum Stock Level</label>
                                <input type="number" id="minimum_stock_level" name="minimum_stock_level" placeholder="5" min="0" value="5">
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
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="discontinued">Discontinued</option>
                                    <option value="in_stock">In Stock</option>
                                    <option value="sold">Sold</option>
                                </select>
                                <div class="form-hint">Current stock status</div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="description">Product Description</label>
                                <textarea id="description" name="description" placeholder="Detailed product description, features, specifications..." rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="button-secondary" href="index.php">Cancel</a>
                        <button class="button-secondary" type="button" id="saveDraftBtn">
                            <i class="fas fa-save"></i>
                            Save as Draft
                        </button>
                        <button class="button-primary" type="submit" id="submitBtn">
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

        // API Configuration
        const API_URL = 'http://localhost:3000/api/products';

        // Auto-set date added to today
        const dateAddedInput = document.getElementById('date_added');
        if (dateAddedInput && !dateAddedInput.value) {
            const today = new Date();
            dateAddedInput.value = today.toISOString().slice(0, 10);
        }

        // Auto-generate SKU
        const productName = document.getElementById('productName');
        const capacity = document.getElementById('capacity');
        const skuInput = document.getElementById('sku');

        function generateSKU() {
            if (productName.value && !skuInput.value) {
                const name = productName.value.substring(0, 5).toUpperCase().replace(/\s/g, '');
                const capacityVal = capacity.value ? '-' + capacity.value.replace(/\s/g, '') : '';
                const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
                skuInput.value = `SKU-${name}${capacityVal}-${random}`;
            }
        }

        if (productName && skuInput) {
            productName.addEventListener('blur', generateSKU);
            if (capacity) {
                capacity.addEventListener('blur', generateSKU);
            }
        }

        // Handle product type change
        const productTypeSelect = document.getElementById('product_type');
        const phoneSpecificFields = document.getElementById('phoneSpecificFields');
        const imeiField = document.getElementById('imeiField');
        const imeiInput = document.getElementById('IMEI');
        const imeiRequired = document.getElementById('imeiRequired');

        function togglePhoneFields() {
            const isPhone = productTypeSelect.value === 'phone';
            
            if (isPhone) {
                phoneSpecificFields.style.display = 'grid';
                imeiField.style.display = 'block';
                imeiRequired.textContent = '*';
                imeiInput.required = true;
            } else {
                phoneSpecificFields.style.display = 'none';
                imeiField.style.display = 'none';
                imeiRequired.textContent = '';
                imeiInput.required = false;
                imeiInput.value = '';
            }
        }

        if (productTypeSelect) {
            productTypeSelect.addEventListener('change', togglePhoneFields);
            togglePhoneFields(); // Initialize on page load
        }

        // Calculate profit margin
        const costPrice = document.getElementById('cost_price');
        const sellingPrice = document.getElementById('selling_price');
        const profitMargin = document.getElementById('profit_margin');
        const priceInput = document.getElementById('price');

        function updateProfitMargin() {
            const cost = parseFloat(costPrice.value) || 0;
            const selling = parseFloat(sellingPrice.value) || 0;
            
            if (cost > 0 && selling > 0) {
                const profit = selling - cost;
                const margin = ((profit / selling) * 100).toFixed(2);
                profitMargin.value = `${margin}% (LKR ${profit.toFixed(2)})`;
                
                // Auto-set price to selling_price if not set
                if (!priceInput.value) {
                    priceInput.value = selling;
                }
            } else {
                profitMargin.value = '';
            }
        }

        if (costPrice && sellingPrice && profitMargin) {
            costPrice.addEventListener('input', updateProfitMargin);
            sellingPrice.addEventListener('input', updateProfitMargin);
        }

        // Form submission handler
        const productForm = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        const saveDraftBtn = document.getElementById('saveDraftBtn');

        // Save as draft handler
        if (saveDraftBtn) {
            saveDraftBtn.addEventListener('click', function() {
                document.getElementById('status').value = 'inactive';
                productForm.requestSubmit();
            });
        }

        if (productForm) {
            productForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Validate required fields first
                const productNameInput = document.getElementById('productName');
                const brandInput = document.getElementById('brand');
                const costPriceInput = document.getElementById('cost_price');
                const sellingPriceInput = document.getElementById('selling_price');
                const skuInput = document.getElementById('sku');
                const productType = document.getElementById('product_type').value;
                
                const errors = [];
                
                if (!productNameInput.value || productNameInput.value.trim() === '') {
                    errors.push('Product Name is required');
                }
                if (!brandInput.value || brandInput.value.trim() === '') {
                    errors.push('Brand is required');
                }
                if (!costPriceInput.value || costPriceInput.value === '') {
                    errors.push('Cost Price is required');
                }
                if (!sellingPriceInput.value || sellingPriceInput.value === '') {
                    errors.push('Selling Price is required');
                }
                if (!skuInput.value || skuInput.value.trim() === '') {
                    errors.push('SKU is required');
                }
                
                // Validate IMEI for phones only
                if (productType === 'phone' && (!document.getElementById('IMEI').value || document.getElementById('IMEI').value.trim() === '')) {
                    errors.push('IMEI is required for phone products');
                }
                
                if (errors.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: '<strong>Please fix these errors:</strong><br><br>' + errors.map(e => '• ' + e).join('<br>'),
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
                
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Product...';
                
                try {
                    // Build payload matching the working Postman format
                    const productData = {
                        // Product fields (required)
                        productName: productNameInput.value.trim(),
                        price: parseFloat(sellingPriceInput.value),
                        brand: brandInput.value.trim(),
                        product_type: productType,
                        
                        // Product fields (optional)
                        description: document.getElementById('description')?.value?.trim() || null,
                        model: document.getElementById('model')?.value?.trim() || null,
                        color: document.getElementById('color')?.value?.trim() || null,
                        capacity: document.getElementById('capacity')?.value?.trim() || null,
                        condition: document.getElementById('condition')?.value?.trim() || null,
                        warrenty: document.getElementById('warrenty')?.value?.trim() || null,
                        IMEI: document.getElementById('IMEI')?.value?.trim() || null,
                        barcode: document.getElementById('barcode')?.value?.trim() || null,
                        serialNumber: document.getElementById('serialNumber')?.value?.trim() || null,
                        
                        // Product_Stock fields (required)
                        sku: skuInput.value.trim(),
                        cost_price: parseFloat(costPriceInput.value),
                        selling_price: parseFloat(sellingPriceInput.value),
                        
                        // Product_Stock fields (optional)
                        profit_margin: null,  // Will be calculated by API, but include it
                        wholesale_price: document.getElementById('wholesale_price')?.value ? parseFloat(document.getElementById('wholesale_price').value) : null,
                        supplier: document.getElementById('supplier')?.value?.trim() || null,
                        minimum_stock_level: document.getElementById('minimum_stock_level')?.value ? parseInt(document.getElementById('minimum_stock_level').value) : null,
                        quantity_in_stock: document.getElementById('quantity_in_stock')?.value ? parseInt(document.getElementById('quantity_in_stock').value, 10) : null,
                        storage_location: document.getElementById('storage_location')?.value?.trim() || null,
                        date_added: document.getElementById('date_added')?.value || null,
                        status: document.getElementById('status')?.value || 'active'
                    };
                    
                    // Remove null values to avoid validation issues
                    Object.keys(productData).forEach(key => {
                        if (productData[key] === null || productData[key] === '') {
                            delete productData[key];
                        }
                    });
                    
                    // Ensure required fields are always present
                    productData.productName = productNameInput.value.trim();
                    productData.brand = brandInput.value.trim();
                    productData.product_type = productType;
                    productData.sku = skuInput.value.trim();
                    productData.cost_price = parseFloat(costPriceInput.value);
                    productData.selling_price = parseFloat(sellingPriceInput.value);
                    productData.price = parseFloat(sellingPriceInput.value);
                    productData.status = document.getElementById('status')?.value || 'active';
                    
                    console.log('Submitting product data:', productData);
                    
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(productData)
                    });
                    
                    const result = await response.json();
                    
                    console.log('API Response:', result);
                    
                    if (response.ok && result.success) {
                        // Show success message
                        const productId = result.newProduct?.id || result.data?.id || 'Created';
                        Swal.fire({
                            icon: 'success',
                            title: 'Product Added Successfully!',
                            html: '<strong>Product ID:</strong> ' + productId,
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    } else {
                        // Show error message with details
                        let errorMsg = result.message || result.error || 'Failed to add product';
                        
                        // If error object has details, add them
                        if (result.error && typeof result.error === 'object') {
                            errorMsg += '\n\nDetails: ' + JSON.stringify(result.error);
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMsg + errorDetails,
                            confirmButtonColor: '#d33'
                        });
                        
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Add Product';
                    }
                } catch (error) {
                    console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Connection Error',
                                html: 'Failed to add product. Please ensure the API server is running at:<br><br><code>' + API_URL + '</code><br><br><small>' + error.message + '</small>',
                                confirmButtonColor: '#d33'
                            });
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Add Product';
                }
            });
        }
    </script>
</body>
</html>
