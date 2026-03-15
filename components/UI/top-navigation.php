<?php
require_once __DIR__ . '/auth.php';
$resolvedPageTitle = isset($pageTitle) ? $pageTitle : 'Dashboard';
$topNavUserName = pos_user_display_name();
$topNavUserRole = pos_user_role_name();
$topNavUserInitials = pos_user_initials();
?>
<style>
    .notif-wrapper {
        position: relative;
    }

    .notif-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: -10px;
        width: 340px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(26,35,126,.14);
        z-index: 9999;
        overflow: hidden;
        animation: notifFadeIn .18s ease;
    }

    .notif-dropdown.open { display: block; }

    @keyframes notifFadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .notif-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px 10px;
        border-bottom: 1px solid #f0f2f8;
    }

    .notif-header h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #111111;
    }

    .notif-mark-all {
        font-size: 11px;
        color: #333333;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
        font-weight: 500;
    }

    .notif-mark-all:hover { text-decoration: underline; }

    .notif-list { max-height: 320px; overflow-y: auto; }

    .notif-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 12px 18px;
        cursor: pointer;
        transition: background .15s;
        border-left: 3px solid transparent;
    }

    .notif-item:hover { background: #f3f4f6; }

    .notif-item.unread {
        background: #f3f4f6;
        border-left-color: #222222;
    }

    .notif-item.unread:hover { background: #e5e7eb; }

    .notif-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .notif-body { flex: 1; min-width: 0; }

    .notif-body p {
        margin: 0 0 3px;
        font-size: 12.5px;
        color: #2c3566;
        line-height: 1.4;
        font-weight: 500;
    }

    .notif-item:not(.unread) .notif-body p { font-weight: 400; color: #5a6480; }

    .notif-time {
        font-size: 11px;
        color: #9da8c9;
    }

    .notif-footer {
        text-align: center;
        padding: 10px;
        border-top: 1px solid #f0f2f8;
    }

    .notif-footer a {
        font-size: 12px;
        color: #222222;
        text-decoration: none;
        font-weight: 500;
    }

    .notif-footer a:hover { text-decoration: underline; }

    .notif-dot {
        width: 7px;
        height: 7px;
        background: #222222;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
    }

    .global-search-suggestions {
        margin-top: 10px;
        border: 1px solid #dbe2f6;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(26, 35, 126, 0.12);
        max-height: 300px;
        overflow: auto;
        display: none;
    }

    .global-search-suggestions.open {
        display: block;
    }

    .global-search-item {
        padding: 10px 12px;
        border-bottom: 1px solid #edf1fb;
        cursor: pointer;
    }

    .global-search-item:last-child {
        border-bottom: none;
    }

    .global-search-item:hover,
    .global-search-item.active {
        background: #f3f6ff;
    }

    .global-search-title {
        font-size: 13px;
        color: #1e2a4a;
        font-weight: 600;
    }

    .global-search-meta {
        margin-top: 3px;
        font-size: 11px;
        color: #6a7698;
    }

    .global-search-highlight {
        background: #fff5b8;
        border-radius: 2px;
        padding: 0 2px;
    }
</style>
<div class="top-header">
    <div class="header-left">
        <i class="fas fa-bars menu-toggle" id="menuToggle" onclick="toggleSidebar()"></i>
        <h1 class="page-title"><?php echo htmlspecialchars($resolvedPageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    </div>

    <div class="header-center">
        <div class="search-box" id="searchTrigger" role="button" aria-haspopup="dialog" aria-controls="searchOverlay" tabindex="0">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..." id="globalSearch" aria-label="Global search" readonly>
        </div>
    </div>

    <div class="header-right">
        <div class="header-icon notif-wrapper" id="notifWrapper">
            <i class="far fa-bell" id="notifBell" style="cursor:pointer;" onclick="toggleNotifDropdown()"></i>
            <span class="badge" id="notifBadge" style="display:none;">0</span>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <h5>Notifications</h5>
                    <button class="notif-mark-all" onclick="markAllRead()">Mark all as read</button>
                </div>
                <div class="notif-list" id="notifList">
                    <div class="notif-item">
                        <div class="notif-body">
                            <p>Loading notifications...</p>
                            <span class="notif-time">Please wait</span>
                        </div>
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="#" onclick="event.preventDefault();">Live updates from system records</a>
                </div>
            </div>
        </div>

        <a class="user-profile" href="<?php echo htmlspecialchars($basePath ?? '../', ENT_QUOTES, 'UTF-8'); ?>profile/index.php" style="text-decoration:none; color:inherit;">
            <img src="https://ui-avatars.com/api/?name=<?php echo rawurlencode($topNavUserInitials); ?>&background=1a237e&color=ffd700&bold=true" alt="User">
            <div class="user-info">
                <h4><?php echo htmlspecialchars($topNavUserName, ENT_QUOTES, 'UTF-8'); ?></h4>
                <p><?php echo htmlspecialchars($topNavUserRole, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </a>
    </div>
</div>

<script>
(function () {
    const NOTIFICATIONS_API = 'http://localhost:3000/api/notifications?limit=25';
    const READ_NOTIFICATIONS_KEY = 'pos.readNotifications.v1';

    function getReadNotificationIds() {
        try {
            const value = JSON.parse(localStorage.getItem(READ_NOTIFICATIONS_KEY) || '[]');
            return Array.isArray(value) ? value : [];
        } catch (_) {
            return [];
        }
    }

    function setReadNotificationIds(ids) {
        try {
            const uniqueIds = Array.from(new Set((ids || []).filter(Boolean))).slice(-500);
            localStorage.setItem(READ_NOTIFICATIONS_KEY, JSON.stringify(uniqueIds));
        } catch (_) {
            // Ignore storage errors.
        }
    }

    function addReadNotificationId(id) {
        if (!id) return;
        const ids = getReadNotificationIds();
        ids.push(id);
        setReadNotificationIds(ids);
    }

    function addReadNotificationIds(ids) {
        const current = getReadNotificationIds();
        setReadNotificationIds(current.concat(ids || []));
    }

    function toggleNotifDropdown() {
        const dropdown = document.getElementById('notifDropdown');
        if (!dropdown) return;
        dropdown.classList.toggle('open');
    }

    function renderEmptyState() {
        const list = document.getElementById('notifList');
        if (!list) return;
        list.innerHTML = `
            <div class="notif-item">
                <div class="notif-body">
                    <p>No notifications right now.</p>
                    <span class="notif-time">System is up to date</span>
                </div>
            </div>
        `;
    }

    function markRead(item) {
        const notificationId = item ? item.getAttribute('data-notification-id') : '';
        addReadNotificationId(notificationId);
        if (item && item.parentNode) {
            item.remove();
            updateBadge();
        }
    }

    function markAllRead() {
        const ids = Array.from(document.querySelectorAll('#notifList .notif-item[data-notification-id]'))
            .map(function (item) { return item.getAttribute('data-notification-id'); })
            .filter(Boolean);
        addReadNotificationIds(ids);

        document.querySelectorAll('#notifList .notif-item').forEach(function (item) {
            item.remove();
        });
        updateBadge();
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function renderNotifications(items) {
        const list = document.getElementById('notifList');
        if (!list) return;

        if (!Array.isArray(items) || items.length === 0) {
            renderEmptyState();
            updateBadge();
            return;
        }

        list.innerHTML = items.map((n) => `
            <div class="notif-item unread" data-notification-id="${escapeHtml(n.id || '')}" onclick="markRead(this)">
                <div class="notif-icon-wrap" style="background:${escapeHtml(n.iconBg || '#f3f4f6')};">
                    <i class="fas ${escapeHtml(n.icon || 'fa-bell')}" style="color:${escapeHtml(n.iconColor || '#222222')};"></i>
                </div>
                <div class="notif-body">
                    <p>${escapeHtml(n.message)}</p>
                    <span class="notif-time">${escapeHtml(n.relativeTime || 'Just now')}</span>
                </div>
                <div class="notif-dot"></div>
            </div>
        `).join('');

        updateBadge();
    }

    function renderLoadError(message) {
        const list = document.getElementById('notifList');
        if (!list) return;
        list.innerHTML = `
            <div class="notif-item">
                <div class="notif-body">
                    <p>${escapeHtml(message || 'Failed to load notifications.')}</p>
                    <span class="notif-time">Please try again later</span>
                </div>
            </div>
        `;
        updateBadge();
    }

    async function loadNotifications() {
        try {
            const response = await fetch(NOTIFICATIONS_API);
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Failed to fetch notifications');
            }
            const readIds = new Set(getReadNotificationIds());
            const items = (result.data?.notifications || []).filter((item) => !readIds.has(item.id));
            renderNotifications(items);
        } catch (error) {
            renderLoadError(error.message);
            console.error('Notification load failed:', error);
        }
    }

    function updateBadge() {
        const count = document.querySelectorAll('#notifList .notif-item.unread').length;
        const allItems = document.querySelectorAll('#notifList .notif-item').length;
        const badge = document.getElementById('notifBadge');
        if (allItems === 0) {
            renderEmptyState();
        }
        if (badge) {
            badge.textContent = count;
            badge.style.display = count === 0 ? 'none' : '';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('notifWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const dropdown = document.getElementById('notifDropdown');
            if (dropdown) dropdown.classList.remove('open');
        }
    });

    // Expose to global scope for inline onclick handlers
    window.toggleNotifDropdown = toggleNotifDropdown;
    window.markRead = markRead;
    window.markAllRead = markAllRead;

    loadNotifications();
    setInterval(loadNotifications, 60000);
}());
</script>

<script>
(function () {
    const GLOBAL_SEARCH_INDEX = [
        { title: 'Dashboard Overview', section: 'Summary Cards', url: '/components/pages/index.php', keywords: ['dashboard', 'overview', 'sales', 'orders', 'products', 'customers'] },
        { title: 'Dashboard Alerts', section: 'Low / Out Of Stock', url: '/components/pages/index.php', keywords: ['alert', 'low stock', 'out of stock', 'inventory warning'] },
        { title: 'Sales List', section: 'Sales Records', url: '/components/pages/sales/index.php', keywords: ['sales', 'invoice', 'orders', 'transactions'] },
        { title: 'Create Sale', section: 'New Sale Form', url: '/components/pages/sales/create.php', keywords: ['new sale', 'create sale', 'billing'] },
        { title: 'Products', section: 'Product Table', url: '/components/pages/products/index.php', keywords: ['products', 'imei', 'device', 'stock item'] },
        { title: 'Add Product', section: 'Add Product Form', url: '/components/pages/products/add-product.php', keywords: ['add product', 'new product'] },
        { title: 'Inventory', section: 'Stock Management', url: '/components/pages/inventory/index.php', keywords: ['inventory', 'stock', 'quantity', 'warehouse'] },
        { title: 'Customers', section: 'Customer List', url: '/components/pages/customers/index.php', keywords: ['customers', 'client', 'credit customers'] },
        { title: 'Suppliers', section: 'Supplier Management', url: '/components/pages/suppliers/index.php', keywords: ['supplier', 'purchase', 'payments', 'cheque'] },
        { title: 'Expenses', section: 'Expense Management', url: '/components/pages/expenses/index.php', keywords: ['expenses', 'cost', 'spending'] },
        { title: 'Vault & Balance', section: 'Accounts and Transactions', url: '/components/pages/vault-balance/index.php', keywords: ['vault', 'drawer', 'bank', 'balance'] },
        { title: 'Shops', section: 'Shop Management', url: '/components/pages/shops/index.php', keywords: ['shop', 'branches', 'store'] },
        { title: 'Returns & Repairs', section: 'Tickets', url: '/components/pages/returns-repairs/index.php', keywords: ['repair', 'return', 'ticket', 'service'] },
        { title: 'Invoices', section: 'Invoice History', url: '/components/pages/invoices-quotations/index.php', keywords: ['invoice', 'quotation', 'billing history'] },
        { title: 'Notifications', section: 'Top Header Bell', url: window.location.pathname || '/components/pages/index.php', keywords: ['notifications', 'alerts', 'mark as read'] },
        { title: 'Settings', section: 'Business / Invoice / Regional', url: '/components/pages/settings/index.php', keywords: ['settings', 'business info', 'invoice settings', 'regional'] },
        { title: 'Users', section: 'Users and Roles', url: '/components/pages/users/index.php', keywords: ['users', 'roles', 'permissions', 'auth'] },
        { title: 'My Profile', section: 'Profile & Password', url: '/components/pages/profile/index.php', keywords: ['profile', 'change password', 'account'] }
    ];

    function scoreResult(item, term) {
        const t = term.toLowerCase();
        const haystack = [item.title, item.section, (item.keywords || []).join(' ')].join(' ').toLowerCase();
        if (!haystack.includes(t)) {
            return -1;
        }

        let score = 0;
        if (item.title.toLowerCase().includes(t)) score += 5;
        if (item.section.toLowerCase().includes(t)) score += 3;
        if ((item.keywords || []).some((k) => k.toLowerCase().includes(t))) score += 2;
        if (item.title.toLowerCase().startsWith(t)) score += 2;
        return score;
    }

    function searchIndex(term) {
        return GLOBAL_SEARCH_INDEX
            .map((item) => ({ item, score: scoreResult(item, term) }))
            .filter((row) => row.score >= 0)
            .sort((a, b) => b.score - a.score)
            .slice(0, 8)
            .map((row) => row.item);
    }

    function getOverlayElements() {
        return {
            overlay: document.getElementById('searchOverlay'),
            input: document.getElementById('globalSearchModal'),
            trigger: document.getElementById('searchTrigger'),
        };
    }

    function createSuggestionContainer(input) {
        const container = document.createElement('div');
        container.id = 'globalSearchSuggestions';
        container.className = 'global-search-suggestions';
        input.insertAdjacentElement('afterend', container);
        return container;
    }

    function buildSearchUrl(baseUrl, searchText, section) {
        const url = new URL(baseUrl, window.location.origin);
        url.searchParams.set('global_search', searchText);
        url.searchParams.set('search_scope', section || '');
        return `${url.pathname}${url.search}`;
    }

    function renderSuggestions(container, items, searchText) {
        if (!items.length) {
            container.innerHTML = '';
            container.classList.remove('open');
            return;
        }

        container.innerHTML = items.map((item, index) => `
            <div class="global-search-item${index === 0 ? ' active' : ''}" data-url="${item.url}" data-title="${item.title}" data-section="${item.section}">
                <div class="global-search-title">${item.title}</div>
                <div class="global-search-meta">${item.section}</div>
            </div>
        `).join('');

        container.classList.add('open');

        container.querySelectorAll('.global-search-item').forEach((node) => {
            node.addEventListener('click', function () {
                const url = buildSearchUrl(this.getAttribute('data-url') || '/components/pages/index.php', searchText, this.getAttribute('data-section') || '');
                window.location.href = url;
            });
        });
    }

    function applySearchContext() {
        const params = new URLSearchParams(window.location.search || '');
        const searchText = params.get('global_search');
        if (!searchText) {
            return;
        }

        const knownInputs = ['searchUser', 'searchProduct', 'searchCustomer', 'searchSale', 'globalSearch'];
        knownInputs.forEach((id) => {
            const input = document.getElementById(id);
            if (input && !input.readOnly) {
                input.value = searchText;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        const root = document.querySelector('.content-area');
        if (!root) {
            return;
        }

        const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
            acceptNode(node) {
                const parent = node.parentElement;
                if (!parent) return NodeFilter.FILTER_REJECT;
                const tag = parent.tagName ? parent.tagName.toLowerCase() : '';
                if (['script', 'style', 'noscript'].includes(tag)) return NodeFilter.FILTER_REJECT;
                if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                return node.nodeValue.toLowerCase().includes(searchText.toLowerCase())
                    ? NodeFilter.FILTER_ACCEPT
                    : NodeFilter.FILTER_SKIP;
            }
        });

        const firstMatch = walker.nextNode();
        if (!firstMatch) {
            return;
        }

        const text = firstMatch.nodeValue;
        const index = text.toLowerCase().indexOf(searchText.toLowerCase());
        if (index < 0) {
            return;
        }

        const before = text.slice(0, index);
        const match = text.slice(index, index + searchText.length);
        const after = text.slice(index + searchText.length);

        const mark = document.createElement('mark');
        mark.className = 'global-search-highlight';
        mark.textContent = match;

        const fragment = document.createDocumentFragment();
        if (before) fragment.appendChild(document.createTextNode(before));
        fragment.appendChild(mark);
        if (after) fragment.appendChild(document.createTextNode(after));

        firstMatch.parentNode.replaceChild(fragment, firstMatch);
        mark.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function initGlobalSearch() {
        const { overlay, input, trigger } = getOverlayElements();
        if (!overlay || !input || !trigger) {
            applySearchContext();
            return;
        }

        const suggestions = createSuggestionContainer(input);

        trigger.addEventListener('click', function () {
            overlay.classList.add('active');
            input.focus();
        });

        input.addEventListener('input', function () {
            const value = this.value.trim();
            if (!value) {
                suggestions.classList.remove('open');
                suggestions.innerHTML = '';
                return;
            }

            const items = searchIndex(value);
            renderSuggestions(suggestions, items, value);
        });

        input.addEventListener('keydown', function (event) {
            const nodes = Array.from(suggestions.querySelectorAll('.global-search-item'));
            const active = suggestions.querySelector('.global-search-item.active');
            const activeIndex = nodes.indexOf(active);

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (!nodes.length) return;
                const next = nodes[(activeIndex + 1) % nodes.length];
                nodes.forEach((node) => node.classList.remove('active'));
                next.classList.add('active');
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (!nodes.length) return;
                const next = nodes[(activeIndex - 1 + nodes.length) % nodes.length];
                nodes.forEach((node) => node.classList.remove('active'));
                next.classList.add('active');
                return;
            }

            if (event.key === 'Enter') {
                const query = input.value.trim();
                if (!query) return;
                event.preventDefault();
                const selected = active || nodes[0];
                if (selected) {
                    const url = buildSearchUrl(selected.getAttribute('data-url') || '/components/pages/index.php', query, selected.getAttribute('data-section') || '');
                    window.location.href = url;
                }
            }
        });

        document.addEventListener('click', function (event) {
            if (!suggestions.contains(event.target) && event.target !== input) {
                suggestions.classList.remove('open');
            }
        });

        applySearchContext();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGlobalSearch);
    } else {
        initGlobalSearch();
    }
}());
</script>
