<?php include("conexion.php");
$id = $_GET['id'];
$conn->query("DELETE FROM pacientes WHERE id=$id");
header("Location: pacientes_listar.php");
?>
