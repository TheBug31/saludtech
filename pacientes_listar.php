<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pacientes</title>
</head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">👨‍⚕️ Gestión de Pacientes</h2>
    <a href="pacientes_crear.php" class="btn btn-success">
      <i class="bi bi-person-plus"></i> Nuevo Paciente
    </a>
  </div>
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
          <thead class="table-primary">
            <tr>
              <th>#</th><th>Nombre</th><th>Documento</th><th>Correo</th><th>Fecha Nac.</th><th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT * FROM pacientes";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td><span class='fw-semibold'>{$row['nombre']} {$row['apellido']}</span></td>
                      <td><span class='badge bg-secondary'>{$row['documento']}</span></td>
                      <td>{$row['correo']}</td>
                      <td>{$row['fecha_nacimiento']}</td>
                      <td class='text-center'>
                        <a href='pacientes_editar.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmDelete{$row['id']}'><i class='bi bi-trash'></i></button>
                      </td>
                    </tr>

                    <!-- Modal Confirmación -->
                    <div class='modal fade' id='confirmDelete{$row['id']}' tabindex='-1'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header bg-danger text-white'>
                            <h5 class='modal-title'><i class='bi bi-exclamation-triangle'></i> Confirmar eliminación</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                          </div>
                          <div class='modal-body'>
                            ¿Eliminar al paciente <strong>{$row['nombre']} {$row['apellido']}</strong>?
                          </div>
                          <div class='modal-footer'>
                            <a href='pacientes_eliminar.php?id={$row['id']}' class='btn btn-danger'>Eliminar</a>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>No hay pacientes registrados</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
