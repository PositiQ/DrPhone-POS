<?php
$activePage = 'products';
$basePath = '../';
$pageTitle = 'Products';
$pageSubtitle = 'Add and manage products, categories, and labels.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Products</title>
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
                        <input type="text" id="searchProducts" placeholder="Search products..." style="min-width: 280px;">
                        <select aria-label="Category">
                            <option>All Categories</option>
                            <option>Smartphones</option>
                            <option>Accessories</option>
                            <option>Tablets</option>
                        </select>
                        <select aria-label="Brand">
                            <option>All Brands</option>
                            <option>Apple</option>
                            <option>Samsung</option>
                            <option>Google</option>
                            <option>Xiaomi</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-secondary" href="../inventory/index.php">
                            <i class="fas fa-warehouse"></i>
                            View Inventory
                        </a>
                        <a class="button-primary" href="add-product.php">
                            <i class="fas fa-plus"></i>
                            Add Product
                        </a>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>In Stock</h4>
                        <div class="metric-value" style="color: #4caf50;">1,058</div>
                        <div class="metric-sub">Available for sale</div>
                    </div>
                    <div class="metric-card">
                        <h4>Low Stock</h4>
                        <div class="metric-value" style="color: #ff9800;">128</div>
                        <div class="metric-sub">Needs restocking</div>
                    </div>
                    <div class="metric-card">
                        <h4>Sold Out</h4>
                        <div class="metric-value" style="color: #f44336;">47</div>
                        <div class="metric-sub">Out of stock</div>
                    </div>
                    <div class="metric-card">
                        <h4>Issued</h4>
                        <div class="metric-value" style="color: #2196f3;">12</div>
                        <div class="metric-sub">To branches</div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Product Catalog</h3>
                        <div class="filter-group" style="gap: 8px;">
                            <button class="pill active" type="button" data-status="all">All</button>
                            <button class="pill" type="button" data-status="in-stock">In Stock</button>
                            <button class="pill" type="button" data-status="low-stock">Low Stock</button>
                            <button class="pill" type="button" data-status="sold-out">Sold Out</button>
                            <button class="pill" type="button" data-status="issued">Issued</button>
                        </div>
                    </div>

                    <table style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 22%;">Product</th>
                                <th style="width: 10%;">Category</th>
                                <th style="width: 9%;">Brand</th>
                                <th style="width: 11%;">SKU</th>
                                <th style="width: 9%;">Cost Price (LKR)</th>
                                <th style="width: 9%;">Selling Price (LKR)</th>
                                <th style="width: 7%;">Stock Qty</th>
                                <th style="width: 11%;">Stock Status</th>
                                <th style="width: 12%;">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="productTable">
                            <!-- Products will be loaded dynamically from API -->
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #1a237e;"></i>
                                    <p style="margin-top: 10px; color: #7a86ad;">Loading products...</p>
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
  // Global variables
  let allProducts = [];
  let filteredProducts = [];
  const API_URL = 'http://localhost:3000/api/products';

  // Fetch products from API
  async function fetchProducts() {
    try {
      const response = await fetch(API_URL);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const result = await response.json();
      
      if (result.success && result.data) {
        allProducts = result.data;
        filteredProducts = allProducts;
        updateMetrics();
        renderProducts(filteredProducts);
      } else {
        showError('Failed to load products: Invalid response format');
      }
    } catch (error) {
      console.error('Error fetching products:', error);
      showError('Failed to load products. Please check if the API server is running.');
    }
  }

  // Update metrics cards
  function updateMetrics() {
    const stats = {
      inStock: 0,
      lowStock: 0,
      soldOut: 0,
      issued: 0
    };

    allProducts.forEach(product => {
      const stockStatus = getStockStatus(product);
      if (stockStatus === 'in-stock') stats.inStock++;
      else if (stockStatus === 'low-stock') stats.lowStock++;
      else if (stockStatus === 'sold-out') stats.soldOut++;
      else if (stockStatus === 'issued') stats.issued++;
    });

    const metricCards = document.querySelectorAll('.metric-card');
    if (metricCards[0]) metricCards[0].querySelector('.metric-value').textContent = stats.inStock.toLocaleString();
    if (metricCards[1]) metricCards[1].querySelector('.metric-value').textContent = stats.lowStock.toLocaleString();
    if (metricCards[2]) metricCards[2].querySelector('.metric-value').textContent = stats.soldOut.toLocaleString();
    if (metricCards[3]) metricCards[3].querySelector('.metric-value').textContent = stats.issued.toLocaleString();
  }

  // Determine stock status based on product data
  function getStockStatus(product) {
    if (!product.Product_Stock) return 'sold-out';
    
    const stock = product.Product_Stock;
    const stockQty = stock.quantity || 0;
    const minLevel = stock.minimum_stock_level || 5;
    
    if (stock.status === 'issued') return 'issued';
    if (stock.status !== 'active') return 'sold-out';
    if (stockQty === 0) return 'sold-out';
    if (stockQty <= minLevel) return 'low-stock';
    return 'in-stock';
  }

  // Render products in table
  function renderProducts(products) {
    const tbody = document.getElementById('productTable');
    
    if (products.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="9" style="text-align: center; padding: 40px;">
            <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
            <p style="color: #7a86ad;">No products found</p>
          </td>
        </tr>
      `;
      return;
    }

    tbody.innerHTML = products.map(product => {
      const stock = product.Product_Stock || {};
      const stockStatus = getStockStatus(product);
      const stockQty = stock.quantity || 0;
      
      const statusConfig = {
        'active': { label: 'In Stock', bg: '#e1f7e3', color: '#0d6832', qtyColor: '#4caf50' },
        'low-stock': { label: 'Low Stock', bg: '#fff3e0', color: '#e65100', qtyColor: '#ff9800' },
        'sold-out': { label: 'Sold Out', bg: '#ffebee', color: '#b71c1c', qtyColor: '#f44336' },
        'issued': { label: 'Issued', bg: '#e3f2fd', color: '#0d47a1', qtyColor: '#2196f3' }
      };
      
      const config = statusConfig[stockStatus];
      const productDetails = `${product.capacity || ''} · ${product.color || ''}`.trim();
      
      return `
        <tr data-status="${stockStatus}">
          <td>
            <div style="display: flex; align-items: center; gap: 10px;">
              <div>
                <strong style="display: block; color: #1a237e;">${product.productName || 'Unknown Product'}</strong>
                ${productDetails ? `<span style="font-size: 12px; color: #7a86ad;">${productDetails}</span>` : ''}
              </div>
            </div>
          </td>
          <td>Smartphone</td>
          <td>${product.brand || 'N/A'}</td>
          <td><code>${stock.sku || 'N/A'}</code></td>
          <td>LKR ${(stock.cost_price || 0).toLocaleString()}</td>
          <td><strong>LKR ${(stock.selling_price || product.price || 0).toLocaleString()}</strong></td>
          <td><strong style="color: ${config.qtyColor};">${stockQty}</strong></td>
          <td><span class="status-badge" style="background: ${config.bg}; color: ${config.color};">${config.label}</span></td>
          <td>
            <div style="display: flex; gap: 6px;">
              <button type="button" class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="View Details">
                <i class="fas fa-eye"></i>
              </button>
              <button type="button" class="button-secondary" style="padding: 6px 10px; font-size: 12px;" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <button
                type="button"
                class="button-secondary print-label-btn"
                style="padding: 6px 10px; font-size: 12px;"
                title="Print Label"
                data-name="${product.productName || 'Product'}"
                data-sku="${stock.sku || 'N/A'}"
                data-price="${stock.selling_price || product.price || 0}"
              >
                <i class="fas fa-barcode"></i>
              </button>
            </div>
          </td>
        </tr>
      `;
    }).join('');
  }

  // Show error message
  function showError(message) {
    const tbody = document.getElementById('productTable');
    tbody.innerHTML = `
      <tr>
        <td colspan="9" style="text-align: center; padding: 40px;">
          <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #f44336; margin-bottom: 10px;"></i>
          <p style="color: #f44336; font-weight: 500;">${message}</p>
          <button class="button-primary" onclick="fetchProducts()" style="margin-top: 15px;">
            <i class="fas fa-redo"></i> Retry
          </button>
        </td>
      </tr>
    `;
  }

  // Filter products by status
  function filterByStatus(status) {
    if (status === 'all') {
      filteredProducts = allProducts;
    } else {
      filteredProducts = allProducts.filter(product => getStockStatus(product) === status);
    }
    applySearchFilter();
  }

  // Apply search filter
  function applySearchFilter() {
    const searchTerm = document.getElementById('searchProducts').value.toLowerCase();
    
    if (!searchTerm) {
      renderProducts(filteredProducts);
      return;
    }
    
    const searchResults = filteredProducts.filter(product => {
      const stock = product.Product_Stock || {};
      return (
        (product.productName || '').toLowerCase().includes(searchTerm) ||
        (product.brand || '').toLowerCase().includes(searchTerm) ||
        (product.model || '').toLowerCase().includes(searchTerm) ||
        (stock.sku || '').toLowerCase().includes(searchTerm) ||
        (product.description || '').toLowerCase().includes(searchTerm)
      );
    });
    
    renderProducts(searchResults);
  }

  // Event Listeners
  document.addEventListener('DOMContentLoaded', function() {
    // Initial load
    fetchProducts();

    // Status filter pills
    document.querySelectorAll('.pill[data-status]').forEach(pill => {
      pill.addEventListener('click', function() {
        document.querySelectorAll('.pill[data-status]').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        filterByStatus(this.dataset.status);
      });
    });

    // Search input
    const searchInput = document.getElementById('searchProducts');
    if (searchInput) {
      searchInput.addEventListener('input', applySearchFilter);
    }

    // Print label button handler
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.print-label-btn');
      if (!btn) return;

      e.preventDefault();

      const name = encodeURIComponent(btn.dataset.name || 'Product');
      const sku = encodeURIComponent(btn.dataset.sku || 'SKU');
      const price = encodeURIComponent(btn.dataset.price || '0');

      const url = `label-print.php?name=${name}&sku=${sku}&price=${price}`;

      const w = window.open(url, '_blank');
      if (!w) alert('Popup blocked! Allow popups to print labels.');
    });
  });
</script>

</body>
</html>