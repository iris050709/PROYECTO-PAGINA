<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <center><h1>Lista de Productos</h1></center>
    <?php if (!empty($products)): ?>
        <table id="mytable" class="table table-bordred table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_id']); ?></td>
                        <!--<td>-->
                            <!--<a href="/products/edit/<?php echo htmlspecialchars($product['id']); ?>">Editar</a>-->
                            <td>
                                <center>
                                <p data-placement="top" data-toggle="tooltip" title="Edit">
                                <a href="/products/edit/<?php echo htmlspecialchars($product['id'] ?? 'ID no disponible'); ?>" class="btn btn-primary btn-xs">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </p>
                                </center>
                            </td>
                            <td>
                            <form action="/products/delete/<?php echo htmlspecialchars($product['id']); ?>" method="POST" style="display:inline;">
                            <p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"><span class="glyphicon glyphicon-trash"></span></button>
                            </form>
                            </td>
                        <!--</td>-->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</body>
</html>
