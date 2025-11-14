<?php
require_once __DIR__ . '/../controllers/RoomController.php';

$controller = new RoomController();
$controller->edit($_GET['id'] ?? 0);
?>