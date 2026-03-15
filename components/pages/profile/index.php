<?php
$activePage = 'profile';
$basePath = '../';
$pageTitle = 'My Profile';
$pageSubtitle = 'Manage your personal details and password.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth('profile');
$authToken = pos_get_token();
$currentUser = pos_get_current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="Manage your profile and password">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · My Profile</title>
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
                <div class="cards-row" style="grid-template-columns: repeat(2, minmax(280px, 1fr)); align-items: start;">
                    <div class="chart-card">
                        <div class="section-header" style="margin-bottom: 18px;">
                            <h3>Profile Details</h3>
                            <span class="view-all">Signed in user</span>
                        </div>
                        <form id="profileForm" style="display:grid; gap:14px;">
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Name</label>
                                <input id="profileName" type="text" class="search-input" value="<?php echo htmlspecialchars($currentUser['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="width:100%;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Email</label>
                                <input id="profileEmail" type="email" class="search-input" value="<?php echo htmlspecialchars($currentUser['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="width:100%;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Phone</label>
                                <input id="profilePhone" type="text" class="search-input" value="<?php echo htmlspecialchars($currentUser['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="width:100%;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Role</label>
                                <input type="text" class="search-input" value="<?php echo htmlspecialchars($currentUser['role']['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; background:#f5f7ff;" readonly>
                            </div>
                            <div>
                                <button class="button-primary" type="submit">
                                    <i class="fas fa-save"></i>
                                    Save Profile
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="chart-card">
                        <div class="section-header" style="margin-bottom: 18px;">
                            <h3>Change Password</h3>
                            <span class="view-all">Security</span>
                        </div>
                        <form id="passwordForm" style="display:grid; gap:14px;">
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Current Password</label>
                                <input id="currentPassword" type="password" class="search-input" style="width:100%;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">New Password</label>
                                <input id="newPassword" type="password" class="search-input" style="width:100%;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:6px; font-weight:600; color:#1f2a44;">Confirm New Password</label>
                                <input id="confirmPassword" type="password" class="search-input" style="width:100%;">
                            </div>
                            <div>
                                <button class="button-primary" type="submit">
                                    <i class="fas fa-key"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const AUTH_TOKEN = <?php echo json_encode($authToken, JSON_UNESCAPED_SLASHES); ?>;
        const AUTH_API = 'http://localhost:3000/api/auth';

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

        async function apiRequest(path, method, payload) {
            const response = await fetch(`${AUTH_API}${path}`, {
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

        async function syncSession(token, user) {
            await fetch('/auth-sync.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token, user }),
            });
        }

        document.getElementById('profileForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            try {
                const data = await apiRequest('/profile', 'PUT', {
                    name: document.getElementById('profileName').value.trim(),
                    email: document.getElementById('profileEmail').value.trim(),
                    phone: document.getElementById('profilePhone').value.trim(),
                });
                await syncSession(data.token, data.user);
                await Swal.fire({ icon: 'success', title: 'Saved', text: 'Your profile details have been updated.' });
                window.location.reload();
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Update failed', text: error.message });
            }
        });

        document.getElementById('passwordForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                Swal.fire({ icon: 'warning', title: 'Passwords do not match', text: 'Confirm the new password exactly.' });
                return;
            }

            try {
                const data = await apiRequest('/change-password', 'PUT', { currentPassword, newPassword });
                await syncSession(data.token, data.user);
                document.getElementById('passwordForm').reset();
                await Swal.fire({ icon: 'success', title: 'Password updated', text: 'Use the new password the next time you log in.' });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Update failed', text: error.message });
            }
        });
    </script>
</body>
</html>
