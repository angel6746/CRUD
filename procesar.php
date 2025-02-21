<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $edad = $_POST['edad'] ?? '';
    
    $db = Database::connect();
    
    if ($accion === 'crear') {
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, edad) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $edad]);
    } elseif ($accion === 'actualizar' && $id) {
        $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, edad = ? WHERE id = ?");
        $stmt->execute([$nombre, $email, $edad, $id]);
    }
    
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $db = Database::connect();
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    
    header('Location: index.php');
    exit;
}
?>
