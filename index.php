<?php
require_once __DIR__ . '/components/UI/auth.php';
pos_require_auth('dashboard');
header('Location: /components/pages/index.php');
exit;
?>
