<?php
require_once 'require_auth.php';
requireAuthentication();
require_once 'connect.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid reservation ID.']);
    exit;
}

$statement = $server->prepare('UPDATE reservations SET receipt_accepted = 1 WHERE id = ?');
$statement->bind_param('i', $id);
$statement->execute();
$statement->close();
$server->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['accepted' => true]);
?>
