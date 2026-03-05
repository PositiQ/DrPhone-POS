<?php
$activePage = 'products';
$basePath = '../';
$pageTitle = 'Edit Product';
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
                                <label for="brand">Brand <span style="color: #f44336;">*</span></label>
                                <input type="text" id="brand" name="brand" required>
                            </div>
                            <div class="form-field">
                                <label for="price">Price (LKR) <span style="color: #f44336;">*</span></label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="model">Model</label>
                                <input type="text" id="model" name="model">
                            </div>
                            <div class="form-field">
                                <label for="color">Color</label>
                                <input type="text" id="color" name="color">
                            </div>
                            <div class="form-field">
                                <label for="capacity">Capacity</label>
                                <input type="text" id="capacity" name="capacity">
                            </div>
                            <div class="form-field">
                                <label for="condition">Condition</label>
                                <input type="text" id="condition" name="condition">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="warrenty">Warranty</label>
                                <input type="text" id="warrenty" name="warrenty">
                            </div>
                            <div class="form-field">
                                <label for="IMEI">IMEI</label>
                                <input type="text" id="IMEI" name="IMEI">
                            </div>
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

        function fillForm(product) {
            document.getElementById('productId').value = product.id || '';
            document.getElementById('productName').value = product.productName || '';
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
                productName: document.getElementById('productName').value.trim(),
                brand: document.getElementById('brand').value.trim(),
                price: parseFloat(document.getElementById('price').value),
                model: document.getElementById('model').value.trim() || null,
                color: document.getElementById('color').value.trim() || null,
                capacity: document.getElementById('capacity').value.trim() || null,
                condition: document.getElementById('condition').value.trim() || null,
                warrenty: document.getElementById('warrenty').value.trim() || null,
                IMEI: document.getElementById('IMEI').value.trim() || null,
                barcode: document.getElementById('barcode').value.trim() || null,
                serialNumber: document.getElementById('serialNumber').value.trim() || null,
                description: document.getElementById('description').value.trim() || null
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
