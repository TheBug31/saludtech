<?php 
include("conexion.php");
$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$paciente = $stmt->get_result()->fetch_assoc();

if (isset($_POST['actualizar'])) {
    $nombre    = trim($_POST['nombre']);
    $apellido  = trim($_POST['apellido']);
    $documento = trim($_POST['documento']);
    $correo    = trim($_POST['correo']);
    $fecha     = $_POST['fecha_nacimiento'];

    $errores = [];

    
    if ($nombre == "" || strlen($nombre) < 2) $errores[] = "El nombre es inválido.";
    if ($apellido == "" || strlen($apellido) < 2) $errores[] = "El apellido es inválido.";
    if (!preg_match("/^[0-9]{6,12}$/", $documento)) $errores[] = "El documento debe tener entre 6 y 12 dígitos.";
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo no es válido.";
    if ($fecha == "") $errores[] = "Debe ingresar la fecha de nacimiento.";

    
    $check = $conn->prepare("SELECT id FROM pacientes WHERE documento = ? AND id != ?");
    $check->bind_param("si", $documento, $id);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        $errores[] = "El documento ya está registrado por otro paciente.";
    }

    if (count($errores) > 0) {
        echo "<div class='alert alert-danger mt-3'><ul>";
        foreach ($errores as $e) echo "<li>$e</li>";
        echo "</ul></div>";
    } else {
        $stmt = $conn->prepare("UPDATE pacientes SET nombre=?, apellido=?, documento=?, correo=?, fecha_nacimiento=? WHERE id=?");
        $stmt->bind_param("sssssi", $nombre, $apellido, $documento, $correo, $fecha, $id);
        if ($stmt->execute()) {
            header("Location: pacientes_listar.php");
            exit;
        } else {
            echo "<div class='alert alert-danger mt-3'>❌ Error: {$conn->error}</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Editar Paciente</title></head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card shadow-lg border-0 rounded-3 col-md-6 mx-auto">
    <div class="card-header bg-warning fw-bold"><i class="bi bi-pencil-square"></i> Editar Paciente</div>
    <div class="card-body">
      <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3"><label>Nombre</label>
          <input type="text" name="nombre" value="<?= $paciente['nombre'] ?>" class="form-control" required minlength="2">
          <div class="invalid-feedback">Mínimo 2 letras.</div>
        </div>
        <div class="mb-3"><label>Apellido</label>
          <input type="text" name="apellido" value="<?= $paciente['apellido'] ?>" class="form-control" required minlength="2">
        </div>
        <div class="mb-3"><label>Documento</label>
          <input type="text" name="documento" value="<?= $paciente['documento'] ?>" class="form-control" required pattern="[0-9]{6,12}">
          <div class="invalid-feedback">6 a 12 dígitos.</div>
        </div>
        <div class="mb-3"><label>Correo</label>
          <input type="email" name="correo" value="<?= $paciente['correo'] ?>" class="form-control" required>
        </div>
        <div class="mb-3"><label>Fecha Nacimiento</label>
          <input type="date" name="fecha_nacimiento" value="<?= $paciente['fecha_nacimiento'] ?>" class="form-control" required>
        </div>
        <button type="submit" name="actualizar" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
        <a href="pacientes_listar.php" class="btn btn-secondary">⬅️ Volver</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
