<?php
$activePage = 'shops';
$basePath = '../';
$pageTitle = 'Add Shop';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PositiQ POS System · Add Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
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
                            Back to Shops
                        </a>
                    </div>
                </div>

                <form class="sale-form" action="#" method="post">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Shop Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="shopName">Shop Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="shopName" name="shopName" placeholder="e.g., Tech Haven Mobile" required>
                            </div>
                            <div class="form-field">
                                <label for="shopID">Shop ID <span style="color: #f44336;">*</span></label>
                                <input type="text" id="shopID" name="shopID" placeholder="e.g., SH-001" required>
                            </div>
                            <div class="form-field">
                                <label for="ownerName">Owner Name <span style="color: #f44336;">*</span></label>
                                <input type="text" id="ownerName" name="ownerName" placeholder="e.g., John Doe" required>
                            </div>
                            <div class="form-field">
                                <label for="registrationDate">Registration Date <span style="color: #f44336;">*</span></label>
                                <input type="date" id="registrationDate" name="registrationDate" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Contact Information</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="phone">Phone Number <span style="color: #f44336;">*</span></label>
                                <input type="tel" id="phone" name="phone" placeholder="+94 77 123 4567" required>
                            </div>
                            <div class="form-field">
                                <label for="altPhone">Alternate Phone</label>
                                <input type="tel" id="altPhone" name="altPhone" placeholder="+94 71 234 5678">
                            </div>
                            <div class="form-field">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="shop@email.com">
                            </div>
                            <div class="form-field">
                                <label for="whatsapp">WhatsApp Number</label>
                                <input type="tel" id="whatsapp" name="whatsapp" placeholder="+94 77 123 4567">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Location Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="address">Shop Address <span style="color: #f44336;">*</span></label>
                                <input type="text" id="address" name="address" placeholder="e.g., 123 Main Street" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="city">City <span style="color: #f44336;">*</span></label>
                                <input type="text" id="city" name="city" placeholder="e.g., Colombo" required>
                            </div>
                            <div class="form-field">
                                <label for="district">District <span style="color: #f44336;">*</span></label>
                                <select id="district" name="district" required>
                                    <option value="">Select District</option>
                                    <option>Colombo</option>
                                    <option>Gampaha</option>
                                    <option>Kalutara</option>
                                    <option>Kandy</option>
                                    <option>Galle</option>
                                    <option>Matara</option>
                                    <option>Hambantota</option>
                                    <option>Jaffna</option>
                                    <option>Kilinochchi</option>
                                    <option>Mannar</option>
                                    <option>Vavuniya</option>
                                    <option>Mullaitivu</option>
                                    <option>Batticaloa</option>
                                    <option>Ampara</option>
                                    <option>Trincomalee</option>
                                    <option>Kurunegala</option>
                                    <option>Puttalam</option>
                                    <option>Anuradhapura</option>
                                    <option>Polonnaruwa</option>
                                    <option>Badulla</option>
                                    <option>Moneragala</option>
                                    <option>Ratnapura</option>
                                    <option>Kegalle</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" id="postalCode" name="postalCode" placeholder="e.g., 10100">
                            </div>
                            <div class="form-field">
                                <label for="landmark">Landmark</label>
                                <input type="text" id="landmark" name="landmark" placeholder="e.g., Near City Mall">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Business Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="businessRegNo">Business Registration No.</label>
                                <input type="text" id="businessRegNo" name="businessRegNo" placeholder="e.g., BR-123456">
                            </div>
                            <div class="form-field">
                                <label for="taxID">Tax ID / TIN</label>
                                <input type="text" id="taxID" name="taxID" placeholder="e.g., 123456789V">
                            </div>
                            <div class="form-field">
                                <label for="shopType">Shop Type</label>
                                <select id="shopType" name="shopType">
                                    <option>Retail</option>
                                    <option>Wholesale</option>
                                    <option>Authorized Dealer</option>
                                    <option>Partner</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="status">Shop Status</label>
                                <select id="status" name="status">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>On Hold</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Financial Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="creditLimit">Credit Limit (LKR)</label>
                                <input type="number" id="creditLimit" name="creditLimit" placeholder="0.00" step="0.01" value="0">
                                <div class="form-hint">Maximum credit allowed for this shop</div>
                            </div>
                            <div class="form-field">
                                <label for="creditDays">Credit Days</label>
                                <input type="number" id="creditDays" name="creditDays" placeholder="30" min="0" value="30">
                                <div class="form-hint">Payment due within days</div>
                            </div>
                            <div class="form-field">
                                <label for="commission">Commission Rate (%)</label>
                                <input type="number" id="commission" name="commission" placeholder="0" step="0.01" min="0" max="100" value="0">
                                <div class="form-hint">Commission on sales</div>
                            </div>
                            <div class="form-field">
                                <label for="paymentTerms">Payment Terms</label>
                                <select id="paymentTerms" name="paymentTerms">
                                    <option>Cash on Delivery</option>
                                    <option>Credit</option>
                                    <option>Bank Transfer</option>
                                    <option>Mixed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Bank Details</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="bankName">Bank Name</label>
                                <input type="text" id="bankName" name="bankName" placeholder="e.g., Bank of Ceylon">
                            </div>
                            <div class="form-field">
                                <label for="branchName">Branch Name</label>
                                <input type="text" id="branchName" name="branchName" placeholder="e.g., Colombo Main">
                            </div>
                            <div class="form-field">
                                <label for="accountNumber">Account Number</label>
                                <input type="text" id="accountNumber" name="accountNumber" placeholder="e.g., 1234567890">
                            </div>
                            <div class="form-field">
                                <label for="accountName">Account Holder Name</label>
                                <input type="text" id="accountName" name="accountName" placeholder="e.g., Shop Owner Name">
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Additional Notes</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="notes">Notes / Comments</label>
                                <textarea id="notes" name="notes" rows="4" placeholder="Add any additional information about this shop..." style="width: 100%; padding: 12px 16px; border: 1px solid #dfe3ed; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; resize: vertical;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end; padding: 24px 0;">
                        <a href="index.php" class="button-secondary" style="text-decoration: none; padding: 12px 32px;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="reset" class="button-secondary">
                            <i class="fas fa-redo"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="button-primary">
                            <i class="fas fa-save"></i>
                            Save Shop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        // Form validation
        document.querySelector('.sale-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const shopName = document.getElementById('shopName').value;
            const shopID = document.getElementById('shopID').value;
            const ownerName = document.getElementById('ownerName').value;
            
            if (!shopName || !shopID || !ownerName) {
                alert('Please fill in all required fields!');
                return false;
            }
            
            // Show success message
            alert('Shop added successfully!');
            window.location.href = 'index.php';
        });

        // Auto-format phone numbers
        document.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('blur', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.startsWith('94')) {
                    value = value.substring(2);
                }
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                if (value.length === 9) {
                    this.value = '+94 ' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5);
                }
            });
        });
    </script>
</body>
</html>
