<?php
include("conexion.php");
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM vacunas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: vacunas_listar.php");
exit;
?>
