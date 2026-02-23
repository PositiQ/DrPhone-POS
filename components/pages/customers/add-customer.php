<?php
$activePage = 'customers';
$basePath = '../';
$pageTitle = 'Add Customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Add Customer</title>
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
                            Back to Customers
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
                                <label for="customerName">Customer Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="customerName" name="customerName" placeholder="e.g., John Doe" required>
                            </div>
                            <div class="form-field">
                                <label for="customerType">Customer Type <span style="color: #f44336;">*</span></label>
                                <select id="customerType" name="customerType" required>
                                    <option value="">Select Type</option>
                                    <option>Regular</option>
                                    <option>VIP</option>
                                    <option>Wholesale</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="phone">Phone Number <span style="color: #f44336;">*</span></label>
                                <input type="tel" id="phone" name="phone" placeholder="+94 77 123 4567" required>
                            </div>
                            <div class="form-field">
                                <label for="altPhone">Alternate Phone</label>
                                <input type="tel" id="altPhone" name="altPhone" placeholder="+94 71 234 5678">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="customer@email.com">
                            </div>
                            <div class="form-field">
                                <label for="nic">NIC / Passport</label>
                                <input type="text" id="nic" name="nic" placeholder="NIC or Passport Number">
                            </div>
                            <div class="form-field">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob">
                            </div>
                            <div class="form-field">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Address Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="address">Street Address</label>
                                <input type="text" id="address" name="address" placeholder="e.g., 123 Main Street">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" placeholder="e.g., Colombo">
                            </div>
                            <div class="form-field">
                                <label for="district">District</label>
                                <select id="district" name="district">
                                    <option value="">Select District</option>
                                    <option>Colombo</option>
                                    <option>Gampaha</option>
                                    <option>Kalutara</option>
                                    <option>Kandy</option>
                                    <option>Galle</option>
                                    <option>Matara</option>
                                    <option>Hambantota</option>
                                    <option>Jaffna</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" id="postalCode" name="postalCode" placeholder="e.g., 10100">
                            </div>
                            <div class="form-field">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country" value="Sri Lanka" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Credit & Payment Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="creditLimit">Credit Limit (LKR)</label>
                                <input type="number" id="creditLimit" name="creditLimit" placeholder="0.00" step="0.01">
                                <div class="form-hint">Maximum outstanding credit allowed</div>
                            </div>
                            <div class="form-field">
                                <label for="creditDays">Credit Days</label>
                                <input type="number" id="creditDays" name="creditDays" placeholder="30" min="0">
                                <div class="form-hint">Payment due within days</div>
                            </div>
                            <div class="form-field">
                                <label for="discount">Discount Percentage (%)</label>
                                <input type="number" id="discount" name="discount" placeholder="0" step="0.01" min="0" max="100">
                                <div class="form-hint">Special discount rate</div>
                            </div>
                            <div class="form-field">
                                <label for="paymentMethod">Preferred Payment Method</label>
                                <select id="paymentMethod" name="paymentMethod">
                                    <option>Cash</option>
                                    <option>Bank Transfer</option>
                                    <option>Credit Card</option>
                                    <option>Cheque</option>
                                    <option>Credit</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Additional Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="registrationDate">Registration Date</label>
                                <input type="date" id="registrationDate" name="registrationDate">
                            </div>
                            <div class="form-field">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="referredBy">Referred By</label>
                                <input type="text" id="referredBy" name="referredBy" placeholder="Reference name">
                            </div>
                            <div class="form-field">
                                <label>&nbsp;</label>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                    <input type="checkbox" id="marketing" name="marketing" style="width: auto;">
                                    <label for="marketing" style="margin: 0; font-size: 13px;">Send marketing communications</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="notes">Notes</label>
                                <textarea id="notes" name="notes" placeholder="Additional notes about the customer..." rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="button-secondary" href="index.php">Cancel</a>
                        <button class="button-primary" type="submit">
                            <i class="fas fa-check"></i>
                            Add Customer
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

        // Auto-set registration date to today
        const registrationDate = document.getElementById('registrationDate');
        if (registrationDate && !registrationDate.value) {
            const today = new Date();
            registrationDate.value = today.toISOString().slice(0, 10);
        }

        // Format phone number
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('blur', function() {
                let value = this.value.replace(/\s/g, '');
                if (value && !value.startsWith('+')) {
                    this.value = '+94 ' + value;
                }
            });
        }
    </script>
</body>
</html>
