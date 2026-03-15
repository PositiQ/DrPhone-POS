<?php
$activePage = 'users';
$basePath = '../';
$pageTitle = 'Users';
$pageSubtitle = 'Add and manage system users.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
$authToken = pos_get_token();
$currentUser = pos_get_current_user();
$canManageUsers = pos_has_permission('users.manage');
$canManageRoles = pos_has_permission('roles.manage');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage system users">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Users</title>
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

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <input type="text" class="search-input" placeholder="Search users..." id="searchUser" style="width: 300px;">
                        <select class="filter-select" id="filterRole">
                            <option value="">All Roles</option>
                        </select>
                        <select class="filter-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="toolbar-actions" style="display:flex; gap:10px;">
                        <?php if ($canManageUsers): ?>
                            <button class="button-primary" type="button" id="addUserBtn">
                                <i class="fas fa-plus"></i>
                                Add User
                            </button>
                        <?php endif; ?>
                        <?php if ($canManageRoles): ?>
                            <button class="button-secondary" type="button" id="manageRolesBtn">
                                <i class="fas fa-user-cog"></i>
                                Manage Roles
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="cards-row">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Total Users</div>
                            <div class="metric-value" id="totalUsersValue">0</div>
                            <div class="metric-change">System accounts</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Active Users</div>
                            <div class="metric-value" id="activeUsersValue">0</div>
                            <div class="metric-change positive">Currently enabled</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Administrators</div>
                            <div class="metric-value" id="adminUsersValue">0</div>
                            <div class="metric-change">Full system access</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-content">
                            <div class="metric-label">Online Now</div>
                            <div class="metric-value" id="onlineUsersValue">0</div>
                            <div class="metric-change">Users with recent logins</div>
                        </div>
                    </div>
                </div>

                <div class="filter-pills" id="rolePills">
                    <button class="pill active" data-filter="all">All Users</button>
                </div>

                <div class="chart-card">
                    <table class="data-table" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 12%;">Phone</th>
                                <th style="width: 12%;">Role</th>
                                <th style="width: 12%;">Last Login</th>
                                <th style="width: 12%;">Created</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 7%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <tr>
                                <td colspan="8" style="text-align:center; color:#7a86ad;">Loading users...</td>
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

    <?php include __DIR__ . '/../../UI/custom-dialog.php'; ?>

    <script>
        const AUTH_TOKEN = <?php echo json_encode($authToken, JSON_UNESCAPED_SLASHES); ?>;
        const CURRENT_USER_ID = <?php echo json_encode($currentUser['user_id'] ?? '', JSON_UNESCAPED_SLASHES); ?>;
        const CAN_MANAGE_USERS = <?php echo $canManageUsers ? 'true' : 'false'; ?>;
        const CAN_MANAGE_ROLES = <?php echo $canManageRoles ? 'true' : 'false'; ?>;
        const USERS_API = 'http://localhost:3000/api/users';

        let users = [];
        let roles = [];
        let permissions = [];
        let activeRolePill = 'all';

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');

            if (window.innerWidth <= 768 && sidebar && menuToggle) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        const searchOverlay = document.getElementById('searchOverlay');
        const searchModalInput = document.getElementById('globalSearchModal');
        const searchTrigger = document.getElementById('searchTrigger');
        const searchClose = document.getElementById('searchClose');
        const searchInput = document.getElementById('searchUser');
        const roleFilter = document.getElementById('filterRole');
        const statusFilter = document.getElementById('filterStatus');
        const tableBody = document.getElementById('userTableBody');
        const rolePills = document.getElementById('rolePills');

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

        function formatDate(value) {
            if (!value) return '-';
            const date = new Date(value);
            if (Number.isNaN(date.getTime())) return '-';
            return date.toLocaleDateString();
        }

        function formatDateTime(value) {
            if (!value) return '-';
            const date = new Date(value);
            if (Number.isNaN(date.getTime())) return '-';
            return date.toLocaleString();
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        async function apiRequest(path = '', method = 'GET', payload) {
            const response = await fetch(`${USERS_API}${path}`, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${AUTH_TOKEN}`,
                },
                body: payload ? JSON.stringify(payload) : undefined,
            });
            const json = await response.json();
            if (!response.ok || !json.success) {
                throw new Error(json.message || 'Request failed');
            }
            return json.data;
        }

        function renderStats(stats) {
            document.getElementById('totalUsersValue').textContent = Number(stats.total || 0).toLocaleString();
            document.getElementById('activeUsersValue').textContent = Number(stats.active || 0).toLocaleString();
            document.getElementById('adminUsersValue').textContent = Number(stats.admins || 0).toLocaleString();
            document.getElementById('onlineUsersValue').textContent = Number(stats.online || 0).toLocaleString();
        }

        function renderRoleFilters() {
            roleFilter.innerHTML = '<option value="">All Roles</option>';
            const roleButtons = ['<button class="pill active" data-filter="all">All Users</button>'];

            roles.forEach((role) => {
                const slug = String(role.name || '').toLowerCase();
                roleFilter.insertAdjacentHTML('beforeend', `<option value="${escapeHtml(slug)}">${escapeHtml(role.name)}</option>`);
                roleButtons.push(`<button class="pill" data-filter="${escapeHtml(slug)}">${escapeHtml(role.name)}</button>`);
            });

            rolePills.innerHTML = roleButtons.join('');
            rolePills.querySelectorAll('.pill').forEach((pill) => {
                pill.addEventListener('click', function() {
                    rolePills.querySelectorAll('.pill').forEach((item) => item.classList.remove('active'));
                    this.classList.add('active');
                    activeRolePill = this.dataset.filter;
                    renderUsers();
                });
            });
        }

        function filteredUsers() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            const selectedRole = roleFilter.value.trim().toLowerCase();
            const selectedStatus = statusFilter.value.trim().toLowerCase();

            return users.filter((record) => {
                const text = [record.name, record.email, record.phone, record.role?.name, record.status].join(' ').toLowerCase();
                const roleName = String(record.role?.name || '').toLowerCase();
                const statusName = String(record.status || '').toLowerCase();
                const matchesSearch = !searchTerm || text.includes(searchTerm);
                const matchesRoleSelect = !selectedRole || roleName === selectedRole;
                const matchesRolePill = activeRolePill === 'all' || roleName === activeRolePill;
                const matchesStatus = !selectedStatus || statusName === selectedStatus;
                return matchesSearch && matchesRoleSelect && matchesRolePill && matchesStatus;
            });
        }

        function statusBadge(status) {
            const normalized = String(status || '').toLowerCase();
            if (normalized === 'active') {
                return '<span class="status-badge" style="background:#e8f5e9; color:#2e7d32;">Active</span>';
            }
            return '<span class="status-badge" style="background:#f5f5f5; color:#616161;">Inactive</span>';
        }

        function roleBadge(roleName) {
            const normalized = String(roleName || '').toLowerCase();
            if (normalized === 'admin') return '<span class="status-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Admin</span>';
            if (normalized === 'manager') return '<span class="status-badge" style="background: #e3f2fd; color: #1976d2;">Manager</span>';
            if (normalized === 'cashier') return '<span class="status-badge" style="background: #f3e5f5; color: #7b1fa2;">Cashier</span>';
            return `<span class="status-badge" style="background:#fff3e0; color:#ef6c00;">${escapeHtml(roleName || 'Role')}</span>`;
        }

        function initials(name) {
            return String(name || 'U')
                .split(/\s+/)
                .filter(Boolean)
                .slice(0, 2)
                .map((part) => part[0].toUpperCase())
                .join('') || 'U';
        }

        function renderUsers() {
            const rows = filteredUsers();
            if (!rows.length) {
                tableBody.innerHTML = '<tr><td colspan="8" style="text-align:center; color:#7a86ad;">No users found.</td></tr>';
                return;
            }

            tableBody.innerHTML = rows.map((record) => `
                <tr data-role="${escapeHtml(String(record.role?.name || '').toLowerCase())}" data-status="${escapeHtml(String(record.status || '').toLowerCase())}">
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); display:flex; align-items:center; justify-content:center; color:white; font-weight:600;">
                                ${escapeHtml(initials(record.name))}
                            </div>
                            <strong>${escapeHtml(record.name)}</strong>
                        </div>
                    </td>
                    <td>${escapeHtml(record.email)}</td>
                    <td>${escapeHtml(record.phone || 'N/A')}</td>
                    <td>${roleBadge(record.role?.name)}</td>
                    <td>${escapeHtml(formatDateTime(record.last_login_at))}</td>
                    <td>${escapeHtml(formatDate(record.createdAt))}</td>
                    <td>${statusBadge(record.status)}</td>
                    <td>
                        ${CAN_MANAGE_USERS ? `<button class="icon-btn" title="Edit User" onclick="openUserDialog('${escapeHtml(record.user_id)}')"><i class="fas fa-pen"></i></button>` : ''}
                    </td>
                </tr>
            `).join('');
        }

        function syncProfileSession(token, user) {
            return fetch('/auth-sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token, user }),
            });
        }

        async function loadData() {
            try {
                const [userResponse, roleResponse, permissionResponse] = await Promise.all([
                    apiRequest('', 'GET'),
                    apiRequest('/roles', 'GET'),
                    CAN_MANAGE_ROLES ? apiRequest('/permissions', 'GET') : Promise.resolve([]),
                ]);

                users = userResponse.users || [];
                roles = roleResponse || [];
                permissions = permissionResponse || [];
                renderStats(userResponse.stats || {});
                renderRoleFilters();
                renderUsers();
            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="8" style="text-align:center; color:#c62828;">${escapeHtml(error.message)}</td></tr>`;
            }
        }

        function userFormHtml(record) {
            const roleOptions = roles.map((role) => {
                const selected = record && record.role?.role_id === role.role_id ? 'selected' : '';
                return `<option value="${escapeHtml(role.role_id)}" ${selected}>${escapeHtml(role.name)}</option>`;
            }).join('');

            return `
                <form id="userForm" style="display:grid; gap:14px;">
                    <input type="hidden" id="userId" value="${escapeHtml(record?.user_id || '')}">
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Name</label>
                        <input id="userName" class="search-input" style="width:100%;" value="${escapeHtml(record?.name || '')}" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Email</label>
                        <input id="userEmail" type="email" class="search-input" style="width:100%;" value="${escapeHtml(record?.email || '')}" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Phone</label>
                        <input id="userPhone" class="search-input" style="width:100%;" value="${escapeHtml(record?.phone || '')}">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Role</label>
                        <select id="userRoleId" class="filter-select" style="width:100%;">${roleOptions}</select>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Status</label>
                        <select id="userStatus" class="filter-select" style="width:100%;">
                            <option value="active" ${record?.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${record?.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">${record ? 'New Password (optional)' : 'Password'}</label>
                        <input id="userPassword" type="password" class="search-input" style="width:100%;" ${record ? '' : 'required'}>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                        <button type="button" class="button-secondary" onclick="AppDialog.close()">Cancel</button>
                        <button type="submit" class="button-primary">${record ? 'Save Changes' : 'Create User'}</button>
                    </div>
                </form>
            `;
        }

        async function openUserDialog(userId = '') {
            const record = users.find((item) => item.user_id === userId) || null;
            AppDialog.open({
                title: record ? 'Edit User' : 'Create User',
                html: userFormHtml(record),
                width: '560px',
            });

            document.getElementById('userForm').addEventListener('submit', async function(event) {
                event.preventDefault();
                const payload = {
                    name: document.getElementById('userName').value.trim(),
                    email: document.getElementById('userEmail').value.trim(),
                    phone: document.getElementById('userPhone').value.trim(),
                    role_id: document.getElementById('userRoleId').value,
                    status: document.getElementById('userStatus').value,
                    password: document.getElementById('userPassword').value,
                };

                try {
                    const data = record
                        ? await apiRequest(`/${record.user_id}`, 'PUT', payload)
                        : await apiRequest('', 'POST', payload);

                    if (data.user_id === CURRENT_USER_ID) {
                        await syncProfileSession(AUTH_TOKEN, data);
                    }

                    AppDialog.close();
                    await loadData();
                    Swal.fire({ icon: 'success', title: record ? 'User updated' : 'User created', text: record ? 'User details were saved successfully.' : 'New user has been created successfully.' });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Action failed', text: error.message });
                }
            });
        }

        function roleFormHtml(record) {
            const selectedPermissions = new Set(record?.permissions || []);
            const permissionHtml = permissions.map((permission) => `
                <label style="display:flex; align-items:center; gap:8px; padding:6px 0; font-size:13px;">
                    <input type="checkbox" class="role-permission" value="${escapeHtml(permission)}" ${selectedPermissions.has(permission) ? 'checked' : ''}>
                    <span>${escapeHtml(permission)}</span>
                </label>
            `).join('');

            return `
                <form id="roleForm" style="display:grid; gap:14px;">
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Role Name</label>
                        <input id="roleName" class="search-input" style="width:100%;" value="${escapeHtml(record?.name || '')}" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Description</label>
                        <textarea id="roleDescription" class="search-input" style="width:100%; min-height:90px;">${escapeHtml(record?.description || '')}</textarea>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; font-weight:600;">Permissions</label>
                        <div style="max-height:260px; overflow:auto; border:1px solid #d8deef; border-radius:10px; padding:12px;">${permissionHtml}</div>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                        <button type="button" class="button-secondary" onclick="AppDialog.close()">Close</button>
                        <button type="submit" class="button-primary">${record ? 'Save Role' : 'Create Role'}</button>
                    </div>
                </form>
            `;
        }

        function openRoleManager() {
            const roleCards = roles.map((role) => `
                <div style="border:1px solid #e6ebf5; border-radius:12px; padding:14px; margin-bottom:10px;">
                    <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start;">
                        <div>
                            <div style="font-weight:700; color:#1a237e;">${escapeHtml(role.name)}</div>
                            <div style="font-size:12px; color:#667085; margin-top:4px;">${escapeHtml(role.description || 'No description')}</div>
                        </div>
                        <button type="button" class="button-secondary" onclick="openRoleDialog('${escapeHtml(role.role_id)}')">Edit</button>
                    </div>
                </div>
            `).join('');

            AppDialog.open({
                title: 'Manage Roles',
                width: '760px',
                html: `
                    <div style="display:flex; justify-content:flex-end; margin-bottom:12px;">
                        <button type="button" class="button-primary" onclick="openRoleDialog()"><i class="fas fa-plus"></i> Create Role</button>
                    </div>
                    <div>${roleCards || '<div style="color:#667085;">No roles available.</div>'}</div>
                `,
            });
        }

        function openRoleDialog(roleId = '') {
            const record = roles.find((item) => item.role_id === roleId) || null;
            AppDialog.open({
                title: record ? 'Edit Role' : 'Create Role',
                html: roleFormHtml(record),
                width: '760px',
            });

            document.getElementById('roleForm').addEventListener('submit', async function(event) {
                event.preventDefault();
                const payload = {
                    name: document.getElementById('roleName').value.trim(),
                    description: document.getElementById('roleDescription').value.trim(),
                    permissions: Array.from(document.querySelectorAll('.role-permission:checked')).map((item) => item.value),
                };

                try {
                    if (record) {
                        await apiRequest(`/roles/${record.role_id}`, 'PUT', payload);
                    } else {
                        await apiRequest('/roles', 'POST', payload);
                    }
                    await loadData();
                    openRoleManager();
                    Swal.fire({ icon: 'success', title: record ? 'Role updated' : 'Role created', text: 'Role permissions were saved successfully.' });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Action failed', text: error.message });
                }
            });
        }

        if (searchInput) searchInput.addEventListener('input', renderUsers);
        if (roleFilter) roleFilter.addEventListener('change', renderUsers);
        if (statusFilter) statusFilter.addEventListener('change', renderUsers);
        if (document.getElementById('addUserBtn')) document.getElementById('addUserBtn').addEventListener('click', () => openUserDialog());
        if (document.getElementById('manageRolesBtn')) document.getElementById('manageRolesBtn').addEventListener('click', openRoleManager);

        loadData();
        window.openUserDialog = openUserDialog;
        window.openRoleDialog = openRoleDialog;
        window.openRoleManager = openRoleManager;
    </script>
</body>
</html>
