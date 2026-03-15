<?php
$activePage = 'customers';
$basePath = '../';
$pageTitle = 'Edit Customer';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Edit Customer</title>
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
                            Back to Customers
                        </a>
                    </div>
                </div>

                <form class="sale-form" id="editCustomerForm" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Basic Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="customerId">Customer ID</label>
                                <input type="text" id="customerId" readonly>
                            </div>
                            <div class="form-field">
                                <label for="customerName">Customer Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="customerName" required>
                            </div>
                            <div class="form-field">
                                <label for="customerType">Customer Type <span style="color: #f44336;">*</span></label>
                                <select id="customerType" required>
                                    <option value="regular">Regular</option>
                                    <option value="wholesale">Wholesale</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="status">Status <span style="color: #f44336;">*</span></label>
                                <select id="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="phone">Phone Number <span style="color: #f44336;">*</span></label>
                                <input type="tel" id="phone" required>
                            </div>
                            <div class="form-field">
                                <label for="altPhone">Alternate Phone</label>
                                <input type="tel" id="altPhone">
                            </div>
                            <div class="form-field">
                                <label for="email">Email Address</label>
                                <input type="email" id="email">
                            </div>
                            <div class="form-field">
                                <label for="nic">NIC / Passport</label>
                                <input type="text" id="nic">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob">
                            </div>
                            <div class="form-field">
                                <label for="gender">Gender</label>
                                <select id="gender">
                                    <option value="">Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="registrationDate">Registration Date</label>
                                <input type="date" id="registrationDate">
                            </div>
                            <div class="form-field">
                                <label for="referredBy">Referred By</label>
                                <input type="text" id="referredBy">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Address & Payment Details</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="address">Address</label>
                                <input type="text" id="address">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="city">City</label>
                                <input type="text" id="city">
                            </div>
                            <div class="form-field">
                                <label for="district">District</label>
                                <input type="text" id="district">
                            </div>
                            <div class="form-field">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" id="postalCode">
                            </div>
                            <div class="form-field">
                                <label for="country">Country</label>
                                <input type="text" id="country">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="creditLimit">Credit Limit</label>
                                <input type="number" id="creditLimit" step="0.01">
                            </div>
                            <div class="form-field">
                                <label for="creditDays">Credit Days</label>
                                <input type="number" id="creditDays" min="0">
                            </div>
                            <div class="form-field">
                                <label for="discount">Discount Rate (%)</label>
                                <input type="number" id="discount" step="0.01" min="0" max="100">
                            </div>
                            <div class="form-field">
                                <label for="paymentMethod">Preferred Payment Method</label>
                                <select id="paymentMethod">
                                    <option value="">Select Method</option>
                                    <option>Cash</option>
                                    <option>Bank Transfer</option>
                                    <option>Credit Card</option>
                                    <option>Cheque</option>
                                    <option>Credit</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="notes">Notes</label>
                                <textarea id="notes" rows="4"></textarea>
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
        const API_URL = 'http://localhost:3000/api/customers';
        const params = new URLSearchParams(window.location.search);
        const customerId = params.get('id');

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

        if (searchClose) searchClose.addEventListener('click', closeSearchModal);
        if (searchOverlay) {
            searchOverlay.addEventListener('click', function(event) {
                if (event.target === searchOverlay) closeSearchModal();
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

        function toDecimal(value) {
            if (value === '' || value === null || value === undefined) return null;
            const parsed = parseFloat(value);
            return Number.isNaN(parsed) ? null : parsed;
        }

        function toInteger(value) {
            if (value === '' || value === null || value === undefined) return null;
            const parsed = parseInt(value, 10);
            return Number.isNaN(parsed) ? null : parsed;
        }

        function fillForm(data) {
            document.getElementById('customerId').value = data.customer_id || '';
            document.getElementById('customerName').value = data.name || '';
            document.getElementById('customerType').value = data.type || 'regular';
            document.getElementById('status').value = data.status || 'active';
            document.getElementById('phone').value = data.phone_number || '';
            document.getElementById('altPhone').value = data.atlernative_phone_number || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('nic').value = data.nic_or_passport_number || '';
            document.getElementById('dob').value = data.dob || '';
            document.getElementById('gender').value = data.gender || '';
            document.getElementById('registrationDate').value = data.registration_date || '';
            document.getElementById('referredBy').value = data.reffered_by || '';
            document.getElementById('address').value = data.address || '';
            document.getElementById('city').value = data.city || '';
            document.getElementById('district').value = data.district || '';
            document.getElementById('postalCode').value = data.postal_code || '';
            document.getElementById('country').value = data.country || '';
            document.getElementById('creditLimit').value = data.credit_limit || '';
            document.getElementById('creditDays').value = data.credit_days || '';
            document.getElementById('discount').value = data.discount_rate || '';
            document.getElementById('paymentMethod').value = data.prefferred_payment_method || '';
            document.getElementById('notes').value = data.note || '';
        }

        async function loadCustomer() {
            if (!customerId) {
                await Swal.fire({ icon: 'error', title: 'Invalid Request', text: 'Customer ID is missing.' });
                window.location.href = 'index.php';
                return;
            }

            try {
                const response = await fetch(`${API_URL}/${customerId}`);
                const result = await response.json();
                if (!response.ok || !result.success || !result.data) {
                    throw new Error(result.error || result.message || 'Customer not found');
                }
                fillForm(result.data);
            } catch (error) {
                await Swal.fire({ icon: 'error', title: 'Load Failed', text: error.message || 'Failed to load customer.' });
                window.location.href = 'index.php';
            }
        }

        document.getElementById('editCustomerForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const payload = {
                name: document.getElementById('customerName').value.trim(),
                type: document.getElementById('customerType').value,
                status: document.getElementById('status').value,
                phone_number: document.getElementById('phone').value.trim(),
                atlernative_phone_number: document.getElementById('altPhone').value.trim() || null,
                email: document.getElementById('email').value.trim() || null,
                nic_or_passport_number: document.getElementById('nic').value.trim() || null,
                dob: document.getElementById('dob').value || null,
                gender: document.getElementById('gender').value || null,
                registration_date: document.getElementById('registrationDate').value || null,
                reffered_by: document.getElementById('referredBy').value.trim() || null,
                address: document.getElementById('address').value.trim() || null,
                city: document.getElementById('city').value.trim() || null,
                district: document.getElementById('district').value.trim() || null,
                postal_code: document.getElementById('postalCode').value.trim() || null,
                country: document.getElementById('country').value.trim() || null,
                credit_limit: toDecimal(document.getElementById('creditLimit').value),
                credit_days: toInteger(document.getElementById('creditDays').value),
                discount_rate: toDecimal(document.getElementById('discount').value),
                prefferred_payment_method: document.getElementById('paymentMethod').value || null,
                note: document.getElementById('notes').value.trim() || null,
            };

            if (!payload.name || !payload.phone_number || !payload.type) {
                Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Name, phone number, and customer type are required.' });
                return;
            }

            Object.keys(payload).forEach((key) => {
                if (payload[key] === null || payload[key] === '') {
                    delete payload[key];
                }
            });

            const updateBtn = document.getElementById('updateBtn');
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            try {
                const response = await fetch(`${API_URL}/${customerId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();
                if (!response.ok || !result.success) {
                    throw new Error(result.error || result.message || 'Update failed');
                }

                await Swal.fire({ icon: 'success', title: 'Customer Updated', text: 'Changes saved successfully.' });
                window.location.href = 'index.php';
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Update Failed', text: error.message || 'Something went wrong.' });
            } finally {
                updateBtn.disabled = false;
                updateBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
            }
        });

        loadCustomer();
    </script>
</body>
</html>
