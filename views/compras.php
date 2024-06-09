<?php
session_start();
// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesion si el usuario no está logueado
    exit();
}

// Incluir la clase de conexion
require_once '../db.php';

try {
    // Obtener la instancia de la conexion
    $conexion = Conexion::obtenerInstancia()->getConexion();

    // Consulta para obtener los cupones comprados por el usuario actual
    $query = "SELECT * FROM CuponesComprados WHERE idCliente = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(1, $_SESSION['id_usuario'], PDO::PARAM_INT);
    $stmt->execute();
    $cupones_comprados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Manejar errores de base de datos
    echo "Error al obtener los cupones comprados: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupones Comprados</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Cupones Comprados</h2>
                </div>
                <div class="card-body">
                    <?php if ($cupones_comprados): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID del Cupon</th>
                                        <th>Fecha de Compra</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Codigo de Cupon</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cupones_comprados as $cupon): ?>
                                        <tr>
                                            <td><?php echo $cupon['idCuponComprado']; ?></td>
                                            <td><?php echo $cupon['fecha_compra']; ?></td>
                                            <td><?php echo $cupon['fecha_vencimiento']; ?></td>
                                            <td><?php echo $cupon['codigo_cupon']; ?></td>
                                            <td>
                                                <!-- Aquí podrías agregar botones de acciones, como ver detalles del cupon, imprimir, etc. -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center">No has comprado ningún cupon.</p>
                    <?php endif; ?>
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
