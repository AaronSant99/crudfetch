<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD php - API fetch</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-center">Registro de productos</h3>
                    </div>
                    <div class="card-body">
                        <form id="frm">
                            <input type="hidden" name="idp" id="idp" value="">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="producto">Producto</label>
                                <input type="text" name="producto" id="producto" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" name="precio" id="precio" class="form-control" min="0" step="any" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" min="0" step="1" required>
                            </div>
                            <div class="form-group">
                                <input type="button" value="Registrar" id="registrar" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-6 ml-auto">
                        <form>
                            <div class="form-group">
                                <label for="buscar">Buscar:</label>
                                <input type="text" id="buscar" placeholder="Buscar..." class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-responsive">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultado"></tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>