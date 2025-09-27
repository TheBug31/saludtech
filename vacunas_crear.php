<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Nueva Vacuna</title></head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card shadow-lg border-0 rounded-3 col-md-6 mx-auto">
    <div class="card-header bg-success text-white fw-bold"><i class="bi bi-plus-circle"></i> Registrar Vacuna</div>
    <div class="card-body">
      <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label class="form-label">Paciente</label>
          <select name="paciente_id" class="form-select" required>
            <option value="">Seleccione un paciente</option>
            <?php
            $pacientes = $conn->query("SELECT id, nombre, apellido FROM pacientes ORDER BY nombre");
            while ($p = $pacientes->fetch_assoc()) {
              echo "<option value='{$p['id']}'>{$p['nombre']} {$p['apellido']}</option>";
            }
            ?>
          </select>
          <div class="invalid-feedback">Debe seleccionar un paciente.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Nombre de la Vacuna</label>
          <input type="text" name="nombre" class="form-control" required minlength="2">
          <div class="invalid-feedback">Ingrese el nombre de la vacuna.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Dosis</label>
          <input type="text" name="dosis" class="form-control" required>
          <div class="invalid-feedback">Ingrese la dosis aplicada.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Fecha</label>
          <input type="date" name="fecha" class="form-control" required>
          <div class="invalid-feedback">Seleccione una fecha válida.</div>
        </div>
        <button class="btn btn-success" type="submit" name="guardar"><i class="bi bi-save"></i> Guardar</button>
        <a href="vacunas_listar.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
      </form>

      <?php
      if (isset($_POST['guardar'])) {
        $paciente_id = $_POST['paciente_id'];
        $nombre = trim($_POST['nombre']);
        $dosis = trim($_POST['dosis']);
        $fecha = $_POST['fecha'];

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
          $stmt = $conn->prepare("INSERT INTO vacunas (paciente_id, nombre, dosis, fecha) VALUES (?,?,?,?)");
          $stmt->bind_param("isss", $paciente_id, $nombre, $dosis, $fecha);
          if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>✅ Vacuna registrada con éxito</div>";
          } else {
            echo "<div class='alert alert-danger mt-3'>❌ Error: {$conn->error}</div>";
          }
        }
      }
      ?>
    </div>
  </div>
</div>
</body>
</html>
