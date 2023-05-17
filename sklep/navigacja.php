<?php
spl_autoload_register(function ($class) {
    include '../panel/classes/' . $class . '.class.php';
});
$db = new Database();
$produkty = new Produkty();
$conn = $db->connect();
$token = session_id();
?>
