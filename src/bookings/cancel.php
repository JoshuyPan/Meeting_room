<?php
require_once __DIR__ . '/../controllers/BookingController.php';

$controller = new BookingController();
$controller->cancel($_POST['booking_id'] ?? 0);
?>