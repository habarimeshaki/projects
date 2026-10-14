<?php
require_once 'require_auth.php';
requireAuthentication();
include("connect.php");
$id = (int) ($_GET['id'] ?? 0);

$statement = $server->prepare("DELETE FROM reservations WHERE id = ?");
$statement->bind_param("i", $id);
$statement->execute();
$statement->close();
$server->close();

header("location: ../management.php")
?>
