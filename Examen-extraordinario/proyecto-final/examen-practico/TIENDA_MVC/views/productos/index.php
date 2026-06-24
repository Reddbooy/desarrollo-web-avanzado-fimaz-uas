<!--Este código PHP es una plantilla para mostrar una lista de productos en una aplicación web. Aquí hay un
desglose de lo que hace el código: -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Productos</h2>
    <a href="productos/create" class="btn btn-success">Nuevo Producto</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Precio Venta</th>
                    <th>Existencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= $producto['id']; ?></td>
                        <td><?= $producto['sku']; ?></td>
                        <td><?= $producto['nombre']; ?></td>
                        <td>$<?= $producto['precio_venta']; ?></td>
                        <td><?= $producto['existencia']; ?></td>
                        <td>
                            <a href="productos/edit&id=<?= $producto['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <form method="POST" action="productos/delete" class="d-inline">
                                <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer text-muted d-flex justify-content-center">
        <nav aria-label="paginacion">
            <ul class="pagination pagination-md">
                <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?= $i === $pagina_actual ? 'active' : ''; ?>">
                        <a class="page-link" href="productos&page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>