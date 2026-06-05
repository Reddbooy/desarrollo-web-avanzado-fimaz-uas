<!--Este fragmento de código PHP crea un formulario para editar un producto. Aquí hay un desglose de lo que es el código.
está haciendo: -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php $_SESSION['csrf_token'] = bin2hex(random_bytes(32)) ?>
<h2>Editar producto</h2>
<form action="../productos/update" method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
    
    <input type="hidden" name="id" value="<?= (int)$producto['id']; ?>">

    <div class="mb-3">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($producto['sku']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripcion</label>
        <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio compra</label>
        <input type="number" step="0.01" name="precio_compra" class="form-control"
        value="<?= htmlspecialchars((string)$producto['precio_compra']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio venta</label>
        <input type="number" step="0.01" name="precio_venta" class="form-control"
        value="<?= htmlspecialchars((string)$producto['precio_venta']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Existencia</label>
        <input type="number" name="existencia" class="form-control" value="<?= (int)$producto['existencia']; ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="../productos" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>