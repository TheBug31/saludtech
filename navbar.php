<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #0d6efd, #198754);">
  <div class="container">
    <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="pacientes_listar.php">
      <i class="bi bi-hospital me-2"></i> SaludTech
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold <?= basename($_SERVER['PHP_SELF'])=='pacientes_listar.php'?'active border-bottom border-2':'' ?>" href="pacientes_listar.php">
            <i class="bi bi-people-fill me-1"></i> Pacientes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold <?= basename($_SERVER['PHP_SELF'])=='vacunas_listar.php'?'active border-bottom border-2':'' ?>" href="vacunas_listar.php">
            <i class="bi bi-capsule-pill me-1"></i> Vacunas
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

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
