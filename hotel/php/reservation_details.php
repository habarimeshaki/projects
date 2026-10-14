<?php
require_once 'require_auth.php';
requireAuthentication();
include('connect.php');
$id = (int) ($_GET['id'] ?? 0);
$statement = $server->prepare("SELECT * FROM reservations WHERE id = ?");
$statement->bind_param("i", $id);
$statement->execute();
$result = $statement->get_result()->fetch_assoc();

echo json_encode($result);
$statement->close();
$server->close();
?>
