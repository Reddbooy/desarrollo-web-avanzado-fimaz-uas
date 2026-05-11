<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");
require_once(__DIR__ . "/../admin/template/header.php");

$ctrl = new TorneosCtrl();
$lista = $ctrl->readTorneo();
?>

<div class="mx-auto p-4">
  <div class="card text-center">
    <div class="card-header fw-bold">
      <i class="fa-solid fa-trophy"></i> LISTADO DE TORNEOS
    </div>

    <div class="card-body">
      <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>TORNEO</th>
            <th>ORGANIZADOR</th>
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($lista): ?>
            <?php foreach ($lista as $dato): ?>
              <tr>
                <td><?php echo $dato['id']; ?></td>
                <td class="fw-bold"><?php echo $dato['nombreTorneo']; ?></td>
                <td><?php echo $dato['organizador']; ?></td>
                <td>
                  <a href="readOneTorneo.php?id=<?php echo $dato['id']; ?>" class="btn btn-primary">
                    Consultar
                  </a>
                  
                  <a href="updateTorneo.php?id=<?php echo $dato['id']; ?>" class="btn btn-success">
                    Editar
                  </a>
                  
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal<?php echo $dato['id']; ?>">
                    Eliminar
                  </button>

                  <div class="modal fade" id="modal<?php echo $dato['id']; ?>" tabindex="-1" aria-labelledby="label<?php echo $dato['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="label<?php echo $dato['id']; ?>">
                            ¿Eliminar este torneo?
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body text-start">
                          Esta acción es irreversible. ¿Realmente desea eliminar el torneo <strong><?php echo $dato['nombreTorneo']; ?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                          <a href="deleteTorneo.php?id=<?php echo $dato['id']; ?>" class="btn btn-danger rounded-pill">Eliminar</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">No hay torneos registrados</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="mt-3">
    <a href="admin.php" class="btn btn-secondary">
      <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
  </div>
</div>

<?php
require_once(__DIR__ . "/../admin/template/footer.php");
?>