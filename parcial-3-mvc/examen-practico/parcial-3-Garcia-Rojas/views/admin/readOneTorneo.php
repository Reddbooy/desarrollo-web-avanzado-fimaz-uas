<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");
require_once(__DIR__ . "/../admin/template/header.php");

$ctrlTorneos = new TorneosCtrl();
$torneo = $ctrlTorneos->readOneTorneo($_GET['id']);
?>

<div class="mx-auto p-4">
  <div class="card">
    <div class="card-header text-center">
      Detalles del Torneo
    </div>

    <div class="card-body">
      <form>
        <div class="mb-3">
          <label for="torneo" class="form-label">Nombre del Torneo (ID: <?php echo $torneo['id']; ?>)</label>
          <input type="text" id="torneo" class="form-control" value="<?php echo $torneo['nombreTorneo']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label for="organizador" class="form-label">Organizador</label>
          <input type="text" id="organizador" class="form-control" value="<?php echo $torneo['organizador']; ?>" readonly>
        </div>

        <div class="mb-3">
          <label for="patrocinio" class="form-label">Patrocinadores</label>
          <textarea id="patrocinio" cols="30" rows="3" class="form-control" readonly><?php echo $torneo['patrocinadores']; ?></textarea>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="lugar" class="form-label">Sede</label>
            <input type="text" id="lugar" class="form-control" value="<?php echo $torneo['sede']; ?>" readonly>
          </div>
          <div class="col mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" id="categoria" class="form-control" value="<?php echo $torneo['categoria']; ?>" readonly>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio1" class="form-label">Premio 1er Lugar</label>
            <input type="text" id="premio1" class="form-control" value="<?php echo $torneo['premio1']; ?>" readonly>
          </div>
          <div class="col mb-3">
            <label for="premio2" class="form-label">Premio 2do Lugar</label>
            <input type="text" id="premio2" class="form-control" value="<?php echo $torneo['premio2']; ?>" readonly>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio3" class="form-label">Premio 3er Lugar</label>
            <input type="text" id="premio3" class="form-control" value="<?php echo $torneo['premio3']; ?>" readonly>
          </div>
          <div class="col mb-3">
            <label for="extra" class="form-label">Otro Premio</label>
            <input type="text" id="extra" class="form-control" value="<?php echo $torneo['otroPremio']; ?>" readonly>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" id="usuario" class="form-control" value="<?php echo $torneo['usuario']; ?>" readonly>
          </div>
          <div class="col mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="text" id="clave" class="form-control" value="<?php echo $torneo['contraseña']; ?>" readonly>
          </div>
        </div>

        <div class="col-12">
          <a href="readAllTorneos.php" class="btn btn-primary">Regresar</a>
        </div>
      </form>
    </div>

    <div class="card-footer text-center text-body-secondary">
      Información del Torneo
    </div>
  </div>
</div>

<?php
require_once(__DIR__ . "/../admin/template/footer.php");
?>