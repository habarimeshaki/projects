
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
include("connect.php");
if ($server->connect_error) {
    die("Connection failed: " . $server->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$room_type = $_POST['room_type'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$guest = $_POST['guest'];
$request = $_POST['request'];
$nights = (int) ($_POST['nights'] ?? 0);

if ($nights < 1) {
    die("Please select a valid number of nights.");
}

if ($nights <= 2) {
    $price_per_night = 120;
} elseif ($nights <= 6) {
    $price_per_night = 100;
} else {
    $price_per_night = 80;
}

$guest_multiplier = 1 + (max((int) $guest, 1) - 1) * 0.5;
$total_price = $nights * $price_per_night * $guest_multiplier;

$st = $server->prepare("INSERT INTO reservations (name,email,phone,room_type,check_in,check_out,guest,request,nights,total_price) VALUES (?,?,?,?,?,?,?,?,?,?)");

if (!$st) {
    die("Prepare failed: " . $server->error);
}

$st->bind_param("ssssssisid", $name, $email, $phone, $room_type, $check_in, $check_out, $guest, $request, $nights, $total_price);

if (!$st->execute()) {
    die("Execute failed: " . $st->error);
}

echo "Reservation saved successfully!";
echo "<br>Your estimated total is $" . number_format($total_price, 2) . ".";
echo "Wait for being contacted once your reservation is confirmed. <a href='../'>Back Home</a>"
?>
</main>
</body>
</html>
