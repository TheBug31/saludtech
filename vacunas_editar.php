<?php 
include("conexion.php");
$id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM vacunas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$vacuna = $stmt->get_result()->fetch_assoc();

if (isset($_POST['actualizar'])) {
    $paciente_id = $_POST['paciente_id'];
    $nombre      = trim($_POST['nombre']);
    $dosis       = trim($_POST['dosis']);
    $fecha       = $_POST['fecha'];

    $errores = [];

    if ($paciente_id == "") $errores[] = "Debe seleccionar un paciente.";
    if ($nombre == "" || strlen($nombre) < 2) $errores[] = "El nombre de la vacuna es inválido.";
    if ($dosis == "") $errores[] = "La dosis es obligatoria.";
    if ($fecha == "") $errores[] = "Debe ingresar una fecha.";

    if (count($errores) > 0) {
        echo "<div class='alert alert-danger mt-3'><ul>";
        foreach ($errores as $e) echo "<li>$e</li>";
        echo "</ul></div>";
    } else {
        $stmt = $conn->prepare("UPDATE vacunas SET paciente_id=?, nombre=?, dosis=?, fecha=? WHERE id=?");
        $stmt->bind_param("isssi", $paciente_id, $nombre, $dosis, $fecha, $id);
        if ($stmt->execute()) {
            header("Location: vacunas_listar.php");
            exit;
        } else {
            echo "<div class='alert alert-danger mt-3'>❌ Error: {$conn->error}</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Editar Vacuna</title></head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card shadow-lg border-0 rounded-3 col-md-6 mx-auto">
    <div class="card-header bg-warning fw-bold"><i class="bi bi-pencil-square"></i> Editar Vacuna</div>
    <div class="card-body">
      <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label class="form-label">Paciente</label>
          <select name="paciente_id" class="form-select" required>
            <option value="">Seleccione un paciente</option>
            <?php
            $pacientes = $conn->query("SELECT id, nombre, apellido FROM pacientes ORDER BY nombre");
            while ($p = $pacientes->fetch_assoc()) {
              $sel = ($p['id'] == $vacuna['paciente_id']) ? "selected" : "";
              echo "<option value='{$p['id']}' $sel>{$p['nombre']} {$p['apellido']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Nombre de la Vacuna</label>
          <input type="text" name="nombre" value="<?= $vacuna['nombre'] ?>" class="form-control" required minlength="2">
        </div>
        <div class="mb-3">
          <label class="form-label">Dosis</label>
          <input type="text" name="dosis" value="<?= $vacuna['dosis'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Fecha</label>
          <input type="date" name="fecha" value="<?= $vacuna['fecha'] ?>" class="form-control" required>
        </div>
        <button type="submit" name="actualizar" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
        <a href="vacunas_listar.php" class="btn btn-secondary">⬅️ Volver</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
