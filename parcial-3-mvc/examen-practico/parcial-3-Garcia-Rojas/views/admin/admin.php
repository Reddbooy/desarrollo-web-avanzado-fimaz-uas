<?php
require_once("../admin/template/header.php");
?>
<div class="mx-auto p-4">
  <div class="card text-center">
    <div class="card-header">
      Menú Principal
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col">
          <div class="card text-center">
            <div class="card-header">Crear Torneo</div>
            <div class="card-body">
              <a href="torneoForm.php" class="btn btn-primary">
                <img src="../img/torneo-admin.webp" alt="Crear torneo" width="180" height="180">
              </a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card text-center">
            <div class="card-header">Listado de Torneos</div>
            <div class="card-body">
              <a href="readAllTorneos.php" class="btn btn-primary">
                <img src="../img/lista-torneos-admin.webp" alt="Listar torneos" width="180" height="180">
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="card text-center">
            <div class="card-header">Estadísticas</div>
            <div class="card-body">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card text-center">
            <div class="card-header">Anuncios</div>
            <div class="card-body">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer text-body-secondary">
      Web App Basket-Ball
    </div>
  </div>
</div>
<?php
require_once("../admin/template/footer.php");
?>