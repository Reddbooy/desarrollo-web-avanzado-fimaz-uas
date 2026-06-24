<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="mb-4">Catálogo Público</h2>

<form method="GET"
    class="row mb-4">

    <input type="hidden"
        name="route"
        value="catalogo">

    <div class="col-md-10">

        <input type="text"
            name="buscar"
            class="form-control"
            placeholder="Buscar por nombre o descripción"
            value="<?= htmlspecialchars($termino); ?>">

    </div>

    <div class="col-md-2">

        <button type="submit"
            class="btn btn-primary w-100">
            Buscar
        </button>

    </div>

</form>

<div class="row">

    <?php foreach ($productos as $producto): ?>

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">
                        <?= $producto['nombre']; ?>
                    </h5>

                    <p class="text-muted">
                        SKU: <?= $producto['sku']; ?>
                    </p>

                    <p>
                        <?= $producto['descripcion']; ?>
                    </p>

                    <h4 class="text-success">
                        $<?= $producto['precio_venta']; ?>
                    </h4>

                    <p>
                        Existencia:
                        <?= $producto['existencia']; ?>
                    </p>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>