<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Vacunas</title>
</head>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">💉 Gestión de Vacunas</h2>
    <a href="vacunas_crear.php" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Nueva Vacuna
    </a>
  </div>
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
          <thead class="table-success">
            <tr>
              <th>#</th><th>Paciente</th><th>Vacuna</th><th>Dosis</th><th>Fecha</th><th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT v.id, v.nombre, v.dosis, v.fecha, p.nombre AS paciente, p.apellido 
                  FROM vacunas v
                  INNER JOIN pacientes p ON v.paciente_id = p.id";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['paciente']} {$row['apellido']}</td>
                      <td>{$row['nombre']}</td>
                      <td>{$row['dosis']}</td>
                      <td>{$row['fecha']}</td>
                      <td class='text-center'>
                        <a href='vacunas_editar.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmDelete{$row['id']}'><i class='bi bi-trash'></i></button>
                      </td>
                    </tr>

                    <!-- Modal -->
                    <div class='modal fade' id='confirmDelete{$row['id']}' tabindex='-1'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header bg-danger text-white'>
                            <h5 class='modal-title'>Confirmar eliminación</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                          </div>
                          <div class='modal-body'>
                            ¿Eliminar la vacuna <strong>{$row['nombre']}</strong> aplicada a <strong>{$row['paciente']} {$row['apellido']}</strong>?
                          </div>
                          <div class='modal-footer'>
                            <a href='vacunas_eliminar.php?id={$row['id']}' class='btn btn-danger'>Eliminar</a>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>No hay vacunas registradas</td></tr>";
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
