<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empresa</title>
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
                    <h2 class="text-center mb-0">Registrar Empresa</h2>
                </div>
                <div class="card-body">
                    <form action="registrar_empresa.php" method="POST" onsubmit="return validarNIT()">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="NIT">NIT:</label>
                            <input type="text" class="form-control" id="NIT" name="NIT" required>
                            <small id="nitHelp" class="form-text text-muted">Formato: XXXX-XXXXXX-XXX-X</small>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
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
    function validarNIT() {
        var nitInput = document.getElementById('NIT').value;
        var nitRegex = /^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]$/;
        if (!nitRegex.test(nitInput)) {
            alert('El formato del NIT no es válido. Por favor, ingrese un NIT con el formato XXXX-XXXXXX-XXX-X.');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
