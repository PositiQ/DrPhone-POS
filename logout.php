<?php
require_once __DIR__ . '/components/UI/auth.php';
pos_logout_user();
header('Location: /login.php');
exit;
