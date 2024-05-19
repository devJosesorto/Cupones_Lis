<?php
if (isset($_GET['idOferta'])) {
    $idOferta = $_GET['idOferta'];
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
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
                    <h2 class="text-center mb-0">Inicio de Sesión</h2>
                </div>
                <div class="card-body">
                    <form action="validar_login.php" method="POST">
                    <input type="hidden" name="idOferta" value="<?php echo isset($idOferta) ? $idOferta : ''; ?>">
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuario:</label>
                            <select id="tipo_usuario" name="tipo_usuario" class="form-control" required>
                                <option value="usuario">Usuario</option>
                                <option value="empresa">Empresa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Nombre de Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a href="../index.php" class="btn btn-secondary btn-block">Regresar</a>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
