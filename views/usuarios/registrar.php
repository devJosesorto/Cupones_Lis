<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #222;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Registrar Cliente</h2>
                </div>
                <div class="card-body">
                    <form action="registrar_cliente.php" method="POST" onsubmit="return validarDUI()">
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contrase&ntilde;a:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="form-group">
                            <label for="DUI">DUI:</label>
                            <input type="text" class="form-control" id="DUI" name="DUI" required>
                            <small id="duiHelp" class="form-text text-muted">Formato: XXXXXXXX-X</small>
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a href="#" onclick="history.back()" class="btn btn-secondary btn-block">Regresar</a>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/bootstrap.min.js"></script>
<script>
    function validarDUI() {
        var duiInput = document.getElementById('DUI').value;
        var duiRegex = /^[0-9]{8}-[0-9]{1}$/;
        if (!duiRegex.test(duiInput)) {
            alert('El formato del DUI no es válido. Por favor, ingrese un DUI con el formato XXXXXXXX-X.');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
