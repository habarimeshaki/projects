
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<link rel="stylesheet" href="../style.css">
</head>
<body>
<header></header>
<main>
<?php
require_once 'require_auth.php';
requireAuthentication();
include("connect.php");
if ($server->connect_error) {
    die("Connection failed: " . $server->connect_error);
}

$id = (int) ($_POST['id'] ?? 0);
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$room_type = $_POST['room_type'] ?? '';
$check_in = $_POST['check_in'] ?? '';
$check_out = $_POST['check_out'] ?? '';
$guest = (int) ($_POST['guest'] ?? 0);
$request = $_POST['request'] ?? '';

$nights_statement = $server->prepare("SELECT nights FROM reservations WHERE id = ?");
$nights_statement->bind_param("i", $id);
$nights_statement->execute();
$reservation = $nights_statement->get_result()->fetch_assoc();
$nights_statement->close();

$nights = (int) ($reservation['nights'] ?? 0);
if ($nights <= 2) {
    $price_per_night = 120;
} elseif ($nights <= 6) {
    $price_per_night = 100;
} else {
    $price_per_night = 80;
}

$guest_multiplier = 1 + (max($guest, 1) - 1) * 0.5;
$total_price = $nights * $price_per_night * $guest_multiplier;

$st = $server->prepare("UPDATE reservations SET name=?, email=?, phone=?, room_type=?, check_in=?, check_out=?, guest=?, request=?, total_price=? WHERE id=?");

if (!$st) {
    die("Prepare failed: " . $server->error);
}

$st->bind_param("ssssssisdi", $name, $email, $phone, $room_type, $check_in, $check_out, $guest, $request, $total_price, $id);

if (!$st->execute()) {
    die("Execute failed: " . $st->error);
}

header("location: ../management.php");
?>
</main>
</body>
</html>
