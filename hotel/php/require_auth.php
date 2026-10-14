<?php
function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function requireAuthentication(bool $redirectToLogin = false): void
{
    startSecureSession();

    if (!empty($_SESSION['user_id'])) {
        return;
    }

    if ($redirectToLogin) {
        header('Location: login.html');
    } else {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Authentication required.']);
    }
    exit;
}
?>
