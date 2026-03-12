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
  <meta name="theme-color" content="#1a237e">
  <meta name="description" content="Manage products, categories, and labels">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Products</title>
  <link rel="manifest" href="/manifest.json">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
  <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>
    <?php include __DIR__ . '/../../UI/custom-dialog.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <input type="text" id="searchProducts" placeholder="Search products..." style="min-width: 280px;">
                        <select aria-label="Category">
                            <option>All Categories</option>
                            <option>Phone</option>
                            <option>Accessory</option>
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
                                <th style="width: 7%;">Tracking</th>
                                <th style="width: 11%;">Stock Status</th>
                                <th style="width: 18%;">Actions</th>
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
      const stock = product.Product_Stock;
      const apiStatus = stock ? stock.status : 'sold';
      
      // Count based on API status
      if (apiStatus === 'in_stock' || apiStatus === 'active') {
        stats.inStock++;
      } else if (apiStatus === 'sold') {
        stats.soldOut++;
      } else if (apiStatus === 'inactive' || apiStatus === 'discontinued') {
        stats.soldOut++;
      }
      
      // Note: Low stock alerts would require quantity tracking
      // Currently showing 0 for low stock as quantity is not tracked in this API
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
    const stockStatus = stock.status || 'active';
    
    // Map API status to display status
    if (stockStatus === 'sold') return 'sold-out';
    if (stockStatus === 'inactive' || stockStatus === 'discontinued') return 'sold-out';
    if (stockStatus === 'in_stock') return 'in-stock';
    if (stockStatus === 'active') return 'in-stock';
    
    return stockStatus;
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
      
      const statusConfig = {
        'in-stock': { label: 'In Stock', bg: '#e1f7e3', color: '#0d6832', qtyColor: '#4caf50' },
        'low-stock': { label: 'Low Stock', bg: '#fff3e0', color: '#e65100', qtyColor: '#ff9800' },
        'sold-out': { label: 'Sold Out', bg: '#ffebee', color: '#b71c1c', qtyColor: '#f44336' },
        'issued': { label: 'Issued', bg: '#e3f2fd', color: '#0d47a1', qtyColor: '#2196f3' }
      };
      
      const config = statusConfig[stockStatus] || statusConfig['sold-out'];
      const productDetails = `${product.capacity || ''} · ${product.color || ''}`.replace(/^·\s*|\s*·$/g, '').trim();
      
      // Get actual status from API
      const apiStatus = stock.status || 'N/A';
      const productType = product.product_type || 'phone';
      const productTypeLabel = productType === 'phone' ? 'Phone' : 'Accessory';
      
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
          <td>${productTypeLabel}</td>
          <td>${product.brand || 'N/A'}</td>
          <td><code>${stock.sku || 'N/A'}</code></td>
          <td>LKR ${(stock.cost_price || 0).toLocaleString()}</td>
          <td><strong>LKR ${(stock.selling_price || product.price || 0).toLocaleString()}</strong></td>
          <td><span style="color: #7a86ad; font-size: 12px;">Status-based</span></td>
          <td><span class="status-badge" style="background: ${config.bg}; color: ${config.color};">${apiStatus.toUpperCase()}</span></td>
          <td>
            <div style="display: flex; gap: 6px;">
              <button 
                type="button" 
                class="button-secondary view-btn" 
                style="padding: 6px 10px; font-size: 12px;" 
                title="View Details"
                data-id="${product.id}"
              >
                <i class="fas fa-eye"></i>
              </button>
              <button 
                type="button" 
                class="button-secondary edit-btn" 
                style="padding: 6px 10px; font-size: 12px;" 
                title="Edit"
                data-id="${product.id}"
              >
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
              <button 
                type="button" 
                class="button-secondary delete-btn" 
                style="padding: 6px 10px; font-size: 12px; background: #ffebee; color: #c62828;" 
                title="Delete Product"
                data-id="${product.id}"
                data-name="${product.productName}"
              >
                <i class="fas fa-trash"></i>
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
      if (!w) {
        Swal.fire({
          icon: 'warning',
          title: 'Popup Blocked',
          text: 'Popup was blocked! Please allow popups to print labels.',
          confirmButtonColor: '#ff9800'
        });
      }
    });

    // View product details handler
    document.addEventListener('click', async function(e) {
      const btn = e.target.closest('.view-btn');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.id;

      try {
        const response = await fetch(`${API_URL}/${productId}`);
        const result = await response.json();

        if (result.success && result.data) {
          const product = result.data;
          const stock = product.Product_Stock || {};
          const detailsHtml = `
            <div class="app-dialog-section">
              <div class="app-dialog-section-title">PRODUCT DETAILS</div>
              <div class="app-dialog-row"><strong>ID:</strong> <code>${product.id}</code></div>
              <div class="app-dialog-row"><strong>Name:</strong> ${product.productName || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Brand:</strong> ${product.brand || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Model:</strong> ${product.model || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Color:</strong> ${product.color || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Capacity:</strong> ${product.capacity || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Condition:</strong> ${product.condition || 'N/A'}</div>
            </div>

            <div class="app-dialog-section">
              <div class="app-dialog-section-title">IDENTIFIERS</div>
              <div class="app-dialog-row"><strong>SKU:</strong> <code>${stock.sku || 'N/A'}</code></div>
              <div class="app-dialog-row"><strong>IMEI:</strong> ${product.IMEI || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Barcode:</strong> ${product.barcode || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Serial Number:</strong> ${product.serialNumber || 'N/A'}</div>
            </div>

            <div class="app-dialog-section">
              <div class="app-dialog-section-title">PRICING</div>
              <div class="app-dialog-row"><strong>Cost Price:</strong> LKR ${(stock.cost_price || 0).toLocaleString()}</div>
              <div class="app-dialog-row"><strong>Selling Price:</strong> LKR ${(stock.selling_price || 0).toLocaleString()}</div>
              <div class="app-dialog-row"><strong>Display Price:</strong> LKR ${(product.price || 0).toLocaleString()}</div>
              <div class="app-dialog-row"><strong>Profit Margin:</strong> ${stock.profit_margin || 'N/A'}%</div>
            </div>

            <div class="app-dialog-section">
              <div class="app-dialog-section-title">STOCK</div>
              <div class="app-dialog-row"><strong>Status:</strong> <span class="app-dialog-pill">${stock.status || 'N/A'}</span></div>
              <div class="app-dialog-row"><strong>Minimum Stock:</strong> ${stock.minimum_stock_level ?? 'N/A'}</div>
              <div class="app-dialog-row"><strong>Supplier:</strong> ${stock.supplier || 'N/A'}</div>
              <div class="app-dialog-row"><strong>Storage Location:</strong> ${stock.storage_location || 'N/A'}</div>
            </div>

            <div class="app-dialog-section">
              <div class="app-dialog-section-title">DESCRIPTION</div>
              <div class="app-dialog-row">${product.description || 'No description available'}</div>
            </div>
          `;

          if (window.AppDialog && typeof window.AppDialog.open === 'function') {
            window.AppDialog.open({
              title: product.productName || 'Product Details',
              html: detailsHtml
            });
          }
        } else {
          if (window.AppDialog && typeof window.AppDialog.open === 'function') {
            window.AppDialog.open({
              title: 'Error',
              html: '<div class="app-dialog-row">Failed to load product details.</div>'
            });
          }
        }
      } catch (error) {
        console.error('Error:', error);
        if (window.AppDialog && typeof window.AppDialog.open === 'function') {
          window.AppDialog.open({
            title: 'Error',
            html: '<div class="app-dialog-row">Failed to load product details.</div>'
          });
        }
      }
    });

    // Edit product handler (placeholder - would need edit page)
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.edit-btn');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.id;

      window.location.href = `edit-product.php?id=${encodeURIComponent(productId)}`;
    });

    // Delete product handler
    document.addEventListener('click', async function(e) {
      const btn = e.target.closest('.delete-btn');
      if (!btn) return;

      e.preventDefault();
      const productId = btn.dataset.id;
      const productName = btn.dataset.name;

      // Confirm deletion
      Swal.fire({
        icon: 'warning',
        title: 'Delete Product?',
        html: `Are you sure you want to delete this product?<br><br><strong>${productName}</strong><br><code>${productId}</code><br><br><small style="color: #f44336;">This action cannot be undone and will also delete all associated stock records.</small>`,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
      }).then(async (result) => {
        if (!result.isConfirmed) return;

      // Show loading state
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

      try {
        const response = await fetch(`${API_URL}/${productId}`, {
          method: 'DELETE'
        });

        const result = await response.json();

        if (response.ok && result.success) {
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Product has been deleted successfully.',
            confirmButtonColor: '#3085d6'
          }).then(() => {
            fetchProducts();
          });
        } else {
          const errorMsg = result.message || result.error || 'Failed to delete product';
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMsg,
            confirmButtonColor: '#d33'
          });
          
          // Re-enable button
          btn.disabled = false;
          btn.innerHTML = '<i class="fas fa-trash"></i>';
        }
      } catch (error) {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to delete product. Please try again.',
          confirmButtonColor: '#d33'
        });
        
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-trash"></i>';
      }
      });
    });
  });
</script>

</body>
</html>