<?php
require_once 'connect.php';
require_once 'require_auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: ../login.html?error=invalid');
    exit;
}

$statement = $server->prepare(
    'SELECT id, username, password, role FROM authorized_users WHERE username = ? LIMIT 1'
);
$statement->bind_param('s', $username);
$statement->execute();
$user = $statement->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    startSecureSession();
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    $statement->close();
    $server->close();
    header('Location: ../management.php');
    exit;
}

$statement->close();
$server->close();
header('Location: ../login.html?error=invalid');
exit;
?>
