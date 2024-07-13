<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="car-header text-center"></div>
                    <h2>Registro</h2>
                </div>
                <div class="card-body">
                    <form action="/register" method="post">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Apellido</label>
                            <input type="text" name="apellido" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="text" name="correo" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="text" name="telefono" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Direccion</label>
                            <input type="text" name="direccion" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>