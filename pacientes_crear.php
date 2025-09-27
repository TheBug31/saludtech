<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Paciente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card shadow-lg border-0 rounded-3 col-md-6 mx-auto">
    <div class="card-header bg-primary text-white fw-bold">
      <i class="bi bi-person-plus"></i> Registrar Paciente
    </div>
    <div class="card-body">
      <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required minlength="2" maxlength="50">
          <div class="invalid-feedback">El nombre es obligatorio (2-50 letras).</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input type="text" name="apellido" class="form-control" required minlength="2" maxlength="50">
          <div class="invalid-feedback">El apellido es obligatorio (2-50 letras).</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Documento</label>
          <input type="text" name="documento" class="form-control" required pattern="[0-9]{6,12}">
          <div class="invalid-feedback">Debe tener entre 6 y 12 dígitos numéricos.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" required>
          <div class="invalid-feedback">Ingrese un correo válido.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Fecha de Nacimiento</label>
          <input type="date" name="fecha_nacimiento" class="form-control" required>
          <div class="invalid-feedback">Seleccione una fecha válida.</div>
        </div>
        <div class="d-flex justify-content-between">
          <button class="btn btn-success" type="submit" name="guardar">
            <i class="bi bi-save"></i> Guardar
          </button>
          <a href="pacientes_listar.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
          </a>
        </div>
      </form>

      <?php
      if (isset($_POST['guardar'])) {
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

        
        $check = $conn->prepare("SELECT id FROM pacientes WHERE documento = ?");
        $check->bind_param("s", $documento);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows > 0) {
          $errores[] = "El documento ya está registrado.";
        }

        if (count($errores) > 0) {
          echo "<div class='alert alert-danger mt-3'><ul>";
          foreach ($errores as $e) echo "<li>$e</li>";
          echo "</ul></div>";
        } else {
          $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellido, documento, correo, fecha_nacimiento) VALUES (?,?,?,?,?)");
          $stmt->bind_param("sssss", $nombre, $apellido, $documento, $correo, $fecha);
          if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>✅ Paciente registrado con éxito</div>";
          } else {
            echo "<div class='alert alert-danger mt-3'>❌ Error en la BD: {$conn->error}</div>";
          }
        }
      }
      ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
</body>
</html>
