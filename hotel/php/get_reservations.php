<?php
require_once 'require_auth.php';
requireAuthentication();
include('connect.php');

$query=$server->query("SELECT * FROM reservations WHERE 1");
$store=[];
$i=0;
while($result=$query->fetch_assoc()){
$store[$i]=$result;
$i++;
}
echo json_encode($store);
$server->close();
?>
