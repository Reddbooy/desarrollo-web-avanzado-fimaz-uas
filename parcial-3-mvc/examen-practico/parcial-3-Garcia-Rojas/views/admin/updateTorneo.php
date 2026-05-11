<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");
require_once(__DIR__ . "/../admin/template/header.php");

$ctrl = new TorneosCtrl();
$torneo = $ctrl->readOneTorneo($_GET['id']);
?>

<div class="mx-auto p-4">
  <div class="card">
    <div class="card-header text-center">
      Datos del Torneo
    </div>

    <div class="card-body">
      <form action="torneosUpdate.php" method="post">
        <input type="hidden" name="txtId" value="<?php echo $torneo['id']; ?>">

        <div class="mb-3">
          <label for="torneo" class="form-label">Nombre del Torneo</label>
          <input type="text" name="txtTorneo" id="torneo" class="form-control" value="<?php echo $torneo['nombreTorneo']; ?>">
        </div>

        <div class="mb-3">
          <label for="organizador" class="form-label">Organizador</label>
          <input type="text" name="txtOrganizador" id="organizador" class="form-control" value="<?php echo $torneo['organizador']; ?>">
        </div>

        <div class="mb-3">
          <label for="patrocinio" class="form-label">Patrocinadores</label>
          <textarea name="txtPatrocinio" id="patrocinio" cols="30" rows="3" class="form-control"><?php echo $torneo['patrocinadores']; ?></textarea>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="lugar" class="form-label">Sede</label>
            <input type="text" name="txtLugar" id="lugar" class="form-control" value="<?php echo $torneo['sede']; ?>">
          </div>
          <div class="col mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input list="categorias" name="txtCategoria" id="categoria" class="form-control" value="<?php echo $torneo['categoria']; ?>">
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio1" class="form-label">Premio 1er Lugar</label>
            <input type="text" name="txtPremio1" id="premio1" class="form-control" value="<?php echo $torneo['premio1']; ?>">
          </div>
          <div class="col mb-3">
            <label for="premio2" class="form-label">Premio 2do Lugar</label>
            <input type="text" name="txtPremio2" id="premio2" class="form-control" value="<?php echo $torneo['premio2']; ?>">
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio3" class="form-label">Premio 3er Lugar</label>
            <input type="text" name="txtPremio3" id="premio3" class="form-control" value="<?php echo $torneo['premio3']; ?>">
          </div>
          <div class="col mb-3">
            <label for="extra" class="form-label">Otro Premio</label>
            <input type="text" name="txtExtra" id="extra" class="form-control" value="<?php echo $torneo['otroPremio']; ?>">
          </div>
        </div>

        <div class="mb-3 text-center">
          <button type="submit" class="btn btn-success">Actualizar</button>
          <a href="readAllTorneos.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>

    <div class="card-footer text-center text-body-secondary">
      Formulario de Actualización
    </div>
  </div>
</div>

<?php
require_once(__DIR__ . "/../admin/template/footer.php");
?>