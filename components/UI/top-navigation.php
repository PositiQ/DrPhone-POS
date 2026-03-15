<?php
$resolvedPageTitle = isset($pageTitle) ? $pageTitle : 'Dashboard';
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
        color: #1a237e;
    }

    .notif-mark-all {
        font-size: 11px;
        color: #5c6bc0;
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

    .notif-item:hover { background: #f5f7ff; }

    .notif-item.unread {
        background: #eef0fb;
        border-left-color: #3f51b5;
    }

    .notif-item.unread:hover { background: #e3e6f7; }

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
        color: #3f51b5;
        text-decoration: none;
        font-weight: 500;
    }

    .notif-footer a:hover { text-decoration: underline; }

    .notif-dot {
        width: 7px;
        height: 7px;
        background: #3f51b5;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
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

        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=1a237e&color=ffd700&bold=true" alt="User">
            <div class="user-info">
                <h4>Admin User</h4>
                <p>Super Admin</p>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const NOTIFICATIONS_API = 'http://localhost:3000/api/notifications?limit=25';

    function toggleNotifDropdown() {
        const dropdown = document.getElementById('notifDropdown');
        if (!dropdown) return;
        dropdown.classList.toggle('open');
    }

    function markRead(item) {
        if (item.classList.contains('unread')) {
            item.classList.remove('unread');
            const dot = item.querySelector('.notif-dot');
            if (dot) dot.remove();
            updateBadge();
        }
    }

    function markAllRead() {
        document.querySelectorAll('#notifList .notif-item.unread').forEach(function (item) {
            item.classList.remove('unread');
            const dot = item.querySelector('.notif-dot');
            if (dot) dot.remove();
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
            list.innerHTML = `
                <div class="notif-item">
                    <div class="notif-body">
                        <p>No notifications right now.</p>
                        <span class="notif-time">System is up to date</span>
                    </div>
                </div>
            `;
            updateBadge();
            return;
        }

        list.innerHTML = items.map((n) => `
            <div class="notif-item unread" onclick="markRead(this)">
                <div class="notif-icon-wrap" style="background:${escapeHtml(n.iconBg || '#eef0fb')};">
                    <i class="fas ${escapeHtml(n.icon || 'fa-bell')}" style="color:${escapeHtml(n.iconColor || '#3f51b5')};"></i>
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
            const items = result.data?.notifications || [];
            renderNotifications(items);
        } catch (error) {
            renderLoadError(error.message);
            console.error('Notification load failed:', error);
        }
    }

    function updateBadge() {
        const count = document.querySelectorAll('#notifList .notif-item.unread').length;
        const badge = document.getElementById('notifBadge');
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
