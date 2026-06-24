<?php
require_once("../admin/template/header.php");
?>
<div class="mx-auto p-4">
  <div class="card">
    <div class="card-header text-center">
      <span><i class="fa-solid fa-trophy"></i> Registro de Torneos</span>
    </div>

    <div class="card-body">
      <form action="torneosInsert.php" method="post">
        <div class="mb-3">
          <label for="torneo" class="form-label">Nombre del Torneo</label>
          <input type="text" name="txtTorneo" id="torneo" class="form-control">
        </div>

        <div class="mb-3">
          <label for="organizador" class="form-label">Organizador</label>
          <input type="text" name="txtOrganizador" id="organizador" class="form-control">
        </div>

        <div class="mb-3">
          <label for="patrocinio" class="form-label">Patrocinadores</label>
          <textarea name="txtPatrocinio" id="patrocinio" cols="30" rows="3" class="form-control"></textarea>
          <small class="form-text text-muted">Separar con coma si hay varios</small>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="lugar" class="form-label">Sede</label>
            <input type="text" name="txtLugar" id="lugar" class="form-control">
          </div>
          <div class="col mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input list="categorias" name="txtCategoria" id="categoria" class="form-control">
            <datalist id="categorias">
              <option value="1ra fuerza">
              <option value="2da fuerza">
              <option value="Veteranos">
              <option value="Libre">
              <option value="Juvenil">
              <option value="Femenil">
              <option value="Empresarial">
              <option value="Infantil">
              <option value="Minibasket">
            </datalist>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio1" class="form-label">Premio 1er Lugar</label>
            <input type="text" name="txtPremio1" id="premio1" class="form-control">
          </div>
          <div class="col mb-3">
            <label for="premio2" class="form-label">Premio 2do Lugar</label>
            <input type="text" name="txtPremio2" id="premio2" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="premio3" class="form-label">Premio 3er Lugar</label>
            <input type="text" name="txtPremio3" id="premio3" class="form-control">
          </div>
          <div class="col mb-3">
            <label for="extra" class="form-label">Otro Premio</label>
            <input type="text" name="txtExtra" id="extra" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" name="txtUsuario" id="usuario" class="form-control">
          </div>
          <div class="col mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" name="txtClave" id="clave" class="form-control">
          </div>
        </div>

        <div class="text-center mb-3">
          <button type="submit" class="btn btn-success">Registrar</button>
          <a href="admin.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>

    <div class="card-footer text-center text-body-secondary">
      Registro de Torneos
    </div>
  </div>
</div>
<?php
require_once("../admin/template/footer.php");
?>