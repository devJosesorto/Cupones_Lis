<?php
session_start();

// Verificar si el usuario está autenticado y tiene una sesion activa
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de configuracion de la base de datos
require_once '../../db.php';

// Realizar una consulta para obtener el codigo del cupon asociado al usuario
try {
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Consulta SQL para obtener el codigo del cupon del usuario
    $query = "SELECT codigo_cupon FROM CuponesComprados WHERE idCliente = :idCliente ORDER BY fecha_compra DESC LIMIT 1";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':idCliente', $_SESSION['id_usuario']);
    $statement->execute();
    $cupon = $statement->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontro un cupon
    if ($cupon) {
        $codigo_cupon = $cupon['codigo_cupon'];
    } else {
        $codigo_cupon = "No se encontro ningún cupon asociado a tu cuenta.";
    }
} catch (Exception $e) {
    // Manejar errores de la base de datos
    $codigo_cupon = "Error al recuperar el codigo del cupon.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacion</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #222;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0 text-dark">Confirmacion</h2>
                </div>
                <div class="card-body">
                    <p class="text-dark">Tu compra se ha procesado correctamente.</p>
                    <p class="text-dark">A continuacion, te mostramos el codigo de tu cupon:</p>
                    <h3 class="text-info"><?php echo $codigo_cupon; ?></h3>
                    <p class="text-dark">Guarda este codigo para canjear tu cupon en el momento adecuado.</p>
                </div>
            </div>
            <div class="mt-3">
                <a href="../../index.php" class="btn btn-secondary btn-block">Volver al inicio</a>
            </div>
        </div>
    </div>
</div>


<script src="../../assets/js/bootstrap.min.js"></script>
</body>
</html>
