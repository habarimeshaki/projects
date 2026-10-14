<?php
require_once 'require_auth.php';
requireAuthentication();
include('connect.php');

$key = $_GET['key'] ?? '';
$search = "%{$key}%";
$statement = $server->prepare("SELECT * FROM reservations WHERE name LIKE ? OR CAST(id AS CHAR) LIKE ?");
$statement->bind_param("ss", $search, $search);
$statement->execute();
$query = $statement->get_result();
$store=[];
$i=0;
while($result=$query->fetch_assoc()){
$store[$i]=$result;
$i++;
}
echo json_encode($store);
$statement->close();
$server->close();
?>
