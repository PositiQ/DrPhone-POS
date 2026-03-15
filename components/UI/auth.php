<?php
if (defined('POSITIQ_AUTH_BOOTSTRAPPED')) {
    return;
}
define('POSITIQ_AUTH_BOOTSTRAPPED', true);

const POSITIQ_API_BASE = 'http://localhost:3000/api';
const POSITIQ_SESSION_NAME = 'positiq_session';
const POSITIQ_REMEMBER_COOKIE = 'positiq_remember_token';
const POSITIQ_SESSION_TTL = 2592000;
const POSITIQ_REMEMBER_TTL = 31536000;

function pos_permission_map() {
    return [
        'dashboard' => 'dashboard.view',
        'sales' => 'sales.view',
        'inventory' => 'inventory.view',
        'products' => 'products.view',
        'customers' => 'customers.view',
        'invoices-quotations' => 'invoices.view',
        'vault-balance' => 'vault.view',
        'expenses' => 'expenses.view',
        'suppliers' => 'suppliers.view',
        'shops' => 'shops.view',
        'returns-repairs' => 'returns_repairs.view',
        'settings' => 'settings.view',
        'users' => 'users.view',
        'profile' => 'profile.manage',
    ];
}

function pos_boot_auth() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_name(POSITIQ_SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => POSITIQ_SESSION_TTL,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);

    session_start();

    if (empty($_SESSION['auth']) && !empty($_COOKIE[POSITIQ_REMEMBER_COOKIE])) {
        pos_restore_session_from_remember_token($_COOKIE[POSITIQ_REMEMBER_COOKIE]);
    }
}

function pos_api_request($method, $path, $payload = null, $jwt = '') {
    $url = rtrim(POSITIQ_API_BASE, '/') . '/' . ltrim($path, '/');
    $headers = ['Accept: application/json'];

    if ($payload !== null) {
        $headers[] = 'Content-Type: application/json';
        $body = json_encode($payload);
    } else {
        $body = null;
    }

    if ($jwt) {
        $headers[] = 'Authorization: Bearer ' . $jwt;
    }

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $error) {
            return ['ok' => false, 'status' => 0, 'data' => null, 'message' => $error ?: 'API request failed.'];
        }
    } else {
        $context = stream_context_create([
            'http' => [
                'method' => strtoupper($method),
                'header' => implode("\r\n", $headers),
                'content' => $body !== null ? $body : '',
                'ignore_errors' => true,
                'timeout' => 20,
            ],
        ]);

        $raw = @file_get_contents($url, false, $context);
        $status = 0;
        if (!empty($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
            $status = (int) $matches[1];
        }

        if ($raw === false) {
            return ['ok' => false, 'status' => $status, 'data' => null, 'message' => 'API request failed.'];
        }
    }

    $decoded = json_decode($raw, true);
    $message = is_array($decoded) && !empty($decoded['message']) ? $decoded['message'] : '';

    return [
        'ok' => $status >= 200 && $status < 300,
        'status' => $status,
        'data' => $decoded,
        'message' => $message,
    ];
}

function pos_set_remember_cookie($token, $expiresAt = null) {
    $expiry = time() + POSITIQ_REMEMBER_TTL;
    if ($expiresAt) {
        $timestamp = strtotime((string) $expiresAt);
        if ($timestamp) {
            $expiry = $timestamp;
        }
    }

    setcookie(POSITIQ_REMEMBER_COOKIE, $token, [
        'expires' => $expiry,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    $_COOKIE[POSITIQ_REMEMBER_COOKIE] = $token;
}

function pos_clear_remember_cookie() {
    setcookie(POSITIQ_REMEMBER_COOKIE, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    unset($_COOKIE[POSITIQ_REMEMBER_COOKIE]);
}

function pos_store_auth_session(array $payload) {
    $_SESSION['auth'] = [
        'token' => $payload['token'] ?? '',
        'user' => $payload['user'] ?? null,
        'logged_in_at' => time(),
    ];
}

function pos_clear_auth_session() {
    unset($_SESSION['auth']);
}

function pos_restore_session_from_remember_token($rememberToken) {
    $response = pos_api_request('POST', '/auth/remember', ['rememberToken' => $rememberToken]);
    if (!$response['ok'] || empty($response['data']['success']) || empty($response['data']['data'])) {
        pos_clear_remember_cookie();
        pos_clear_auth_session();
        return false;
    }

    pos_store_auth_session($response['data']['data']);
    pos_set_remember_cookie($rememberToken, $response['data']['data']['rememberTokenExpiresAt'] ?? null);
    return true;
}

function pos_get_current_user() {
    return $_SESSION['auth']['user'] ?? null;
}

function pos_get_token() {
    return $_SESSION['auth']['token'] ?? '';
}

function pos_get_page_permission($pageKey) {
    $map = pos_permission_map();
    return $map[$pageKey] ?? '';
}

function pos_has_permission($permission) {
    $user = pos_get_current_user();
    if (!$user) {
        return false;
    }

    if (!$permission) {
        return true;
    }

    $permissions = $user['permissions'] ?? [];
    return in_array('*', $permissions, true) || in_array($permission, $permissions, true);
}

function pos_require_auth($pageKey = null) {
    pos_boot_auth();

    if (empty($_SESSION['auth']['user'])) {
        header('Location: /login.php');
        exit;
    }

    $requiredPermission = $pageKey ? pos_get_page_permission($pageKey) : '';
    if ($requiredPermission && !pos_has_permission($requiredPermission)) {
        header('Location: /components/pages/index.php');
        exit;
    }
}

function pos_redirect_if_authenticated() {
    pos_boot_auth();
    if (!empty($_SESSION['auth']['user'])) {
        header('Location: /components/pages/index.php');
        exit;
    }
}

function pos_logout_user() {
    pos_boot_auth();
    $token = pos_get_token();
    if ($token) {
        pos_api_request('POST', '/auth/logout', [], $token);
    }
    pos_clear_auth_session();
    pos_clear_remember_cookie();
}

function pos_user_display_name() {
    $user = pos_get_current_user();
    return $user['name'] ?? 'Guest';
}

function pos_user_role_name() {
    $user = pos_get_current_user();
    return $user['role']['name'] ?? 'User';
}

function pos_user_initials() {
    $name = trim((string) pos_user_display_name());
    if ($name === '') {
        return 'U';
    }

    $parts = preg_split('/\s+/', $name);
    $initials = '';
    foreach ($parts as $part) {
        if ($part !== '') {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        if (strlen($initials) >= 2) {
            break;
        }
    }

    return $initials ?: 'U';
}

pos_boot_auth();
