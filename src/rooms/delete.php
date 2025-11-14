<?php
require_once __DIR__ . '/../controllers/RoomController.php';

$controller = new RoomController();
$controller->delete($_POST['room_id'] ?? 0);
?>