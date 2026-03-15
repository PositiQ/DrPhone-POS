<?php
$activePage = $activePage ?? '';
$basePath = $basePath ?? './';
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="shop-logo">
            <img id="sidebarBusinessLogo" src="https://res.cloudinary.com/dhqcnszvn/image/upload/v1771863002/Gemini_Generated_Image_ijmf3cijmf3cijmf_1_1_1_gbxcyz.png" alt="logo" width="50px">
            <div class="shop-info">
                <h2 id="sidebarBusinessName">Doctor Phone</h2>
                <p>Admin Dashboard</p>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <a class="nav-item<?php echo $activePage === 'dashboard' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>index.php">
            <i class="fas fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'sales' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>sales/index.php">
            <i class="fas fa-shopping-cart"></i>
            <span>Sales</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'inventory' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>inventory/index.php">
            <i class="fas fa-boxes"></i>
            <span>Inventory</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'products' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>products/index.php">
            <i class="fas fa-mobile"></i>
            <span>Products</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'customers' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>customers/index.php">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'invoices-quotations' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>invoices-quotations/index.php">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'vault-balance' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>vault-balance/index.php">
            <i class="fas fa-vault"></i>
            <span>Vault & Balance</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'expenses' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>expenses/index.php">
            <i class="fas fa-wallet"></i>
            <span>Expenses</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'suppliers' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>suppliers/index.php">
            <i class="fas fa-truck"></i>
            <span>Suppliers</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'shops' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>shops/index.php">
            <i class="fas fa-store"></i>
            <span>Shops</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'returns-repairs' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>returns-repairs/index.php">
            <i class="fas fa-tools"></i>
            <span>Returns & Repairs</span>
        </a>

        <div class="nav-divider"></div>

        <a class="nav-item<?php echo $activePage === 'settings' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>settings/index.php">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>

        <a class="nav-item<?php echo $activePage === 'users' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>users/index.php">
            <i class="fas fa-user-shield"></i>
            <span>Users</span>
        </a>
    </div>
</div>

<script>
    (function applySidebarBusinessSettings() {
        const nameEl = document.getElementById('sidebarBusinessName');
        const logoEl = document.getElementById('sidebarBusinessLogo');
        const cacheKey = 'posSidebarSettings.v1';
        if (!nameEl || !logoEl) {
            return;
        }

        const applySettings = (settings) => {
            if (!settings || typeof settings !== 'object') {
                return;
            }
            if (settings.businessName) {
                nameEl.textContent = settings.businessName;
            }
            if (settings.businessLogo) {
                logoEl.src = settings.businessLogo;
                logoEl.style.objectFit = 'contain';
            }
        };

        try {
            const cached = sessionStorage.getItem(cacheKey);
            if (cached) {
                const parsed = JSON.parse(cached);
                applySettings(parsed);
                return;
            }
        } catch (_) {
            // Ignore cache read/parse errors and fall back to API call.
        }

        fetch('http://localhost:3000/api/settings')
            .then((resp) => resp.json())
            .then((json) => {
                if (!json || !json.success || !json.data) {
                    return;
                }
                const settings = {
                    businessName: json.data.businessName || '',
                    businessLogo: json.data.businessLogo || '',
                };
                applySettings(settings);
                try {
                    sessionStorage.setItem(cacheKey, JSON.stringify(settings));
                } catch (_) {
                    // Ignore quota/storage errors.
                }
            })
            .catch(() => {
                // Keep defaults if settings API is unavailable.
            });
    })();
</script>
