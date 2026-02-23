<?php
$activePage = 'settings';
$basePath = '../';
$pageTitle = 'Settings';
$pageSubtitle = 'Manage general settings and invoice details.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Settings</title>
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
                        <h2 style="margin: 0; font-size: 16px; color: #333;">System Configuration</h2>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <button class="button-secondary" type="button">
                            <i class="fas fa-undo"></i>
                            Reset to Default
                        </button>
                    </div>
                </div>

                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-store"></i> Business Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="businessName">Business Name</label>
                                <input type="text" id="businessName" value="Doctor Phone" placeholder="Your Business Name">
                            </div>
                            <div class="form-field">
                                <label for="businessPhone">Phone Number</label>
                                <input type="tel" id="businessPhone" value="+94 77 123 4567" placeholder="+94 XX XXX XXXX">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="businessEmail">Email Address</label>
                                <input type="email" id="businessEmail" value="info@doctorphone.lk" placeholder="your@email.com">
                            </div>
                            <div class="form-field">
                                <label for="businessWebsite">Website</label>
                                <input type="url" id="businessWebsite" value="www.doctorphone.lk" placeholder="www.yourwebsite.com">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="businessAddress">Address</label>
                                <textarea id="businessAddress" rows="3">123 Main Street, Colombo 07, Sri Lanka</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-globe"></i> Regional Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="currency">Currency</label>
                                <select id="currency">
                                    <option selected>LKR - Sri Lankan Rupees</option>
                                    <option>USD - US Dollar</option>
                                    <option>EUR - Euro</option>
                                    <option>GBP - British Pound</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="timezone">Timezone</label>
                                <select id="timezone">
                                    <option selected>Asia/Colombo (GMT+5:30)</option>
                                    <option>Asia/Dubai (GMT+4:00)</option>
                                    <option>Asia/Singapore (GMT+8:00)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="dateFormat">Date Format</label>
                                <select id="dateFormat">
                                    <option>DD/MM/YYYY</option>
                                    <option selected>MMM DD, YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="language">Language</label>
                                <select id="language">
                                    <option selected>English</option>
                                    <option>Sinhala</option>
                                    <option>Tamil</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-receipt"></i> Invoice Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="invoicePrefix">Invoice Prefix</label>
                                <input type="text" id="invoicePrefix" value="INV-" placeholder="INV-">
                            </div>
                            <div class="form-field">
                                <label for="nextInvoiceNo">Next Invoice Number</label>
                                <input type="number" id="nextInvoiceNo" value="246" placeholder="1">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="taxRate">Tax Rate (%)</label>
                                <input type="number" id="taxRate" value="18" placeholder="0" step="0.01">
                            </div>
                            <div class="form-field">
                                <label for="taxLabel">Tax Label</label>
                                <input type="text" id="taxLabel" value="VAT" placeholder="VAT/GST">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="invoiceFooter">Invoice Footer Note</label>
                                <textarea id="invoiceFooter" rows="3">Thank you for your business! Please contact us for any queries.</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-credit-card"></i> Payment Methods</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                    <div>
                                        <strong style="display: block;">Cash</strong>
                                        <span style="color: #666; font-size: 13px;">Accept cash payments</span>
                                    </div>
                                </div>
                                <span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Enabled</span>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                    <div>
                                        <strong style="display: block;">Bank Transfer</strong>
                                        <span style="color: #666; font-size: 13px;">Online and offline transfers</span>
                                    </div>
                                </div>
                                <span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Enabled</span>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                    <div>
                                        <strong style="display: block;">Credit/Debit Card</strong>
                                        <span style="color: #666; font-size: 13px;">Card payments via POS terminal</span>
                                    </div>
                                </div>
                                <span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Enabled</span>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                    <div>
                                        <strong style="display: block;">Credit (Account)</strong>
                                        <span style="color: #666; font-size: 13px;">Allow credit for customers</span>
                                    </div>
                                </div>
                                <span class="status-badge" style="background: #e8f5e9; color: #2e7d32;">Enabled</span>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="checkbox" style="width: 20px; height: 20px;">
                                    <div>
                                        <strong style="display: block;">Cheque</strong>
                                        <span style="color: #666; font-size: 13px;">Accept cheque payments</span>
                                    </div>
                                </div>
                                <span class="status-badge" style="background: #f5f5f5; color: #616161;">Disabled</span>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-bell"></i> Notification Settings</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <strong>Low Stock Alerts</strong>
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                </div>
                                <div style="display: flex; gap: 12px;">
                                    <div style="flex: 1;">
                                        <label style="font-size: 13px; color: #666;">Alert when stock below:</label>
                                        <input type="number" value="5" style="width: 100%; margin-top: 4px;">
                                    </div>
                                </div>
                            </div>

                            <div style="padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <strong>Payment Reminders</strong>
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                </div>
                                <span style="font-size: 13px; color: #666;">Send reminders for overdue payments</span>
                            </div>

                            <div style="padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <strong>Daily Sales Report</strong>
                                    <input type="checkbox" checked style="width: 20px; height: 20px;">
                                </div>
                                <span style="font-size: 13px; color: #666;">Email daily sales summary at 6 PM</span>
                            </div>

                            <div style="padding: 16px; background: #fafafa; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <strong>Customer SMS Notifications</strong>
                                    <input type="checkbox" style="width: 20px; height: 20px;">
                                </div>
                                <span style="font-size: 13px; color: #666;">Send SMS for order updates</span>
                            </div>
                        </div>
                    </div>
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

        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
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
    </script>
</body>
</html>
