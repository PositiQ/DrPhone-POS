<?php
require_once __DIR__ . '/auth.php';
$activePage = $activePage ?? '';
$basePath = $basePath ?? './';
$currentUserName = pos_user_display_name();
$currentUserRole = pos_user_role_name();
$navItems = [
    ['page' => 'dashboard', 'href' => 'index.php', 'icon' => 'fa-chart-pie', 'label' => 'Dashboard', 'permission' => 'dashboard.view'],
    ['page' => 'sales', 'href' => 'sales/index.php', 'icon' => 'fa-shopping-cart', 'label' => 'Sales', 'permission' => 'sales.view'],
    ['page' => 'inventory', 'href' => 'inventory/index.php', 'icon' => 'fa-boxes', 'label' => 'Inventory', 'permission' => 'inventory.view'],
    ['page' => 'products', 'href' => 'products/index.php', 'icon' => 'fa-mobile', 'label' => 'Products', 'permission' => 'products.view'],
    ['page' => 'customers', 'href' => 'customers/index.php', 'icon' => 'fa-users', 'label' => 'Customers', 'permission' => 'customers.view'],
    ['page' => 'invoices-quotations', 'href' => 'invoices-quotations/index.php', 'icon' => 'fa-file-invoice', 'label' => 'Invoices', 'permission' => 'invoices.view'],
    ['page' => 'vault-balance', 'href' => 'vault-balance/index.php', 'icon' => 'fa-vault', 'label' => 'Vault & Balance', 'permission' => 'vault.view'],
    ['page' => 'expenses', 'href' => 'expenses/index.php', 'icon' => 'fa-wallet', 'label' => 'Expenses', 'permission' => 'expenses.view'],
    ['page' => 'suppliers', 'href' => 'suppliers/index.php', 'icon' => 'fa-truck', 'label' => 'Suppliers', 'permission' => 'suppliers.view'],
    ['page' => 'shops', 'href' => 'shops/index.php', 'icon' => 'fa-store', 'label' => 'Shops', 'permission' => 'shops.view'],
    ['page' => 'returns-repairs', 'href' => 'returns-repairs/index.php', 'icon' => 'fa-tools', 'label' => 'Returns & Repairs', 'permission' => 'returns_repairs.view'],
];
?>
<style>
    .sidebar {
        background: linear-gradient(180deg, #111111 0%, #000000 100%) !important;
        scrollbar-color: #333333 #111111 !important;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #111111 !important;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #333333 !important;
    }

    .sidebar .nav-item.active,
    .sidebar .nav-item.active i {
        color: #111111 !important;
    }
</style>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="shop-logo">
            <img id="sidebarBusinessLogo" src="https://res.cloudinary.com/dhqcnszvn/image/upload/v1771863002/Gemini_Generated_Image_ijmf3cijmf3cijmf_1_1_1_gbxcyz.png" alt="logo" width="50px">
            <div class="shop-info">
                <h2 id="sidebarBusinessName">Doctor Phone</h2>
                <p><?php echo htmlspecialchars($currentUserRole, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <?php foreach ($navItems as $item): ?>
            <?php if (!pos_has_permission($item['permission'])) { continue; } ?>
            <a class="nav-item<?php echo $activePage === $item['page'] ? ' active' : ''; ?>" href="<?php echo htmlspecialchars($basePath . $item['href'], ENT_QUOTES, 'UTF-8'); ?>">
                <i class="fas <?php echo htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                <span><?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
        <?php endforeach; ?>

        <div class="nav-divider"></div>

        <a class="nav-item<?php echo $activePage === 'profile' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>profile/index.php">
            <i class="fas fa-id-badge"></i>
            <span>My Profile</span>
        </a>

        <?php if (pos_has_permission('settings.view')): ?>
            <a class="nav-item<?php echo $activePage === 'settings' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>settings/index.php">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        <?php endif; ?>

        <?php if (pos_has_permission('users.view')): ?>
            <a class="nav-item<?php echo $activePage === 'users' ? ' active' : ''; ?>" href="<?php echo $basePath; ?>users/index.php">
                <i class="fas fa-user-shield"></i>
                <span>Users</span>
            </a>
        <?php endif; ?>

        <a class="nav-item" href="/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
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
