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
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage general settings and invoice details">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Settings</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .logo-upload-area {
            width: 110px;
            height: 110px;
            border: 2px dashed #c5cae9;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            flex-shrink: 0;
            background: #f5f7ff;
            transition: border-color 0.2s, background 0.2s;
        }
        .logo-upload-area:hover { border-color: #3f51b5; background: #eef0fb; }
        .logo-upload-area img { width: 100%; height: 100%; object-fit: contain; }
        .logo-upload-area .placeholder-icon { font-size: 30px; color: #9fa8da; margin-bottom: 4px; }
        .logo-upload-area .placeholder-label { font-size: 11px; color: #9fa8da; text-align: center; padding: 0 6px; }
        .danger-zone-card { border: 1px solid #ffcdd2 !important; }
        .danger-zone-card .chart-header { border-bottom-color: #ffcdd2 !important; }
        .danger-zone-card .chart-header h3 { color: #c62828; }
        .reset-option-box {
            flex: 1; min-width: 260px; padding: 20px;
            background: #fff5f5; border: 1px solid #ffcdd2; border-radius: 10px;
        }
        .reset-option-box h4 { margin: 0 0 6px; font-size: 15px; color: #b71c1c; }
        .reset-option-box p { margin: 0 0 14px; font-size: 13px; color: #666; }
        .btn-danger {
            background: #c62828; color: white; border: none;
            padding: 8px 18px; border-radius: 6px; cursor: pointer;
            font-size: 13px; font-weight: 600; transition: background 0.2s;
        }
        .btn-danger:hover { background: #b71c1c; }
        .btn-danger-outline {
            background: transparent; color: #c62828; border: 1.5px solid #c62828;
            padding: 7px 18px; border-radius: 6px; cursor: pointer;
            font-size: 13px; font-weight: 600; transition: all 0.2s;
        }
        .btn-danger-outline:hover { background: #ffebee; }
    </style>
</head>
<body>
    <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <h2 style="margin: 0; font-size: 16px; color: #333;">System Configuration</h2>
                    </div>
                    <div class="toolbar-actions">
                        <button class="button-primary" type="button" onclick="saveSettings()">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <button class="button-secondary" type="button" onclick="resetFormToDefaults()">
                            <i class="fas fa-undo"></i>
                            Reset to Default
                        </button>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-store"></i> Business Information</h3>
                        </div>

                        <!-- Logo Upload -->
                        <div style="display: flex; align-items: flex-start; gap: 20px; margin-bottom: 20px; padding: 16px; background: #fafafa; border-radius: 10px;">
                            <div class="logo-upload-area" id="logoUploadArea" onclick="document.getElementById('logoFileInput').click()" title="Click to upload logo">
                                <img id="logoPreview" src="" alt="Logo" style="display: none;">
                                <div id="logoPlaceholder" style="display: flex; flex-direction: column; align-items: center;">
                                    <i class="fas fa-image placeholder-icon"></i>
                                    <span class="placeholder-label">Click to upload</span>
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <p style="font-size: 14px; font-weight: 600; margin: 0 0 4px; color: #22315b;">Business Logo</p>
                                <p style="font-size: 12px; color: #888; margin: 0 0 14px; line-height: 1.5;">This logo will appear on all printed invoices.<br>Recommended size: 300 × 100 px (PNG or JPG).</p>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <button type="button" class="button-secondary" style="font-size: 13px; padding: 6px 14px;" onclick="document.getElementById('logoFileInput').click()">
                                        <i class="fas fa-upload"></i> Upload Logo
                                    </button>
                                    <button type="button" class="button-secondary" id="removeLogoBtn" style="font-size: 13px; padding: 6px 14px; color: #c62828; border-color: #c62828; display: none;" onclick="removeLogo()">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                <input type="file" id="logoFileInput" accept="image/*" style="display: none;" onchange="handleLogoUpload(event)">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="businessName">Business Name</label>
                                <input type="text" id="businessName" placeholder="Your Business Name">
                            </div>
                            <div class="form-field">
                                <label for="businessPhone">Phone Number</label>
                                <input type="tel" id="businessPhone" placeholder="+94 XX XXX XXXX">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="businessEmail">Email Address</label>
                                <input type="email" id="businessEmail" placeholder="your@email.com">
                            </div>
                            <div class="form-field">
                                <label for="businessWebsite">Website</label>
                                <input type="url" id="businessWebsite" placeholder="www.yourwebsite.com">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="businessAddress">Address</label>
                                <textarea id="businessAddress" rows="3" placeholder="Business address..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Settings + Regional Settings -->
                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-receipt"></i> Invoice Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="invoicePrefix">Invoice Prefix</label>
                                <input type="text" id="invoicePrefix" placeholder="INV-">
                            </div>
                            <div class="form-field">
                                <label for="nextInvoiceNo">Next Invoice Number</label>
                                <input type="number" id="nextInvoiceNo" placeholder="1" min="1">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field" style="grid-column: 1 / -1;">
                                <label for="invoiceFooter">Invoice Footer Note</label>
                                <textarea id="invoiceFooter" rows="3" placeholder="Thank you for your business!..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-globe"></i> Regional Settings</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="currency">Currency</label>
                                <select id="currency">
                                    <option value="LKR - Sri Lankan Rupees">LKR - Sri Lankan Rupees</option>
                                    <option value="USD - US Dollar">USD - US Dollar</option>
                                    <option value="EUR - Euro">EUR - Euro</option>
                                    <option value="GBP - British Pound">GBP - British Pound</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="timezone">Timezone</label>
                                <select id="timezone">
                                    <option value="Asia/Colombo (GMT+5:30)">Asia/Colombo (GMT+5:30)</option>
                                    <option value="Asia/Dubai (GMT+4:00)">Asia/Dubai (GMT+4:00)</option>
                                    <option value="Asia/Singapore (GMT+8:00)">Asia/Singapore (GMT+8:00)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="dateFormat">Date Format</label>
                                <select id="dateFormat">
                                    <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                    <option value="MMM DD, YYYY">MMM DD, YYYY</option>
                                    <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="language">Language</label>
                                <select id="language">
                                    <option value="English">English</option>
                                    <option value="Sinhala">Sinhala</option>
                                    <option value="Tamil">Tamil</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="cards-row" style="margin-bottom: 24px;">
                    <div class="chart-card danger-zone-card" style="flex: 1;">
                        <div class="chart-header">
                            <h3><i class="fas fa-exclamation-triangle"></i> Danger Zone — System Reset</h3>
                        </div>
                        <p style="font-size: 13px; color: #888; margin: 0 0 18px;">These actions are irreversible. All deleted data cannot be recovered. Make sure you have a backup before proceeding.</p>
                        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                            <div class="reset-option-box">
                                <h4><i class="fas fa-filter"></i> Selective Reset</h4>
                                <p>Choose specific data groups to clear while keeping everything else intact.</p>
                                <button type="button" class="btn-danger-outline" onclick="openSelectiveReset()">
                                    <i class="fas fa-database"></i> Select Data to Reset
                                </button>
                            </div>
                            <div class="reset-option-box">
                                <h4><i class="fas fa-skull-crossbones"></i> Full System Reset</h4>
                                <p>Permanently wipe ALL data from every table. The system will be completely empty.</p>
                                <button type="button" class="btn-danger" onclick="openFullReset()">
                                    <i class="fas fa-trash-alt"></i> Full Reset
                                </button>
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
        const API_BASE = 'http://localhost:3000/api';

        const DEFAULT_SETTINGS = {
            businessName: 'Doctor Phone',
            businessPhone: '+94 77 123 4567',
            businessEmail: 'info@doctorphone.lk',
            businessWebsite: 'www.doctorphone.lk',
            businessAddress: '123 Main Street, Colombo 07, Sri Lanka',
            businessLogo: '',
            currency: 'LKR - Sri Lankan Rupees',
            timezone: 'Asia/Colombo (GMT+5:30)',
            dateFormat: 'MMM DD, YYYY',
            language: 'English',
            invoicePrefix: 'INV-',
            nextInvoiceNo: 1,
            invoiceFooter: 'Thank you for your business! Please contact us for any queries.',
        };

        let currentLogo = '';

        function applySettingsToForm(s) {
            document.getElementById('businessName').value = s.businessName;
            document.getElementById('businessPhone').value = s.businessPhone;
            document.getElementById('businessEmail').value = s.businessEmail;
            document.getElementById('businessWebsite').value = s.businessWebsite;
            document.getElementById('businessAddress').value = s.businessAddress;
            document.getElementById('currency').value = s.currency;
            document.getElementById('timezone').value = s.timezone;
            document.getElementById('dateFormat').value = s.dateFormat;
            document.getElementById('language').value = s.language;
            document.getElementById('invoicePrefix').value = s.invoicePrefix;
            document.getElementById('nextInvoiceNo').value = s.nextInvoiceNo;
            document.getElementById('invoiceFooter').value = s.invoiceFooter;
            currentLogo = s.businessLogo || '';
            applyLogoPreview(currentLogo);
        }

        async function loadSettings() {
            try {
                const resp = await fetch(`${API_BASE}/settings`);
                const json = await resp.json();
                if (!resp.ok || !json.success) {
                    throw new Error(json.message || 'Failed to load settings');
                }
                const s = { ...DEFAULT_SETTINGS, ...(json.data || {}) };
                applySettingsToForm(s);
            } catch (error) {
                applySettingsToForm({ ...DEFAULT_SETTINGS });
                Swal.fire({
                    icon: 'warning',
                    title: 'Using Default Settings',
                    text: `Could not load saved settings from server: ${error.message}`,
                });
            }
        }

        async function saveSettings() {
            const s = {
                businessName: document.getElementById('businessName').value.trim(),
                businessPhone: document.getElementById('businessPhone').value.trim(),
                businessEmail: document.getElementById('businessEmail').value.trim(),
                businessWebsite: document.getElementById('businessWebsite').value.trim(),
                businessAddress: document.getElementById('businessAddress').value.trim(),
                businessLogo: currentLogo,
                currency: document.getElementById('currency').value,
                timezone: document.getElementById('timezone').value,
                dateFormat: document.getElementById('dateFormat').value,
                language: document.getElementById('language').value,
                invoicePrefix: document.getElementById('invoicePrefix').value.trim() || 'INV-',
                nextInvoiceNo: parseInt(document.getElementById('nextInvoiceNo').value, 10) || 1,
                invoiceFooter: document.getElementById('invoiceFooter').value.trim(),
            };
            try {
                const resp = await fetch(`${API_BASE}/settings`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(s),
                });
                const json = await resp.json();
                if (!resp.ok || !json.success) {
                    throw new Error(json.message || 'Failed to save settings');
                }
                Swal.fire({ icon: 'success', title: 'Saved!', text: 'Settings have been saved successfully.', timer: 1800, showConfirmButton: false });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Save Failed', text: error.message });
            }
        }

        function resetFormToDefaults() {
            Swal.fire({
                title: 'Reset to Defaults?',
                text: 'This will reset all form fields to default values and save them to the database.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Reset Form',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    currentLogo = '';
                    try {
                        const resp = await fetch(`${API_BASE}/settings`, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(DEFAULT_SETTINGS),
                        });
                        const json = await resp.json();
                        if (!resp.ok || !json.success) {
                            throw new Error(json.message || 'Failed to reset settings');
                        }
                        await loadSettings();
                        Swal.fire({ icon: 'success', title: 'Done', text: 'Form reset to defaults.', timer: 1500, showConfirmButton: false });
                    } catch (error) {
                        Swal.fire({ icon: 'error', title: 'Reset Failed', text: error.message });
                    }
                }
            });
        }

        function compressImageFile(file, { maxWidth = 640, maxHeight = 240, quality = 0.82 } = {}) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onerror = () => reject(new Error('Failed to read image file.'));
                reader.onload = () => {
                    const img = new Image();
                    img.onerror = () => reject(new Error('Failed to process image file.'));
                    img.onload = () => {
                        const ratio = Math.min(maxWidth / img.width, maxHeight / img.height, 1);
                        const canvas = document.createElement('canvas');
                        canvas.width = Math.max(1, Math.round(img.width * ratio));
                        canvas.height = Math.max(1, Math.round(img.height * ratio));
                        const ctx = canvas.getContext('2d');
                        if (!ctx) {
                            reject(new Error('Canvas not supported in this browser.'));
                            return;
                        }
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        resolve(canvas.toDataURL('image/jpeg', quality));
                    };
                    img.src = reader.result;
                };
                reader.readAsDataURL(file);
            });
        }

        async function handleLogoUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Please select an image file (PNG, JPG, etc.).' });
                return;
            }
            try {
                const compressedLogo = await compressImageFile(file);
                currentLogo = compressedLogo;
                applyLogoPreview(currentLogo);
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Upload Failed', text: error.message || 'Could not process image.' });
            }
            event.target.value = '';
        }

        function applyLogoPreview(src) {
            const img = document.getElementById('logoPreview');
            const placeholder = document.getElementById('logoPlaceholder');
            const removeBtn = document.getElementById('removeLogoBtn');
            if (src) {
                img.src = src;
                img.style.display = 'block';
                placeholder.style.display = 'none';
                removeBtn.style.display = 'inline-flex';
            } else {
                img.src = '';
                img.style.display = 'none';
                placeholder.style.display = 'flex';
                removeBtn.style.display = 'none';
            }
        }

        function removeLogo() {
            currentLogo = '';
            applyLogoPreview('');
        }

        async function openSelectiveReset() {
            let groups = [];
            try {
                const resp = await fetch(`${API_BASE}/reset/groups`);
                const json = await resp.json();
                groups = json.data || [];
            } catch {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not load reset options. Is the server running?' });
                return;
            }

            const checkboxesHtml = groups.map((g) => `
                <div style="display:flex;align-items:flex-start;gap:10px;padding:12px;margin-bottom:8px;background:#fff5f5;border:1px solid #ffcdd2;border-radius:8px;cursor:pointer;" onclick="this.querySelector('input').click()">
                    <input type="checkbox" id="chk_${g.key}" value="${g.key}" style="margin-top:2px;width:16px;height:16px;flex-shrink:0;cursor:pointer;" onclick="event.stopPropagation()">
                    <div>
                        <strong style="font-size:14px;color:#b71c1c;">${g.label}</strong>
                        <p style="margin:2px 0 0;font-size:12px;color:#666;">${g.description}</p>
                    </div>
                </div>
            `).join('');

            const { value: confirmed } = await Swal.fire({
                title: '<span style="color:#b71c1c"><i class="fas fa-database"></i> Selective Reset</span>',
                html: `
                    <p style="font-size:13px;color:#666;margin-bottom:16px;text-align:left;">Select the data groups you want to permanently delete:</p>
                    <div style="text-align:left;max-height:320px;overflow-y:auto;">${checkboxesHtml}</div>
                    <p style="font-size:12px;color:#e53935;margin-top:14px;text-align:left;"><i class="fas fa-exclamation-circle"></i> This action cannot be undone.</p>
                `,
                showCancelButton: true,
                confirmButtonColor: '#c62828',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Reset Selected',
                preConfirm: () => {
                    const selected = groups
                        .filter((g) => document.getElementById(`chk_${g.key}`)?.checked)
                        .map((g) => g.key);
                    if (selected.length === 0) {
                        Swal.showValidationMessage('Please select at least one group.');
                        return false;
                    }
                    return selected;
                },
            });

            if (!confirmed) return;

            const { isConfirmed: finalConfirm } = await Swal.fire({
                title: 'Are you absolutely sure?',
                html: `<p style="font-size:13px;color:#666">You are about to delete: <strong style="color:#b71c1c">${confirmed.join(', ')}</strong><br><br>This data <strong>cannot be recovered</strong>.</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#c62828',
                confirmButtonText: 'Yes, Delete It',
                cancelButtonText: 'Cancel',
            });

            if (!finalConfirm) return;

            try {
                Swal.fire({ title: 'Resetting...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                const resp = await fetch(`${API_BASE}/reset/selective`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ groups: confirmed }),
                });
                const json = await resp.json();
                if (!resp.ok || !json.success) throw new Error(json.message || 'Reset failed');
                Swal.fire({ icon: 'success', title: 'Reset Complete', text: json.message });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Reset Failed', text: error.message });
            }
        }

        async function openFullReset() {
            const { value: typed } = await Swal.fire({
                title: '<span style="color:#b71c1c"><i class="fas fa-skull-crossbones"></i> Full System Reset</span>',
                html: `
                    <p style="font-size:13px;color:#666;margin-bottom:14px;">This will <strong>permanently delete ALL data</strong> from every table in the database. The system will be completely empty.</p>
                    <p style="font-size:13px;color:#b71c1c;margin-bottom:12px;">Type <strong>RESET</strong> below to confirm:</p>
                    <input id="resetConfirmInput" type="text" class="swal2-input" placeholder="Type RESET here" style="border-color:#c62828;margin:0;">
                `,
                showCancelButton: true,
                confirmButtonColor: '#c62828',
                confirmButtonText: 'Permanently Delete All Data',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const val = document.getElementById('resetConfirmInput').value.trim();
                    if (val !== 'RESET') {
                        Swal.showValidationMessage('You must type RESET exactly to proceed.');
                        return false;
                    }
                    return val;
                },
            });

            if (!typed) return;

            try {
                Swal.fire({ title: 'Resetting all data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                const resp = await fetch(`${API_BASE}/reset/full`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                });
                const json = await resp.json();
                if (!resp.ok || !json.success) throw new Error(json.message || 'Reset failed');
                Swal.fire({ icon: 'success', title: 'Full Reset Complete', text: json.message });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Reset Failed', text: error.message });
            }
        }

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

        loadSettings();
    </script>
</body>
</html>
